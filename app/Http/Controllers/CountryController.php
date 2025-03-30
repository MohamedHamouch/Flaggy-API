<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\Storage;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::all();
        return response()->json([
            'status' => 'success',
            'data' => $countries
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capital' => 'required|string|max:255',
            'population' => 'required|integer',
            'currency' => 'required|string|max:50',
            'region' => 'required|string|max:100',
            'flag' => 'required|image|mimes:jpg,png,jpeg,svg|max:2048'
        ]);

        $flagPath = $request->file('flag')->store('flags', 'public');

        $country = Country::create([
            'name' => $request->name,
            'capital' => $request->capital,
            'population' => $request->population,
            'currency' => $request->currency,
            'region' => $request->region,
            'flag' => $flagPath
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Country created successfully',
            'data' => $country
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
{
    return response()->json([
        'status' => 'success',
        'data' => $country
    ]);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capital' => 'required|string|max:255',
            'population' => 'required|integer',
            'currency' => 'required|string|max:50',
            'region' => 'required|string|max:100',
            'flag' => 'sometimes|image|mimes:jpg,png,jpeg,svg|max:2048'
        ]);

        $data = $request->except('flag');

        if ($request->hasFile('flag')) {
            // Delete old flag if exists
            if ($country->flag) {
                Storage::disk('public')->delete($country->flag);
            }
            $data['flag'] = $request->file('flag')->store('flags', 'public');
        }

        $country->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Country updated successfully',
            'data' => $country
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {

        // Delete flag file if exists
        if ($country->flag) {
            Storage::disk('public')->delete($country->flag);
        }

        $country->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Country deleted successfully'
        ]);
    }   
}
