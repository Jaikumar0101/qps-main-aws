<?php

namespace App\Livewire\Admin\Tasks\Components;

use App\Helpers\Quick\QuickConstants;
use App\Models\QuickProject;
use App\Models\QuickProjectCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectListContent extends Component
{
    use QuickConstants;

    use WithPagination;
    protected $paginationTheme = "bootstrap";

    protected $validationAttributes = [
        'request.name'=>'name'
    ];

    protected $rules = [
        'request.name'=>'required|max:255',
    ];

    public $selectedCategory;

    public $search;

    public $request = [];

    public $editModal = false;

    public $categories = [];

    public $filter = [
        'status'=>null
    ];

    public $adminUser;

    public function mount()
    {
        $this->adminUser = Auth::user();

        $this->selectedCategory = QuickProjectCategory::where('parent_id',null)
            ->orderBy('position','asc')
            ->first();
        $this->getCategories();
        $this->NewRequest();
    }

    #[On('Quick::project:render')]
    public function render()
    {
        $data = QuickProject::query();

        $data->where('category_id',$this->selectedCategory?->id ??null);

        if (checkData($this->search))
        {
            $data->where(function ($q){
                $q->orWhere('name','LIKE',"%{$this->search}%")
                    ->orWhere('name','LIKE',"%{$this->search}%");
            });
        }

        if (checkData($this->filter['status']))
        {
            $data->where('status',$this->filter['status']);
        }

        $data->orderBy('id','desc');

        $data =  $data->paginate(10);

        return view('livewire.admin.tasks.components.project-list-content',compact('data'));
    }

    #[On('Quick::project:category-change')]
    public function changeCategory($category_id = null): void
    {
        $this->selectedCategory = QuickProjectCategory::find($category_id);
    }

    public function openAddEditModal():void
    {
        $this->dispatch('clearFlatPickerRange');
        $this->getCategories();
        $this->NewRequest();
        $this->editModal = true;
    }

    public function Submit():void
    {
        $this->validate($this->rules);
        $this->create($this->request);
        $this->dispatch($this->eventRenderMethods['categoryListRenderMethod']);
    }

    protected function create($data = [])
    {
        try
        {
            $data['start_date'] = checkData($data['start_date'])
                ?Carbon::parse($data['start_date'])->format('Y-m-d')
                :null;
            $data['end_date'] = checkData($data['end_date'])
                ?Carbon::parse($data['end_date'])->format('Y-m-d')
                :null;
            QuickProject::create($data);
            $this->editModal = false;
            $this->NewRequest();
            $this->dispatch('SetMessage',type:'success',message:'Added Successfully');

        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',type:'error',message:$exception->getMessage());
        }
    }

    public function NewRequest():void
    {
        $this->request = [
            'user_id'=>$this->adminUser->id,
            'category_id'=>$this->selectedCategory?->id ??null,
            'name'=>null,
            'description'=>null,
            'content'=>null,
            'image'=>null,
            'start_date'=>null,
            'end_date'=>null,
            'company'=>null,
            'project_report'=>null,
            'emails'=>null,
            'tags'=>null,
            'status'=>QuickProject::STATUS_ACTIVE,
        ];
    }

    public function getCategories():void
    {
        $this->categories = QuickProjectCategory::where('parent_id',null)
            ->orderBy('position','asc')
            ->get();

    }

    public function destroy($id = null)
    {
        $check = QuickProject::find($id);
        if ($check)
        {
            $check->delete();
            $this->dispatch($this->eventRenderMethods['categoryListRenderMethod']);
            $this->dispatch('SetMessage',type:'success',message:'Moved to trash');
        }
    }
}
