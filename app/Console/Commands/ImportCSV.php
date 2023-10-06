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
        $this->info("Hello World! " . $this->argument('file'));

        $row = 1;
        if (($handle = fopen($this->argument('file'), "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $num = count($data);
                $this->info($num . " fields in line " . $row);
                $row++;
                for ($c=0; $c < $num; $c++) {
                    $this->info($data[$c]);
                }
                DB::table('projects')->insert([
                    'name' => $data[0],
                    'slug' => $data[1]
                    ]
                );
            }
        }
        fclose($handle);
    }
}
