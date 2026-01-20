<?php

namespace App\Helpers\Traits;

use App\Models\UserNote;
use Illuminate\Support\Arr;

trait WithClaimNotes
{
    public array $notes = [];

    public function getClaimNotes($claim_id = null): void
    {
        if (checkData($claim_id))
        {
            $this->notes = UserNote::where([
                'claim_id'=>$claim_id,
            ])->orderBy('id','asc')->get()->toArray();
        }
        else
        {
            $this->notes = [];
        }
    }

    public function addNewClaimNote():void
    {
        $this->notes[] = [
            'user_id'=>$this->adminUser->id,
            'claim_id'=>$this->editModal->id,
            'title'=>null,
            'note'=>null,
            'due_date'=>null,
        ];
    }

    public function removeClaimNote($index):void
    {
        if (Arr::has($this->notes,$index))
        {
            $temp = $this->notes;
            if (Arr::has($temp[$index],'id'))
            {
                UserNote::where('id',$temp[$index]['id'])->delete();
                $this->dispatch('renderAdditionalNotesModal');
            }
            Arr::forget($temp,$index);
            $this->notes = array_values($temp);
        }
    }

    public function saveClaimNotes():void
    {
        foreach ($this->notes as $i=>$note)
        {
            $check = null;

            if (Arr::has($note,'id'))
            {
                $check = UserNote::find($note['id']);
            }

            if (!$check)
            {
                $check = new UserNote();
            }

            $check->fill(Arr::only($note,[
                'user_id',
                'claim_id',
                'title',
                'note',
            ]));

            $check->save();

            $this->notes[$i]['id'] = $check->id;
            $this->notes[$i]['created_at'] = $check->created_at;
        }

        if (count($this->notes)>0)
        {
            $this->dispatch('renderAdditionalNotesModal');
        }
    }

}
