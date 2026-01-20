<?php

namespace App\Livewire\Admin\Tasks\Components;

use App\Helpers\Quick\QuickConstants;
use App\Models\QuickProject;
use App\Models\QuickTask;
use App\Models\QuickTaskCategory;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithPagination;
use function Symfony\Component\String\b;

class ProjectTaskTabContent extends Component
{
    use WithPagination, QuickConstants;

    public QuickProject $project;

    public $request = [];
    public $categoryRequest = [];

    public $search;
    public $selectedCategory;

    public $editModel = false;
    public $taskModel = false;

    public $editInlineTask = false;


    protected $validationAttributes = [
        'request.name'=>'name',
        'request.description'=>'description',

        'categoryRequest.name'=>'name',
        'categoryRequest.description'=>'description',
        'categoryRequest.position'=>'position',
        'request.parent_id'=>'task list'
    ];

    protected function rules($case = 0):array
    {
        return match ($case){
            1=>[
                'categoryRequest.name'=>'required|max:255',
                'categoryRequest.description'=>'max:500',
                'categoryRequest.position'=>'required|numeric|min:0',
            ],
            default=>[
                'request.name'=>'required|max:255',
                'request.parent_id'=>'required'
            ],
        };
    }
    public function mount()
    {
        $this->NewTaskRequest();
        $this->NewTaskListRequest();
    }
    public function render()
    {
        $categories = QuickTaskCategory::where('project_id',$this->project->id)
            ->where(function ($q){
                $q->orWhere(function ($qs){
                    $qs->whereDoesntHave('tasks');
                })
                ->orWhere(function ($qs){
                    $qs->whereHas('tasks',function ($task){
                        $task->where('is_completed',0);
                    });
                });
            })
            ->orderBy('position','asc')
            ->get();

        $completedCategories = QuickTaskCategory::withCount('tasks')
            ->where('project_id',$this->project->id)
            ->has('tasks','>',0)
            ->where(function ($q){
                $q->orWhere(function ($qs){
                        $qs->whereDoesntHave('tasks',function ($task){
                            $task->where('is_completed',0);
                        });
                   });
            })
            ->orderBy('position','asc')
            ->get();


        $totalCount = QuickTask::whereIn('parent_id',$categories->pluck('id')->toArray())->count();

        $data = QuickTask::query();

        $data->whereHas('project',function ($q){
            $q->where('quick_projects.id',$this->project->id);
        });

        if (checkData($this->search))
        {
            $data->where(function ($q){
                $q->orWhere('name','LIKE',"%{$this->search}%");
            });
        }

        if (checkData($this->selectedCategory))
        {
            $data->where('parent_id',$this->selectedCategory);
        }
        else
        {
            $data->whereIn('parent_id',$categories->pluck('id')->toArray());
        }

       $data = $data->orderBy('id','desc')
           ->get();

        return view('livewire.admin.tasks.components.project-task-tab-content',compact('categories','completedCategories','data','totalCount'));
    }

    public function Submit():void
    {
        $this->validate($this->rules(case:1));

        try
        {
            if (Arr::has($this->categoryRequest,'id'))
            {
                $check = QuickTaskCategory::find($this->categoryRequest['id']);
                $message = "Updated successfully";
            }
            else
            {
                $check = new QuickTaskCategory();
                $message = "Created successfully";
            }

            $check->fill(Arr::except($this->categoryRequest,'id'));
            $check->save();

            $this->editModel = false;

            $this->dispatch('SetMessage',type:'success',message:$message);

        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',type:'error',message:$exception->getMessage());
        }

    }

    public function SaveTask()
    {
        $this->validate($this->rules());

        try {
            if (Arr::has($this->request,'id'))
            {
                $check = QuickTask::find($this->request['id']);
                $message = "Updated successfully";
            }
            else
            {
                $check = new QuickTask();
                $message = "Created successfully";
            }

            $check->fill(Arr::except($this->request,'id'));
            $check->save();

            $this->taskModel = false;

            if(!$this->editInlineTask)
            {
                $this->dispatch('SetMessage',type:'success',message:$message);
            }

            $this->editInlineTask = false;
        }
        catch (\Exception $exception){
            $this->dispatch('SetMessage',type:'error',message:$exception->getMessage());
        }
    }

    public function openAddEditTaskModal($id = null):void
    {
        if (checkData($id))
        {
            $check = QuickTaskCategory::find($id);
            $this->EditTaskRequest($check);
            $this->editModel = true;
        }
        else
        {
            $this->NewTaskRequest();
            $this->editModel = true;
        }
    }

    public function NewTaskRequest():void
    {
        $this->categoryRequest = [
            'project_id'=>$this->project->id,
            'name'=>null,
            'description'=>null,
            'position'=>0,
            'status'=>1,
        ];
    }

    public function EditTaskRequest($check):void
    {
        $this->categoryRequest = $check->only([
            'id',
            'project_id',
            'name',
            'description',
            'position',
            'status',
        ]);
    }

    public function openAddEditTaskMainModal($id = null, $inline = false):void
    {
        if (checkData($id))
        {
            $check = QuickTask::find($id);
            $this->EditTaskListRequest($check);
            $this->dispatch('resetModalEditor',content:$check->content ??'');
            if ($inline){
                $this->editInlineTask = true;
                $this->taskModel = false;
            }else{
                $this->taskModel = true;
                $this->editInlineTask = false;
            }
        }
        else
        {
            $this->NewTaskListRequest();
            $this->dispatch('resetModalEditor',content:'');
            if ($inline){
                $this->editInlineTask = true;
                $this->taskModel = false;
            }else{
                $this->taskModel = true;
                $this->editInlineTask = false;
            }
        }
    }

    public function NewTaskListRequest():void
    {
        $this->request = [
            'parent_id'=>$this->selectedCategory,
            'name'=>null,
            'subject'=>null,
            'content'=>null,
            'start_date'=>null,
            'end_date'=>null,
            'status'=>null,
            'is_completed'=>false,
        ];

        $this->dispatch('clearFlatPickerTaskRange');
    }

    public function EditTaskListRequest($check):void
    {
        $this->request = $check->only([
            'id',
            'parent_id',
            'name',
            'subject',
            'content',
            'start_date',
            'end_date',
            'status',
            'is_completed',
        ]);
    }

    public function changeCurrentList($id = null):void
    {
        $this->selectedCategory = $id;
        $this->editInlineTask = false;
        $this->NewTaskListRequest();
    }

    public function destroyTaskList($id = null):void
    {
        $check = QuickTaskCategory::find($id);

        if ($check)
        {
            if($this->selectedCategory == $check->id){
                $this->selectedCategory = null;
            }

            $check->delete();
            $this->dispatch('SetMessage',type:'success',message:'Deleted successfully');
        }
    }

    public function destroyTask($id = null)
    {
        $check = QuickTask::find($id);

        if ($check)
        {
            $this->editInlineTask = false;
            $check->delete();
            $this->dispatch('SetMessage',type:'success',message:'Deleted successfully');
        }
    }

    public function closeTaskInline(): void
    {
        $this->editInlineTask = false;
        $this->NewTaskListRequest();
    }

    public function toggleMore($id = null)
    {
        if ($this->editInlineTask)
        {
            $this->editInlineTask = false;
            $this->NewTaskListRequest();
        }
        else
        {
            $this->openAddEditTaskMainModal($id,true);
        }
    }

    public function markAsCompleted($id)
    {
        $check = QuickTask::find($id);
        if ($check)
        {
            $check->is_completed = !$check->is_completed;
            $check->save();
        }
    }
}
