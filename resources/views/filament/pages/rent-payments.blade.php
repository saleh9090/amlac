<x-filament-panels::page>
    <div class="flex flex-wrap items-end gap-4">
        <div class="w-52">
            <label class="fi-fo-field-wrp-label block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                Building
            </label>
            <x-filament::input.wrapper>
                <x-filament::input.select wire:model.live="buildingId">
                    <option value="">All Buildings</option>
                    @foreach ($this->getBuildingOptions() as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-filament::input.select>
            </x-filament::input.wrapper>
        </div>

        <div class="w-44">
            <label class="fi-fo-field-wrp-label block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                Month
            </label>
            <x-filament::input.wrapper>
                <x-filament::input.select wire:model.live="month">
                    @foreach ($this->getMonthOptions() as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-filament::input.select>
            </x-filament::input.wrapper>
        </div>

        <div class="w-32">
            <label class="fi-fo-field-wrp-label block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                Year
            </label>
            <x-filament::input.wrapper>
                <x-filament::input.select wire:model.live="year">
                    @foreach ($this->getYearOptions() as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-filament::input.select>
            </x-filament::input.wrapper>
        </div>
    </div>

    <div class="mt-6">
        {{ $this->table }}
    </div>

    @php($totals = $this->getTotals())
    <div class="mt-4 flex flex-wrap gap-6 rounded-xl border border-gray-200 dark:border-white/10 px-4 py-3">
        <div>
            <span class="block text-sm text-gray-500 dark:text-gray-400">Total Due</span>
            <span class="text-lg font-semibold text-gray-950 dark:text-white">{{ number_format($totals['due'], 1) }}</span>
        </div>
        <div>
            <span class="block text-sm text-gray-500 dark:text-gray-400">Total Paid</span>
            <span class="text-lg font-semibold text-gray-950 dark:text-white">{{ number_format($totals['paid'], 1) }}</span>
        </div>
        <div>
            <span class="block text-sm text-gray-500 dark:text-gray-400">Total Outstanding</span>
            <span class="text-lg font-semibold text-gray-950 dark:text-white">{{ number_format($totals['outstanding'], 1) }}</span>
        </div>
    </div>
</x-filament-panels::page>
