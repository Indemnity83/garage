<?php

/*
 * Garage -- A code kata for the automobile owner
 *
 * Copyright (C) <2019> <Kyle Klaus>
 *
 * This software may be modified and distributed under the terms of the MIT license.  See the LICENSE file for details.
 */

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        //
    ];
}
