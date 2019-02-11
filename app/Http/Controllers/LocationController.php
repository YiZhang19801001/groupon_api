<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * all locations(shops)
     * @param Integer $language_id
     * @return Response all shops
     */
    public function index()
    {
        // validation
        $errors = array();
        // if (!is_numeric($language_id) || !is_integer($language_id)) {
        //     $errors['language_id'] = ['The language id is not valid'];
        // }
        if (count($errors) > 0) {
            return response()->json(compact('errors'), 422);
        }

        // prepare data
        $locations = Location::all();
        foreach ($locations as $location) {
            if ($location->open !== null) {
                $location->open = json_decode($location->open);
            } else {
                $location->open = [];
            }
        }

        return response()->json(compact('locations'), 200);
    }
    public function show($location_id)
    {
        $shop = Location::find($location_id);
        if ($shop->open !== null) {
            $shop->open = json_decode($shop->open);
        } else {
            $shop->open = [];
        }

        return response()->json(compact("shop"), 200);
    }

    /**
     * create location
     * @param Request
     * @return Response new location created
     */
    public function create(Request $request)
    {

        //validation
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'telephone' => 'required',
        ]);
        $errors = array();
        if (!isset($request->open) || !is_array($request->open)) {
            $errors['open'] = ['The open is not valid.'];
        }
        if (count($errors) > 0) {
            return response()->json(compact('errors'), 422);
        }

        // create location
        $location = Location::create(['name' => $request->name, 'open' => json_encode($request->open), 'address' => $request->address, 'telephone' => $request->telephone]);

        return response()->json(compact('location'), 201);
    }
    /**
     * update location
     * @param Request
     * @param Integer $location_id
     * @return Response new location info
     */
    public function update(Request $request, $location_id)
    {
        // validation
        $errors = array();
        if (!is_numeric($location_id) || !is_integer($location_id + 0)) {
            $errors['language_id'] = ['The language id is not valid.'];
        }

        $location = Location::find($location_id);
        if ($location === null) {
            $errors['location'] = ['The location is not found.'];
        }
        if (isset($request->open) && !is_array($request->open)) {
            $errors['open'] = ['The open is not valid.'];
        }
        if (count($errors) > 0) {
            return response()->json(compact('errors'), 422);
        }

        // update
        $input = array();
        if (isset($request->address)) {
            $input['address'] = $request->address;
        }

        if (isset($request->name)) {
            $input['name'] = $request->name;
        }

        if (isset($request->telephone)) {
            $input['telephone'] = $request->telephone;
        }

        if (isset($request->open)) {
            $input['open'] = json_encode($request->open);
        }

        $location->update($input);

        return response()->json(compact('location'), 200);
    }
}
