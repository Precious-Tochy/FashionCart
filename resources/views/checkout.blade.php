@extends('layouts.index layout')

@section('content')
<div class="container" style="margin-top:50px; max-width:1000px;">

    <h1 style="color: rgb(172,112,148); text-align:center; margin-bottom:30px;">
        Checkout
    </h1>

    @if(count($cart) > 0)

    <div style="display:flex; gap:40px; flex-wrap:wrap;">

        {{-- ================================
            LEFT SIDE — ORDER SUMMARY
        ================================= --}}
        <div style="flex:1; min-width:300px;">
            <h3 style="margin-bottom:15px;">Your Order</h3>

            @foreach($cart as $item)
            <div style="
                display:flex;
                align-items:center;
                margin-bottom:15px;
                padding:10px;
                border:1px solid #eee;
                border-radius:8px;
                box-shadow:0 2px 4px rgba(0,0,0,0.05);
            ">
                <img 
                    src="{{ asset('uploads/dress_pic/'.$item->product_image) }}"
                    style="width:80px; height:80px; object-fit:cover; border-radius:6px; margin-right:15px;"
                >

                <div style="flex:1;">
                    <p style="margin:0; font-weight:bold;">{{ $item->product_name }}</p>
                    <p style="margin:5px 0;">Quantity: {{ $item->quantity }}</p>
                    <p style="margin:0;">Price: ₦{{ number_format($item->price) }}</p>
                </div>

                <div style="text-align:right; font-weight:bold;">
                    ₦{{ number_format($item->price * $item->quantity) }}
                </div>
            </div>
            @endforeach

            <div style="text-align:right; margin-top:20px; font-size:18px; font-weight:bold;">
                Subtotal: ₦<span id="subtotal">{{ number_format($subtotal) }}</span>
            </div>
        </div>


        {{-- ================================
            RIGHT SIDE — DELIVERY + PAYMENT
        ================================= --}}
        <div style="flex:1; min-width:300px;">
            <h3 style="margin-bottom:15px;">Delivery Details</h3>

            <form id="checkoutForm">
                @csrf

                <input type="hidden" id="amount" value="{{ $subtotal }}">

                {{-- Full Name --}}
                <label>Full Name:</label>
                <input type="text" id="fullName" required
                    placeholder="Enter your full name"
                    style="width:100%; padding:10px; margin-bottom:10px; border-radius:6px; border:1px solid #ccc;">

                {{-- Phone --}}
                <label>Phone Number:</label>
                <input type="text" id="phone" required
                    placeholder="Enter your phone number"
                    style="width:100%; padding:10px; margin-bottom:10px; border-radius:6px; border:1px solid #ccc;">

                {{-- Email --}}
                <label>Email:</label>
                <input type="email" id="email" required
                    placeholder="Enter your email"
                    style="width:100%; padding:10px; margin-bottom:10px; border-radius:6px; border:1px solid #ccc;">

                {{-- Address --}}
                <label>Address:</label>
                <textarea id="address" required
                    placeholder="Delivery Address"
                    style="width:100%; padding:10px; margin-bottom:10px; border-radius:6px; border:1px solid #ccc;"></textarea>

                {{-- City --}}
                <label>City:</label>
                <input type="text" id="city" required
                    placeholder="City"
                    style="width:100%; padding:10px; margin-bottom:10px; border-radius:6px; border:1px solid #ccc;">

                {{-- State --}}
                <label>State:</label>
                <select id="state" required
                    style="width:100%; padding:10px; margin-bottom:20px; border-radius:6px; border:1px solid #ccc;">
                    <option value="">Select State</option>

                    @foreach($deliveries as $delivery)
                        <option value="{{ $delivery->state }}" data-fee="{{ $delivery->fee }}">
                            {{ $delivery->state }}
                        </option>
                    @endforeach
                </select>

                {{-- Order Summary Box --}}
                <div style="padding:15px; border:1px solid #eee; border-radius:8px; margin-bottom:20px;">
                    <h3>Order Summary</h3>

                    <div style="display:flex; justify-content:space-between; margin:8px 0;">
                        <span>Subtotal:</span>
                        <span id="subtotalDisplay">₦{{ number_format($subtotal) }}</span>
                    </div>

                    <div style="display:flex; justify-content:space-between; margin:8px 0;">
                        <span>Delivery Fee:</span>
                        <span id="deliveryFee">₦0</span>
                    </div>

                    <hr>

                    <div style="display:flex; justify-content:space-between; font-weight:bold; margin-top:10px;">
                        <span>Total:</span>
                        <span id="totalAmount">₦{{ number_format($subtotal) }}</span>
                    </div>
                </div>

                {{-- Paystack Button --}}
                <button type="button" id="paystackBtn"
                    style="width:100%; padding:12px; background: rgb(172,112,148); 
                           color:#fff; font-size:16px; border:none; border-radius:6px; cursor:pointer;">
                    Pay Now
                </button>

            </form>
        </div>

    </div>

    @else
        <p>Your cart is empty.</p>
        <a href="{{ url('/') }}">
            <button style="
                background: rgb(172,112,148);
                color:#fff;
                padding:10px 15px;
                border:none;
                border-radius:6px;
                cursor:pointer;">
                Start Shopping
            </button>
        </a>
    @endif
