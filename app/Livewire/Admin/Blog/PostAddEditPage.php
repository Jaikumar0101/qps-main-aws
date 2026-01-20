<?php

namespace App\Livewire\Admin\Blog;

use App\Helpers\Admin\BackendHelper;
use App\Helpers\Admin\SlugHelper;
use App\Models\BlogPost;
use App\Rules\SlugValidate;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Component;

class PostAddEditPage extends Component
{
    public $post_id;
    public array $request = [], $metaRequest = [], $postCategoryRequest = [];
    public mixed $postTagRequest;

    public bool $editSlug;
    public mixed $slug = "";

    protected array $validationAttributes = [
        'request.title'=>'title',
        'request.slug'=>'slug',
        'request.status'=>'status',
        'request.desc'=>'description',
        'metaRequest.title'=>'title',
        'metaRequest.description'=>'description',
    ];

    public function mount()
    {
        if (isset($this->post_id) && $this->post_id!=="")
        {
            $post = BlogPost::find($this->post_id);
            if ($post)
            {
                $this->EditRequest($post);
            }
            else{ redirect()->route('admin::blog:posts')->with('error','Invalid Post'); }
        }
        else{ $this->NewRequest(); }
    }

    public function render()
    {
        return view('livewire.admin.blog.post-add-edit-page')
            ->layout('layouts.admin.app',['includeAddons'=>true]);
    }

    public function Save():void
    {
        $this->validate([
            'request.title'=>'required|max:255',
            'request.desc'=>'max:500',
            'request.slug'=>['required','max:255',new SlugValidate(['model_id'=>$this->post_id,'model_class'=>BlogPost::class])],
            'metaRequest.title'=>'max:110',
            'metaRequest.description'=>'max:160',
            'request.status'=>'required',
        ]);
        $this->update($this->request);
    }

    public function Submit():void
    {
        $this->validate([
            'request.title'=>'required|max:255',
            'request.desc'=>'max:500',
            'request.slug'=>['required','max:255',new SlugValidate(['model_id'=>null,'model_class'=>BlogPost::class])],
            'metaRequest.title'=>'max:110',
            'metaRequest.description'=>'max:160',
            'request.status'=>'required',
        ]);
        $this->create($this->request);
    }

    protected function create($data = [])
    {
        try {

            $post = BlogPost::create(Arr::only($data,[
                'user_id',
                'title',
                'desc',
                'content',
                'image',
                'post_date',
                'category',
                'format',
                'video_url',
                'video_embed',
                'read_time_format',
                'read_time',
                'layout',
                'status'
            ]));
            SlugHelper::createOrUpdate($data['slug'],$data['title'],$post->id,BlogPost::class);
            $this->metaRequest['model_id'] = $post->id;
            BackendHelper::createOrUpdateMetaData($this->metaRequest);
            BackendHelper::createOrUpdatePostTags($this->postTagRequest,$post->id);
            BackendHelper::createOrUpdatePostCategory($this->postCategoryRequest,$post->id);
            $this->post_id = $post->id;
            $this->dispatch('SweetMessage',
                type:'success',
                title:'New Post',
                message:'Created successfully',
                url:route('admin::blog:posts')
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

    protected function update($data = [])
    {
        try {
            $post = BlogPost::find($this->post_id);
            $post->fill(Arr::only($data,[
                'title',
                'desc',
                'content',
                'image',
                'post_date',
                'category',
                'format',
                'video_url',
                'video_embed',
                'read_time_format',
                'read_time',
                'layout',
                'status'
            ]));
            $post->save();
            SlugHelper::createOrUpdate($data['slug'],$data['title'],$this->post_id,BlogPost::class);
             if (!isset($this->metaRequest['model_id']))
             {
                 $this->metaRequest['model_id'] = $this->post_id;
             }
            BackendHelper::createOrUpdateMetaData($this->metaRequest);
            BackendHelper::createOrUpdatePostTags($this->postTagRequest,$post->id);
            BackendHelper::createOrUpdatePostCategory($this->postCategoryRequest,$post->id);
            $this->dispatch('SweetMessage',
                type:'success',
                title:'Edit Post',
                message:'Updated successfully',
                url:route('admin::blog:posts')
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

    protected function NewRequest():void
    {
        $this->metaRequest = BackendHelper::getMetaData(null,BlogPost::class);
        $this->postCategoryRequest = BackendHelper::getPostCategory();
        $this->postTagRequest = BackendHelper::getPostTags();
        $this->request = [
            'user_id'=>auth()->user()->id,
            'title'=>null,
            'slug'=>null,
            'desc'=>null,
            'content'=>null,
            'image'=>null,
            'post_date'=>now()->format('Y-m-d'),
            'category'=>null,
            'format'=>0,
            'video_url'=>null,
            'video_embed'=>null,
            'read_time_format'=>0,
            'read_time'=>0,
            'layout'=>'default',
            'status'=>0,
        ];
    }

    protected function EditRequest($post):void
    {
        $this->metaRequest = BackendHelper::getMetaData($post,BlogPost::class);
        $this->postCategoryRequest = BackendHelper::getPostCategory($post);
        $this->postTagRequest = BackendHelper::getPostTags($post);
        $this->request = $post->only([
            'user_id',
            'title',
            'desc',
            'content',
            'image',
            'post_date',
            'category',
            'format',
            'video_url',
            'video_embed',
            'read_time_format',
            'read_time',
            'layout',
            'status',
        ]);
        $this->request['slug'] = $post->getSlugAttribute();
    }

    public function generateSlug():void
    {
        try
        {
            if (!checkData($this->request['slug']))
            {
                $this->slug = $this->request['slug'] = Str::slug($this->request['title']);
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
