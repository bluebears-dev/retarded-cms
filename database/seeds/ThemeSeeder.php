<?php

use App\User;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        // Colors
        // main;primary;secondary;detail;error;
        DB::table('themes')->insert([
            'name' => 'Default',
            'path' => '/css/rcms/default/',
            'colors' => base64_encode('221E22;31263E;44355B;ECA72C;EE5622'),
        ]);
        DB::table('themes')->insert([
            'name' => 'Frozen',
            'path' => '/css/rcms/frozen/',
            'colors' => base64_encode('001923;003249;007EA7;80CED7;DB9D9E'),
        ]);
    }
}
