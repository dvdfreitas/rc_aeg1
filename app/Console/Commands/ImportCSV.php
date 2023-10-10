<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Bool_;

class ImportCSV extends Command
{
    /**
     * 
     */
    public $validation = [
        'projects' => [
            'mandatory' => ['slug', 'name']
        ],
        'teachers' => [
            'mandatory' => ['name']
        ],
    ];


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

        // while(($line_csv = fgets($file)) !== false) {
        //     $line = str_getcsv($line_csv, ";");
        //     // $csv_id = $line[0];
        //     // $this->info($csv_id);
        // }
        
        fclose($file);

        return Command::SUCCESS;
    }

    /**
     * 
     */
    public function verifyExistence($mandatory, $header) {
        $result = true;        
        foreach ($mandatory as $field) {
            if (!in_array($field, $header)) {
                $result = false;
                $this->info($field . " não está no vector");
            }
        }
        return $result;
    }

    public function validTable($table) {
        if (!array_key_exists($table, $this->validation)) {
            $this->error("Table " . $table . " doesn't exist.");
            return false;
        }
        return true;
    }


    public function validateHeader($header)
    {                
        $validHeader = true;

        // Check first if $header[0] is in validation array and not an empty key
        if (array_key_exists($header[0], $this->validation))
            $this->validTable($header[0]);
        else
            dd("Table " . $header[0] . " doesn't exist.");
        $mandatory = $this->validation[$header[0]]['mandatory'];
        
        $validHeader = $this->verifyExistence($mandatory, $header);
        dd($validHeader);
        
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
