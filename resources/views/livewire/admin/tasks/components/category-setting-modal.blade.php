<div>
    <x-admin.theme.modal  wire:model="editModal"
                          title="{{ Arr::has($request,'id')?'Edit':'New' }} Category"
                          description="Here you can add edit the category details"
    >
        <x-slot:body>
            <form wire:submit.prevent="Save">
                <x-input.text wire:model="request.name"
                              label="Name"
                />
                <x-input.text-area wire:model="request.description"
                                   label="Description"
                />
                <x-input.select wire:model="request.parent_id"
                                label="Parent Category"
                >
                    <option value="">Root</option>
                    @foreach($parentCategories as $item)
                        <option value="{{ $item->id }}">{{ $item->name ??'' }}</option>
                    @endforeach
                </x-input.select>
                <x-input.text wire:model="request.position"
                              label="Position"
                />
                <x-input.select wire:model="request.status"
                                label="Status"
                >
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </x-input.select>
                <div class="text-center py-3">
                    <x-admin.theme.button type="submit"
                                          label="Save"
                                          spinner="Save"
                                          color="primary"
                                          class="me-3"
                    />
                    <x-admin.theme.button type="button"
                                          label="Close"
                                          color="dark"
                                          class="ml-2"
                                          @click="$wire.editModal = false"
                    />
                </div>
            </form>
        </x-slot:body>
    </x-admin.theme.modal>
</div>

