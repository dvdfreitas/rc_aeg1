<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'David Freitas',
            'email' => 'david.freitas@aeg1.pt',
        ]);

        Artisan::call('importCSV /home/dfreitas/www/rc_aeg1/csv/school_classes.csv --model=school_classes');
        Artisan::call('importCSV /home/dfreitas/www/rc_aeg1/csv/teachers.csv --model=teachers');
        Artisan::call('importCSV /home/dfreitas/www/rc_aeg1/csv/school_class_teachers.csv --model=school_class_teacher');

        // $this->call([
        //     DocumentSeeder::class
        // ]);
    }
}
