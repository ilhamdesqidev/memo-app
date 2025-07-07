<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jabatan;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jabatan::insert([
            ['nama' => 'Staff', 'urutan' => 1],
            ['nama' => 'Manager', 'urutan' => 2],
            ['nama' => 'Direktur', 'urutan' => 3],
        ]);
    }
}
