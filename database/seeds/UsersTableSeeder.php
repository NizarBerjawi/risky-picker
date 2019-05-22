<?php

use Picker\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->data()->each(function($user) {
            User::create($user + [
              'password' => bcrypt('secret'),
            ]);
        });
    }

    private function data()
    {
        return collect([
            [
                'first_name' => 'Nizar',
                'last_name' => 'El Berjawi',
                'email' => 'nizar@weareflip.com',
            ],
        ]);
    }
}
