<?php

namespace ViralsBackpack\BackPackImageUpload\Facades;

use Illuminate\Support\Facades\Facade;

class BackPackImageUpload extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'backpackimageupload';
    }
}
