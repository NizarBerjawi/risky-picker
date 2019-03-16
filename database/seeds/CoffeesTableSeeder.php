<?php

use App\Coffee;
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
            ],
            [
                'name' => 'Flat White',
            ],
            [
                'name' => 'Nitro',
            ],
            [
                'name' => 'Latte',
            ],
        ]);
    }
}
