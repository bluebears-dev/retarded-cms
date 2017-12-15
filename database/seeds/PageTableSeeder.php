<?php

use App\User;
use Illuminate\Database\Seeder;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('pages')->insert([
            'name' => 'home',
            'route' => '/',
            'template' => 'default',
            'content' => 'Welcome home!',
            'parent_page' => '',
            'active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
