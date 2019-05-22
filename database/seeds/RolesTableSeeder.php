<?php

use Picker\{Role, User};
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->data()->each(function($user) {
            Role::create($user);
        });

        $admin = Role::whereName('admin')->first();
        $user = User::whereEmail('nizar@weareflip.com')->first();

        $user->roles()->attach($admin);
    }

    private function data()
    {
        return collect([
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
            ],
            [
                'name' => 'user',
                'display_name' => 'User',
            ],
        ]);
    }
}
