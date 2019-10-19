<?php

namespace App\Support\Uuid;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Uuid
{
    /**
     * Number of attempts.
     */
    const ATTEMPTS = 5;

    /**
     * Attempt to generate a Uuid for the model
     *
     * @param Model $model
     */
    public static function create(Model $model, string $field) : string
    {
        $attempts = 0;

        while($attempts <= static::ATTEMPTS) {
            $uuid = (string) Str::uuid();

            // Check if the Uuid already exists
            $exists = $model->newQueryWithoutScopes()
                            ->where($field, $uuid)
                            ->exists();

            if (! $exists) {
                return $uuid;
            }

            $attempts ++;
        }

        throw new \Exception('Could not find a unique Uuid');
    }
}
