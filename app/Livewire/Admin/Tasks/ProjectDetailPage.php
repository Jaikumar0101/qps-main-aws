<?php

namespace App\Livewire\Admin\Tasks;

use App\Helpers\Quick\QuickConstants;
use App\Helpers\Quick\QuickTaskHelper;
use App\Models\Customer;
use App\Models\QuickProject;
use App\Models\QuickProjectCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectDetailPage extends Component
{
    use WithPagination, QuickConstants;

    public $client_id;
    public $client;

    public $project;

    public $pageTitle = "";

    public $currentTab = "dashboard";

    public $settingRequest = [];

    public $request = [];

    public $categories = [];

    public $adminUser;

    protected $validationAttributes = [
        'request.name'=>'name'
    ];

    protected $rules = [
        'request.name'=>'required|max:255',
    ];

    public function mount()
    {
        $this->adminUser = Auth::user();
        try
        {
            if (checkData($this->client_id))
            {
                $this->client = Customer::find($this->client_id);

                if (!$this->client)
                {
                    return redirect()->route('admin::customers:list')->with('error','Invalid client');
                }

                $this->project = QuickProject::findByClient($this->client_id);

                if(!$this->project)
                {
                    $this->project = QuickProject::create([
                        'user_id'=>$this->adminUser->id,
                        'client_id'=>$this->client->id,
                        'name'=>$this->client->last_name,
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
                    ]);
                }

                if (!$this->project)
                {
                    return redirect()->route('admin::customers:list')->with('error','Invalid project');
                }

                $this->pageTitle = $this->project->name ??'';
            }
            else
            {
                return redirect()->route('admin::customers:list')->with('error','Invalid project');
            }
        }
        catch (\Exception $exception)
        {
            return redirect()->route('admin::customers:list')->with('error','Invalid project');
        }

        $this->NewRequest($this->project);

        $this->currentTab = $this->settingRequest['default_tab'];

        $this->categories = QuickProjectCategory::where('parent_id',null)
            ->orderBy('position','asc')
            ->get();
    }

    #[On('Quick::project::main:render')]
    public function render()
    {
        return view('livewire.admin.tasks.project-detail-page');
    }

    public function NewRequest($check):void
    {
        $this->settingRequest = QuickTaskHelper::getProjectSettings($this->project->id);

        $this->request = $check->only([
            'name',
            'description',
            'content',
            'image',
            'start_date',
            'end_date',
            'company',
            'project_report',
            'emails',
            'tags',
            'status',
        ]);
    }

    public function changePageTitle($title = "Project"):void
    {
        $this->pageTitle = $title;
    }

    public function saveSetting():void
    {
        $this->validate($this->rules);

        QuickTaskHelper::saveProjectSetting($this->project,$this->settingRequest);

        $this->saveProjectDetail($this->request);

        $this->dispatch('SetMessage',
            type:'success',
            message:'Setting Saved',
        );
    }

    protected function saveProjectDetail($data = [])
    {
        $data['start_date'] = checkData($data['start_date'])
            ?Carbon::parse($data['start_date'])->format('Y-m-d')
            :null;
        $data['end_date'] = checkData($data['end_date'])
            ?Carbon::parse($data['end_date'])->format('Y-m-d')
            :null;

        $this->project->fill($data);

        $this->project->save();

        $this->pageTitle = $this->project->name ??'';
    }
}
