<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Beneficiary;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use Illuminate\Bus\Batchable;

class ImportBenFromCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $file;

    /**
     * Create a new job instance.
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /*
        $path = Storage::disk('local')->path($this->file);

        if (!file_exists($path)) {
            dd('CSV file does not exist!', $path);
        }
    
        $csv = \League\Csv\Reader::createFromPath($path, 'r');
    
        $csv->setHeaderOffset(0); // Assuming your file has headers
    
        $records = iterator_to_array($csv);
    
        dd('Records:', $records);
      */
           // Load the CSV file from storage
           $path = Storage::disk('local')->path($this->file);

           if (!file_exists($path)) {
            logger()->error('File not found: ' . $path);
            return;
        }
         
           $csv =  Reader::createFromPath($path, 'r');
           $csv->setHeaderOffset(0); // Assuming the first row contains headers
   

    
    // Process each row
    foreach ($csv->getRecords() as $row) {
        // Example: create user from CSV data
      //dump($row);

        Beneficiary::create([

                'national_id' => $row['national_id'],
                'fullname' => $row['fullname'],
                'phonenumber' => $row['phonenumber'],
                'recipient_name' => $row['recipient name'],
                'recipient_phone' => $row[ 'recipient phone'],
                'recipient_nid' => $row['recipient nid'],
                'governate' => $row['governate'],
                'project_name' => $row['project name'],
                'partner' => $row['partner'],
                'donor' => $row[ 'donor'],
                'statement_num' => $row[ 'statement_num'],
                'transfer_value' => $row['transfer_value'],
                'transfer_count' => $row[ 'transfer count'],
                'project_start_date' => $row['project start date'],
                'project_end_date' => $row[ 'project end date' ],
                'recieve_date' => $row['receive date'],
                'sector' => $row['sector'],
                'modality' => $row[ 'modality'],
                'created_by' => $row['created_by'],
               
                'created_at' => now(),
                'updated_at' => now(),
            ]);

         
        }


    }

    protected function insertBatch(array $batch)
{
    if (!empty($batch)) {
        Beneficiary::insert($batch);
    }
}
}
