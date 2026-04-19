<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Slider;

class SliderController extends Controller
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
        $sliders = Slider::latest()->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.form', ['slider' => new Slider()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'nullable|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'image'          => 'required|image|max:4096',
            'mobile_image'   => 'nullable|image|max:4096',
            'status'         => 'boolean',
            'show_text'      => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'sliders');
        }

        if ($request->hasFile('mobile_image')) {
            $data['mobile_image'] = $this->uploadImage($request->file('mobile_image'), 'sliders');
        }

        Slider::create($data);
        return redirect()->route('admin.sliders.index')->with('success', 'Slider created successfully.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.form', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $data = $request->validate([
            'title'       => 'nullable|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'image'          => 'nullable|image|max:4096',
            'mobile_image'   => 'nullable|image|max:4096',
            'status'         => 'boolean',
            'show_text'      => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $this->deleteImage($slider->image);   // delete old
            $data['image'] = $this->uploadImage($request->file('image'), 'sliders');
        }

        if ($request->hasFile('mobile_image')) {
            $this->deleteImage($slider->mobile_image);   // delete old
            $data['mobile_image'] = $this->uploadImage($request->file('mobile_image'), 'sliders');
        }

        $slider->update($data);
        return redirect()->route('admin.sliders.index')->with('success', 'Slider updated successfully.');
    }

    public function destroy(Slider $slider)
    {
        $this->deleteImage($slider->image);
        $this->deleteImage($slider->mobile_image);
        $slider->delete();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider deleted successfully.');
    }
}
