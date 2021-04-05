$(document).ready(() => {
    let $user_id = $('#user_id'),
        token = $('meta[name="csrf-token"]').attr('content')

    $user_id.select2({
        ajax: {
            url: $user_id.data('url'),
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
        placeholder: $user_id.data('placeholder'),
        language: {
            // You can find all of the options in the language files provided in the
            // build. They all must be functions that return the string that should be
            // displayed.
            inputTooShort: function () {
                return $user_id.data('start');
            },
            searching: function () {
                return $user_id.data('searching');
            },
            noResults: function () {
                return $user_id.data('noResults');
            },
        }
    });


    $('#form').parsley();
    $('#buttonSubmit').click(() => {
        $('#form').submit();
    })
})

