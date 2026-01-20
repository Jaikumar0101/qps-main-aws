<?php

namespace App\Livewire\Admin\InsuranceClaim;

use App\Helpers\Admin\BackendHelper;
use App\Helpers\Imports\ImportHelper;
use App\Helpers\Imports\ImportRevertHelper;
use App\Imports\ClaimImport;
use App\Models\Customer;
use App\Models\ImportClaim;
use App\Models\ImportClaimHistory;
use App\Models\User;
use Excel;
use Livewire\Component;
use Livewire\WithPagination;

class ClaimImportPage extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $request = [];
    public $importRequest = [];
    public ?User $adminUser;
    public $importHistory;
    public $importErrors = [];

    public $staff = true;

    public $importClaimLog;

    protected $validationAttributes = [
        'request.name'=>'name',
        'request.file'=>'file',
        'request.note'=>'note',
        'request.client_id'=>'client'
    ];

    protected $rules = [
        'request.name'=>'required|max:255',
        'request.file'=>'required',
        'request.client_id'=>'required|exists:customers,id',
        'request.note'=>'max:5000',
    ];

    public $clients = [];

    public function mount():void
    {
        $this->adminUser = auth()->user();
        $this->staff = $this->adminUser?->isStaff();
        $this->NewRequest();

        $this->clients = Customer::where('status',1)->orderBy('first_name','asc')->get();
    }


    public function render()
    {
        $data = $this->getData();
        return view('livewire.admin.insurance-claim.claim-import-page',compact('data'));
    }

    private function getData()
    {
        $data = ImportClaim::query();

        if ($this->staff)
        {
            $data->where('user_id',$this->adminUser->id);
        }

        return $data->orderBy('id','desc')
            ->paginate(10);
    }

    public function SaveImportHistory(): void
    {
        $this->validate($this->rules);
        try
        {

            ImportClaim::create($this->request);

            $this->NewRequest();

            $this->dispatch('removeUploadedFile');
            $this->dispatch('SetMessage',
                type:'success',
                message:'File added successfully',
                close:true
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


    public function OpenAddEditModal():void
    {
        $this->NewRequest();
        $this->dispatch('OpenAddEditModal');
    }

    public function OpenImportModal($id = null):void
    {
        $this->importClaimLog = ImportClaim::find($id);
        if ($this->importClaimLog)
        {
            if ($this->importClaimLog->history()->exists())
            {
                $this->importHistory = $this->importClaimLog->history()->latest()->first();
                $this->importErrors = BackendHelper::JsonDecode($this->importHistory->errors);
            }
            else
            {
                $this->importErrors = [];
            }
            $this->dispatch('OpenImportModal');
        }
    }

    private function NewRequest():void
    {
        $this->request = [
            'user_id'=>$this->adminUser->id,
            'client_id'=>null,
            'name'=>null,
            'note'=>null,
            'file'=>null,
            'status'=>0,
        ];
    }

    public function ImportLead($id)
    {
        $check = ImportClaim::find($id);
        if ($check)
        {

            // $importHelper = new ImportHelper($check);
            // $results = $importHelper->ImportLeads();

            $importer = new ClaimImport($check);
            Excel::import($importer, $check->getFilePath());

            $this->dispatch('SetMessage',
                    type: 'success',
                    message: 'Imported successfully',
                );

            // if ($results['success'])
            // {
            //     $this->dispatch('SetMessage',
            //         type:'success',
            //         message:'Imported successfully',
            //     );
            // }
            // else
            // {
            //     $this->dispatch('SetMessage',
            //         type:'error',
            //         message:$results['message'],
            //     );
            // }
        }
    }

    public function destroy($id)
    {
        $check = ImportClaim::find($id);
        if ($check)
        {
            $check->delete();
            $this->dispatch('SetMessage',
                type:'success',
                message:'Deleted successfully',
            );
        }
    }

    public function revertBackImport($id = null)
    {
        $check = ImportClaim::find($id);

        if($check)
        {
            $importRevertHelper = new ImportRevertHelper($check);
            $result = $importRevertHelper->revert();

            if ($result['success'])
            {
                $this->dispatch('SetMessage',type:'success',message:'Reverted successfully');
            }
            else
            {
                $this->dispatch('SetMessage',type:'error',message:$result['message']);
            }

        }
    }

}
