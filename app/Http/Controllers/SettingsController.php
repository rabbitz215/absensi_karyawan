<?php

namespace App\Http\Controllers;

use App\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Settings::first();
        $titleTab = 'Settings Page';

        return view('settings.index', compact('settings', 'titleTab'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $settings = Settings::first();
        if ($settings) {
            $settings->jam_masuk = $request->jam_masuk;
            $settings->jam_pulang = $request->jam_pulang;
            $settings->toleransi_jam_masuk = $request->toleransi_jam_masuk;
            $settings->save();
        } else {
            $settings = new Settings();
            $settings->jam_masuk = $request->jam_masuk;
            $settings->jam_pulang = $request->jam_pulang;
            $settings->toleransi_jam_masuk = $request->toleransi_jam_masuk;
            $settings->save();
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Settings $settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Settings $settings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Settings $settings)
    {
        //
    }
}
