<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Divisi;


class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Divisi::insert([
            ['nama' => 'Pengembangan Bisnis', 'urutan' => 1],
            ['nama' => 'Operasional Wilayah I', 'urutan' => 2],
            ['nama' => 'Operasional Wilayah II', 'urutan' => 3],
            ['nama' => 'Umum dan Legal', 'urutan' => 4],
            ['nama' => 'Administrasi dan Keuangan', 'urutan' => 5],
            ['nama' => 'Infrastruktur dan Sipil', 'urutan' => 6],
            ['nama' => 'Food Beverage', 'urutan' => 7],
            ['nama' => 'Marketing dan Sales', 'urutan' => 8],
        ]);
    }
}
