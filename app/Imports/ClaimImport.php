<?php

namespace App\Imports;

use App\Models\ImportClaim;
use App\Models\User;
use App\Rules\ClaimClientCheckRule;
use App\Helpers\Admin\BackendHelper;
use App\Helpers\Imports\ImportHelper;
use App\Helpers\Imports\NewImportHelper;
use App\Models\ImportClaimHistory;
use App\Models\ImportClaimRevertHistory;
use App\Models\InsuranceClaim;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClaimImport implements ToCollection, WithHeadingRow
{
    use Importable;

    public ?ImportClaim $importClaim;
    public ?User $user;
    protected int $imported = 0;
    protected int $total = 0;
    public array $importedClaimsIds = [];

    public function __construct(ImportClaim $importClaim)
    {
        $this->importClaim = $importClaim;
        $this->user = Auth::user();
    }

    public $validationAttributes = [
        'Client ID' => 'Client',
        'INS Name' => 'Insurance Name',
        'INS Ph No' => 'Insurance Phone Number',
        'SUB NAME' => 'Subscriber Name',
        'SUB ID' => 'Subscriber ID',
        'Patient ID' => 'Patient ID',
        'PATIENT NAME' => 'Patient Name',
        'DOB' => 'Date of Birth',
        'DOS' => 'Date of Service',
        'SENT' => 'Sent Date',
        'TOTAL $$' => 'Total Amount',
        'DAYS' => 'Days',
        'DAYS-R' => 'Days Remaining',
        'Prov Nm' => 'Provider Name',
        'Location' => 'Location',
    ];

    public function rules(): array
    {
        return [
            "Client ID"=>[
                'required',
                'exists:customers,id',
                 new ClaimClientCheckRule($this->user),
            ],
            'INS Name'=>'required|max:255',
            'INS Ph No'=>'max:255',
            'SUB NAME'=>'max:255',
            'SUB ID'=>'max:255',
            'Patient ID'=>'max:255',
            'PATIENT NAME'=>'max:255',
            'DOB'=>'nullable',
            'DOS'=>'nullable',
            'SENT'=>'nullable',
            'TOTAL $$'=>'nullable|numeric',
            'DAYS'=>'max:255',
            'DAYS-R'=>'max:255',
            'Prov Nm'=>'max:255',
            'Location'=>'max:255',
        ];
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {

        $claimHistory = ImportClaimHistory::create([
            'parent_id' => $this->importClaim->id,
        ]);

        $this->total = count($collection);
        $this->imported = 0;
        $importErrors = [];

        foreach ($collection as $i => $item) {
            // Convert Collection item to array for validation
            $itemArray = $item->toArray();

            $itemArray['Client ID'] = $this->importClaim->client_id ?? null;
            $itemArray['TOTAL $$'] = $itemArray['TOTAL $$'] === '' ? null : $itemArray['TOTAL $$'];

            $validator = Validator::make($itemArray, $this->rules(),[], $this->validationAttributes);

            if ($validator->fails())
            {
                $importErrors[] = [
                    'row' => $i + 1,
                    'name' => $itemArray['INS Name'] ?? '--',
                    'errors' => $validator->errors()->all(),
                ];
                continue;
            }

            $result = (new NewImportHelper($this->importClaim,$this->user))->ImportItem($itemArray, $claimHistory);

            if ($result['success'])
            {
                $this->importedClaimsIds[] = $result['id'];
                $this->imported++;
            }
            else
            {
                $importErrors[] = [
                    'row' => $i + 1,
                    'name' => $itemArray['INS Name'] ?? '--',
                    'errors' => [$result['message']],
                ];
            }
        }

        // Removing data which is not imported
        if (checkData($this->importClaim->client_id))
        {
            $data = InsuranceClaim::where('customer_id', $this->importClaim->client_id)
                ->whereNotIn('id', $this->importedClaimsIds)
                ->get();

            foreach ($data as $item)
            {
                ImportClaimRevertHistory::create([
                    'import_claim_id' => $this->importClaim->id,
                    'claim_id' => $item->id,
                    'type' => ImportClaimRevertHistory::TYPE_TRASH,
                    'is_reverted' => 0,
                ]);

                $item->delete();
            }
        }

        $claimHistory->fill([
            'total' => $this->total,
            'imported' => $this->imported,
            'errors' => BackendHelper::JsonEncode($importErrors),
            'status' => 1,
        ]);
        $claimHistory->save();

        $this->importClaim->status = 1;
        $this->importClaim->save();
    }

    public function headingRow(): int
    {
        return 1;
    }
}
