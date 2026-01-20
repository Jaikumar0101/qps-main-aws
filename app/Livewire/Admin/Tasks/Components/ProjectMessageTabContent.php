<?php

namespace App\Livewire\Admin\Tasks\Components;

use App\Helpers\Admin\BackendHelper;
use App\Models\QuickProjectMessage;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProjectMessageTabContent extends Component
{
    public $project;

    public $request = [];

    public $perPage = 10;

    public $selectedCategory;

    public $editMessage = false;

    public $adminUser;

    protected $validationAttributes = [
        'request.subject'=>'subject',
    ];

    protected $rules = [
        'request.subject'=>'required|max:255',
    ];
    public function mount()
    {
        $this->adminUser = Auth::user();
        $this->NewRequest();
    }

    public function render()
    {
        $data = QuickProjectMessage::query();

        $data->where('project_id',$this->project->id);

        $data = $data->orderBy('id','desc')
            ->paginate($this->perPage,['*'],'messagePage');

        return view('livewire.admin.tasks.components.project-message-tab-content',compact('data'));
    }

    public function Submit()
    {
        $this->validate($this->rules);
        if (Arr::has($this->request,'id'))
        {
            $this->update($this->request);
        }
        else
        {
            $this->create($this->request);
        }
        $this->dispatch('removeUploadedFile');
    }

    public function create($data = [])
    {
        try
        {
            $data['files'] = BackendHelper::JsonEncode($data['files']);
            $data['notified_people'] = BackendHelper::JsonEncode($data['notified_people']);
            QuickProjectMessage::create($data);
            $this->backToMessage();
            $this->dispatch('SweetMessage',type:'success',title:'New Message',message:'Posted Successfully');
        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',type:'error',message:$exception->getMessage());
        }
    }

    public function update($data = [])
    {
        try
        {
            $data['files'] = BackendHelper::JsonEncode($data['files']);
            $data['notified_people'] = BackendHelper::JsonEncode($data['notified_people']);

            $check = QuickProjectMessage::find($data['id']);
            $check->fill($data);
            $check->save();

            $this->backToMessage();
            $this->dispatch('SweetMessage',type:'success',title:'Edit Message',message:'Updated Successfully');
        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',type:'error',message:$exception->getMessage());
        }
    }

    public function openAddEditMessageModal($id = null):void
    {
        if (checkData($id))
        {
            $check = QuickProjectMessage::find($id);
            if ($check)
            {
                $this->EditRequest($check);
                $this->editMessage = true;
            }
        }
        else
        {
            $this->NewRequest();
            $this->editMessage = true;
        }
    }

    private function NewRequest():void
    {
        $this->request = [
            'user_id'=>$this->adminUser->id,
            'project_id'=>$this->project->id,
            'category_id'=>null,
            'subject'=>null,
            'content'=>null,
            'tags'=>null,
            'files'=>[],
            'notified'=>1,
            'notified_people'=>[],
            'people_access'=>1,
        ];
        $this->dispatch('addMessageTextEditor',content:$this->request['content'] ??'');
    }

    private function EditRequest($check):void
    {
        $this->request = $check->only([
            'id',
            'user_id',
            'project_id',
            'category_id',
            'subject',
            'content',
            'tags',
            'files',
            'notified',
            'notified_people',
            'people_access',
        ]);

        $this->request['files'] = BackendHelper::JsonDecode($this->request['files']);
        $this->request['notified_people'] = BackendHelper::JsonDecode($this->request['notified_people']);

        $this->dispatch('addMessageTextEditor',content:$this->request['content'] ??'');
    }

    public function changeCurrentList($id = null): void
    {
        $this->selectedCategory = $id;
        $this->backToMessage();
    }

    public function backToMessage():void
    {
        $this->editMessage = false;
    }

    public function uploadNewResource($data = [],$type = "files"): void
    {
        if ($data['success'] && Arr::has($this->request,$type))
        {
            $data = $data['data'];
            $this->request[$type][] = [
                'id'=>$data['id'],
                'name'=>$data['name'] ??'',
                'file'=>$data['url'] ??'',
            ];
        }
    }

    public function removeDocumentItem($index = null,$type = "files"): void
    {
        if (Arr::has($this->request,$type))
        {
            $temp = $this->request[$type];
            if (Arr::has($temp,$index))
            {
                Arr::forget($temp,$index);

                $this->request[$type] = array_values($temp);

            }
        }
    }

    public function destroy($id = null):void
    {
        $check = QuickProjectMessage::find($id);
        if ($check)
        {
            $check->delete();
            $this->dispatch('SetMessage',type:'success',message:'Deleted successfully');
        }
    }
}
