<?php

namespace App\Livewire\Admin\Other;

use App\Models\ContactMail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Rap2hpoutre\FastExcel\FastExcel;

class ContactMailPage extends Component
{
    use WithPagination;
    protected string $paginationTheme = "bootstrap";
    public array $requestFilter = [];
    public array $filter = [];
    public mixed $search,$exportFiles = [];
    public string $status = "";
    public array $request = [];

    public function mount()
    {
        $this->resetFilter();
    }

    public function render()
    {

        if (isset($this->search) && $this->search!=="")
        {
            $data = ContactMail::query();
            $data->where(function ($q){
                    $q->orWhere('id','LIKE',$this->search)
                        ->orWhere(DB::raw("CONCAT(`first_name`, ' ', `last_name`)"), 'LIKE', "%{$this->search}%")
                        ->orWhere('first_name','like',"{$this->search}%")
                        ->orWhere('last_name','like',"%{$this->search}")
                        ->orWhere('email','like',"%{$this->search}")
                        ->orWhere('phone','like',"%{$this->search}")
                        ->orWhere('subject','like',"%{$this->search}");

                });
            if (checkData($this->status))
            {
                   $data->where('status',$this->status);
            }
            $data = $data->orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        else
        {
            $data = ContactMail::query();
            if (checkData($this->status))
            {
                $data->where('status',$this->status);
            }
            $data = $data->orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                 ->paginate($this->filter['perPage']);
        }

        return view('livewire.admin.other.contact-mail-page',compact('data'))
            ->layout('layouts.admin.app',['includeAddons'=>true]);
    }

    public function exportData():void
    {
        $this->exportFiles = [];
        ContactMail::orderBy($this->filter['sortBy'],$this->filter['orderBy'])
            ->chunk(10000, function ($history) {
                $filename = time()."export_contact_mails.xlsx";
                $path = storage_path('app/exports/').$filename;
                (new FastExcel($history->sortByDesc('id')))->headerStyle(config('excel.header_style'))
                    ->export($path, function ($ranking) {
                        return [
                            "Id"=>$ranking->id ??'',
                            "First Name"=>$ranking->name ??'',
                            "Last Name"=>$ranking->last_name ??'',
                            "Email"=>$ranking->email ??'',
                            "Subject"=>$ranking->subject ??'',
                            "Message"=>$ranking->message ??'',
                            "Time"=>get_time_by_format($ranking->created_at),
                        ];
                    });
                $this->exportFiles [] = [
                    'name'=>$filename,
                    'link'=>'app/exports/'.$filename,
                    'path'=>$path,
                    'removed'=>false,
                ];
            });
        $this->dispatch('OpenExportModal');
    }

    public function DownloadFile($index): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $path = $this->exportFiles[$index]['link'];
        $this->exportFiles[$index]['removed'] = true;
        return response()->download(storage_path($path))->deleteFileAfterSend();
    }

    public function resetFilter():void
    {
       $this->requestFilter = $this->filter = [
            'sortBy'=>'id',
            'orderBy'=>'desc',
            'perPage'=>10
        ];
    }

    public function applyFilter():void
    {
        $this->filter =  $this->requestFilter;
    }

    public function destroy($id = null):void
    {
        $check = ContactMail::find($id);
        if ($check)
        {
            $check->delete();
            $this->dispatch('SetMessage',
                type:'success',
                message:'Deleted Successfully'
            );
        }
    }

    public function updatedSearch()
    {
        $this->search = trim_search_keyword($this->search);
    }

    public function OpenAddEditModal($id = null, $edit = false):void
    {
        if (isset($id) && $id!=="")
        {
            $model = ContactMail::find($id);
            if ($model)
            {
                $this->EditRequest($model,$edit);
                $this->dispatch('OpenAddEditModal');
            }
        }
    }

    protected function EditRequest($contact , $edit = false)
    {
        if ($edit)
        {
            $this->request = $contact->only([
                'id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'subject',
                'message',
                'status',
            ]);
        }
        else
        {
            $this->request = $contact->only([
                'id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'subject',
                'message',
                'status',
            ]);
        }
    }

    public function MarkSeen()
    {
        ContactMail::where('id',$this->request['id'])->update(['status'=>1]);
        $this->dispatch('SetMessage',type:'success',message:'Status updated',close:true);
    }

}
