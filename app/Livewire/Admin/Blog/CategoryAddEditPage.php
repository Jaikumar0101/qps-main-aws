<?php

namespace App\Livewire\Admin\Blog;

use App\Helpers\Admin\BackendHelper;
use App\Helpers\Admin\SlugHelper;
use App\Models\BlogCategory;
use App\Rules\SlugValidate;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Component;

class CategoryAddEditPage extends Component
{
    public array $request = [];
    public array $metaRequest = [];

    public $category_id;

    public bool $editSlug;
    public mixed $slug = "";

    protected array $validationAttributes = [
        'request.name'=>'name',
        'request.slug'=>'slug',
        'metaRequest.title'=>'title',
        'metaRequest.description'=>'description',
    ];


    public function mount()
    {
        if (checkData($this->category_id))
        {
            $check = BlogCategory::find($this->category_id);
            $check?$this->EditRequest($check):redirect()->route('admin::blog:category')->with('error','Invalid Category ID');
        }
        else
        {
            $this->NewRequest();
        }
    }

    public function render()
    {
        return view('livewire.admin.blog.category-add-edit-page')
            ->layout('layouts.admin.app');
    }

    public function Save():void
    {
        $this->validate([
            'request.name'=>'required|max:255',
            'request.slug'=>['required','max:255',new SlugValidate(['model_id'=>$this->request['id'],'model_class'=>BlogCategory::class])],
            'metaRequest.title'=>'max:110',
            'metaRequest.description'=>'max:160',
        ]);
        $this->update($this->request);
        $this->dispatch('SweetMessage',
            type:'success',
            title:'Edit Category',
            message:'Updated Successfully',
            url:route('admin::blog:category'),
        );
    }

    public function Submit():void
    {
        $this->validate([
            'request.name'=>'required|max:255',
            'request.slug'=>['required','max:255',new SlugValidate(['model_id'=>null,'model_class'=>BlogCategory::class])],
            'metaRequest.title'=>'max:110',
            'metaRequest.description'=>'max:160',
        ]);
        $this->create($this->request);
        $this->dispatch('SweetMessage',
            type:'success',
            title:'New Category',
            message:'Created Successfully',
            url:route('admin::blog:category'),
        );
    }

    protected function update($data = []):void
    {
        try {
            BlogCategory::where('id',$data['id'])
                ->update(Arr::only($data,[
                    'parent_id',
                    'name',
                    'description',
                    'icon',
                    'thumbnail',
                    'position',
                    'status'
                ]));
            SlugHelper::createOrUpdate($data['slug'],$data['name'],$data['id'],BlogCategory::class);
            if (!isset($this->metaRequest['model_id']))
            {
                $this->metaRequest['model_id'] = $data['id'];
            }
            BackendHelper::createOrUpdateMetaData($this->metaRequest);
        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',
                type:'error',
                message:$exception->getMessage()
            );
        }
    }

    protected function create($data = []):void
    {
        try {
            $model = BlogCategory::create(Arr::only($data,[
                'parent_id',
                'name',
                'description',
                'icon',
                'thumbnail',
                'position',
                'status'
            ]));
            SlugHelper::createOrUpdate($data['slug'],$data['name'],$model->id,BlogCategory::class);
            $this->metaRequest['model_id'] = $model->id;
            BackendHelper::createOrUpdateMetaData($this->metaRequest);
            $this->NewRequest();
        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',
                type:'error',
                message:$exception->getMessage()
            );
        }
    }

    public function NewRequest():void
    {
        $this->metaRequest = BackendHelper::getMetaData(null,BlogCategory::class);

        $this->request = [
            'parent_id'=>null,
            'name'=>null,
            'slug'=>null,
            'description'=>null,
            'icon'=>null,
            'thumbnail'=>null,
            'position'=>0,
            'status'=>1
        ];
        $this->slug = null;
        $this->dispatch('removeUploadedFile');
    }

    public function EditRequest($category):void
    {
        $this->metaRequest = BackendHelper::getMetaData($category,BlogCategory::class);
        $this->request = $category->only([
            'id',
            'parent_id',
            'name',
            'description',
            'icon',
            'thumbnail',
            'position',
            'status'
        ]);
        $this->slug = $this->request['slug'] = $category->getSlugAttribute();
        $this->dispatch('removeUploadedFile');
    }

    public function generateSlug():void
    {
        try
        {
            if (!checkData($this->request['slug']))
            {
               $this->slug = $this->request['slug'] = Str::slug($this->request['name']);
            }
        }
        catch (\Exception $exception)
        {
            $this->slug = $this->request['slug'] = "";
            $this->dispatch('SetMessage',
                type:'error',
                message:$exception->getMessage()
            );
        }
    }

    public function destroy($cat_id = null)
    {
        $check = BlogCategory::find($cat_id);
        if($check)
        {
            $check->delete();
            $this->dispatch('SetMessage',
                type:'success',
                message:'Deleted successfully'
            );
        }
    }

    public function updatedRequestParentId()
    {
        $this->request['parent_id'] = $this->request['parent_id']!==""?$this->request['parent_id']:null;
    }

    public function EditSlug($edit = true)
    {
        $this->editSlug = $edit;
        if ($edit)
        {
            $this->slug = $this->request['slug'];
        }
    }

    public function SaveSlug()
    {
        $this->validate([
            'slug'=>'required',
        ]);
        $this->request['slug'] = $this->slug;
        $this->editSlug = false;
    }
}
