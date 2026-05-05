@extends('layouts.admin')

@section('header', $voucher->exists ? 'Edit Voucher' : 'Add Voucher')

@section('content')
    <div class="bg-white rounded shadow p-6 max-w-2xl mx-auto">
        <form action="{{ $voucher->exists ? route('admin.vouchers.update', $voucher) : route('admin.vouchers.store') }}"
            method="POST">
            @csrf
            @if($voucher->exists)
                @method('PUT')
            @endif

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Voucher Code <span
                        class="text-red-500">*</span></label>
                <input type="text" name="code" value="{{ old('code', $voucher->code) }}"
                    class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900 uppercase"
                    required placeholder="SUMMER50">
                @error('code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Discount Type <span
                            class="text-red-500">*</span></label>
                    <select name="type"
                        class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900" required>
                        <option value="fixed" {{ old('type', $voucher->type) == 'fixed' ? 'selected' : '' }}>Fixed Amount ($)
                        </option>
                        <option value="percent" {{ old('type', $voucher->type) == 'percent' ? 'selected' : '' }}>Percentage
                            (%)</option>
                    </select>
                    @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Discount Amount <span
                            class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="amount" value="{{ old('amount', $voucher->amount) }}"
                        class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900" required>
                    @error('amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Usage Limit (Total)</label>
                    <input type="number" name="usage_limit" value="{{ old('usage_limit', $voucher->usage_limit) }}"
                        class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900"
                        placeholder="e.g. 100">
                    <p class="text-xs text-gray-500 mt-1">Leave empty for unlimited</p>
                    @error('usage_limit') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Expiry Date</label>
                    <input type="date" name="expiry_date" value="{{ old('expiry_date', $voucher->expiry_date) }}"
                        class="w-full border-gray-300 rounded shadow-sm focus:border-gray-900 focus:ring-gray-900">
                    <p class="text-xs text-gray-500 mt-1">Leave empty if it never expires</p>
                    @error('expiry_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mb-6 flex items-center">
                <input type="hidden" name="status" value="0">
                <input type="checkbox" name="status" value="1" {{ old('status', $voucher->status ?? true) ? 'checked' : '' }}
                    class="rounded border-gray-300 text-gray-900 shadow-sm focus:border-gray-900 focus:ring focus:ring-gray-900 focus:ring-opacity-50">
                <label class="ml-2 block text-gray-700 text-sm font-bold">Active</label>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline">
                    {{ $voucher->exists ? 'Update Voucher' : 'Save Voucher' }}
                </button>
                <a href="{{ route('admin.vouchers.index') }}"
                    class="text-gray-600 hover:text-gray-900 font-medium">Cancel</a>
            </div>
        </form>
    </div>
@endsection
