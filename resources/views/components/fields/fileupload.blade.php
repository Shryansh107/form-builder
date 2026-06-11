@props([
    'field' => null,
    'isBuilder' => false,
])

@php
    $label = $field['label'] ?? 'File Upload';
    $placeholder = $field['placeholder'] ?? 'Choose a file...';
    $required = $field['required'] ?? false;
    $class = $field['class'] ?? '';
    $name = $field['name'] ?? 'file_upload';
    $maxFileSize = $field['maxFileSize'] ?? '';
    $allowedExtensions = $field['allowedExtensions'] ?? '';
@endphp

<div class="w-full" @if(!$isBuilder) class="{{ $class }}" @endif>
    @if($isBuilder)
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                <span x-text="field.label || 'File Upload'"></span>
                <span x-show="field.required" class="text-red-500 ml-0.5">*</span>
            </label>
            <div class="w-full flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-lg p-4 bg-gray-50 cursor-not-allowed">
                <svg class="h-8 w-8 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                <span class="text-xs font-medium text-gray-600" x-text="field.placeholder || 'Choose a file...'"></span>
            </div>
            <div class="mt-1 flex items-center justify-between text-xs text-gray-500">
                <span>
                    Max Size: <span x-text="field.maxFileSize ? field.maxFileSize + ' MB' : 'unlimited'"></span>
                    <span x-show="field.allowedExtensions" x-text="' (' + field.allowedExtensions + ')'"></span>
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
            <div class="flex items-center justify-center w-full">
                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                        </svg>
                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-500">
                            @if($allowedExtensions)
                                {{ $allowedExtensions }}
                            @else
                                Any file
                            @endif
                            @if($maxFileSize)
                                (Max: {{ $maxFileSize }}MB)
                            @endif
                        </p>
                    </div>
                    <input 
                        type="file" 
                        name="{{ $name }}" 
                        class="hidden"
                        {{ $required ? 'required' : '' }}
                        @if($allowedExtensions) accept="{{ $allowedExtensions }}" @endif
                    />
                </label>
            </div>
        </div>
    @endif
</div>
