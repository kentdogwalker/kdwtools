<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;
use App\Services\CsvToArray;
use App\Services\ServiceService;
use App\Services\UploadedService;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;

class PspUploadServices extends Component
{
    use WithFileUploads;

    public $csv_file;
    protected $servicesService;
    protected $uploadedService;
    protected $csvService;

    public function __construct()
    {
        $this->servicesService = new ServiceService;
        $this->csvService = new CsvToArray;
        $this->uploadedService = new UploadedService;
    }

    public function render()
    {
        $data = [
            'service' => $this->uploadedService->getInformation(4)
        ];
        return view('livewire.psp-upload-services', $data);
    }

    public function store()
    {
        $this->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $csvFile = $this->csv_file->getRealPath();
        $csv = $this->csvService->csvToArray($csvFile);

        $dataCsv = $this->servicesService->getHotelStayAndOtherData($csv);
        $hotelStay = $dataCsv['hotelStay'];
        $otherData = $dataCsv['otherData'];

        $newHotelStay = $this->servicesService->getHotelStayFix($hotelStay);

        try {
            foreach ($newHotelStay as $key) {
                $client = Client::find($key['ClientID']);
                if ($client) {
                    $this->servicesService->createToServices($key, 'hotel stays');
                }
            }

            foreach ($otherData as $item) {
                $client = Client::find($item['ClientID']);
                if ($client) {
                    $this->servicesService->createToServices($item, 'other');
                }
            }
            $this->uploadedService->createOrUpdateData('services');
        } catch (\Exception $e) {
            Log::error("Error processing CSV import: {$e->getMessage()}");
            alert()->error('Error', 'There was an issue processing your CSV file.');
        }

        alert()->success('Success', 'File has been uploaded successfully!');
    }
}
