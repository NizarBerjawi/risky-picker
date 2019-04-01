<?php

use Picker\Coffee\Coffee;
use Illuminate\Database\Seeder;

class CoffeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->data()->each(function($user) {
            Coffee::create($user);
        });
    }

    private function data()
    {
        return collect([
            [
                'name' => 'Long Black',
                'description' => 'A very long black',
            ],
            [
                'name' => 'Flat White',
                'description' => 'A very flat white'
            ],
            [
                'name' => 'Nitro',
                'description' => 'Nitro... Stronger than Turbo',
            ],
            [
                'name' => 'Latte',
                'description' => 'A plain Latte',
            ],
        ]);
    }
}
