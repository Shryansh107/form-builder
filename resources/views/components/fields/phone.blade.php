@props([
    'field' => null,
    'isBuilder' => false,
])

@php
    $label = $field['label'] ?? 'Phone Input';
    $placeholder = $field['placeholder'] ?? '+1 (555) 000-0000';
    $required = $field['required'] ?? false;
    $defaultValue = $field['defaultValue'] ?? '';
    $class = $field['class'] ?? '';
    $name = $field['name'] ?? 'phone_input';
@endphp

<div class="w-full" @if(!$isBuilder) class="{{ $class }}" @endif>
    @if($isBuilder)
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                <span x-text="field.label || 'Phone Input'"></span>
                <span x-show="field.required" class="text-red-500 ml-0.5">*</span>
            </label>
            <input 
                type="tel" 
                disabled
                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 text-sm block cursor-not-allowed"
                :placeholder="field.placeholder || '+1 (555) 000-0000'"
                :value="field.defaultValue || ''"
            />
            <div class="mt-1 flex items-end justify-between text-xs text-gray-500">
                <span>Phone validation</span>
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
                type="tel" 
                name="{{ $name }}"
                placeholder="{{ $placeholder }}"
                value="{{ $defaultValue }}"
                {{ $required ? 'required' : '' }}
                class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block transition-all"
            />
        </div>
    @endif
</div>
