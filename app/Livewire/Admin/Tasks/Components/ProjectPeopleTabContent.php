<?php

namespace App\Livewire\Admin\Tasks\Components;

use App\Helpers\Quick\QuickConstants;
use App\Helpers\Quick\QuickTaskHelper;
use App\Models\QuickProjectAssign;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectPeopleTabContent extends Component
{
    use WithPagination, QuickConstants;

    protected $paginationTheme = "bootstrap";

    public $project;

    public $filter = false;

    public $search;

    public $companies = [];
    public $selectedCompanies = [];

    public $selectedPeople = [];

    public function mount()
    {
        $this->companies = User::select('company')
            ->whereNotNull('company')
            ->where('company', '!=', '')
            ->where('company', '!=', null)
            ->distinct()
            ->pluck('company')
            ->all();
    }

    public function render()
    {
        $data = User::query();

        $data->where('status',1);

        $data->whereDoesntHave('projectAssigned',function ($q){
            $q->where('project_id',$this->project->id);
        });

        if (checkData($this->search))
        {
            $data->where(function ($q){
                $q->orWhere('id','like',$this->search)
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orWhere('name','like',"{$this->search}%")
                    ->orWhere('name','like',"%{$this->search}%")
                    ->orWhere('last_name', 'like', "%{$this->search}%")
                    ->orWhere('company','like',"%{$this->search}%");
            });
        }

        if ($this->filter && count($this->selectedCompanies)>0)
        {
            $data->whereIn('company',$this->selectedCompanies);
        }

        $data = $data->paginate(6,['*'],'peoplePage');

        $assignedUsers = User::where('status',1)
            ->whereHas('projectAssigned',function ($q){
                $q->where('project_id',$this->project->id);
            })->paginate(10,['*'],'assignedPeoplePage');

        return view('livewire.admin.tasks.components.project-people-tab-content',compact('data','assignedUsers'));
    }
    public function resetSearch():void
    {
        $this->search = null;
    }

    public function assignUser($user_id = null): void
    {
        if (checkData($user_id))
        {
            QuickTaskHelper::assignUserToProject($this->project->id,$user_id);
        }
        $this->selectedPeople = [];
    }

    public function resetAssignedTeam():void
    {
        QuickProjectAssign::where('project_id',$this->project->id)->delete();
    }

    public function removeAssignedUser($user_id = null):void
    {
        QuickProjectAssign::where([
            'project_id'=>$this->project->id,
            'user_id'=>$user_id,
        ])->delete();
    }

    public function assignMultiplePeople():void
    {
        foreach ($this->selectedPeople as $item)
        {
            QuickTaskHelper::assignUserToProject($this->project->id,$item);
        }
        $this->selectedPeople = [];
    }

}
