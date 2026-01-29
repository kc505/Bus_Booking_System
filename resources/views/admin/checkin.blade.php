@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-black text-slate-800 mb-2">Check-in Management</h1>
            <p class="text-slate-500 font-medium">Scan tickets and manage passenger check-ins for today's trips</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid md:grid-cols-4 gap-6 mb-10">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Bookings</p>
                        <p class="text-3xl font-black text-slate-800">{{ $stats['total_today'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Checked In</p>
                        <p class="text-3xl font-black text-green-600">{{ $stats['checked_in'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Pending</p>
                        <p class="text-3xl font-black text-amber-500">{{ $stats['pending'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">No Show</p>
                        <p class="text-3xl font-black text-red-500">{{ $stats['no_show'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center text-red-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-12 gap-8">
            <!-- Sidebar: QR Scanner -->
            <div class="lg:col-span-4">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 sticky top-6">
                    <h2 class="text-xl font-black text-slate-800 mb-6">Quick Check-in</h2>

                    <div class="mb-6">
                        <label class="block text-xs font-black text-slate-400 uppercase mb-2">Booking Number</label>
                        <div class="flex space-x-2">
                            <input type="text" id="bookingNumber" placeholder="e.g. BK123456" class="flex-1 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all font-bold">
                            <button onclick="searchBooking()" class="btn-blue px-5 rounded-xl shadow-lg transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="relative py-4">
                        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-100"></div></div>
                        <div class="relative flex justify-center text-[10px] font-black text-slate-400 uppercase"><span class="px-3 bg-white tracking-widest">Scanning</span></div>
                    </div>

                    <div class="mt-4">
                        <button onclick="activateScanner()" class="w-full bg-slate-800 hover:bg-slate-900 text-white px-6 py-4 rounded-xl font-bold transition-all flex items-center justify-center shadow-lg">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                            Scan Ticket QR Code
                        </button>
                        <div id="qrScanner" class="hidden mt-6 bg-slate-900 rounded-2xl aspect-square flex items-center justify-center">
                            <p class="text-slate-400 text-xs font-bold italic">Initializing Camera...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content: Booking List -->
            <div class="lg:col-span-8 space-y-6">
                <!-- Advanced Filter Section -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <form action="{{ route('admin.checkin') }}" method="GET" class="row g-3 align-items-end text-dark">
                        <div class="col-md-5">
                            <label class="text-[10px] font-black text-slate-400 uppercase mb-2 block">Trip Date</label>
                            <input type="date" name="travel_date" class="form-control form-control-lg bg-slate-50 border-slate-200 rounded-xl font-bold text-sm"
                                   value="{{ request('travel_date', today()->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="text-[10px] font-black text-slate-400 uppercase mb-2 block">Departure Time</label>
                            <select name="departure_time" class="form-select form-select-lg bg-slate-50 border-slate-200 rounded-xl font-bold text-sm">
                                <option value="">All Schedules</option>
                                <option value="07:00" {{ request('departure_time') == '07:00' ? 'selected' : '' }}>07:00 AM (Morning)</option>
                                <option value="19:00" {{ request('departure_time') == '19:00' ? 'selected' : '' }}>07:00 PM (Evening)</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn-blue w-100 py-3 rounded-xl font-black text-xs uppercase tracking-widest shadow-lg">
                                Filter Bookings
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Bookings Table Container -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase">Booking #</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase">Passenger</th>
                                    <th class="px-6 py-4 text-center text-[10px] font-black text-slate-400 uppercase">Seats</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase">Status</th>
                                    <th class="px-6 py-4 text-right text-[10px] font-black text-slate-400 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100" id="bookingsTable">
                                @forelse($bookings as $booking)
                                <tr class="hover:bg-slate-50/50 transition-colors" data-booking-id="{{ $booking->id }}" data-status="{{ $booking->status }}">
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-blue-600">#{{ $booking->booking_number }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-black text-slate-800 text-sm mb-0">{{ $booking->passenger_name }}</p>
                                            <p class="text-xs text-slate-400">{{ $booking->passenger_phone }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex flex-wrap justify-center gap-1">
                                            @php $seatList = is_array($booking->seats) ? $booking->seats : json_decode($booking->seats, true); @endphp
                                            @foreach($seatList as $seat)
                                            <span class="bg-slate-100 text-slate-600 px-2 py-0.5 rounded text-[10px] font-black">{{ $seat }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="status-badge">
                                            @if($booking->status === 'confirmed')
                                                <span class="px-3 py-1 text-[10px] font-black uppercase rounded-full bg-amber-100 text-amber-700">Pending</span>
                                            @elseif($booking->status === 'checked_in')
                                                <span class="px-3 py-1 text-[10px] font-black uppercase rounded-full bg-green-100 text-green-700">Checked In</span>
                                            @elseif($booking->status === 'no_show')
                                                <span class="px-3 py-1 text-[10px] font-black uppercase rounded-full bg-red-100 text-red-800">No Show</span>
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2 action-buttons">
                                            @if($booking->status === 'confirmed')
                                                <button type="button" onclick="checkInBooking({{ $booking->id }})" class="btn-blue px-4 py-1.5 rounded-lg text-[10px] font-black uppercase shadow-sm">Check In</button>
                                                <button type="button" onclick="markNoShow({{ $booking->id }})" class="px-4 py-1.5 border border-red-200 text-red-500 rounded-lg text-[10px] font-black uppercase hover:bg-red-50 transition-all">No Show</button>
                                            @else
                                                <button type="button" onclick="viewDetails({{ $booking->id }})" class="px-4 py-1.5 border border-slate-200 text-slate-600 rounded-lg text-[10px] font-black uppercase hover:bg-slate-50 transition-all">Details</button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center text-slate-400 font-bold italic">No bookings found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(method_exists($bookings, 'hasPages') && $bookings->hasPages())
                    <div class="px-6 py-4 border-t border-slate-50">
                        {{ $bookings->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-blue {
        background-color: #2563eb;
        color: white;
        border: none;
        transition: all 0.2s ease;
    }
    .btn-blue:hover {
        background-color: #1d4ed8;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }
    .fw-black {
        font-weight: 900 !important;
    }
</style>

<script>
// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Check-in page loaded successfully');
});

// Get CSRF token for all requests
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

if (!csrfToken) {
    console.error('CSRF token not found! Make sure your layout has <meta name="csrf-token">');
}

// Search for booking by booking number
async function searchBooking() {
    const bookingNumber = document.getElementById('bookingNumber').value.trim();

    if (!bookingNumber) {
        showNotification('Please enter a booking number', 'error');
        return;
    }

    try {
        const response = await fetch(`{{ route('admin.checkin.search') }}?number=${bookingNumber}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        });

        const data = await response.json();

        if (data.success) {
            showNotification(`Found: ${data.booking.passenger_name}`, 'success');
            highlightBooking(data.booking.id);
        } else {
            showNotification(data.message || 'Booking not found', 'error');
        }
    } catch (error) {
        console.error('Search error:', error);
        showNotification('Error searching for booking', 'error');
    }
}

// Check in a booking
async function checkInBooking(bookingId) {
    console.log('Check-in clicked for booking:', bookingId);

    // Show confirmation dialog
    const confirmed = confirm('Confirm check-in for this passenger?');

    if (!confirmed) {
        console.log('Check-in cancelled by user');
        return;
    }

    console.log('Processing check-in...');

    try {
        const response = await fetch(`/admin/checkin/${bookingId}/check-in`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        });

        console.log('Response status:', response.status);
        const data = await response.json();
        console.log('Response data:', data);

        if (data.success) {
            showNotification('Check-in successful!', 'success');
            updateBookingRow(bookingId, 'checked_in');
        } else {
            showNotification(data.message || 'Failed to check in', 'error');
        }
    } catch (error) {
        console.error('Check-in error:', error);
        showNotification('Error processing check-in', 'error');
    }
}

// Mark booking as no show
async function markNoShow(bookingId) {
    console.log('No show clicked for booking:', bookingId);

    const confirmed = confirm('Mark this booking as No Show? This action cannot be undone.');

    if (!confirmed) {
        console.log('No show cancelled by user');
        return;
    }

    console.log('Processing no show...');

    try {
        const response = await fetch(`/admin/checkin/${bookingId}/no-show`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        });

        console.log('Response status:', response.status);
        const data = await response.json();
        console.log('Response data:', data);

        if (data.success) {
            showNotification('Marked as No Show', 'success');
            updateBookingRow(bookingId, 'no_show');
        } else {
            showNotification(data.message || 'Failed to mark as no show', 'error');
        }
    } catch (error) {
        console.error('No show error:', error);
        showNotification('Error marking as no show', 'error');
    }
}

// View booking details
function viewDetails(bookingId) {
    window.location.href = `/admin/checkin/${bookingId}`;
}

// Update booking row in the table after status change
function updateBookingRow(bookingId, newStatus) {
    console.log('Updating row for booking:', bookingId, 'New status:', newStatus);

    const row = document.querySelector(`tr[data-booking-id="${bookingId}"]`);
    if (!row) {
        console.log('Row not found, will reload page');
        setTimeout(() => window.location.reload(), 1500);
        return;
    }

    // Update status badge
    const statusCell = row.querySelector('.status-badge');
    if (statusCell) {
        if (newStatus === 'checked_in') {
            statusCell.innerHTML = '<span class="px-3 py-1 text-[10px] font-black uppercase rounded-full bg-green-100 text-green-700">Checked In</span>';
        } else if (newStatus === 'no_show') {
            statusCell.innerHTML = '<span class="px-3 py-1 text-[10px] font-black uppercase rounded-full bg-red-100 text-red-800">No Show</span>';
        }
    }

    // Update action buttons
    const actionsCell = row.querySelector('.action-buttons');
    if (actionsCell) {
        actionsCell.innerHTML = `<button type="button" onclick="viewDetails(${bookingId})" class="px-4 py-1.5 border border-slate-200 text-slate-600 rounded-lg text-[10px] font-black uppercase hover:bg-slate-50 transition-all">Details</button>`;
    }

    // Update row data attribute
    row.setAttribute('data-status', newStatus);

    // Add a highlight effect
    row.classList.add('bg-green-50');
    setTimeout(() => {
        row.classList.remove('bg-green-50');
    }, 2000);

    // Refresh page after 2 seconds to update stats
    setTimeout(() => {
        window.location.reload();
    }, 2000);
}

// Highlight a specific booking in the table
function highlightBooking(bookingId) {
    document.querySelectorAll('tr').forEach(row => {
        row.classList.remove('bg-blue-50', 'ring-2', 'ring-blue-500');
    });

    const row = document.querySelector(`tr[data-booking-id="${bookingId}"]`);
    if (row) {
        row.classList.add('bg-blue-50', 'ring-2', 'ring-blue-500');
        row.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

// Show notification
function showNotification(message, type = 'info') {
    console.log('Notification:', type, message);

    const toast = document.createElement('div');
    toast.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; padding: 16px 24px; border-radius: 8px; font-weight: bold; box-shadow: 0 4px 12px rgba(0,0,0,0.15); animation: slideIn 0.3s ease-out;';

    if (type === 'success') {
        toast.style.backgroundColor = '#10b981';
        toast.style.color = 'white';
        toast.innerHTML = `
            <div style="display: flex; align-items: center; gap: 8px;">
                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>${message}</span>
            </div>
        `;
    } else if (type === 'error') {
        toast.style.backgroundColor = '#ef4444';
        toast.style.color = 'white';
        toast.innerHTML = `
            <div style="display: flex; align-items: center; gap: 8px;">
                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span>${message}</span>
            </div>
        `;
    } else {
        toast.style.backgroundColor = '#3b82f6';
        toast.style.color = 'white';
        toast.innerHTML = `<span>${message}</span>`;
    }

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Add animation CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);

// Activate QR scanner
function activateScanner() {
    const scannerDiv = document.getElementById('qrScanner');
    scannerDiv.classList.toggle('hidden');

    if (!scannerDiv.classList.contains('hidden')) {
        showNotification('QR Scanner activated (Feature coming soon)', 'info');
    }
}

// Add Enter key support for booking search
document.getElementById('bookingNumber')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        searchBooking();
    }
});
</script>
@endsection
