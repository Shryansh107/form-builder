@props([
    'field' => null,
    'isBuilder' => false,
])

@php
    $layoutType = $field['layoutType'] ?? 'title';
    $label = $field['label'] ?? '';
    $placeholder = $field['placeholder'] ?? '';
    $class = $field['class'] ?? '';
@endphp

<div class="w-full" @if(!$isBuilder) class="{{ $class }}" @endif>
    @if($isBuilder)
        <div>
            @if($layoutType === 'title')
                <h2 class="text-xl font-bold text-gray-900 border-b pb-1 mb-2" x-text="field.label || 'Title Header'"></h2>
            @elseif($layoutType === 'description')
                <p class="text-sm text-gray-600 leading-relaxed" x-text="field.placeholder || 'Enter description text here...'"></p>
            @elseif($layoutType === 'newline')
                <div class="py-2 border-t border-dotted border-gray-300 flex items-center justify-between text-xs text-gray-400">
                    <span>New Line Break</span>
                </div>
            @elseif($layoutType === 'pagebreak')
                <div class="py-3 flex items-center">
                    <div class="flex-grow border-t border-dashed border-gray-400"></div>
                    <span class="flex-shrink mx-4 text-xs font-semibold text-gray-400 tracking-wider uppercase">Page Break</span>
                    <div class="flex-grow border-t-2 border-dashed border-gray-400"></div>
                </div>
            @endif
            <div class="mt-1 flex items-end justify-end text-xs text-gray-400">
                <span x-show="field.class" class="font-mono bg-gray-100 px-1 py-0.5 rounded text-[10px]" x-text="'Class: ' + field.class"></span>
            </div>
        </div>
    @else
        <div>
            @if($layoutType === 'title')
                <h2 class="text-xl font-bold text-gray-950 border-b pb-1 mb-2">{{ $label }}</h2>
            @elseif($layoutType === 'description')
                <p class="text-sm text-gray-650 leading-relaxed">{{ $placeholder }}</p>
            @elseif($layoutType === 'newline')
                <div class="h-4"></div>
            @elseif($layoutType === 'pagebreak')
                <div class="py-4 flex items-center">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="flex-shrink mx-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Page Break</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>
            @endif
        </div>
    @endif
</div>
