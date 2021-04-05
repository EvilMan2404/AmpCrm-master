$(document).ready(() => {
    let token = $('meta[name="csrf-token"]').attr('content'),
        $searchName = $('#searchName'),
        $searchCompany = $('#searchCompany'),
        $searchOwner = $('#searchOwner'),
        $searchAssigned = $('#searchAssigned')

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
    $searchOwner.select2(
        {
            ajax: {
                url: $searchOwner.data('url'),
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
            placeholder: $searchOwner.data('placeholder'),
            language: {
                // You can find all of the options in the language files provided in the
                // build. They all must be functions that return the string that should be
                // displayed.
                inputTooShort: function () {
                    return $searchOwner.data('start');
                },
                searching: function () {
                    return $searchOwner.data('searching');
                },
                noResults: function () {
                    return $searchOwner.data('noResults');
                },
            }
        });
    $searchAssigned.select2(
        {
            ajax: {
                url: $searchAssigned.data('url'),
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
            placeholder: $searchAssigned.data('placeholder'),
            language: {
                // You can find all of the options in the language files provided in the
                // build. They all must be functions that return the string that should be
                // displayed.
                inputTooShort: function () {
                    return $searchAssigned.data('start');
                },
                searching: function () {
                    return $searchAssigned.data('searching');
                },
                noResults: function () {
                    return $searchAssigned.data('noResults');
                },
            }
        });
    $searchCompany.select2(
        {
            ajax: {
                url: $searchCompany.data('url'),
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
            placeholder: $searchCompany.data('placeholder'),
            language: {
                // You can find all of the options in the language files provided in the
                // build. They all must be functions that return the string that should be
                // displayed.
                inputTooShort: function () {
                    return $searchCompany.data('start');
                },
                searching: function () {
                    return $searchCompany.data('searching');
                },
                noResults: function () {
                    return $searchCompany.data('noResults');
                },
            }
        });
    $searchName.on('change', (e) => {
        $('#form').submit()
    })
    $searchCompany.on('change', (e) => {
        $('#form').submit()
    })
    $searchOwner.on('change', (e) => {
        $('#form').submit()
    })
    $searchAssigned.on('change', (e) => {
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