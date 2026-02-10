<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Bag</title>

<link rel="stylesheet" href="{{ asset('project/css/bag.css') }}">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">

<style>
body {
    font-family: 'Arial', sans-serif;
    background: #f5f5f5;
    margin:0;
    padding: 0;
}
.container {
    max-width: 900px;
    margin: 50px auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
}
@media(max-width:600px){
    .container {
        margin-left: 5px;
        margin-right: 5px;
        
    }

}
h1 { text-align: center; margin-bottom: 20px; color: rgb(172,112,148); }
.cart-item {
    display: flex;
    gap: 15px;
    align-items: center;
    border-bottom: 1px solid #ddd;
    padding: 15px 0;
}
.cart-item img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 10px;
}
.item-details { flex: 1; }
.item-details h3 { margin: 0 0 5px 0; }
.item-details p { margin: 3px 0; color: #555; }
.qty-box { display: flex; align-items: center; gap: 5px; }
.qty-box input {
    width: 50px;
    padding: 5px;
    text-align: center;
}
.remove-btn {
    background: #ff4d4d;
    border: none;
    color: #fff;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
}
.cart-summary button {
    background: rgb(172,112,148);
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}
.item-total { font-weight: bold; margin-top: 5px; }
</style>
</head>
<body>

<div class="container">
    <h1>Your Bag</h1>

    @if(count($cart) == 0)
        <div class="my">
            <p>YOU DON'T HAVE ANYTHING IN YOUR BAG YET</p>
            <div class="but">
                <a href="{{ url('/') }}">
                    <button>START SHOPPING</button>
                </a>
            </div>
        </div>
    @else
        @foreach($cart as $item)
        <div class="cart-item" data-id="{{ $item->id }}">
            
            <img src="{{ asset('uploads/dress_pic/'.$item->product_image) }}" alt="Dress Image">

            <div class="item-details">
                <h3>{{ $item->product_name }}</h3>
                <p><b>Price:</b> ₦{{ number_format($item->price) }}</p>
                <p><b>Color:</b> {{ $item->color }}</p>
                <p><b>Size:</b> {{ $item->size }}</p>
                <p class="item-total"><b>Total:</b> ₦{{ number_format($item->price * $item->quantity) }}</p>
            </div>

            <div class="qty-box">
                <input type="number"
                       value="{{ $item->quantity }}"
                       min="1"
                       class="cartQty"
                       data-id="{{ $item->id }}">
            </div>

            <button class="remove-btn" data-id="{{ $item->id }}">
                <i class="ri-delete-bin-line"></i>
            </button>

        </div>
        @endforeach

        <div class="cart-summary" style="margin-top: 20px; text-align: right;">
            <h3>Subtotal: ₦<span id="cartSubtotal">{{ number_format($cart->sum(fn($i)=>$i->price*$i->quantity)) }}</span></h3>
            <br>
            <a href="{{ route('checkout') }}">
                <button>Proceed to Checkout</button>
            </a>
        </div>
    @endif
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {

    // ------------------------------
    // UPDATE QUANTITY
    // ------------------------------
    $(".cartQty").on("change", function () {
        let cart_id = $(this).data("id");
        let newQty = $(this).val();
        let row = $(this).closest(".cart-item");

        $.ajax({
            url: "{{ route('cart.updateQuantity') }}",
            method: "POST",
            data: {
                cart_id: cart_id,
                quantity: newQty,
                _token: "{{ csrf_token() }}"
            },
            success: function(response){
                if(!response.status){
                    Swal.fire({
                        icon: "warning",
                        title: "Limited Stock",
                        text: response.message,
                        confirmButtonColor: "rgb(172,112,148)"
                    });
                    return;
                }

                // Update item total
                row.find(".item-total").html(`<b>Total:</b> ₦${(response.itemTotal).toLocaleString()}`);

                // Update subtotal
                $("#cartSubtotal").text(response.subtotal.toLocaleString());

                Swal.fire({
                    icon: "success",
                    title: "Updated!",
                    text: response.message,
                    timer: 1500,
                    confirmButtonColor: "rgb(172,112,148)"
                });
            },
            error: function(){
                Swal.fire("Error", "Something went wrong", "error");
            }
        });
    });

    // ------------------------------
    // REMOVE ITEM
    // ------------------------------
    $(".remove-btn").on("click", function () {
        let cart_id = $(this).data("id");
        let row = $(this).closest(".cart-item");

        Swal.fire({
            title: "Remove Item?",
            text: "Do you want to delete this item?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, remove",
            confirmButtonColor: "rgb(172,112,148)"
        }).then((result) => {
            if(!result.isConfirmed) return;

            $.ajax({
                url: "{{ route('cart.remove') }}",
                method: "POST",
                data: {
                    cart_id: cart_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response){
                    if(response.status){
                        row.remove();
                        Swal.fire({
                            icon: "success",
                            title: "Item removed successfully!",
                            timer: 1500,
                            confirmButtonColor: "rgb(172,112,148)"
                        });

                        // Update subtotal
                        let subtotal = 0;
                        $(".cart-item").each(function(){
                            let qty = parseInt($(this).find(".cartQty").val());
                            let price = parseFloat($(this).find(".item-details p:first").text().replace(/[^0-9]/g, ''));
                            subtotal += qty * price;
                        });
                        $("#cartSubtotal").text(subtotal.toLocaleString());
                    } else {
                        Swal.fire("Error", response.message, "error");
                    }
                },
                error: function(){
                    Swal.fire("Error", "Failed to remove item", "error");
                }
            });
        });
    });

});
</script>

</body>
</html>
