$(document).ready(() => {
    let $search = $('#search_for_catalog'), $lots = $('#lots'), token = $('meta[name="csrf-token"]').attr('content'),
        $searchBrand = $('#search_brand_id'),
        $searchCatalogs = $('#id_catalog'),
        $showModal = $('#show_modal'),
        cart = []

    if ($showModal.data('value') === true) {
        $('#course-settings').modal('show')
    }

    function loadCart() {
        let localCart = JSON.parse(localStorage.getItem('cart'))
        if (localCart !== null && localCart.length > 0) {
            cart = localCart
        }
        $.each(cart, (k, v) => {
            $('#check-' + v).prop('checked', true);
        })
    }

    loadCart();


    $('.cart-check').on('change', function (e) {
        let $this = $(this), id = parseInt($this.data('id'))
        if ($this.is(":checked") && id > 0 && cart.indexOf(id) === -1) {
            cart.push(id)
        } else {
            let index = cart.indexOf(id);
            if (index !== -1) {
                cart.splice(index, 1)
            }
        }
        console.log(cart)
        localStorage.setItem('cart', JSON.stringify(cart))
    })
    $('.cart-save').on('click', function (e) {
        e.preventDefault()
        let $this = $(this), url = $this.data('url')
        localStorage.setItem('cart', null)
        window.document.location.href = url + '?categories_id=' + cart.join(',') + '&lot_id=' + $lots.val()
    })
//----------------------------------//
    $('[data-toggle="select2"]').select2({
        "width": '100%'
    });

    $lots.select2(
        {
            ajax: {
                url: $lots.data('url'),
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
            placeholder: $lots.data('placeholder'),
            language: {
                // You can find all of the options in the language files provided in the
                // build. They all must be functions that return the string that should be
                // displayed.
                inputTooShort: function () {
                    return $lots.data('start');
                },
                searching: function () {
                    return $lots.data('searching');
                },
                noResults: function () {
                    return $lots.data('noResults');
                },
            }
        });

    $searchCatalogs.select2(
        {
            ajax: {
                url: $searchCatalogs.data('url'),
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
            placeholder: $searchCatalogs.data('placeholder'),
            language: {
                // You can find all of the options in the language files provided in the
                // build. They all must be functions that return the string that should be
                // displayed.
                inputTooShort: function () {
                    return $searchCatalogs.data('start');
                },
                searching: function () {
                    return $searchCatalogs.data('searching');
                },
                noResults: function () {
                    return $searchCatalogs.data('noResults');
                },
            }
        });
    $search.select2({
        "ajax": {
            url: $search.data('url'),
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
        "placeholder": $search.data('placeholder'),
        "width": '100%',
        'language': {
            // You can find all of the options in the language files provided in the
            // build. They all must be functions that return the string that should be
            // displayed.
            inputTooShort: function () {
                return $search.data('start');
            },
            searching: function () {
                return $search.data('searching');
            },
            noResults: function () {
                return $search.data('noResults');
            },
        }
    });


    $search.on('change', (e) => {
        $('#form').submit()
    })
    $searchCatalogs.on('change', (e) => {
        $('#form-global').submit()
    })
    $searchBrand.on('change', (e) => {
        $('#form').submit()
    })
    $lots.on('change', (e) => {
        $('#form').submit()
    })

    $('#buttonSubmit').click(() => {
        $('#form').submit()
    })

    $('#form,#course-form').parsley();


    $(function () {
        $('#form,#course-form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
            $('.alert-info').toggleClass('d-none', !ok);
            $('.alert-warning').toggleClass('d-none', ok);
        })
    });
});
var drEvent = $('.dropify').dropify({
    tpl: {
        wrap: '<div class="dropify-wrapper"></div>',
        loader: '<div class="dropify-loader"></div>',
        message: '<div class="dropify-message"><span class="file-icon" /> <p>{{ default }}</p></div>',
        preview: '<div class="dropify-preview"><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"><p class="dropify-infos-message"></p></div></div></div>',
        filename: '<p class="dropify-filename"><span class="file-icon"></span> <span class="dropify-filename-inner"></span></p>',
        clearButton: '<button type="button" class="dropify-clear">{{ remove }}</button>',
        errorLine: '<p class="dropify-error">{{ error }}</p>',
        errorsContainer: '<div class="dropify-errors-container"><ul></ul></div>'
    }
});

drEvent.on('dropify.afterClear', function (event, element) {
    $.ajax({
        'url': '/catalog/removeImage/' + element.settings.objId + '/' + element.settings.dropifyId,
        'method': 'POST',
        'success': () => {
            let $form = $('#listImages'), val = $form.val(), list = [], newList = []

            if (val !== '') {
                list = val.split(',')
            }

            $.each(list, (k, v) => {

                if (element.settings.dropifyId !== parseInt(v)) {
                    newList.push(v);
                }
            })
            $form.val(newList.join(','))

            $('[data-dropify-id=' + element.settings.dropifyId + ']').parent().remove();
        }
    })
});
Dropzone.options.myAwesomeDropzone =
    {
        maxFilesize: 10,
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        // addRemoveLinks: true,
        timeout: 60000,
        sending: function (file, xhr, formData) {
            formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
        },
        success: function (file, response) {
            let $image = $('#listImages'), v = $image.val(), val = []

            if (v !== '') {
                val = v.split(',')
            }
            if (response.status) {
                val.push(response.id)
            } else {
                alert(response.error)
            }

            $image.val(val.join(','))
        },

        error: function (file, response) {
            alert('Error load file');
        }
    };