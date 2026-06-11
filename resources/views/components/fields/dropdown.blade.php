@props([
    'field' => null,
    'isBuilder' => false,
])

@php
    $label = $field['label'] ?? 'Dropdown Select';
    $required = $field['required'] ?? false;
    $options = $field['options'] ?? ['Option 1', 'Option 2', 'Option 3'];
    $class = $field['class'] ?? '';
    $name = $field['name'] ?? 'dropdown_select';
@endphp

<div class="w-full" @if(!$isBuilder) class="{{ $class }}" @endif>
    @if($isBuilder)
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                <span x-text="field.label || 'Dropdown Select'"></span>
                <span x-show="field.required" class="text-red-500 ml-0.5">*</span>
            </label>
            <select 
                disabled
                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 text-sm block cursor-not-allowed"
            >
                <option value="" x-text="field.placeholder || 'Select an option...'"></option>
                <template x-for="opt in field.options" :key="opt">
                    <option x-text="opt"></option>
                </template>
            </select>
            <div class="mt-1 flex items-end justify-between text-xs text-gray-500">
                <span x-text="(field.options ? field.options.length : 0) + ' options available'"></span>
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
            <select 
                name="{{ $name }}"
                {{ $required ? 'required' : '' }}
                class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block transition-all"
            >
                <option value="">{{ $field['placeholder'] ?? 'Select an option...' }}</option>
                @foreach($options as $opt)
                    <option value="{{ $opt }}">{{ $opt }}</option>
                @endforeach
            </select>
        </div>
    @endif
</div>
