<?php

namespace App\Livewire\Admin\Blog\Collection;

use App\Helpers\Admin\BackendHelper;
use App\Models\PostCollection;
use Livewire\Component;

class PostCollectionAddEditPage extends Component
{
    public $collection_id;
    public array $request = [];

    public array $postItems = [];

    protected array $validationAttributes = [
        'request.title'=>'title',
        'request.description'=>'description',
    ];

    protected function rules():array
    {
        return [
            'request.title'=>'required|max:255',
            'request.description'=>'max:500',
        ];
    }

    public function mount()
    {
        if (checkData($this->collection_id))
        {
            $check = PostCollection::find($this->collection_id);
            $check?$this->EditRequest($check):redirect()->route('admin::post-collection:list')->with('error','Invalid ID');
        }
        else
        {
            $this->NewRequest();
        }
    }

    public function render()
    {
        return view('livewire.admin.blog.collection.post-collection-add-edit-page')
            ->layout('layouts.admin.app');
    }

    public function Submit()
    {
        $this->validate($this->rules());
        $this->create($this->request);
    }

    public function Save()
    {
        $this->validate($this->rules());
        $this->update($this->request);
    }

    private function create($data)
    {
        try
        {
            $data['post_items'] = BackendHelper::JsonEncode($this->postItems);
            $check = PostCollection::create($data);
            $this->collection_id = $check->id;
            $this->dispatch('SweetMessage',
                type:'success',
                title:'New Post Collection',
                message:"Created Successfully",
                url:route('admin::post-collection:list')
            );
        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',
                type:'error',
                message:$exception->getMessage()
            );
        }
    }

    private function update($data)
    {
        $data['post_items'] = BackendHelper::JsonEncode($this->postItems);
        $check = PostCollection::find($this->collection_id);
        $check->fill($data);
        $check->save();
        $this->dispatch('SweetMessage',
            type:'success',
            title:'Edit Post Collection',
            message:"Updated Successfully",
            url:route('admin::post-collection:list')
        );
    }

    private function EditRequest($check)
    {
        $this->request = $check->only([
            'title',
            'description',
            'post_items',
            'position',
            'status',
        ]);
        $this->postItems = BackendHelper::JsonDecode($this->request['post_items']);
    }

    private function NewRequest()
    {
        $this->request = [
            'title'=>null,
            'description'=>null,
            'post_items'=>null,
            'position'=>0,
            'status'=>1,
        ];
    }

}
