<?php

namespace App\Livewire\Admin\Components\Notes;

use App\Models\UserNote;
use Illuminate\Support\Arr;
use Livewire\Attributes\On;
use Livewire\Component;

class AdditionalNotesModel extends Component
{
    public $noteModal = false;

    public $limit = 5;

    public $adminId;

    public $request = [];

    protected $validationAttributes = [
        'request.note'=>'note'
    ];

    protected $rules = [
        'request.note'=>'required',
    ];

    public function mount()
    {
        $this->adminId = auth()->user()->id;
        $this->NewRequest();
    }

    #[On('renderAdditionalNotesModal')]
    public function render()
    {
        $data = UserNote::where('user_id',$this->adminId)
            ->orderBy('id','desc')
            ->paginate($this->limit,['*'],'userNotePage');

        return view('livewire.admin.components.notes.additional-notes-model',compact('data'));
    }

    #[On('openUserNotesModal')]
    public function openNotesModal():void
    {
        $check = UserNote::where('user_id',$this->adminId)
            ->latest()
            ->first();
        $check?$this->EditRequest($check):$this->NewRequest();

        $this->noteModal = true;
    }

    public function saveNoteAndClose(): void
    {
        $this->saveNote(true);
    }

    public function saveNote($withClose = false):void
    {
        $this->validate($this->rules);

        try
        {
            $check = null;

            if (Arr::has($this->request,'id'))
            {
                $check = UserNote::where([
                    'id'=>$this->request['id'],
                    'user_id'=>$this->adminId,
                ])->first();
            }

            if (!$check)
            {
                $check = new UserNote();
            }

            $check->fill($this->request);
            $check->save();
            $this->request['id'] = $check->id;

            $this->dispatch('SetMessage',type:'success',message:'Note Saved');

            if ($withClose)
            {
                $this->noteModal = false;
            }

        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',type:'error',message:$exception->getMessage());
        }

    }

    public function openEditNote($noteId = null)
    {
        $check = UserNote::find($noteId);
        if ($check)
        {
            $this->EditRequest($check);
        }
    }

    public function EditRequest($check):void
    {
        $this->request = $check->only([
            'id',
            'claim_id',
            'user_id',
            'title',
            'note',
            'due_date',
        ]);
    }

    public function NewRequest():void
    {
        $this->request = [
            'user_id'=>$this->adminId,
            'claim_id'=>null,
            'title'=>null,
            'note'=>null,
            'due_date'=>null,
        ];
    }

    public function loadMore(): void
    {
        $this->limit +=10;
    }


    public function destroy($id = null)
    {
        $check = UserNote::find($id);
        if ($check)
        {
            $check->delete();
            $this->dispatch('SetMessage',type:'success',message:'Note Removed');
        }
    }

}

