<?php

use Picker\{User, UserCoffee, Role};
use Picker\Cup\CupManager;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class DummyDataSeeder extends Seeder
{
    protected $disk = 'cups';

    /**
     * The total number of users in the database
     *
     * @var integer
     */
    protected $totalUsers = 100;

    /**
     * The total number of coffees in the database
     *
     * @var integer
     */
    protected $totalCoffees = 10;

    /**
     * The percentage of users who do no have a reusable
     * coffee cup
     *
     * @var float
     */
    protected $percentageWithoutCup = 0.1;

    /**
     * The percentage of users who are not in the pool of users
     * that can be selected to do a coffee run
     *
     * @var float
     */
    protected $percentageOfVipUsers = 0.3;

    /**
     * The maximum number of coffees allowed per user
     *
     * @var integer
     */
    protected $maxNumberOfCoffeesPerUser = 5;

    /**
     * The total number of users in the database
     *
     * @var integer
     */
    protected $maxNumberOfSugarsPerCoffee = 3;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        // The storage disk
        $storage = Storage::disk($this->disk);

        // Get all the available user roles
        $roles = Role::get();

        // Create a bunch of random coffee types
        $coffees = factory(Picker\Coffee::class, $this->totalCoffees)->create();

        // Get all the available week days
        $daysOfWeek = collect(days())->keys();

        // Create all the users, attach a role to every user, create user coffees
        factory(Picker\User::class, $this->totalUsers)
            ->create()
            ->each(function($user) use ($coffees, $roles, $daysOfWeek, $storage, $faker) {
                $user->update([
                    'is_vip' => $faker->boolean($chanceOfGettingTrue = floor($this->percentageOfVipUsers * 100)),
                ]);
                // Give the user a role
                $user->roles()->attach($roles->random());
                // Give a percentage of the users a reusable cup
                if (mt_rand(0, $this->totalUsers) > ($this->totalUsers * $this->percentageWithoutCup)) {
                    $file = new File(dist_path('img/cup.jpg'));
                    $path = $storage->putFile(null, $file);
                    (new CupManager)->generateThumbnail($path);
                    $user->cup()->create(['filename' => $path]);
                }
                // Give every user a random number of coffees
                for($i = 0; $i <= mt_rand(0, $this->maxNumberOfCoffeesPerUser); $i++) {
                    // Make sure all the created coffees are valid
                    do {
                        // Create a new user coffee model
                        $userCoffee = new UserCoffee([
                            'sugar'      => $faker->numberBetween(0, $this->maxNumberOfSugarsPerCoffee),
                            'start_time' => $faker->time('G:i', null),
                            'end_time'   => $faker->time('G:i', null),
                            'days'       => $daysOfWeek->random(mt_rand(1, count($daysOfWeek))),
                        ]);
                        // Make sure every user coffee has a start time that
                        // falls before its end time
                        $validRange = UserCoffee::validateTimeRange(
                            $userCoffee->start_time, $userCoffee->end_time
                        );
                        // Make sure a user does not have more than one coffee
                        // at any one point of time
                        $conflict =  UserCoffee::timeslotConflict($user, $userCoffee);
                    } while (!$validRange || $conflict);

                    // If we got to this point, then the coffee is valid
                    $userCoffee->fill([
                      'user_id' => $user->id,
                      'coffee_id' => $coffees->random()->id,
                    ])->save();
                }
            });
    }
}
