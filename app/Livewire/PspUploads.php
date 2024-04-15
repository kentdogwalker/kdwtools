<?php

namespace App\Livewire;

use App\Models\Vet;
use App\Models\Client;
use Livewire\Component;
use App\Services\CsvToArray;
use App\Services\PetService;
use App\Services\VetService;
use Livewire\WithFileUploads;
use App\Services\ClientService;
use App\Services\UploadedService;
use Illuminate\Support\Facades\Log;

class PspUploads extends Component
{
    use WithFileUploads;

    public $clients_file, $vets_file, $pets_file;

    protected $clientService;
    protected $petService;
    protected $vetService;
    protected $csvService;
    protected $uploadedService;

    public function __construct()
    {
        $this->clientService = new ClientService;
        $this->petService = new PetService;
        $this->vetService = new VetService;
        $this->csvService = new CsvToArray;
        $this->uploadedService = new UploadedService;
    }

    public function render()
    {

        $data = [
            'client' => $this->uploadedService->getInformation(1),
            'vet' => $this->uploadedService->getInformation(2),
            'pet' => $this->uploadedService->getInformation(3),
            'service' => $this->uploadedService->getInformation(4)
        ];

        return view('livewire.psp-uploads', $data);
    }

    public function store()
    {
        $this->validate([
            'clients_file' => 'required|file|mimes:csv,txt|max:2048',
            'vets_file' => 'required|file|mimes:csv,txt|max:2048',
            'pets_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);
        $clientsFile = $this->clients_file->getRealPath();
        $vetsFile = $this->vets_file->getRealPath();
        $petsFile = $this->pets_file->getRealPath();
        //import clients.csv
        $clientSRecords = $this->csvService->csvToArray($clientsFile);
        $this->clientService->importConversion($clientSRecords);
        //import vets.csv
        $this->uploadVets($vetsFile);
        //import pets.csv
        $this->uploadPets($petsFile);

        alert()->success('Success', 'Files have been uploaded successfully!');
    }

    public function uploadPets($file)
    {
        if (($handle = fopen($file, 'r')) !== FALSE) {

            fgetcsv($handle); // Skip the header row

            while (($row = fgetcsv($handle, 0, ",", "\"")) !== FALSE) {

                Log::info('CSV Row:', $row);

                try {
                    $client = Client::find($row[0]);
                    $vet = Vet::find($row[2]);
                    if ($client) {
                        if ($vet) {
                            $this->petService->createCsvToDb($row);
                        } else {
                            if ($row[2] === '') {
                                $this->petService->createCsvToDb($row);
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::error("Error inserting pet data: {$e->getMessage()}", ['row' => $row]);
                    alert()->error('Error', 'There was an issue processing your Pets CSV file.');
                }
            }

            fclose($handle);
        } else {
            alert()->error('Error', 'Could not open the uploaded Pets CSV file.');
        }
        $this->uploadedService->createOrUpdateData('pets');
    }

    public function uploadVets($file)
    {
        try {
            // Open and read the CSV
            if (($handle = fopen($file, 'r')) !== false) {
                // Skip the header row
                fgetcsv($handle);

                while (($row = fgetcsv($handle, 0, ",", '"')) !== false) { // Ensuring encapsulation handling
                    $this->vetService->csvUpdateOrCreate($row);
                }

                fclose($handle);
            }
            $this->uploadedService->createOrUpdateData('vets');
        } catch (\Exception $e) {
            Log::error('Error importing vets CSV: ' . $e->getMessage());
            alert()->error('Error', 'An error occurred while importing the Vet CSV. Please check the Laravel log for details.');
        }
    }
}
