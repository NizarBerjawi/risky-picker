<?php

namespace App\Support\Uuid;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

trait HasUuid
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function bootHasUuid()
    {
        static::creating(function($model) {
            $field = $model->getUuidField();

            // Check if the column exists in the database
            if (! Schema::hasColumn($model->getTable(), $field)) {
                throw new \Exception('Uuid column not found');
            }

            $model->forceFill([
                $model->getUuidField() => Uuid::create($model, $field),
            ]);
        });
    }

    /**
     * Get the uuid field name
     *
     * @return
     */
    protected function getUuidField() : string
    {
        return property_exists($this, 'uuid') ? $this->uuid : 'uuid';
    }
}
