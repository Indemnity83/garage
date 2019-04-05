<?php

/*
 * Garage -- A code kata for the automobile owner
 *
 * Copyright (C) 2019 Kyle Klaus <kklaus@indemnity83.com>
 *
 * This software may be modified and distributed under the terms of the MIT license.  See the LICENSE file for details.
 */

namespace App\Http\Controllers;

use App\Vehicle;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Vehicle::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $attributes = $this->validate($request, [
            'name' => ['required'],
            'vin' => [],
            'license' => [],
            'make' => [],
            'model' => [],
            'year' => ['integer'],
            'notes' => [],
        ]);

        $vehicle = Vehicle::create($attributes);

        return response()->json($vehicle, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        return response()->json($vehicle);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Vehicle $vehicle
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $attributes = $this->validate($request, [
            'name' => ['required'],
            'vin' => [],
            'license' => [],
            'make' => [],
            'model' => [],
            'year' => ['integer'],
            'notes' => [],
        ]);

        $vehicle->update($attributes);

        return response()->json($vehicle);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vehicle $vehicle
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
