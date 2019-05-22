<?php

namespace Picker;

use Picker\User;
use Picker\Cup\Events\{CupUpdated, CupDeleted};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasOne};
use Illuminate\Support\Facades\Storage;

class Cup extends Model
{
    /**
      * The table associated with the model.
      *
      * @var string
      */
    protected $table = 'user_cups';

    /**
      * The storage driver for cups
      *
      * @var Storage
      */
    protected $storage;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['file_path'];

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
     public function __construct(array $attributes = [])
     {
       parent::__construct($attributes);

       $this->storage = Storage::disk('local');
     }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
      parent::boot();

      // Delete the cup's image if the model
      // is deleted from the database
      static::deleted(function($model) {
          event(new CupDeleted($model));
      });

      // Delete the cup's old image if the user
      // uploaded a new image
      static::updated(function($model) {
          $oldPath = $model->getOriginal('file_path');
          $newPath = $model->getAttribute('file_path');

          if ($oldPath !== $newPath) {
              event(new CupUpdated($model));
          };
      });
    }
    /**
     * The user that owns this cup
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Determine if a cup has an uploaded image
     *
     * @return bool
     */
    public function hasImage() : bool
    {
      return $this->storage->exists($this->getOriginal('file_path'));
    }

    /**
     * Delete a cup's image if it exists
     *
     * @return bool
     */
    public function deleteImage() : bool
    {
        if (!$this->hasImage()) { return false; }

        return $this->storage->delete($this->getOriginal('file_path'));
    }

    /**
     * Generate a url for the cup's image that is
     * publicly accessible.
     *
     * @return string
     */
    public function getFilePathAttribute() : string
    {
        return $this->storage->url($this->getOriginal('file_path'));
    }
}
