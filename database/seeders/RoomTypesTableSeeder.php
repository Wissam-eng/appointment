<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RoomTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('room_types')->insert([
            ['room_type' => 'اقامة','created_at' => now(),'updated_at' => now()],
            ['room_type' => 'عمليات','created_at' => now(),'updated_at' => now()],
            ['room_type' => 'حضانة','created_at' => now(),'updated_at' => now()],
            ['room_type' => 'عناية مشددة','created_at' => now(),'updated_at' => now()   ],

        ]);
    }
}
