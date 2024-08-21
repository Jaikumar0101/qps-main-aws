<?php

namespace App\Livewire\Admin\Themes;

use App\Helpers\Admin\BackendHelper;
use App\Helpers\Admin\SlugHelper;
use App\Models\ThemePage;
use App\Rules\SlugValidate;
use Illuminate\Support\Str;
use Livewire\Component;

class PagesAddEditPage extends Component
{
    public $page_id;
    public $request = [],$metaRequest = [];

    public bool $editSlug;
    public mixed $slug = "";

    protected $validationAttributes = [
        'request.name'=>'title',
        'request.authenticate'=>'authenticate',
        'request.status'=>'status',
        'metaRequest.title'=>'title',
        'metaRequest.description'=>'description',
    ];

    protected function rules()
    {
        return [
            'request.name'=>'required|max:255',
            'request.slug'=>['required','max:255',new SlugValidate(['model_id'=>$this->page_id ??null,'model_class'=>ThemePage::class])],
            'metaRequest.title'=>'max:110',
            'metaRequest.description'=>'max:160',
            'request.status'=>'required',
        ];
    }

    public function mount()
    {
        if (isset($this->page_id) && $this->page_id!=="")
        {
            $check = ThemePage::find($this->page_id);
            if ($check)
            {
                $this->EditRequest($check);
            }
            else{ redirect()->route('admin::theme:pages.list')->with('error','Invalid Page Id'); }
        }
        else{ $this->NewRequest(); }
    }

    public function render()
    {
        return view('livewire.admin.themes.pages-add-edit-page');
    }

    public function Submit()
    {
        $this->validate($this->rules());
        $this->create($this->request);
    }

    private function create($data)
    {
        try {

            $check = ThemePage::create(\Arr::except($data,'slug'));
            $this->metaRequest['model_id'] = $this->page_id = $check->id;
            SlugHelper::createOrUpdate($data['slug'],$data['name'],$check->id,ThemePage::class);
            BackendHelper::createOrUpdateMetaData($this->metaRequest);
            $this->dispatch('SweetMessage',
                type:'success',
                title:'New Page',
                message:'Created successfully',
                url:route('admin::theme:pages.list')
            );
        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',type:'error',message:$exception->getMessage());
        }
    }

    public function Save()
    {
        $this->validate($this->rules());
        $this->update($this->request);
    }

    private function update($data)
    {
        try {
            $check = ThemePage::find($this->page_id);
            $check->fill(\Arr::except($data,'slug'));
            $check->save();
            $this->metaRequest['model_id'] = $check->id;
            SlugHelper::createOrUpdate($data['slug'],$data['name'],$check->id,ThemePage::class);
            BackendHelper::createOrUpdateMetaData($this->metaRequest);
            $this->dispatch('SweetMessage',
                type:'success',
                title:'Edit Page',
                message:'Updated successfully',
                url:route('admin::theme:pages.list')
            );
        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',type:'error',message:$exception->getMessage());
        }
    }

    private function NewRequest(): void
    {
        $this->request = [
            'name'=>null,
            'authenticate'=>0,
            'content'=>"",
            'status'=>1,
        ];
        $this->slug = $this->request['slug'] = null;
        $this->metaRequest = BackendHelper::getMetaData(null,ThemePage::class);
    }
    private function EditRequest($check): void
    {
        $this->metaRequest = BackendHelper::getMetaData($check,ThemePage::class);
        $this->request = $check->only([
            'name',
            'content',
            'authenticate',
            'status',
        ]);
        $this->slug = $this->request['slug'] = $check->getSlugAttribute();
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
