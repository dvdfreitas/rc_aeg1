<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:importCSV {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = $this->argument('file');

        $file = fopen($filename, "r");
        
        $header_csv = fgets($file);
        $header = str_getcsv($header_csv, ",");     
        
        $validHeader = $this->validateHeader($header);

        while(($line_csv = fgets($file)) !== false) {
            $line = str_getcsv($line_csv, ";");
            // $csv_id = $line[0];
            // $this->info($csv_id);
        }
        
        fclose($file);

        return Command::SUCCESS;
    }

    public function verifyExistence($mandatory, $header) {
        $result = true;
        print_r($header);
        foreach ($mandatory as $field) {
            if (!in_array($field, $header)) {
                $result = false;
                $this->info($field . " não está no vector");
            }
        }
        return $result;
    }

    public function validateHeader($header)
    {        
        
        $validHeader = true;
        if ($header[0] == "projects") {
            $validHeader = $this->verifyExistence(["slug", "name", "description"], $header);
        }

        if ($validHeader)
            dd("Está válido"); 
        else
            dd("Inválido");
        

        // $line = $this->line($header);

        // foreach ($header as $key => $column) {                
        //     $this->info($line[$key]);
        //     $record[$header[$key]] = $line[$key];
        //     if ($record[$header[$key]] == "")
        //         $record[$header[$key]] = null;
        // }   
        
        return true;
    }    

}
