<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Vet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\ClientService;
use App\Services\CsvToArray;
use App\Services\PetService;
use App\Services\VetService;

class PspUploadController extends Controller
{
    protected $clientService;
    protected $petService;
    protected $vetService;

    public function __construct()
    {
        $this->clientService = new ClientService;
        $this->petService = new PetService;
        $this->vetService = new VetService;
    }

    public function showForm()
    {
        return view('uploader.upload'); // Make sure this view path is correct
    }

    public function upload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $csvFile = $request->file('csv_file')->getRealPath();
        $csvService = new CsvToArray;
        $records = $csvService->csvToArray($csvFile);
        try {
            // DB::table('clients')->truncate(); // Truncate (i.e remove everything from) the clients table
            foreach ($records as $record) {
                $this->clientService->csvUpdateOrCreate($record);
            }
        } catch (\Exception $e) {
            Log::error("Error processing CSV import: {$e->getMessage()}");
            alert()->error('Error', 'There was an issue processing your CSV file.');
            return back();
        }
        alert()->success('Success', 'File has been uploaded successfully!');
        return back();
    }


    public function uploadPets(Request $request)
    {
        $request->validate([
            'pets_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('pets_file');

        if (($handle = fopen($file->getRealPath(), 'r')) !== FALSE) {
            // Optionally, truncate the pets table if you want to replace all data
            // DB::table('pets')->truncate();

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
                    alert()->error('Error', 'There was an issue processing your CSV file.');
                    return back();
                }
            }

            fclose($handle);
            alert()->success('Success', 'Pets CSV uploaded successfully!');
            return back();
        } else {
            alert()->error('Error', 'Could not open the uploaded file.');
            return back();
        }
    }

    public function uploadVets(Request $request)
    {
        $file = $request->file('vets_csv')->getRealPath(); // Get the real path to the file

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
        } catch (\Exception $e) {
            // Log any exceptions to the Laravel log file
            Log::error('Error importing vets CSV: ' . $e->getMessage());

            // Optionally, return an error response or redirect back with an error message
            alert()->error('Error', 'An error occurred while importing the CSV. Please check the Laravel log for details.');
            return back();
        }
        alert()->success('Success', 'Vets imported successfully.');
        return back();
    }
}