</div>


{{-- Paystack Script --}}
<script src="https://js.paystack.co/v1/inline.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {

    const subtotal = parseFloat("{{ $subtotal }}".replace(/,/g, "")) || 0;

    const stateEl        = document.getElementById("state");
    const deliveryFeeEl  = document.getElementById("deliveryFee");
    const totalAmountEl  = document.getElementById("totalAmount");
    const amountInput    = document.getElementById("amount");
    const payBtn         = document.getElementById("paystackBtn");


    /** Update total when a state is selected */
    function updateTotal() {
        const selectedOption = stateEl.options[stateEl.selectedIndex];
        const fee = parseFloat(selectedOption.dataset.fee) || 0;

        deliveryFeeEl.innerText = "₦" + fee.toLocaleString();
        const total = subtotal + fee;

        totalAmountEl.innerText = "₦" + total.toLocaleString();
        amountInput.value = total;
    }

    updateTotal();
    stateEl.addEventListener("change", updateTotal);


    /** Handle Paystack Payment */
    payBtn.addEventListener("click", function(e) {
        e.preventDefault();

        // Collect inputs
        const name    = document.getElementById("fullName").value.trim();
        const phone   = document.getElementById("phone").value.trim();
        const email   = document.getElementById("email").value.trim();
        const address = document.getElementById("address").value.trim();
        const city    = document.getElementById("city").value.trim();
        const state   = stateEl.value;
        const amount  = parseFloat(amountInput.value);

        if (!name || !phone || !email || !address || !city || !state) {
            alert("Please fill all delivery details");
            return;
        }

        const selectedOption = stateEl.options[stateEl.selectedIndex];
        const delivery_fee = parseFloat(selectedOption.dataset.fee) || 0;

        // Initialize transaction
        fetch("{{ route('pay.initialize') }}", {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                name, email, phone, address, city, state, amount, delivery_fee
            })
        })
        .then(res => res.json())
        .then(data => {

            if (!data.status) {
                alert("Payment initialization failed");
                return;
            }

            const handler = PaystackPop.setup({
                key: "{{ env('PAYSTACK_PUBLIC_KEY') }}",
                email: email,
                amount: Math.round(amount * 100),
                currency: "NGN",
                ref: data.reference,

                callback: function(response) {
                    fetch("{{ route('pay.verify') }}", {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ reference: response.reference })
                    })
                    .then(res => res.json())
                    .then(v => {
                        if (v.status) {
                            window.location.href = v.redirect;
                        } else {
                            alert("Payment verification failed");
                        }
                    });
                },

                onClose: function() {
                    alert("Payment window closed");
                }
            });

            handler.openIframe();
        });

    });

});
</script>

@endsection
