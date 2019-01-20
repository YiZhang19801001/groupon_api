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
            $errors['open'] = 'The open is not valid.';
        }
        if (count($errors) > 0) {
            return response()->json(compact('errors'), 422);
        }

        // create location
        $location = Location::create($request->only('name', 'open', 'address', 'telephone'));

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
        if (!is_numeric($location_id) || !is_integer($location_id)) {
            $errors['location_id'] = ['The language id is not valid.'];
        }
        $location = Location::find($location_id);
        if ($location === null) {
            $errors['location'] = ['The location is not found.'];
        }
        if (count($errors) > 0) {
            return response()->json(compact('errors'), 422);
        }

        // update
        $location->update($request->all());

        return response()->json(compact('location'), 200);
    }
}
