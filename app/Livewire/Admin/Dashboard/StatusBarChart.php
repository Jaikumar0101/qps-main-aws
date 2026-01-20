<?php

namespace App\Livewire\Admin\Dashboard;

use App\Helpers\ClaimHelper;
use App\Models\InsuranceClaim;
use App\Models\InsuranceClaimStatus;
use Livewire\Component;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;

class StatusBarChart extends Component
{
    public $filterCases = [
        'ST30'=>'0-30',
        'ST60'=>'30-60',
        'ST90'=>'60-90',
        'ST120'=>'90-120',
        '120+'=>'120+',
    ];

    public $insStatus = [];
    public $chartLabels = [];
    public $chartData = [];
    public $chartTotal = [];

    public $exportFiles = [];

    public $filter = "ST30";

    public $type = "count";

    public function mount()
    {
        $this->insStatus = InsuranceClaimStatus::where('status',1)->get();
        $this->chartLabels = $this->insStatus->pluck('name')->toArray();
        $this->getChartData();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.status-bar-chart');
    }

    protected function getChartData()
    {
        $this->chartTotal = $this->chartData = [];

        switch ($this->filter)
        {
            case "ST30":
                foreach ($this->insStatus as $item)
                {
                    $data = InsuranceClaim::where('claim_status',$item->id)
                        ->where('days','<=',30)
                        ->get();

                    $this->chartData[] = $data->count();
                    $this->chartTotal[] = $data->sum('total');
                }
                break;
            case "ST60":
                foreach ($this->insStatus as $item)
                {
                    $data = InsuranceClaim::where('claim_status',$item->id)
                        ->where('days','>',30)
                        ->where('days','<=',60)
                        ->get();

                    $this->chartData[] = $data->count();
                    $this->chartTotal[] = $data->sum('total');
                }
                break;
            case "ST90":
                foreach ($this->insStatus as $item)
                {
                    $data = InsuranceClaim::where('claim_status',$item->id)
                        ->where('days','>',60)
                        ->where('days','<=',90)
                        ->get();

                    $this->chartData[] = $data->count();
                    $this->chartTotal[] = $data->sum('total');
                }
                break;
            case "ST120":
                foreach ($this->insStatus as $item)
                {
                    $data = InsuranceClaim::where('claim_status',$item->id)
                        ->where('days','>',90)
                        ->where('days','<=',120)
                        ->get();

                    $this->chartData[] = $data->count();
                    $this->chartTotal[] = $data->sum('total');
                }
                break;
            case"120+":
                foreach ($this->insStatus as $item)
                {
                    $data = InsuranceClaim::where('claim_status',$item->id)
                        ->where('days','>',120)
                        ->get();

                    $this->chartData[] = $data->count();
                    $this->chartTotal[] = $data->sum('total');
                }
                break;
            default:
                foreach ($this->insStatus as $item)
                {
                    $data = InsuranceClaim::where('claim_status',$item->id)
                        ->get();

                    $this->chartData[] = $data->count();
                    $this->chartTotal[] = $data->sum('total');
                }
        }
    }

    public function changeFilter($filter = "ST30"): void
    {
        $this->filter = $filter;
        $this->getChartData();
        $this->dispatch('updateBarChart',
            type:$this->type,data:$this->chartData,total:$this->chartTotal
        );
    }

    public function updatedType(): void
    {
        $this->getChartData();
        $this->dispatch('updateBarChart',
            type:$this->type,data:$this->chartData,total:$this->chartTotal
        );
    }

    public function ExportData()
    {

        $data = [];

        foreach ($this->filterCases as $case=>$value)
        {
            $tempData = $this->getDataVariation($case);

            $data[$case] = $tempData->map(function ($ranking){
                return ClaimHelper::mapClaimExportFiled($ranking);
            });
        }

        $sheets = new SheetCollection($data);

        $filename = time()."export_insurance_claims.xlsx";
        $path = storage_path('app/exports/').$filename;

        (new FastExcel($sheets))->headerStyle(config('excel.header_style'))->export($path);

        $this->exportFiles [] = [
            'name'=>$filename,
            'link'=>'app/exports/'.$filename,
            'path'=>$path,
            'removed'=>false,
        ];

        $this->dispatch('OpenExportModal');
    }

    public function DownloadFile($index): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $path = $this->exportFiles[$index]['link'];
        $this->exportFiles[$index]['removed'] = true;
        return response()->download(storage_path($path))->deleteFileAfterSend();
    }

    protected function getDataVariation($case = "ST30")
    {

        $this->chartTotal = $this->chartData = [];

        $status = $this->insStatus->pluck('id')->toArray();

        return match ($case) {
            "ST30" => InsuranceClaim::whereIn('claim_status', $status)
                ->where('days', '<=', 30)
                ->get(),
            "ST60" => InsuranceClaim::whereIn('claim_status', $status)
                ->where('days', '>', 30)
                ->where('days', '<=', 60)
                ->get(),
            "ST90" => InsuranceClaim::whereIn('claim_status', $status)
                ->where('days', '>', 60)
                ->where('days', '<=', 90)
                ->get(),
            "ST120" => InsuranceClaim::whereIn('claim_status', $status)
                ->where('days', '>', 90)
                ->where('days', '<=', 120)
                ->get(),
            "120+" => InsuranceClaim::whereIn('claim_status', $status)
                ->where('days', '>', 120)
                ->get(),
            default => InsuranceClaim::whereIn('claim_status', $status)
                ->get(),
        };
    }

    public function Export():void
    {
        $this->exportFiles = [];

        $data = [];

        foreach ($this->chartLabels as $i=>$label)
        {
            $data[] = [
                'Claim Status'=>$label,
                'No of Claims'=>$this->chartData[$i],
                'Total Amount'=>$this->chartTotal[$i],
            ];
        }

        $filename = time()."export_analytics.xlsx";
        $path = storage_path('app/exports/').$filename;

        (new FastExcel($data))->headerStyle(config('excel.header_style'))->export($path);

        $this->exportFiles [] = [
            'name'=>$filename,
            'link'=>'app/exports/'.$filename,
            'path'=>$path,
            'removed'=>false,
        ];

        $this->dispatch('OpenExportModal');
    }

}
