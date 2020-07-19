
$(document).ready(function() {

    $('.add-to-cart').on('click', function (e) {
        e.preventDefault();

        var product_type = $(this).attr('product-type');
        var product_id = $(this).attr('product-id');
        var product_slug = $(this).attr('product-slug');

        if (product_type == 'configurable') {
            alert('configurable')
        } else {
            $.ajax({
                type: 'POST',
                url: '/product/add/cart',
                data:{
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    product_id: product_id,
                    qty: 1
                },
                success: function (response) {
                    // console.log(response);
                    location.reload(true);
                }
            });
        }
    });

    $('.increase-item, .decrease-item').on('click', function (e) {
        e.preventDefault();

        var id = $(this).attr('data-id');
        var qty = $(this).attr('data-qty');
        $.ajax({
            type: "POST",
            url: "/cart/item/update",
            data:{
                _token: $('meta[name="csrf-token"]').attr('content'),
                id,
                qty,
            },
            success: function (response) {
                // console.log(response);
                location.reload(true);
            }
        });
    });

    // ============ Set Shipping Cost ================
    $('#shipping-cost-option').on('change', function (e) {
        var shipping_service = e.target.value;

        $.ajax({
            type: 'POST',
            url: '/orders/set-shipping',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                city_id: "1",
                shipping_service: shipping_service
            },
            success: function (response) {
                $('.total-amount').html(response.data.total);
            }
        });
    });

});

