<?php

namespace App\Services;

class AvatarService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function generate(string $name)
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&background=random';
    }
}
