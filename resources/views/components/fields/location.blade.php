@props([
    'field' => null,
    'isBuilder' => false,
])

@php
    $label = $field['label'] ?? 'Location';
    $required = $field['required'] ?? false;
    $locationType = $field['locationType'] ?? 'combined'; // state, city, combined
    $class = $field['class'] ?? '';
    $name = $field['name'] ?? 'location';
@endphp

<div class="w-full" @if(!$isBuilder) class="{{ $class }}" @endif>
    @if($isBuilder)
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                <span x-text="field.label || 'Location'"></span>
                <span x-show="field.required" class="text-red-500 ml-0.5">*</span>
            </label>
            <div class="grid grid-cols-2 gap-4">
                <!-- State Selection -->
                <div x-show="field.locationType === 'state' || field.locationType === 'combined'">
                    <label class="block text-xs text-gray-500 mb-1">State</label>
                    <select disabled class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-905 text-sm block cursor-not-allowed">
                        <option>Select State...</option>
                    </select>
                </div>
                <!-- City Selection -->
                <div x-show="field.locationType === 'city' || field.locationType === 'combined'"
                     :class="field.locationType === 'city' ? 'col-span-2' : ''">
                    <label class="block text-xs text-gray-500 mb-1">City</label>
                    <select disabled class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-905 text-sm block cursor-not-allowed">
                        <option>Select City...</option>
                    </select>
                </div>
            </div>
            <div class="mt-1 flex items-end justify-between text-xs text-gray-500">
                <span x-text="'Type: ' + (field.locationType || 'combined')"></span>
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
            <div class="grid grid-cols-2 gap-4">
                @if($locationType === 'state' || $locationType === 'combined')
                    <div class="{{ $locationType === 'state' ? 'col-span-2' : '' }}">
                        <label class="block text-xs text-gray-600 mb-1 font-medium">State</label>
                        <select 
                            name="{{ $name }}_state"
                            {{ $required ? 'required' : '' }}
                            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block transition-all"
                        >
                            <option value="">Select State...</option>
                            <option value="CA">California</option>
                            <option value="NY">New York</option>
                            <option value="TX">Texas</option>
                            <option value="FL">Florida</option>
                            <option value="IL">Illinois</option>
                        </select>
                    </div>
                @endif
                @if($locationType === 'city' || $locationType === 'combined')
                    <div class="{{ $locationType === 'city' ? 'col-span-2' : '' }}">
                        <label class="block text-xs text-gray-600 mb-1 font-medium">City</label>
                        <select 
                            name="{{ $name }}_city"
                            {{ $required ? 'required' : '' }}
                            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block transition-all"
                        >
                            <option value="">Select City...</option>
                            <option value="LA">Los Angeles</option>
                            <option value="NYC">New York City</option>
                            <option value="HOU">Houston</option>
                            <option value="MIA">Miami</option>
                            <option value="CHI">Chicago</option>
                        </select>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
