<?php

namespace App\Helpers\Traits;

use App\Models\InsuranceClaim;

trait ClaimsBulkAction
{
    public function permanentlyRemoveRecords():void
    {
        if (count($this->selected)>0)
        {
            InsuranceClaim::withTrashed()->whereIn('id',$this->selected)->forceDelete();
            $this->resetSelectedRows();
            $this->dispatch(
                "SetMessage",
                type:'success',message:'Removed Successfully',
            );
        }
        else
        {
            $this->dispatch(
                "SetMessage",
                type:'info',message:'Please select at least one record',
            );
        }
    }

    public function moveRecordsToTrashed():void
    {
        if (count($this->selected)>0)
        {
            InsuranceClaim::withTrashed()->whereIn('id',$this->selected)->delete();
            $this->resetSelectedRows();
            $this->dispatch(
                "SetMessage",
                type:'success',message:'Moved to Archived',
            );
        }
        else
        {
            $this->dispatch(
                "SetMessage",
                type:'info',message:'Please select at least one record',
            );
        }
    }

    public function restoreRecords():void
    {
        if (count($this->selected)>0)
        {
            InsuranceClaim::onlyTrashed()->whereIn('id',$this->selected)->restore();
            $this->resetSelectedRows();
            $this->dispatch(
                "SetMessage",
                type:'success',message:'Records Restored',
            );
        }
        else
        {
            $this->dispatch(
                "SetMessage",
                type:'info',message:'Please select at least one record',
            );
        }
    }

    public function moveLeadToArchive($id = null):void
    {
        if (checkData($id))
        {
            $claim = InsuranceClaim::find($id);
            if ($claim)
            {
                $claim->delete();
                $this->dispatch('SetMessage',
                    type:'success',
                    message:'Moved to archived'
                );
            }
        }
    }

    public function recoverArchiveLead($id = null):void
    {
        if (checkData($id))
        {
            $claim = InsuranceClaim::withTrashed()->find($id);
            if ($claim)
            {
                $claim->restore();
                $this->dispatch('SetMessage',
                    type:'success',
                    message:'Recovered Successfully'
                );
            }
        }
    }

    public function openBulkFieldUpdateModal():void
    {
        if (count($this->selected)>0)
        {
            $this->dispatch('openBulkFieldUpdateModal',selected:$this->selected);
        }
    }
}
