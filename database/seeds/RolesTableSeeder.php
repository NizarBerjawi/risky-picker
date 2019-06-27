<?php

use Picker\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class RolesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        // Create all the required user roles
        $this->roles()->each(function($user) {
            Role::create($user);
        });
    }

    /**
     * Get the custom roles required
     *
     * @return Collection
     */
    protected function roles()
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
