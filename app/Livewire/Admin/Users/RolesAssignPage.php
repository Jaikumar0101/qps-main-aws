<?php

namespace App\Livewire\Admin\Users;

use App\Models\ClaimAssign;
use App\Models\ClientAssign;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RolesAssignPage extends Component
{
    use WithPagination;

    protected $paginationTheme = "simple-bootstrap";

    public $user_id;
    public ?User $user;
    public $requestClients = [];
    public $request = [];
    public $search;
    public $backUrl;

    public function mount()
    {
        $this->backUrl = back()->getTargetUrl();
        $this->user = User::find($this->user_id);
        if (!$this->user || $this->user->isMasterAdmin())
        {
            return redirect()->route('admin::users:admin.list')
                ->with('error','Invalid team member');
        }
        $this->NewRequest();
    }

    public function render()
    {
        $clients = Customer::query();
        if (checkData($this->search))
        {
            $clients->where(function ($q) {
                $q->orWhere('id', 'like', $this->search)
                    ->orWhere('first_name', 'like', "{$this->search}%")
                    ->orWhere('last_name', 'like', "%{$this->search}%")
                    ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$this->search}%");
            });
        }
        $clients = $clients->orderBy('first_name','asc')
            ->paginate(10);

        return view('livewire.admin.users.roles-assign-page',compact('clients'));
    }

    public function saveRoleAccess(): void
    {
        try
        {
            $tempClientAssign = [];
            $tempClaimAssign = [];

            foreach ($this->requestClients as $client_id)
            {
                $check = ClientAssign::where([
                    'user_id'=>$this->user->id,
                    'customer_id'=>$client_id,
                ])->first();

                if (!$check)
                {
                    $check = ClientAssign::create([
                        'user_id'=>$this->user->id,
                        'customer_id'=>$client_id,
                    ]);
                }

                $tempClientAssign[] = $check->id;

            }

            foreach ($this->request as $leads)
            {
                foreach ($leads as $lead_id)
                {
                    $check = ClaimAssign::where([
                        'user_id'=>$this->user->id,
                        'claim_id'=>$lead_id,
                    ])->first();

                    if (!$check)
                    {
                        $check = ClaimAssign::create([
                            'user_id'=>$this->user->id,
                            'claim_id'=>$lead_id,
                        ]);
                    }

                    $tempClaimAssign[] = $check->id;
                }
            }

            ClientAssign::where('user_id',$this->user->id)
                ->whereNotIn('id',$tempClientAssign)
                ->delete();
            ClaimAssign::where('user_id',$this->user->id)
                ->whereNotIn('id',$tempClaimAssign)
                ->delete();

            $this->dispatch('SweetMessage',type:'success',title:'Team Role Access',message:'Setup successfully',url:$this->backUrl);
        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',type:'error',message:$exception->getMessage());
        }
    }

    private function NewRequest()
    {
        $this->requestClients = ClientAssign::where('user_id',$this->user->id)
            ->pluck('customer_id')->toArray();

        foreach ($this->requestClients as $client)
        {
            $this->request[$client] = ClaimAssign::where('user_id',$this->user->id)
                ->whereHas('claim',function ($q) use ($client) {
                    $q->where('customer_id',$client);
                })
                ->pluck('claim_id')->toArray();
        }

    }

    public function updatedSearch():void
    {
        $this->resetPage();
    }

    public function assignClient($id = null): void
    {
        if (!in_array($id, $this->requestClients)) {
            $this->requestClients[] = $id;
        }
    }

    public function removeClient($id = null): void
    {
        $index = array_search($id, $this->requestClients);
        if ($index !== false) {
            unset($this->requestClients[$index]);
        }
    }

    public function addLeadAccess($customer_id,$lead_id): void
    {
        $customer_id = (int)$customer_id;
        $lead_id = (int)$lead_id;

        if (!\Arr::has($this->request,$customer_id))
        {
            $this->request[$customer_id] = [];
        }

        if (!in_array($lead_id,$this->request[$customer_id]))
        {
            $this->request[$customer_id][] = $lead_id;
        }
    }

    public function removeLeadAccess($customer_id, $lead_id): void
    {
        $customer_id = (int)$customer_id;
        $lead_id = (int)$lead_id;

        if (\Arr::has($this->request, $customer_id)) {
            $index = array_search($lead_id, $this->request[$customer_id]);
            if ($index !== false) {
                unset($this->request[$customer_id][$index]);
            }
        }
    }

}
