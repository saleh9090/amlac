@php
    $record = $getRecord();
    $state = $getState();
@endphp

<input
    type="date"
    value="{{ $state }}"
    wire:change="saveDate({{ $record->id }}, $event.target.value)"
    class="fi-input block w-full rounded-lg border border-gray-300 bg-white px-2 py-1.5 text-sm shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500 dark:border-white/10 dark:bg-white/5 dark:text-white"
/>
