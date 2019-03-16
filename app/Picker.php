<?php

namespace App;

use App\{Type, User};
use Illuminate\Support\Collection;
use App\Exceptions\UnluckyUserNotFoundException;

class Picker
{
    /**
     * A collection of users to choose from
     *
     * @var Collection
     */
    protected $users;

    /**
     * The type of the order being made
     *
     * @var Type
     */
    protected $type;

    /**
     * Initialize the picker
     *
     * @param Collection $user
     * @param Type $type
     * @return void
     */
    public function __construct(Collection $users, Type $type)
    {
        $this->users = $users;
        $this->type = $type;
    }

    /**
     * Attempt to pick a user
     *
     * @return User
     * @throws UnluckyUserNotFoundException
     */
    public function pick() : User
    {
        /** TODO: TOO MANY QUERIES **/
        $pickableUsers = $this->users->reject(function($user) {
            return $user->canNotBePickedFor($this->type);
        });

        if ($pickableUsers->isEmpty()) {
            throw new UnluckyUserNotFoundException('Could not pick a user');
        }

        return $pickableUsers->random();

    }
}
