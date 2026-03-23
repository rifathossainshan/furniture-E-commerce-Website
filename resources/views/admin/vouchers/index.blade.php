@extends('layouts.admin')

@section('header', 'Vouchers')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Manage Vouchers & Coupons</h2>
        <a href="{{ route('admin.vouchers.create') }}"
            class="px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-800">Add Voucher</a>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr>
                    <th
                        class="py-3 px-6 bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Code</th>
                    <th
                        class="py-3 px-6 bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Discount</th>
                    <th
                        class="py-3 px-6 bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Usage</th>
                    <th
                        class="py-3 px-6 bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Expiry Date</th>
                    <th
                        class="py-3 px-6 bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Status</th>
                    <th
                        class="py-3 px-6 bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider text-right">
                        Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vouchers as $voucher)
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-6 border-b border-gray-200 text-sm font-bold text-gray-900">{{ $voucher->code }}</td>
                        <td class="py-4 px-6 border-b border-gray-200 text-sm text-gray-700">
                            {{ $voucher->type === 'percent' ? rtrim(rtrim($voucher->amount, '0'), '.') . '%' : '$' . number_format($voucher->amount, 2) }}
                        </td>
                        <td class="py-4 px-6 border-b border-gray-200 text-sm text-gray-700">
                            {{ $voucher->used_count }} / {{ $voucher->usage_limit ?: '∞' }}
                        </td>
                        <td class="py-4 px-6 border-b border-gray-200 text-sm text-gray-700">
                            {{ $voucher->expiry_date ? \Carbon\Carbon::parse($voucher->expiry_date)->format('M d, Y') : 'Never' }}
                        </td>
                        <td class="py-4 px-6 border-b border-gray-200 text-sm">
                            <span
                                class="px-2 py-1 leading-tight rounded-full text-xs font-semibold {{ $voucher->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $voucher->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="py-4 px-6 border-b border-gray-200 text-sm text-right">
                            <a href="{{ route('admin.vouchers.edit', $voucher) }}"
                                class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                            <form action="{{ route('admin.vouchers.destroy', $voucher) }}" method="POST" class="inline-block"
                                onsubmit="return confirm('Delete this voucher?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 px-6 text-center text-gray-500">No vouchers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection