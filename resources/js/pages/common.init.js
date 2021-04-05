$(document).ready(() => {
    let $searchName = $('#searchName'),
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

    if ($('#formCrud').length) {
        $('#formCrud').parsley();
    }
})

