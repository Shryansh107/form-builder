@props([
    'field' => null,
    'isBuilder' => false,
])

@php
    $label = $field['label'] ?? 'Checkbox Group';
    $required = $field['required'] ?? false;
    $options = $field['options'] ?? ['Option 1', 'Option 2', 'Option 3'];
    $class = $field['class'] ?? '';
    $name = $field['name'] ?? 'checkbox_group';
    $defaultValues = $field['defaultValues'] ?? [];
    if (is_string($defaultValues)) {
        $defaultValues = array_map('trim', explode(',', $defaultValues));
    }
@endphp

<div class="w-full" @if(!$isBuilder) class="{{ $class }}" @endif>
    @if($isBuilder)
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                <span x-text="field.label || 'Checkbox Group'"></span>
                <span x-show="field.required" class="text-red-500 ml-0.5">*</span>
            </label>
            <div class="space-y-2">
                <template x-for="(opt, index) in field.options" :key="index">
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            disabled 
                            :name="'builder_' + field.id + '[]'"
                            :value="opt"
                            :checked="field.defaultValues && field.defaultValues.includes(opt)"
                            class="h-4 w-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500 cursor-not-allowed"
                        />
                        <span class="ml-2 text-sm text-gray-700" x-text="opt"></span>
                    </div>
                </template>
            </div>
            <div class="mt-1 flex items-end justify-between text-xs text-gray-500">
                <span x-text="(field.options ? field.options.length : 0) + ' checkboxes available'"></span>
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
            <div class="space-y-2 flex flex-col">
                @foreach($options as $opt)
                    <label class="inline-flex items-center cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="{{ $name }}[]" 
                            value="{{ $opt }}"
                            {{ in_array($opt, $defaultValues) ? 'checked' : '' }}
                            class="h-4 w-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500 cursor-pointer"
                        />
                        <span class="ml-2 text-sm text-gray-700">{{ $opt }}</span>
                    </label>
                @endforeach
            </div>
        </div>
    @endif
</div>
