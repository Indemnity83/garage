<?php

/*
 * Garage -- A code kata for the automobile owner
 *
 * Copyright (C) 2019 Kyle Klaus <kklaus@indemnity83.com>
 *
 * This software may be modified and distributed under the terms of the MIT license.  See the LICENSE file for details.
 */

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Fideloper\Proxy\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array
     */
    protected $proxies;

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}
