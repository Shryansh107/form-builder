@props([
    'field' => null,
    'isBuilder' => false,
])

@php
    $label = $field['label'] ?? 'Text Area';
    $placeholder = $field['placeholder'] ?? 'Enter detailed text...';
    $required = $field['required'] ?? false;
    $defaultValue = $field['defaultValue'] ?? '';
    $class = $field['class'] ?? '';
    $minChars = $field['minChars'] ?? '';
    $maxChars = $field['maxChars'] ?? '';
    $name = $field['name'] ?? 'textarea_input';
@endphp

<div class="w-full" @if(!$isBuilder) class="{{ $class }}" @endif>
    @if($isBuilder)
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                <span x-text="field.label || 'Text Area'"></span>
                <span x-show="field.required" class="text-red-500 ml-0.5">*</span>
            </label>
            <textarea 
                disabled
                rows="3"
                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 text-sm block cursor-not-allowed resize-none"
                :placeholder="field.placeholder || 'Enter detailed text...'"
                x-text="field.defaultValue || ''"
            ></textarea>
            <div class="mt-1 flex items-center justify-between text-xs text-gray-500">
                <span x-show="field.minChars || field.maxChars">
                    Min: <span x-text="field.minChars || 0"></span>, Max: <span x-text="field.maxChars || 'unlimited'"></span> chars
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
            <textarea 
                name="{{ $name }}"
                rows="4"
                placeholder="{{ $placeholder }}"
                {{ $required ? 'required' : '' }}
                @if($minChars) minlength="{{ $minChars }}" @endif
                @if($maxChars) maxlength="{{ $maxChars }}" @endif
                class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block transition-all"
            >{{ $defaultValue }}</textarea>
        </div>
    @endif
</div>
