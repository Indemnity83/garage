<?php

/*
 * Garage -- A code kata for the automobile owner
 *
 * Copyright (C) 2019 Kyle Klaus <kklaus@indemnity83.com>
 *
 * This software may be modified and distributed under the terms of the MIT license.  See the LICENSE file for details.
 */

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
