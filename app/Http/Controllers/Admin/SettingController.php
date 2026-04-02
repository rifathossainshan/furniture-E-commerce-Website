<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $files = $request->allFiles();

        // Process standard text data
        foreach ($data as $key => $value) {
            if (!array_key_exists($key, $files)) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => is_array($value) ? json_encode($value) : $value]
                );
            }
        }

        // Process any uploaded files
        foreach ($files as $key => $file) {
            $path = $file->store('settings', 'public');
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $path]
            );
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}
