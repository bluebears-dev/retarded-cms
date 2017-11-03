<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected function assingRole($role_id, $user_id)
    {
        DB::table('model_has_roles')->insert([
            'role_id' => $role_id,
            'model_id' => $user_id,
            'model_type' => 'App\User'
        ]);
    }

    public function run()
    {
        DB::table('users')->insert([
            'login' => 'admin',
            'password' => bcrypt('secret'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $this->assingRole(1, User::where('login', 'admin')->first()->id);
        factory(App\User::class, 2)->create()->each(function($u) {
            $this->assingRole(2, $u->id);
        });
        factory(App\User::class, 3)->create()->each(function($u) {
            $this->assingRole(3, $u->id);
        });
    }
}
