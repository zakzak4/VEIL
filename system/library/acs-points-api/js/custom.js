function initAcs() {
    postcodeSearch(
        jQuery("#input-shipping-postcode").val() ?? jQuery("#input-payment-postcode").val(),
        (jQuery("#input-shipping-address-1").val() ?? jQuery("#input-payment-address-1").val()) + ',' + (jQuery('#input-shipping-city').val() ?? jQuery('#input-payment-city').val())
    );
}

window.addEventListener("click", function (event) {
    if (event.target.getAttribute("name") == 'shipping_method') {
        if (event.target.value == "acspoint.acspoint") {
            $("#select_point").show();
        } else {
            $("#select_point").hide();
        }
    }
});
$(document).ready(function () {
    if ($('input[name=shipping_method]').val() == "acspoint.acspoint") {
        $("#select_point").show();
    } else {
        $("#select_point").hide();
    }
    $('input[name=shipping_method]').click(function () {
        if (this.value == "acspoint.acspoint") {
            $("#select_point").show();
        } else {
            $("#select_point").hide();
        }
    });
    $('#input-shipping-postcode,#input-payment-postcode').on('change', function () {
        initAcs();
    });
    initAcs();
});

$('input[name="shipping_address"], select[name="country_id"], select[name="zone_id"]').on('change', function () {
    $.ajax({
        url: 'index.php?route=checkout/shipping_method/reload',
        type: 'get',
        dataType: 'json',
        success: function (json) {
            if (json['shipping_method']) {
                $('#shipping-method').html(json['shipping_method']);
            }
        }
    });
});
