<?php

namespace App\Livewire\Admin\Components;

use App\Models\InsuranceClaim;
use App\Models\InsuranceClaimStatus;
use Livewire\Component;
use Rap2hpoutre\FastExcel\FastExcel;

class TlfDaysChart extends Component
{
    public $statusList = [];

    public $exportFiles = [];

    public function mount()
    {
        $this->statusList = InsuranceClaimStatus::where('status',1)
            ->whereHas('tlfExcluded')
            ->pluck('id')
            ->toArray();
    }

    public function render()
    {
        $data = InsuranceClaim::select(['claim_status','id','ins_name'])
            ->whereIn('claim_status',$this->statusList)
            ->get('days');
        return view('livewire.admin.components.tlf-days-chart',compact('data'));
    }

    public function Export():void
    {
        $this->exportFiles = [];

        $data = InsuranceClaim::select(['claim_status','id','ins_name'])
            ->whereIn('claim_status',$this->statusList)
            ->get('days');

        $filename = time()."export_analytics.xlsx";
        $path = storage_path('app/exports/').$filename;

        (new FastExcel($data))->headerStyle(config('excel.header_style'))->export($path,function ($ranking){
            return [
                'Insurance Claim'=>$ranking->ins_name ??'',
                'TLF Days'=>$ranking->days ??'0',
            ];
        });

        $this->exportFiles [] = [
            'name'=>$filename,
            'link'=>'app/exports/'.$filename,
            'path'=>$path,
            'removed'=>false,
        ];

        $this->dispatch('OpenExportModalTLF');
    }


    public function DownloadFile($index): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $path = $this->exportFiles[$index]['link'];
        $this->exportFiles[$index]['removed'] = true;
        return response()->download(storage_path($path))->deleteFileAfterSend();
    }

}
