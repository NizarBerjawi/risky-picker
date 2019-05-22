<?php

namespace Picker\Support;

class Day
{
    const DAYS = [
      'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun',
    ];

    /**
     *
     * @return void
     */
    public function __construct(int $num)
    {
        $this->num = $num;
    }

    /**
     *
     */
    public function displayName() : string
    {
        return static::name($this->num);
    }

    /**
     *
     */
    public static function name(int $day)
    {
        try {
            $day = static::DAYS[$day - 1];
        } catch (\Exception $e) {
            return null;
        }

        return $day;
    }
}
