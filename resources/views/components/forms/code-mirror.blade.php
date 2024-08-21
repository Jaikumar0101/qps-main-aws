<div
    x-data="{
        model: @entangle($attributes->wire('model')),
    }"
    x-init="
           codeBlock = CodeMirror.fromTextArea($refs.input, {
            mode: '{{ $attributes->has('mode')?$attributes->get('mode'):'htmlmixed' }}',
            value:model?model:'',
            lineNumbers: true,
            tabSize: 150,
          });
          codeBlock.save();
          codeBlock.on('blur',function (cMirror) {
              model = cMirror.getValue();
          });
         codeBlock.refresh();
    "
    wire:ignore
    class="border"
>
    <textarea x-ref="input"  {{ $attributes->merge(['class' => '']) }}>{{ $slot ??'' }}</textarea>
</div>
