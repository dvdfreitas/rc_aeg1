<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-emails {file}';

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

        // if ($this->option('model'))
        //     $model = $this->option('model');
        // else
        //     $model = pathinfo($filename, PATHINFO_FILENAME);
            
        $header_csv = fgets($file);
        $header = str_getcsv($header_csv, ";");     
        
        $header_csv = fgets($file);
        $header = str_getcsv($header_csv, ";");     
        $this->info("Vou enviar para $header[0]: $header[1]");

        $header_csv = fgets($file);
        $header = str_getcsv($header_csv, ";");     
        $this->info("Vou enviar para $header[0]: $header[1]");

        $header_csv = fgets($file);
        $header = str_getcsv($header_csv, ";");     
        $this->info("Vou enviar para $header[0]: $header[1]");

        $header_csv = fgets($file);
        $header = str_getcsv($header_csv, ";");     
        $this->info("Vou enviar para $header[0]: $header[1]");

    }
}
