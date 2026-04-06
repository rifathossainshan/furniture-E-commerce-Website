<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Setting;

class SettingController extends Controller
{
    // ─── Helper: upload image to public/uploads/{folder} ────────────────────
    private function uploadImage($file, string $folder): string
    {
        $dir = public_path("uploads/{$folder}");
        if (!file_exists($dir)) {
            mkdir($dir, 0775, true);
        }
        $fileName = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $fileName);
        return "uploads/{$folder}/{$fileName}";
    }

    // ─── Helper: delete image from public/ ──────────────────────────────────
    private function deleteImage(?string $path): void
    {
        if ($path && file_exists(public_path($path))) {
            unlink(public_path($path));
        }
    }

    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $files = $request->allFiles();
        $data  = $request->except('_token');

        // Save plain text/textarea fields
        foreach ($data as $key => $value) {
            if (!array_key_exists($key, $files)) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => is_array($value) ? json_encode($value) : $value]
                );
            }
        }

        // Save uploaded image files → public/uploads/settings/
        foreach ($files as $key => $file) {
            // Delete old file if one exists
            $old = Setting::where('key', $key)->value('value');
            $this->deleteImage($old);

            $path = $this->uploadImage($file, 'settings');
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $path]
            );
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}
