<?php

namespace Picker;

use Picker\User;
use Picker\Cup\CupManager;
use Picker\Cup\Events\{CupUpdated, CupDeleted};
use Illuminate\Database\Eloquent\Model;

class Cup extends Model
{
    /**
      * The table associated with the model.
      *
      * @var string
      */
    protected $table = 'user_cups';

    /**
      * The cup manager
      *
      * @var CupManager
      */
    protected $manager;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['filename'];

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
     public function __construct(array $attributes = [])
     {
       parent::__construct($attributes);

       $this->manager = app(CupManager::class);
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Determine if a cup has an uploaded image
     *
     * @return bool
     */
    public function hasImage()
    {
        $filename = basename($this->getOriginal('filename'));

        return $this->manager->imageExists($filename);
    }

    /**
     * Determine if a cup has a thumbnail image
     *
     * @return bool
     */
    public function hasThumbnail()
    {
        $filename = basename($this->getOriginal('filename'));

        return $this->manager->thumbnailExists($filename);
    }

    /**
     * Delete a cup's image if it exists
     *
     * @return bool
     */
    public function deleteImage()
    {
        if (!$this->hasImage()) { return false; }

        $filename = basename($this->getOriginal('filename'));

        return $this->manager->deleteImage($filename);
    }

    /**
     * Delete a cup's thumbnail if it exists
     *
     * @return bool
     */
    public function deleteThumbnail()
    {
        if (!$this->hasThumbnail()) { return false; }

        $filename = basename($this->getOriginal('filename'));

        return $this->manager->deleteThumbnail($filename);
    }

    /**
     * Generate a url for the cup's image that is
     * publicly accessible.
     *
     * @return string
     */
    public function getThumbnailPathAttribute()
    {
        $filename = basename($this->getOriginal('filename'));

        return $this->manager->getStorage()->url("cups/thumbs/$filename");
    }

    /**
     * Generate a url for the cup's image that is
     * publicly accessible.
     *
     * @return string
     */
    public function getImagePathAttribute()
    {
        $filename = basename($this->getOriginal('filename'));

        return $this->manager->getStorage()->url("cups/$filename");
    }
}
