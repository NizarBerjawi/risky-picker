<?php

namespace Picker\Cup;

use Illuminate\Http\Request;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;

class CupManager
{
    /**
     * The storage driver for cups
     *
     * @var Storage
     */
    protected $storage;

    /**
     * Instantiate the manager
     *
     * @return void
     */
    public function __construct()
    {
        $this->storage = Storage::disk('cups');
    }

    /**
     * Handle a coffee cup image upload for the user
     *
     * @param Request $request
     * @return mixed
     */
    public function handleFileUpload(Request $request)
    {
        if (!$request->hasFile('cup_photo')) { return false; }

        $file = $request->file('cup_photo');

        if(!$file->isValid()) { return false; }

        $path = $this->storage->putFile(null, $file);

        $this->generateThumbnail($path);

        return $path;
    }

    /**
     * Get the storage disk for cup images
     *
     * @return Storage
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Check that a cup image exists on disk
     *
     * @param string $filename
     * @return bool
     */
    public function imageExists($filename) : bool
    {
        return $this->storage->exists($filename);
    }

    /**
     * Check that a cup image exists on disk
     *
     * @param string $filename
     * @return bool
     */
    public function thumbnailExists($filename)
    {
        return $this->storage->exists("thumbs/$filename");
    }

    /**
     * Delete a cup image that exists on disk
     *
     * @param string $filename
     * @return bool
     */
    public function deleteImage($filename)
    {
        return $this->storage->delete($filename);
    }

    /**
     * Create a thumbnail for the uploaded cup image.
     *
     * @param string $path
     * @return string
     */
    protected function generateThumbnail($path)
    {
        $manager = new ImageManager();

        $image = $manager->make($this->storage->path($path))
                         ->resize(250, null)
                         ->resize(null, 250);

        $filename = $this->getFilenameFromPath($path);

        if (!$this->storage->exists('thumbs')) {
            $this->storage->makeDirectory('thumbs');
        }

        return $image->save($this->storage->path("thumbs/$filename"));
    }

    /**
     * Get the name of the file from the path
     *
     * @param string $path
     * @return string
     */
    protected function getFilenameFromPath($path)
    {
        return basename($path);
    }
}
