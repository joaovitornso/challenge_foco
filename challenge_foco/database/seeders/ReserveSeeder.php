<?php

namespace Database\Seeders;

use App\Models\Reserve;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReserveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reserve::factory()->count(50)->create();

    }
}
