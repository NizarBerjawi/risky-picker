<?php

use Picker\Type;
use Illuminate\Database\Seeder;

class OrderTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->data()->each(function($type) {
            Type::create($type);
        });
    }

    private function data()
    {
        return collect([
            [
                'display_name' => 'Coffee',
                'description' => 'A coffee run; either in the morning or the afternoon',
            ],
            [
                'display_name' => 'Food',
                'description' => 'Ordering food for the team on a Friday',
            ],
        ]);
    }
}
