<?php

namespace Picker\Cup;

use Illuminate\Http\Request;

class CupManager
{
    /**
     * The location where cups should be uploaded
     *
     * @var string
     */
    const PATH = 'public/cups';

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

        return $file->store(static::PATH);
    }
}
