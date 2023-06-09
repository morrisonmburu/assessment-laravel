<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('statuses')->count() > 0) {
            return;
        }
        DB::table('statuses')->insert([
            ['name' => 'New'],
            ['name' => 'In Progress'],
            ['name' => 'Ready For Review'],
            ['name' => 'Done'],
        ]);
    }
}
