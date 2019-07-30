<?php

if (! function_exists('days')) {
    /**
     * Get a list of week days to choose from.
     * Optionally specify what day of the week to start from.
     *
     * @return array
     */
    function days($start = 'sun')
    {
        $days = collect(\Carbon\Carbon::getDays())->flatMap(function ($day) {
            return [strtolower(\Carbon\Carbon::parse($day)->shortEnglishDayOfWeek) => $day];
        })->all();

        $before = [];
        foreach($days as $key => $day) {
            if ($key === $start || $day === $start) { break; }

            $before[$key] = $day;
            unset($days[$key]);
        }

        return $days + $before;
    }
}

if (! function_exists('dist_path')) {
    /**
     * Get the path to the dist folder.
     *
     * @param  string  $path
     * @return string
     */
    function dist_path($path = '')
    {
      return public_path('dist'.($path ? DIRECTORY_SEPARATOR.ltrim($path, DIRECTORY_SEPARATOR) : $path));
    }
}

if (! function_exists('webpack')) {
    /**
     * Get path to a webpack bundle asset
     *
     * @param string $bundle Bundle name
     * @param string $type Asset type to take from the bundle ('js' or 'css')
     * @return string Path to asset
     */
    function webpack($bundle, $type = 'js')
    {
        $path = dist_path('manifest.json');

        if (!file_exists($path)) {
            throw new InvalidArgumentException('Unable to locate webpack manifest');
        }

        $manifest = json_decode(File::get($path));

        if (! isset($manifest->$bundle->$type)) {
            throw new InvalidArgumentException("Unable to find $bundle $type bundle");
        }

        return asset('dist/'.$manifest->$bundle->$type);
    }
}
