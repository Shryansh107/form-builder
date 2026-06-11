<form id="rendered-preview-form" class="space-y-6 max-w-4xl mx-auto" onsubmit="event.preventDefault(); alert('Form submitted successfully!');">
    @csrf
    <div class="grid grid-cols-2 gap-6">
        @foreach($schema as $field)
            <div class="{{ $field['class'] ?? 'col-span-1' }} p-4 bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition-all">
                <x-form-field :field="$field" :is-builder="false" />
            </div>
        @endforeach
    </div>
    <div class="flex justify-end pt-6 border-t border-gray-100">
        <button type="submit" class="px-6 py-2.5 bg-indigo-650 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all">
            Submit Form
        </button>
    </div>
</form>
