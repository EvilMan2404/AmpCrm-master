$(document).ready(() => {
    $(function () {
        // Multiple images preview in browser
        var imagesPreview = function (input, placeToInsertImagePreview) {

            if (input.files) {
                var filesAmount = input.files.length;

                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();

                    reader.onload = function (event) {
                        $($.parseHTML('<img>')).attr('src', event.target.result).attr('class', 'img-fluid').appendTo(placeToInsertImagePreview);
                    }

                    reader.readAsDataURL(input.files[i]);
                }
            }

        };

        $('#gallery-photo-add').on('change', function () {
            $('label.label img').remove();
            $('.material-icons').hide();
            $('span.title').hide();
            imagesPreview(this, 'label.label');
        });
    });


    let $billing_country = $('#country'), $shipping_country = $('#country-shipping'),
        $shipping_address_city = $('#shipping_address_city'),
        $billing_address_city = $('#billing_address_city'),
        $assigned_user_id = $('#assigned_user_id'),
        $c_type = $('#c_type'),
        $industry = $('#industry'),
        $searchName = $('#searchName'),
        $searchPhone = $('#searchPhone'),
        $group_id = $('#group_id'),
        token = $('meta[name="csrf-token"]').attr('content')


    $searchName.select2({
        ajax: {
            url: $searchName.data('url'),
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-Token': token
            },
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
        },
        placeholder: $searchName.data('placeholder'),
        language: {
            // You can find all of the options in the language files provided in the
            // build. They all must be functions that return the string that should be
            // displayed.
            inputTooShort: function () {
                return $searchName.data('start');
            },
            searching: function () {
                return $searchName.data('searching');
            },
            noResults: function () {
                return $searchName.data('noResults');
            },
        }
    });
    $searchName.change(() => {
        $('#form').submit();
    })

    $searchPhone.select2({
        ajax: {
            url: $searchPhone.data('url'),
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-Token': token
            },
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
        },
        placeholder: $searchPhone.data('placeholder'),
        language: {
            // You can find all of the options in the language files provided in the
            // build. They all must be functions that return the string that should be
            // displayed.
            inputTooShort: function () {
                return $searchPhone.data('start');
            },
            searching: function () {
                return $searchPhone.data('searching');
            },
            noResults: function () {
                return $searchPhone.data('noResults');
            },
        }
    });
    $searchPhone.change(() => {
        $('#form').submit();
    })

    /*  $billing_country.on('change', initializeSelect2);
      $shipping_country.on('change', initializeSelect2Shipping);*/
    $group_id.select2();
    $industry.select2();
    $c_type.select2();
    $assigned_user_id.select2({
        ajax: {
            url: $assigned_user_id.data('url'),
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-Token': token
            },
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
        },
        placeholder: $assigned_user_id.data('placeholder'),
        language: {
            // You can find all of the options in the language files provided in the
            // build. They all must be functions that return the string that should be
            // displayed.
            inputTooShort: function () {
                return $assigned_user_id.data('start');
            },
            searching: function () {
                return $assigned_user_id.data('searching');
            },
            noResults: function () {
                return $assigned_user_id.data('noResults');
            },
        },
        minimumInputLength: 1,
    });
    $billing_country.select2({
        "placeholder": $billing_country.data('placeholder'),
        "width": '100%'
    });
    $shipping_country.select2({
        "placeholder": $billing_country.data('placeholder'),
        "width": '100%'
    });
    initializeSelectBillingCities()
    $billing_country.change(() => {
        $billing_address_city.val(null);
        $billing_address_city.data("placeholder", $billing_address_city.data('searching'));
        initializeSelectBillingCities()
    });

    initializeSelectShippingCities()
    $shipping_country.change(() => {
        $shipping_address_city.val(null);
        $shipping_address_city.data("placeholder", $shipping_address_city.data('searching'));
        initializeSelectShippingCities()
    });

    function initializeSelectShippingCities() {
        let value = $shipping_country.children("option:selected").val();
        $shipping_address_city.select2({
            ajax: {
                url: $shipping_address_city.data('url'),
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-Token': token
                },
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        country: value
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
            },
            placeholder: $shipping_address_city.data('searching'),
            language: {
                // You can find all of the options in the language files provided in the
                // build. They all must be functions that return the string that should be
                // displayed.
                inputTooShort: function () {
                    return $shipping_address_city.data('start');
                },
                searching: function () {
                    return $shipping_address_city.data('searching');
                },
                noResults: function () {
                    return $shipping_address_city.data('noResults');
                },
            },
            minimumInputLength: 1,
        });
    }

    function isNumeric(value) {
        return /^-?\d+$/.test(value);
    }

    function initializeSelectBillingCities() {
        let value = $billing_country.children("option:selected").val();
        $billing_address_city.select2({
            ajax: {
                url: $billing_address_city.data('url'),
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-Token': token
                },
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        country: value
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
            },
            placeholder: $billing_address_city.data('searching'),
            language: {
                // You can find all of the options in the language files provided in the
                // build. They all must be functions that return the string that should be
                // displayed.
                inputTooShort: function () {
                    return $billing_address_city.data('start');
                },
                searching: function () {
                    return $billing_address_city.data('searching');
                },
                noResults: function () {
                    return $billing_address_city.data('noResults');
                },
            },
            minimumInputLength: 1,
        });
    }

})

