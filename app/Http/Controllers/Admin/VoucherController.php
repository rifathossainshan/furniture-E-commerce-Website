<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Voucher;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::latest()->get();
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.vouchers.form', ['voucher' => new Voucher()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|unique:vouchers,code|max:50',
            'type' => 'required|in:fixed,percent',
            'amount' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date',
            'usage_limit' => 'nullable|integer|min:1',
            'status' => 'boolean'
        ]);

        $data['code'] = strtoupper($data['code']);
        Voucher::create($data);

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher created successfully.');
    }

    public function edit(Voucher $voucher)
    {
        return view('admin.vouchers.form', compact('voucher'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:vouchers,code,' . $voucher->id,
            'type' => 'required|in:fixed,percent',
            'amount' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date',
            'usage_limit' => 'nullable|integer|min:1',
            'status' => 'boolean'
        ]);

        $data['code'] = strtoupper($data['code']);
        $voucher->update($data);

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher updated successfully.');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher deleted successfully.');
    }
}
