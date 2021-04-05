$(document).ready(() => {
    let $country = $('#country'),
        $city = $('#city'),
        $team_id = $('#team_id'),
        $space_id = $('#space_id'),
        $searchName = $('#searchName'),
        $searchEmail = $('#searchEmail'),
        $searchPhone = $('#searchPhone'),
        $assigned_user_id = $('#assigned_user_id'),
        $roleId = $('#roleId'),
        token = $('meta[name="csrf-token"]').attr('content')

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
        }
    });

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
    $searchEmail.select2({
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
    $searchEmail.change(() => {
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

    $team_id.select2({
        ajax: {
            url: $team_id.data('url'),
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
        placeholder: $team_id.data('placeholder'),
        language: {
            // You can find all of the options in the language files provided in the
            // build. They all must be functions that return the string that should be
            // displayed.
            inputTooShort: function () {
                return $team_id.data('start');
            },
            searching: function () {
                return $team_id.data('searching');
            },
            noResults: function () {
                return $team_id.data('noResults');
            },
        }
    });

    $space_id.select2({
        ajax: {
            url: $space_id.data('url'),
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
        placeholder: $space_id.data('placeholder'),
        language: {
            // You can find all of the options in the language files provided in the
            // build. They all must be functions that return the string that should be
            // displayed.
            inputTooShort: function () {
                return $space_id.data('start');
            },
            searching: function () {
                return $space_id.data('searching');
            },
            noResults: function () {
                return $space_id.data('noResults');
            },
        }
    });
    $country.select2({
        "placeholder": $country.data('placeholder'),
        "width": '100%'
    });
    $roleId.select2({
        "placeholder": $roleId.data('placeholder'),
        "width": '100%'
    });

    initializeSelectCities()
    $country.change(() => {
        $city.val(null);
        $city.data("placeholder", $city.data('searching'));
        initializeSelectCities()
    });

    function initializeSelectCities() {
        let value = $country.children("option:selected").val();
        $city.select2({
            ajax: {
                url: $city.data('url'),
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
            placeholder: $city.data('searching'),
            language: {
                // You can find all of the options in the language files provided in the
                // build. They all must be functions that return the string that should be
                // displayed.
                inputTooShort: function () {
                    return $city.data('start');
                },
                searching: function () {
                    return $city.data('searching');
                },
                noResults: function () {
                    return $city.data('noResults');
                },
            },
            minimumInputLength: 1,
        });
    }

})

