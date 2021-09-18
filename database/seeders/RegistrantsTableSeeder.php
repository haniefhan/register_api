<?php

namespace Database\Seeders;

use App\Models\Registrant;
use Illuminate\Database\Seeder;

class RegistrantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Registrant::factory()->count(10)->create();
    }
}
