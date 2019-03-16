<?php

use App\User;
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
            User::create($user);
        });
    }

    private function data()
    {
        return collect([
            [
                'name' => 'Nizar',
                'email' => 'nizar@weareflip.com',
            ],
            [
                'name' => 'John',
                'email' => 'john@weareflip.com'
            ],
            [
                'name' => 'Jenna',
                'email' => 'jenna@weareflip.com'
            ],
            [
                'name' => 'Nick',
                'email' => 'nickb@weareflip.com'
            ],
            [
                'name' => 'Keith',
                'email' => 'keith@weareflip.com'
            ],
            [
                'name' => 'Joel',
                'email' => 'joel@weareflip.com'
            ],
            [
                'name' => 'Katch',
                'email' => 'katch@weareflip.com'
            ],
            [
                'name' => 'Chris',
                'email' => 'chris@weareflip.com'
            ],
            [
                'name' => 'Harry',
                'email' => 'harry@weareflip.com'
            ],
            [
                'name' => 'Jesse',
                'email' => 'jesse@weareflip.com'
            ],
            [
                'name' => 'Sarah',
                'email' => 'sarah@weareflip.com'
            ],
            [
                'name' => 'Ben',
                'email' => 'ben@weareflip.com'
            ],
            [
                'name' => 'Doug',
                'email' => 'doug@weareflip.com'
            ],
        ]);
    }
}
