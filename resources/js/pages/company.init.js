$(document).ready(() => {
    let token = $('meta[name="csrf-token"]').attr('content'),
        $searchName = $('#searchName'),
        $searchPhone = $('#searchPhone'),
        $searchEmail = $('#searchEmail'),
        $searchSite = $('#searchSite'),
        $searchBilling = $('#searchBilling'),
        $searchPayment = $('#searchPayment')

//----------------------------------//
    $('[data-toggle="select2"]').select2({
        "width": '100%'
    });

    $searchName.select2(
        {
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

    $searchPhone.select2(
        {
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

    $searchEmail.select2(
        {
            ajax: {
                url: $searchEmail.data('url'),
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
            placeholder: $searchEmail.data('placeholder'),
            language: {
                // You can find all of the options in the language files provided in the
                // build. They all must be functions that return the string that should be
                // displayed.
                inputTooShort: function () {
                    return $searchEmail.data('start');
                },
                searching: function () {
                    return $searchEmail.data('searching');
                },
                noResults: function () {
                    return $searchEmail.data('noResults');
                },
            }
        });

    $searchSite.select2(
        {
            ajax: {
                url: $searchSite.data('url'),
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
            placeholder: $searchSite.data('placeholder'),
            language: {
                // You can find all of the options in the language files provided in the
                // build. They all must be functions that return the string that should be
                // displayed.
                inputTooShort: function () {
                    return $searchSite.data('start');
                },
                searching: function () {
                    return $searchSite.data('searching');
                },
                noResults: function () {
                    return $searchSite.data('noResults');
                },
            }
        });

    $searchPayment.select2(
        {
            ajax: {
                url: $searchPayment.data('url'),
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
            placeholder: $searchPayment.data('placeholder'),
            language: {
                // You can find all of the options in the language files provided in the
                // build. They all must be functions that return the string that should be
                // displayed.
                inputTooShort: function () {
                    return $searchPayment.data('start');
                },
                searching: function () {
                    return $searchPayment.data('searching');
                },
                noResults: function () {
                    return $searchPayment.data('noResults');
                },
            }
        });


    $searchBilling.select2(
        {
            ajax: {
                url: $searchBilling.data('url'),
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
            placeholder: $searchBilling.data('placeholder'),
            language: {
                // You can find all of the options in the language files provided in the
                // build. They all must be functions that return the string that should be
                // displayed.
                inputTooShort: function () {
                    return $searchBilling.data('start');
                },
                searching: function () {
                    return $searchBilling.data('searching');
                },
                noResults: function () {
                    return $searchBilling.data('noResults');
                },
            }
        });

    $searchName.on('change', (e) => {
        $('#form').submit()
    })
    $searchPhone.on('change', (e) => {
        $('#form').submit()
    })
    $searchEmail.on('change', (e) => {
        $('#form').submit()
    })
    $searchSite.on('change', (e) => {
        $('#form').submit()
    })
    $searchBilling.on('change', (e) => {
        $('#form').submit()
    })
    $searchPayment.on('change', (e) => {
        $('#form').submit()
    })

    /* $('#form').parsley();


     $(function () {
         $('#form').parsley().on('field:validated', function () {
             var ok = $('.parsley-error').length === 0;
             $('.alert-info').toggleClass('d-none', !ok);
             $('.alert-warning').toggleClass('d-none', ok);
         })
     });*/

})