<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Http\Requests\UploadServicesRequest;
use App\Models\Client;
use App\Models\Vet;
use Illuminate\Support\Facades\Log;
use App\Services\ClientService;
use App\Services\CsvToArray;
use App\Services\PetService;
use App\Services\ServiceService;
use App\Services\UploadedService;
use App\Services\VetService;

class PspUploadController extends Controller
{
    protected $clientService;
    protected $petService;
    protected $vetService;
    protected $csvService;
    protected $servicesService;
    protected $uploadedService;

    public function __construct()
    {
        $this->clientService = new ClientService;
        $this->petService = new PetService;
        $this->vetService = new VetService;
        $this->csvService = new CsvToArray;
        $this->servicesService = new ServiceService;
        $this->uploadedService = new UploadedService;
    }

    public function showForm()
    {
        $data = [
            'client' => $this->uploadedService->getInformation(1),
            'vet' => $this->uploadedService->getInformation(2),
            'pet' => $this->uploadedService->getInformation(3),
            'service' => $this->uploadedService->getInformation(4)
        ];
        return view('uploader.upload', $data);
    }

    public function upload(UploadRequest $request)
    {
        $clientsFile = $request->file('clients_file')->getRealPath();
        $vetsFile = $request->file('vets_file')->getRealPath();
        $petsFile = $request->file('pets_file')->getRealPath();
        //import clients.csv
        $clientSRecords = $this->csvService->csvToArray($clientsFile);
        $this->clientService->importConversion($clientSRecords);
        //import vets.csv
        $this->uploadVets($vetsFile);
        //import pets.csv
        $this->uploadPets($petsFile);

        alert()->success('Success', 'Files has been uploaded successfully!');
        return redirect()->back();
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
                    return back();
                }
            }

            fclose($handle);
        } else {
            alert()->error('Error', 'Could not open the uploaded Pets CSV file.');
            return back();
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
            // Log any exceptions to the Laravel log file
            Log::error('Error importing vets CSV: ' . $e->getMessage());
            alert()->error('Error', 'An error occurred while importing the Vet CSV. Please check the Laravel log for details.');
            return redirect()->back();
        }
    }

    public function uploadServices(UploadServicesRequest $request)
    {
        $csvFile = $request->file('csv_file')->getRealPath();
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
            return redirect()->back();
        }

        alert()->success('Success', 'File has been uploaded successfully!');
        return redirect()->back();
    }
}
