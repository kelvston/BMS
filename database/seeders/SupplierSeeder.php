<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Supplier::firstOrCreate([
            'name' => 'ABEC',
            'phone'=>'0756443322',
            'email'=>'supplier@gmail.com',
            'address'=>'dar es salaam'
        ]);

        Supplier::firstOrCreate([
            'name' => 'TULIP',
            'phone'=>'0756443322',
            'email'=>'supplier@gmail.com',
            'address'=>'dar es salaam'
        ]);

        Supplier::firstOrCreate([
            'name' => 'PUMA',
            'phone'=>'0756443322',
            'email'=>'supplier@gmail.com',
            'address'=>'dar es salaam'
        ]);
    }
}
