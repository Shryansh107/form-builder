@props([
    'field' => null,
    'isBuilder' => false,
])

@php
    $label = $field['label'] ?? 'Date Selection';
    $placeholder = $field['placeholder'] ?? 'Select date...';
    $required = $field['required'] ?? false;
    $defaultValue = $field['defaultValue'] ?? '';
    $class = $field['class'] ?? '';
    $name = $field['name'] ?? 'datepicker';
    $minDate = $field['minDate'] ?? '';
    $maxDate = $field['maxDate'] ?? '';
@endphp

<div class="w-full" @if(!$isBuilder) class="{{ $class }}" @endif>
    @if($isBuilder)
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                <span x-text="field.label || 'Date Selection'"></span>
                <span x-show="field.required" class="text-red-500 ml-0.5">*</span>
            </label>
            <input 
                type="date" 
                disabled
                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 text-sm block cursor-not-allowed"
                :value="field.defaultValue || ''"
            />
            <div class="mt-1 flex items-center justify-between text-xs text-gray-500">
                <span x-show="field.minDate || field.maxDate">
                    Min: <span x-text="field.minDate || 'none'"></span>, Max: <span x-text="field.maxDate || 'none'"></span>
                </span>
                <span x-show="field.class" class="font-mono bg-gray-100 px-1 py-0.5 rounded text-[10px]" x-text="'Class: ' + field.class"></span>
            </div>
        </div>
    @else
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                <span>{{ $label }}</span>
                @if($required)
                    <span class="text-red-500 ml-0.5">*</span>
                @endif
            </label>
            <input 
                type="date" 
                name="{{ $name }}"
                value="{{ $defaultValue }}"
                {{ $required ? 'required' : '' }}
                @if($minDate) min="{{ $minDate }}" @endif
                @if($maxDate) max="{{ $maxDate }}" @endif
                class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block transition-all"
            />
        </div>
    @endif
</div>
