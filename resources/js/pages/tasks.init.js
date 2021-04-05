$(document).ready(() => {
    let $statuses = $('#status_id'),
        $assigned_user_id = $('#assigned_user_id'),
        $modelTypeList = $('#source'),
        $source_id = $('#source_id'),
        $priority_id = $('#priority_id'),
        $source = $modelTypeList.children("option:selected").val(),
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
    $statuses.select2({
        "placeholder": $statuses.data('placeholder'),
        "width": '100%'
    })
    $priority_id.select2({
        "placeholder": $priority_id.data('placeholder'),
        "width": '100%'
    })
    $modelTypeList.select2({
        "placeholder": $modelTypeList.data('placeholder'),
        "width": '100%'
    });

    initializeSourceId('empty');
    $modelTypeList.change(() => {
        $source_id.val(null);
        $source_id.data("placeholder", $source_id.data('searching'));
        initializeSourceId()
    });
    if ($source !== '') {
        initializeSourceId()
    }

    function initializeSourceId($status = 'withValue') {
        if ($status === 'empty') {
            $source_id.select2({
                "placeholder": $source_id.data('placeholder'),
                "width": '100%'
            })
        } else {
            let $source = $modelTypeList.children("option:selected").val();
            $source_id.select2({
                ajax: {
                    url: $source_id.data('url'),
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-Token': token
                    },
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page,
                            source: $source,
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
                placeholder: $source_id.data('searching'),
                language: {
                    // You can find all of the options in the language files provided in the
                    // build. They all must be functions that return the string that should be
                    // displayed.
                    inputTooShort: function () {
                        return $source_id.data('start');
                    },
                    searching: function () {
                        return $source_id.data('searching');
                    },
                    noResults: function () {
                        return $source_id.data('noResults');
                    },
                }
            });
        }
    }

    $('#buttonSubmit').click(() => {
        $('#form').submit()
    })

    $('#form').parsley();

    $(function () {
        $('#form').parsley().on('field:validated', function () {
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
        'url': '/tasks/removeFile/' + element.settings.objId + '/' + element.settings.dropifyId,
        'method': 'POST',
        'success': () => {
            let $form = $('#listFiles'), val = $form.val(), list = [], newList = []

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
        acceptedFiles: ".jpeg,.jpg,.png,.gif,.docx,.doc",
        // addRemoveLinks: true,
        timeout: 60000,
        sending: function (file, xhr, formData) {
            formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
        },
        success: function (file, response) {
            let $image = $('#listFiles'), v = $image.val(), val = []

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

