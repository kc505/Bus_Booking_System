@extends('layouts.app')

@section('content')
<!-- BULLETPROOF STYLES: These will work even if your CSS file is broken -->
<style>
    .bus-hull {
        background-color: #f1f5f9;
        border: 4px solid #cbd5e1;
        border-radius: 40px;
        padding: 30px;
        max-width: 440px;
        margin: 20px auto;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
    }
    .seat-row {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
        margin-bottom: 10px;
    }
    .seat-item {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        border: 2px solid #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 13px;
        cursor: pointer;
        user-select: none;
        background-color: white;
        transition: all 0.2s;
    }
    .aisle-space { width: 35px; }

    /* FIXED COLOR STATES */
    .s-available { background-color: #ffffff !important; color: #1e293b !important; border-color: #94a3b8 !important; }
    .s-selected { background-color: #22c55e !important; color: #ffffff !important; border-color: #16a34a !important; transform: scale(1.05); }
    .s-booked { background-color: #f87171 !important; color: #ffffff !important; border-color: #ef4444 !important; cursor: not-allowed !important; }
    .s-offline { background-color: #e2e8f0 !important; color: #94a3b8 !important; border-color: #cbd5e1 !important; cursor: not-allowed !important; }

    .legend-indicator { width: 22px; height: 22px; border-radius: 4px; border: 1px solid #94a3b8; }
</style>

<div class="min-h-screen bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-8 items-start">

            <!-- LEFT: BUS SEATING -->
            <div class="lg:col-span-2 bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
                <h2 class="text-3xl font-black text-gray-900 text-center mb-8">Select Your Seat</h2>

                <!-- Legend -->
                <div class="flex flex-wrap justify-center gap-8 mb-12 pb-8 border-b">
                    <div class="flex items-center gap-2"><div class="legend-indicator" style="background-color: #ffffff;"></div><span class="text-xs font-bold">Available</span></div>
                    <div class="flex items-center gap-2"><div class="legend-indicator" style="background-color: #22c55e;"></div><span class="text-xs font-bold">Selected</span></div>
                    <div class="flex items-center gap-2"><div class="legend-indicator" style="background-color: #f87171;"></div><span class="text-xs font-bold">Booked</span></div>
                    <div class="flex items-center gap-2"><div class="legend-indicator" style="background-color: #e2e8f0;"></div><span class="text-xs font-bold">Offline</span></div>
                </div>

                <div class="bus-hull">
                    <!-- Driver Section -->
                    <div class="flex justify-between items-center mb-10 px-2">
                        <div style="border: 2px dashed #94a3b8; padding: 6px 16px; border-radius: 10px; font-size: 11px; font-weight: 900; color: #94a3b8;">ENTRY</div>
                        <div style="background: #1e293b; color: white; padding: 8px 25px; border-radius: 10px; font-size: 14px; font-weight: 900; letter-spacing: 1px;">DRIVER</div>
                    </div>

                    @php
                        $booked = $bookedSeats ?? [];
                        $totalRows = 16;
                    @endphp

                    @for ($r = 0; $r < $totalRows; $r++)
                        <div class="seat-row">
                            <!-- ONLINE SECTION (Left, 1-32) -->
                            @for ($c = 1; $c <= 2; $c++)
                                @php
                                    $n = ($r * 2) + $c;
                                    $isB = in_array($n, $booked);
                                @endphp
                                @if($n <= 32)
                                    <div id="seat-{{ $n }}"
                                         onclick="toggleSeat({{ $n }})"
                                         class="seat-item {{ $isB ? 's-booked' : 's-available' }}">
                                        {{ $n }}
                                    </div>
                                @endif
                            @endfor

                            <div class="aisle-space"></div>

                            <!-- OFFLINE SECTION (Right, 33-70) -->
                            @for ($c = 1; $c <= 3; $c++)
                                @php
                                    $n = 32 + ($r * 3) + $c;
                                    $isB = in_array($n, $booked);
                                @endphp
                                @if($n <= 70)
                                    <div class="seat-item {{ $isB ? 's-booked' : 's-offline' }}">
                                        {{ $n }}
                                    </div>
                                @else
                                    <div style="width:44px;"></div>
                                @endif
                            @endfor
                        </div>
                    @endfor
                </div>
            </div>

            <!-- RIGHT: SUMMARY PANEL -->
            <div class="lg:col-span-1 bg-white rounded-3xl shadow-xl p-8 border border-gray-100 sticky top-10">
                <h3 class="text-2xl font-black text-gray-900 mb-8 border-b pb-6">Booking Summary</h3>

                <div class="space-y-6 mb-10">
                    <div><p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Agency</p><p class="text-xl font-bold text-gray-800">{{ $bookingData['agency_name'] ?? 'Musango' }}</p></div>
                    <div><p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Route</p><p class="font-bold text-gray-700 text-lg">{{ $bookingData['departure_city'] }} → {{ $bookingData['destination_city'] }}</p></div>
                    <div class="flex justify-between">
                        <div><p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Date</p><p class="font-bold text-gray-800">{{ date('M d, Y', strtotime($bookingData['travel_date'])) }}</p></div>
                        <div><p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Time</p><p class="font-bold text-gray-800">{{ date('g:i A', strtotime($bookingData['departure_time'])) }}</p></div>
                    </div>
                </div>

                <div style="background-color: #eff6ff; border: 1px solid #dbeafe; padding: 20px; border-radius: 20px; margin-bottom: 30px;">
                    <p class="text-[10px] font-black text-blue-500 mb-3 uppercase">Selected Seats</p>
                    <div id="ui-selected-list" class="text-sm text-blue-300 italic font-bold">No seats selected</div>
                </div>

                <div class="space-y-3 mb-10 text-sm">
                    <div class="flex justify-between text-gray-500">
                        <span>Price per seat</span>
                        <!-- FIXED: ADDED ID FOR JAVASCRIPT ACCESS -->
                        <span class="font-bold text-gray-900" id="ui-seat-price">0 FCFA</span>
                    </div>
                    <div class="flex justify-between text-gray-500"><span>Number of seats</span><span class="font-bold text-gray-900" id="ui-count">0</span></div>
                    <div class="flex justify-between text-gray-500"><span>Service Fee</span><span class="font-bold text-gray-900">500 FCFA</span></div>
                    <div class="flex justify-between text-3xl font-black text-blue-600 pt-6 border-t mt-6">
                        <span>Total</span>
                        <span id="ui-total">0 FCFA</span>
                    </div>
                </div>

                <form id="payment-form" action="{{ route('booking.confirm') }}" method="POST">
                    @csrf
                    <!-- Core IDs -->
                    <input type="hidden" name="agency_id" value="{{ $bookingData['agency_id'] }}">
                    <input type="hidden" name="route_id" value="{{ $bookingData['route_id'] }}">

                    <!-- Display Names -->
                    <input type="hidden" name="agency_name" value="{{ $bookingData['agency_name'] ?? 'Musango' }}">
                    <input type="hidden" name="departure_city" value="{{ $bookingData['departure_city'] }}">
                    <input type="hidden" name="destination_city" value="{{ $bookingData['destination_city'] }}">

                    <!-- Trip Details -->
                    <input type="hidden" name="travel_date" value="{{ $bookingData['travel_date'] }}">
                    <input type="hidden" name="departure_time" value="{{ $bookingData['departure_time'] }}">
                    <input type="hidden" name="price" value="{{ $bookingData['price'] ?? 0 }}">

                    <!-- Dynamic Totals -->
                    <input type="hidden" name="seats" id="hidden-seats-val">
                    <input type="hidden" name="subtotal" id="hidden-subtotal-val">
                    <input type="hidden" name="total_amount" id="hidden-total-val">

                    <button type="button" onclick="submitForm()" style="background-color: #2563eb;" class="w-full text-white font-black py-5 rounded-2xl shadow-lg active:scale-95 transition-transform text-lg">
                        Continue to Payment
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let mySelection = [];
    const seatPrice = {{ $bookingData['price'] ?? 0 }};
    const fee = 500;

    function toggleSeat(id) {
        const el = document.getElementById('seat-' + id);
        if (el.classList.contains('s-booked') || el.classList.contains('s-offline')) return;

        const pos = mySelection.indexOf(id);
        if (pos > -1) {
            mySelection.splice(pos, 1);
            el.classList.remove('s-selected');
            el.classList.add('s-available');
        } else {
            if (mySelection.length >= 5) { alert("Maximum 5 seats allowed."); return; }
            mySelection.push(id);
            el.classList.remove('s-available');
            el.classList.add('s-selected');
        }
        refreshSummary();
    }

    function refreshSummary() {
        const list = document.getElementById('ui-selected-list');
        const priceText = document.getElementById('ui-seat-price');
        const totalText = document.getElementById('ui-total');
        const countText = document.getElementById('ui-count');

        const inputSeats = document.getElementById('hidden-seats-val');
        const inputSubtotal = document.getElementById('hidden-subtotal-val');
        const inputTotal = document.getElementById('hidden-total-val');

        if (mySelection.length === 0) {
            list.innerHTML = "No seats selected";
            priceText.innerText = "0 FCFA";
            totalText.innerText = '0 FCFA';
            if(inputSubtotal) inputSubtotal.value = 0;
            if(inputTotal) inputTotal.value = 0;
        } else {
            list.innerHTML = mySelection.sort((a,b) => a-b).map(s =>
                `<span style="background:#2563eb; color:#fff; padding:4px 12px; border-radius:20px; margin-right:6px; font-weight:bold; font-size:11px;">Seat ${s}</span>`
            ).join('');

            // FIXED: UPDATE THE PRICE DISPLAY AUTOMATICALLY
            priceText.innerText = seatPrice.toLocaleString() + ' FCFA';

            let subtotal = mySelection.length * seatPrice;
            let total = subtotal + fee;

            totalText.innerText = total.toLocaleString() + ' FCFA';

            if(inputSeats) inputSeats.value = JSON.stringify(mySelection);
            if(inputSubtotal) inputSubtotal.value = subtotal;
            if(inputTotal) inputTotal.value = total;
        }
        countText.innerText = mySelection.length;
    }

    function submitForm() {
        if (mySelection.length === 0) {
            alert("Please select at least one seat before continuing.");
            return;
        }
        document.getElementById('payment-form').submit();
    }
</script>
@endsection
