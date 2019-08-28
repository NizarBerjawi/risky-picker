<?php

use App\Models\{User, Role};
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        $user = factory(User::class)->make([
            'email'      => 'admin@picker.com',
            'first_name' => 'Test',
            'last_name'  => 'Account',
        ]);

        $user->save();

        $user->roles()->attach(Role::whereName('admin')->first());
    }
}
