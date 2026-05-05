@extends('layouts.admin')

@section('header', 'Manage Customer Reviews')

@section('content')
    <div class="bg-white rounded shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">All Reviews</h3>
            <a href="{{ route('admin.reviews.create') }}" class="text-white font-bold py-2 px-4 rounded text-sm shadow transition" style="background-color: #2563eb;">
                + Add Manual Review
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 text-green-700 px-6 py-3 border-b border-green-200 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="p-6 space-y-6">
            @forelse($reviews as $review)
                <div class="border border-gray-200 rounded p-5 relative">
                    <!-- Status Badge -->
                    <div class="absolute top-5 right-5">
                        <span class="px-2 py-1 leading-tight rounded-full text-xs font-semibold
                            {{ $review->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $review->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $review->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($review->status) }}
                        </span>
                    </div>

                    <div class="mb-4 text-sm text-gray-600">
                        <p class="mb-1"><strong class="text-gray-900">Product:</strong> {{ $review->product->name ?? 'Deleted Product' }}</p>
                        <p class="mb-1">
                            <strong class="text-gray-900">Customer:</strong> {{ $review->customer_name ?? ($review->user->name ?? 'Guest') }} 
                            <span class="text-xs text-gray-400">({{ ($review->review_date ?? $review->created_at)->format('M d, Y h:i A') }})</span>
                            @if($review->is_admin_added)
                                <span class="ml-2 bg-blue-100 text-blue-800 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider">Admin Added</span>
                            @endif
                        </p>
                        <p class="mb-1"><strong class="text-gray-900">Rating:</strong> <span class="text-yellow-500 font-bold">{{ $review->rating }}/5</span></p>
                    </div>

                    @if($review->comment)
                        <div class="mb-4">
                            <strong class="text-gray-900 text-sm block mb-1">Comment:</strong>
                            <p class="text-gray-700 bg-gray-50 p-3 rounded text-sm">{{ $review->comment }}</p>
                        </div>
                    @endif

                    @if($review->images->count())
                        <div class="mb-4">
                            <strong class="text-gray-900 text-sm block mb-2">Attached Images:</strong>
                            <div class="flex gap-2 flex-wrap">
                                @foreach($review->images as $img)
                                    <a href="{{ asset($img->image) }}" target="_blank">
                                        <img src="{{ asset($img->image) }}" class="w-16 h-16 object-cover rounded border border-gray-200 shadow-sm hover:opacity-80 transition">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap items-end gap-4 mt-6 pt-4 border-t border-gray-100">
                        <div class="flex gap-2">
                            @if($review->status !== 'approved')
                            <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-white text-xs font-semibold px-3 py-1.5 rounded transition shadow-sm" style="background-color: #16a34a;">
                                    Approve
                                </button>
                            </form>
                            @endif

                            @if($review->status !== 'rejected')
                            <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-white text-xs font-semibold px-3 py-1.5 rounded transition shadow-sm" style="background-color: #dc2626;">
                                    Reject
                                </button>
                            </form>
                            @endif

                            <!-- Delete Button -->
                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-white text-xs font-semibold px-3 py-1.5 rounded transition shadow-sm" style="background-color: #4b5563;">
                                    Delete
                                </button>
                            </form>
                        </div>

                        <!-- Admin Reply Form -->
                        <div class="ml-auto w-full md:w-3/4">
                            <form action="{{ route('admin.reviews.reply', $review->id) }}" method="POST" class="flex gap-2 items-end">
                                @csrf
                                <div class="w-1/3">
                                    <label class="text-[10px] uppercase font-bold text-gray-500 tracking-wider mb-1 block">Reply As</label>
                                    <select name="reply_by" class="w-full text-sm border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 p-2 h-[38px]">
                                        <option value="Admin" {{ $review->reply_by === 'Admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="Musfiq (Owner)" {{ $review->reply_by === 'Musfiq (Owner)' ? 'selected' : '' }}>Musfiq (Owner)</option>
                                        <option value="Royal Support" {{ $review->reply_by === 'Royal Support' ? 'selected' : '' }}>Royal Support</option>
                                        <option value="Customer Care" {{ $review->reply_by === 'Customer Care' ? 'selected' : '' }}>Customer Care</option>
                                        <option value="Team Royal" {{ $review->reply_by === 'Team Royal' ? 'selected' : '' }}>Team Royal</option>
                                    </select>
                                </div>
                                <div class="flex-1">
                                    <label class="text-[10px] uppercase font-bold text-gray-500 tracking-wider mb-1 block">Response Message</label>
                                    <input type="text" name="admin_reply" value="{{ $review->admin_reply }}" placeholder="Write admin reply..." required class="w-full text-sm border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 p-2 h-[38px]">
                                </div>
                                <button type="submit" class="text-white text-xs font-semibold px-4 py-2 rounded transition shadow-sm whitespace-nowrap h-[38px]" style="background-color: #2563eb;">
                                    {{ $review->admin_reply ? 'Update Reply' : 'Send Reply' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10">
                    <p class="text-gray-500">No reviews found.</p>
                </div>
            @endforelse
        </div>

        @if($reviews->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
@endsection
