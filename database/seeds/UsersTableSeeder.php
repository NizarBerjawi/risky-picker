<?php

use Picker\{User, UserCoffee, Role};
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class UsersTableSeeder extends Seeder
{
    /**
     * The total number of users in the database
     *
     * @var integer
     */
    protected $totalUsers = 10000;

    /**
     * The total number of coffees in the database
     *
     * @var integer
     */
    protected $totalCoffees = 35;

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
        // Create all the required user roles
        $roles = $this->roles()->map(function($user) {
            return Role::create($user);
        });

        // Create a bunch of random coffee types
        $coffees = factory(Picker\Coffee::class, $this->totalCoffees)->create();

        // Get all the available week days
        $daysOfWeek = $this->getDays();

        // Create all the users, attach a role to every user, create user coffees
        factory(Picker\User::class, $this->totalUsers)
            ->create()
            ->each(function($user) use ($coffees, $roles, $daysOfWeek, $faker) {
                // Give the user a role
                $user->roles()->attach($roles->random());
                // Give every user a random number of coffees
                for($i = 0; $i < mt_rand(0, $this->maxNumberOfCoffeesPerUser); $i++) {
                    // Make sure all the created coffees are validated
                    do {
                        // Create a new user coffee model
                        $userCoffee = new UserCoffee([
                            'sugar'      => $faker->numberBetween(0, $this->maxNumberOfSugarsPerCoffee),
                            'start_time' => $faker->time('G:i', null),
                            'end_time'   => $faker->time('G:i', null),
                            'days'       => $daysOfWeek->random(mt_rand(1, count($daysOfWeek))),
                        ]);

                        $validRange = UserCoffee::validateTimeRange(
                            $userCoffee->start_time, $userCoffee->end_time
                        );

                        $conflict =  UserCoffee::timeslotConflict($user, $userCoffee);
                    } while (!$validRange || $conflict);

                    // If we got to this point, then the coffee is valid
                    $userCoffee->fill([
                      'user_id' => $user->id,
                      'coffee_id' => $coffees->random()->id,
                    ])->save();
                }
            });

        $this->getUsers()->each(function($user) {
            User::create($user + [
              'password' => bcrypt('secret'),
            ]);
        });
    }

    /**
     * Get the custom users required
     *
     * @return Collection
     */
    protected function getUsers()
    {
        return collect([
            [
                'first_name' => 'Nizar',
                'last_name' => 'El Berjawi',
                'email' => 'nizar@weareflip.com',
            ],
        ]);
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

    /**
     * Get a list of week days to choose from
     *
     * @return Collection
     */
    protected function getDays()
    {
      return collect(Carbon::getDays())->map(function ($day) {
          return strtolower(Carbon::parse($day)->shortEnglishDayOfWeek);
      });
    }
}
