<div x-data="{
        model: @entangle($attributes->wire('model')),
        suggestions: @js($options),
        tagInputField:$refs.input,
        tagInput:null,
        selectAll: function() {
            this.tagInput.removeAllTags(); // Clear all existing tags
            this.tagInput.addTags(this.suggestions); // Add all suggestions as tags
            this.model = suggestions.map(tag => tag.value || tag); // Update the model with all tags
        }
     }"
     x-init="
          tagInput = new Tagify(tagInputField,{
               enforceWhitelist: true,
               skipInvalid: true,
               dropdown: {
                   maxItems: 20,           // maximum items to show in the suggestions dropdown
                   enabled: 0,             // show suggestions on focus
                   closeOnSelect: false,    // keep the dropdown open after selecting a suggestion
               },
              whitelist: suggestions,
           });

            tagInput.on('change', function(e) {
                let tagsArr = tagInput.value.map(tag => tag.value);
                model = tagsArr; // Update the model with the tags array
            });
    "
     wire:ignore
>
    <input x-ref="input"  class="form-control form-control-sm" />
</div>
