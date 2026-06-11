@props([
    'field' => null,
    'isBuilder' => false,
])

@php
    $type = $field['type'] ?? 'text';
@endphp

@if(in_array($type, ['text', 'text_input']))
    <x-fields.text :field="$field" :isBuilder="$isBuilder" />
@elseif(in_array($type, ['textarea', 'text_area']))
    <x-fields.textarea :field="$field" :isBuilder="$isBuilder" />
@elseif(in_array($type, ['number', 'number_input']))
    <x-fields.number :field="$field" :isBuilder="$isBuilder" />
@elseif(in_array($type, ['email', 'email_input']))
    <x-fields.email :field="$field" :isBuilder="$isBuilder" />
@elseif(in_array($type, ['phone', 'phone_input']))
    <x-fields.phone :field="$field" :isBuilder="$isBuilder" />
@elseif($type === 'dropdown')
    <x-fields.dropdown :field="$field" :isBuilder="$isBuilder" />
@elseif($type === 'radio')
    <x-fields.radio :field="$field" :isBuilder="$isBuilder" />
@elseif($type === 'checkbox')
    <x-fields.checkbox :field="$field" :isBuilder="$isBuilder" />
@elseif($type === 'datepicker')
    <x-fields.datepicker :field="$field" :isBuilder="$isBuilder" />
@elseif($type === 'fileupload')
    <x-fields.fileupload :field="$field" :isBuilder="$isBuilder" />
@elseif($type === 'hidden')
    <x-fields.hidden :field="$field" :isBuilder="$isBuilder" />
@elseif(in_array($type, ['title', 'description', 'new_line', 'page_break']))
    <x-fields.layout :field="$field" :isBuilder="$isBuilder" />
@elseif(in_array($type, ['location_state', 'location_city', 'location_combined']))
    <x-fields.location :field="$field" :isBuilder="$isBuilder" />
@else
    <div class="p-3 border border-red-300 bg-red-50 text-red-700 rounded-lg text-sm">
        Unknown field type: <strong>{{ $type }}</strong>
    </div>
@endif
