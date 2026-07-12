<?php

namespace App\Filament\Pages;

use App\Models\Building;
use App\Models\Payment;
use App\Models\Unit;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RentPayments extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTableCells;

    protected static ?string $navigationLabel = 'Rent Payments';

    protected static ?string $title = 'Rent Payments';

    protected string $view = 'filament.pages.rent-payments';

    public ?int $buildingId = null;

    public int $month;

    public int $year;

    public function mount(): void
    {
        $this->month = (int) now()->month;
        $this->year = (int) now()->year;

        // Default to AlGobrah instead of "All Buildings", so the page
        // opens already scoped to one building's units.
        $this->buildingId = Building::query()
            ->where('name', 'AlGobrah')
            ->value('id')
            ?? Building::query()->orderBy('name')->value('id');
    }

    /**
     * @return array<int, string>
     */
    public function getBuildingOptions(): array
    {
        return Building::query()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->all();
    }

    /**
     * @return array<int, string>
     */
    public function getMonthOptions(): array
    {
        return [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
        ];
    }

    /**
     * @return array<int, int>
     */
    public function getYearOptions(): array
    {
        $current = (int) now()->year;

        return array_combine(
            range($current - 2, $current + 2),
            range($current - 2, $current + 2),
        );
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Unit::query()
                    ->when($this->buildingId, fn (Builder $query) => $query->where('building_id', $this->buildingId))
                    ->with([
                        'contract.tenant',
                        'payments' => fn ($query) => $query
                            ->where('payment_for_month', $this->month)
                            ->where('payment_for_year', $this->year),
                    ])
                    // Natural sort so "2" comes before "10" instead of alphabetical order.
                    ->orderByRaw('CAST(unit_number AS UNSIGNED) asc, unit_number asc'),
            )
            ->paginated(false)
            ->headerActions([
                Action::make('saveAll')
                    ->label('Save All')
                    ->icon('heroicon-o-check')
                    ->visible(fn (): bool => ! auth()->user()?->is_read_only)
                    ->action('saveAll'),
            ])
            ->columns([
                TextColumn::make('unit_number')
                    ->label('Unit')
                    ->weight('medium'),

                TextColumn::make('tenant')
                    ->label('Tenant')
                    ->getStateUsing(fn (Unit $record): string => $record->contract?->tenant?->name ?? '— no contract —'),

                TextColumn::make('rent')
                    ->label('Rent')
                    ->getStateUsing(fn (Unit $record): float => (float) ($record->contract?->rent_amount ?? 0))
                    ->numeric(decimalPlaces: 1),

                TextInputColumn::make('paid')
                    ->label('Paid')
                    ->type('number')
                    ->step('0.01')
                    ->disabled(fn (): bool => (bool) auth()->user()?->is_read_only)
                    ->getStateUsing(fn (Unit $record) => (float) ($record->payments->first()?->paid_amount ?? 0))
                    ->updateStateUsing(fn (Unit $record, $state) => $this->savePaymentField($record, 'paid_amount', $state))
                    ->extraInputAttributes(function (Unit $record): array {
                        $rent = (float) ($record->contract?->rent_amount ?? 0);
                        $paid = (float) ($record->payments->first()?->paid_amount ?? 0);

                        if ($rent > 0 && $paid == $rent) {
                            return ['style' => 'color: rgb(22 163 74); font-weight: 600;'];
                        }

                        return [];
                    }),

                // A plain, self-rendered date input instead of TextInputColumn:
                // Filament's inline-edit column wraps inputs with a click
                // interceptor (to stop row-click actions) which also blocks
                // the browser's native date picker from opening. Rendering
                // this cell ourselves avoids that.
                Column::make('payment_date')
                    ->label('Date')
                    ->getStateUsing(fn (Unit $record) => $record->payments->first()?->payment_date?->format('Y-m-d'))
                    ->view('filament.tables.columns.rent-payment-date'),

                TextInputColumn::make('note')
                    ->label('Note')
                    ->disabled(fn (): bool => (bool) auth()->user()?->is_read_only)
                    ->getStateUsing(fn (Unit $record) => $record->payments->first()?->note)
                    ->updateStateUsing(fn (Unit $record, $state) => $this->savePaymentField($record, 'note', $state ?: null)),
            ]);
    }

    /**
     * Totals for the units currently on screen (same building/month/year
     * scope as the table) — used for the summary row under the table.
     *
     * @return array{due: float, paid: float, outstanding: float}
     */
    public function getTotals(): array
    {
        $units = Unit::query()
            ->when($this->buildingId, fn (Builder $query) => $query->where('building_id', $this->buildingId))
            ->with([
                'contract',
                'payments' => fn ($query) => $query
                    ->where('payment_for_month', $this->month)
                    ->where('payment_for_year', $this->year),
            ])
            ->get();

        $due = (float) $units->sum(fn (Unit $unit) => (float) ($unit->contract?->rent_amount ?? 0));
        $paid = (float) $units->sum(fn (Unit $unit) => (float) ($unit->payments->first()?->paid_amount ?? 0));

        return [
            'due' => $due,
            'paid' => $paid,
            'outstanding' => max(0, $due - $paid),
        ];
    }

    protected function savePaymentField(Unit $unit, string $field, mixed $value): void
    {
        abort_if(auth()->user()?->is_read_only, 403);

        $payment = Payment::firstOrNew([
            'unit_id' => $unit->id,
            'payment_for_month' => $this->month,
            'payment_for_year' => $this->year,
        ]);

        if (! $payment->exists) {
            $payment->paid_amount = 0;
        }

        $payment->{$field} = $value;
        $payment->save();
    }

    /**
     * Called from the plain date input's wire:change (see the
     * rent-payment-date column view), since that cell isn't a
     * TextInputColumn.
     */
    public function saveDate(int $unitId, ?string $date): void
    {
        $this->savePaymentField(Unit::findOrFail($unitId), 'payment_date', $date ?: null);
    }

    /**
     * Makes sure every currently listed unit has a payment row for the
     * selected month/year. Existing rows (and anything already typed
     * in) are left untouched.
     */
    public function saveAll(): void
    {
        abort_if(auth()->user()?->is_read_only, 403);

        $units = Unit::query()
            ->when($this->buildingId, fn (Builder $query) => $query->where('building_id', $this->buildingId))
            ->get();

        foreach ($units as $unit) {
            Payment::firstOrCreate(
                [
                    'unit_id' => $unit->id,
                    'payment_for_month' => $this->month,
                    'payment_for_year' => $this->year,
                ],
                [
                    'paid_amount' => 0,
                ],
            );
        }

        Notification::make()
            ->title('All units have a payment row for this month')
            ->success()
            ->send();
    }
}
