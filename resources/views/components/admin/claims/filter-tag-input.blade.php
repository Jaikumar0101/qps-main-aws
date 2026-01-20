<div wire:ignore>
    <div
        x-data="{
        model: @entangle($attributes->wire('model')),
        suggestions:@js(array_values($suggestions)),
        tagInputField:$refs.input,
        tagInput:null,
         selectAll: function() {
                this.tagInput.removeAllTags(); // Clear all existing tags
                this.tagInput.addTags(suggestions); // Add all suggestions as tags
                this.model = suggestions.map(tag => tag.value || tag); // Update the model with all tags
        }
    }"
        x-init="
          tagInput = new Tagify(tagInputField,{
               enforceWhitelist: false,
               skipInvalid: false,
               dropdown: {
                   maxItems: 20,           // maximum items to show in the suggestions dropdown
                   enabled: 0,             // show suggestions on focus
                   closeOnSelect: true    // keep the dropdown open after selecting a suggestion
               },
              whitelist: suggestions,
           });

            tagInput.on('change', function(e) {
                let tagsArr = tagInput.value.map(tag => tag.value);
                model = tagsArr; // Update the model with the tags array
            });


    "
    >
        @if($attributes->has('label'))
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1 fs-8 fw-bold">
                {{ $attributes->get('label') ??'' }}
            </label>
        @endif
        <input x-ref="input"  {{ $attributes->merge(['class' => 'form-control form-control-sm ps-2 min-w-150px']) }} />
    </div>
</div>
