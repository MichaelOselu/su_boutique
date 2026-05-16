@extends('shop.layout')

@section('content')

<div class="max-w-6xl mx-auto px-4 sm:px-0">

    <!-- PAGE TITLE -->
    <div class="mb-6">

        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">
            Checkout
        </h1>

        <p class="text-gray-500 text-sm mt-1">
            Enter your details and confirm delivery location
        </p>

    </div>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- =========================
         RESPONSIVE GRID
         (STACK ON MOBILE, 2-COLUMN ON DESKTOP)
    ========================= -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- =========================
             CHECKOUT FORM
        ========================= -->
        <div class="lg:col-span-2 bg-white p-4 sm:p-6 rounded-lg shadow">

            <form method="POST" action="{{ route('checkout.store') }}">
                @csrf

                <!-- NAME -->
                <div class="mb-4">
                    <label class="block mb-1 font-medium text-gray-700">
                        Full Name
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ auth()->user()->name ?? '' }}"
                           class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                           required>
                </div>

                <!-- EMAIL -->
                <div class="mb-4">
                    <label class="block mb-1 font-medium text-gray-700">
                        Email
                    </label>

                    <input type="email"
                           name="email"
                           value="{{ auth()->user()->email ?? '' }}"
                           class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                           required>
                </div>

                <!-- PHONE -->
                <div class="mb-4">
                    <label class="block mb-1 font-medium text-gray-700">
                        Phone Number
                    </label>

                    <input type="text"
                           name="phone"
                           placeholder="07XXXXXXXX"
                           class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                           required>
                </div>

                <!-- ADDRESS -->
                <div class="mb-4">

                    <label class="block mb-1 font-medium text-gray-700">
                        Delivery Address
                    </label>

                    <textarea name="address"
                              id="address"
                              rows="4"
                              class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                              placeholder="Enter your house, street, estate..."
                              required></textarea>

                    <!-- LOCATION BUTTON -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-2 gap-2">

                        <button type="button"
                                onclick="useMyLocation()"
                                class="text-sm text-green-600 font-medium hover:underline text-left sm:text-left">
                            📍 Use my current location
                        </button>

                        <span id="locStatus" class="text-xs text-gray-500"></span>

                    </div>

                </div>

                <!-- HIDDEN COORDINATES -->
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

                <!-- COORDINATES PREVIEW -->
                <div class="bg-gray-100 p-3 rounded mb-4 text-sm space-y-1">

                    <p>
                        <strong>Latitude:</strong>
                        <span id="latText"></span>
                    </p>

                    <p>
                        <strong>Longitude:</strong>
                        <span id="lngText"></span>
                    </p>

                </div>

                <!-- SUBMIT -->
                <button class="w-full bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                    Place Order
                </button>

            </form>

        </div>

        <!-- =========================
             ORDER SUMMARY
        ========================= -->
        <div class="bg-white p-4 sm:p-6 rounded-lg shadow h-fit">

            <h2 class="text-xl font-bold mb-4">
                Order Summary
            </h2>

            <div class="space-y-4">

                @foreach($cart as $item)

                    <div class="flex justify-between border-b pb-2 gap-3">

                        <div>
                            <p class="font-medium text-gray-800">
                                {{ $item['name'] }}
                            </p>

                            <p class="text-sm text-gray-500">
                                Qty: {{ $item['quantity'] }}
                            </p>
                        </div>

                        <div class="font-bold text-gray-800 whitespace-nowrap">
                            KSh {{ $item['price'] * $item['quantity'] }}
                        </div>

                    </div>

                @endforeach

            </div>

            <div class="mt-6 border-t pt-4 flex justify-between text-lg sm:text-xl font-bold">

                <span>Total</span>
                <span>KSh {{ $total }}</span>

            </div>

        </div>

    </div>

</div>

<!-- ===================== -->
<!-- GEOLOCATION SCRIPT -->
<!-- ===================== -->
<script>

function useMyLocation() {

    const status = document.getElementById("locStatus");
    status.innerText = "Detecting location...";

    if (!navigator.geolocation) {
        status.innerText = "Geolocation not supported";
        return;
    }

    navigator.geolocation.getCurrentPosition(
        function (position) {

            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            document.getElementById("latitude").value = lat;
            document.getElementById("longitude").value = lng;

            document.getElementById("latText").innerText = lat;
            document.getElementById("lngText").innerText = lng;

            status.innerText = "Location captured ✔";

            reverseGeocode(lat, lng);
        },
        function (error) {

            if (error.code === 1) {
                status.innerText = "Please allow location access";
            } else if (error.code === 2) {
                status.innerText = "Location unavailable";
            } else if (error.code === 3) {
                status.innerText = "Request timed out";
            } else {
                status.innerText = "Failed to get location";
            }
        }
    );
}

// Reverse geocode (optional)
function reverseGeocode(lat, lng) {

    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
        .then(res => res.json())
        .then(data => {

            if (data && data.display_name) {
                document.getElementById("address").value = data.display_name;
            }
        })
        .catch(() => {});
}

</script>

@endsection
