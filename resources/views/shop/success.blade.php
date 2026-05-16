@extends('shop.layout')

@section('content')

<div class="max-w-3xl mx-auto px-4 sm:px-0">

    <!-- SUCCESS HEADER -->
    <div class="text-center bg-white p-6 sm:p-8 rounded-lg shadow mb-6">

        <div class="text-green-600 text-5xl sm:text-6xl mb-4">
            ✓
        </div>

        <h1 class="text-2xl sm:text-3xl font-bold mb-2 text-gray-800">
            Order Placed Successfully
        </h1>

        <p class="text-gray-600 mb-4 sm:mb-6 text-sm sm:text-base">
            Thank you for shopping with us.
        </p>

        <!-- STATUS BADGE -->
        <span id="order-status"
              class="inline-block px-4 py-1 rounded text-white text-sm
              {{ $order->status == 'paid' ? 'bg-green-600' : 'bg-yellow-500' }}">

            Status: {{ strtoupper($order->status) }}

        </span>

    </div>

    <!-- ORDER SUMMARY -->
    <div class="bg-white border rounded-lg p-4 sm:p-6 mb-6 shadow">

        <h2 class="text-lg sm:text-xl font-bold mb-4 text-gray-800">
            Order Summary
        </h2>

        <div class="space-y-3 text-sm sm:text-base">

            <div class="flex justify-between">
                <span class="font-medium text-gray-600">Order ID:</span>
                <span>#{{ $order->id }}</span>
            </div>

            <div class="flex justify-between">
                <span class="font-medium text-gray-600">Customer:</span>
                <span class="text-right">{{ $order->name }}</span>
            </div>

            <div class="flex justify-between">
                <span class="font-medium text-gray-600">Phone:</span>
                <span>{{ $order->phone }}</span>
            </div>

            <div class="flex justify-between pt-2 border-t">
                <span class="font-medium text-gray-600">Total:</span>
                <span class="font-bold text-gray-800">
                    KSh {{ number_format($order->total, 2) }}
                </span>
            </div>

        </div>

    </div>

    <!-- MPESA PAYMENT SECTION -->
    @if($order->status != 'paid')

    <div class="bg-gray-100 p-4 sm:p-6 rounded-lg mb-6 shadow">

        <h3 class="font-bold mb-2 text-lg text-gray-800">
            Pay with M-Pesa
        </h3>

        <p class="text-sm text-gray-600 mb-4">
            Enter your Safaricom number to receive STK Push.
        </p>

        <form id="mpesa-form" class="space-y-3">

            @csrf

            <input type="text"
                   id="phone"
                   name="phone"
                   value="{{ $order->phone }}"
                   placeholder="2547XXXXXXXX"
                   class="border p-3 w-full rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">

            <button type="submit"
                    id="pay-btn"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg w-full transition font-medium">

                Pay Now
            </button>

        </form>

        <!-- RESPONSE AREA -->
        <div id="mpesa-response" class="mt-4 text-sm"></div>

    </div>

    @else

    <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 text-sm sm:text-base">
        ✔ Payment completed successfully
    </div>

    @endif

    <!-- ORDER ITEMS -->
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow">

        <h2 class="text-lg sm:text-xl font-bold mb-4 text-gray-800">
            Ordered Items
        </h2>

        <div class="space-y-4">

            @foreach($order->items as $item)

                <div class="flex justify-between items-start border-b pb-3 gap-3">

                    <div class="flex-1">

                        <p class="font-medium text-gray-800">
                            {{ $item->product->name }}
                        </p>

                        <p class="text-sm text-gray-500">
                            Qty: {{ $item->quantity }}
                        </p>

                    </div>

                    <div class="font-bold text-gray-800 whitespace-nowrap">
                        KSh {{ number_format($item->subtotal, 2) }}
                    </div>

                </div>

            @endforeach

        </div>

    </div>

    <!-- CONTINUE SHOPPING -->
    <div class="mt-8 text-center">

        <a href="{{ route('shop') }}"
           class="inline-block w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition">

            Continue Shopping

        </a>

    </div>

</div>

<!-- =========================
     MPESA AJAX SCRIPT
========================= -->

<script>

document.getElementById('mpesa-form')?.addEventListener('submit', async function(e) {

    e.preventDefault();

    let phone = document.getElementById('phone').value.trim();
    let btn = document.getElementById('pay-btn');
    let responseBox = document.getElementById('mpesa-response');

    responseBox.innerHTML = "";
    btn.disabled = true;
    btn.innerHTML = "Sending STK Push...";

    try {

        let response = await fetch("{{ route('mpesa.stk', $order->id) }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                phone: phone,
                amount: {{ $order->total }}
            })
        });

        let text = await response.text();
        let data;

        try {
            data = JSON.parse(text);
        } catch (e) {

            responseBox.innerHTML = `
                <div class="bg-red-100 text-red-700 p-3 rounded">
                    ❌ Invalid JSON response from server
                </div>
            `;

            btn.disabled = false;
            btn.innerHTML = "Pay Now";
            return;
        }

        if (data.success === true || data.ResponseCode == "0") {

            responseBox.innerHTML = `
                <div class="bg-green-100 text-green-700 p-3 rounded">
                    ✔ STK Push sent successfully. Check your phone.
                </div>
            `;

        } else {

            responseBox.innerHTML = `
                <div class="bg-red-100 text-red-700 p-3 rounded">
                    ❌ ${data.message || data.errorMessage || 'Payment failed'}
                </div>
            `;
        }

    } catch (error) {

        responseBox.innerHTML = `
            <div class="bg-red-100 text-red-700 p-3 rounded">
                ❌ Network or server error
            </div>
        `;
    }

    btn.disabled = false;
    btn.innerHTML = "Pay Now";

});

</script>

@endsection
