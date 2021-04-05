$(document).ready(() => {
    $('#form').parsley();
    let
        $user_id = $('#user_id'),
        $searchName = $('#searchName'),
        $searchDate = $('#searchDate'),
        $searchOwner = $('#searchOwner'),
        $purchases = $('#purchases'),
        $owner = $('#owner input[type="radio"]'),
        $valueOwner = $('#owner input[type="radio"]:checked'),
        purchases = '',
        token = $('meta[name="csrf-token"]').attr('content')


    $user_id.select2({
        ajax: {
            url: $valueOwner.data('route'),
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
        placeholder: $owner.data('placeholder'),
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
        },
    });

    $('#owner input[type=radio]').change(function () {
        $user_id.val(null);
        $user_id.find('option').remove();
        $user_id.select2({
            ajax: {
                url: $(this).data('route'),
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
            },
        });
    });

    $purchases.select2({
        ajax: {
            url: $purchases.data('url'),
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
        placeholder: $purchases.data('placeholder'),
        language: {
            // You can find all of the options in the language files provided in the
            // build. They all must be functions that return the string that should be
            // displayed.
            inputTooShort: function () {
                return $purchases.data('start');
            },
            searching: function () {
                return $purchases.data('searching');
            },
            noResults: function () {
                return $purchases.data('noResults');
            },
        },
    });

    $searchDate.select2({
        ajax: {
            url: $searchDate.data('url'),
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
        placeholder: $searchDate.data('placeholder'),
        language: {
            // You can find all of the options in the language files provided in the
            // build. They all must be functions that return the string that should be
            // displayed.
            inputTooShort: function () {
                return $searchDate.data('start');
            },
            searching: function () {
                return $searchDate.data('searching');
            },
            noResults: function () {
                return $searchDate.data('noResults');
            },
        },
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
        },
    });
    $searchName.change(() => {
        $('#form').submit();
    })
    $searchOwner.select2({
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
        },
    });
    $searchOwner.change(() => {
        $('#form').submit();
    })
    $searchDate.change(() => {
        $('#form').submit();
    })

    $purchases.on('change', () => {

        $.ajax({
            'url': $purchases.data('info'),
            'method': 'POST',
            'data': {"purchases": $purchases.val()},
            'dataType': 'json',
            'success': (data) => {
                purchases = data
                updateForm().then(() => {
                    $('.ceramic-input').trigger("change");
                })
            }
        })
    })
    $('body').on('change','.ceramic-input', updateDiff)

    function updateDiff() {
        let $this = $(this),
            $type = $this.data('m'),
            $value = parseFloat($this.val()),
            $allowed = ['pt', 'pd', 'rh'],
            $result = 0


        if ($allowed.indexOf($type) !== -1) {
            let $subject = 0,
                $target = $('#' + $type + '_diff'),
                $purch = $('#' + $type + '_purchase')
            $subject = getTotalInput('ceramic-input', $type);
            $result = $subject - parseFloat($purch.val())
            $target.val($result.toFixed(3))
        }
    }

    function getTotalInput($class, $type) {
        let $get = $('.' + $class + '[data-m="' + $type + '"]'),
            $total = 0;
        $.each($get, (k, v) => {
            let input = $(v);
            $total += parseFloat(input.val());
        });
        console.log($total);
        return $total;
    }

    function updateForm() {
        return new Promise((resolve) => {
            let pt_purchase = 0,
                pd_purchase = 0,
                rh_purchase = 0,
                weight_purchase = 0,
                catalyst_purchase = 0,
                pt_rate = 0,
                pd_rate = 0,
                rh_rate = 0,
                i = 0,
                $tablePurchase = $('#purchase-body')
            $tablePurchase.find('tr').not('.table-info').remove();
            $.each(purchases, (k, v) => {
                if (k !== 'error') {
                    pt_purchase += parseFloat(v.pt) * parseFloat(v.count);
                    pd_purchase += parseFloat(v.pd) * parseFloat(v.count);
                    rh_purchase += parseFloat(v.rh) * parseFloat(v.count);
                    weight_purchase += parseFloat(v.weight) * parseFloat(v.count);
                    catalyst_purchase += parseInt(v.count);


                    /* Purchase table */
                    let $newLine = ' <tr data-id="' + v.id + '">\n' +
                        '                                                <th scope="row">' + v.id + '</th>\n' +
                        '                                                <td>' + v.name + '</td>\n' +
                        '                                                <td>' + v.ownerName + '</td>\n' +
                        '                                                <td>' + v.pt + '</td>\n' +
                        '                                                <td>' + v.pd + '</td>\n' +
                        '                                                <td>' + v.rh + '</td>\n' +
                        '                                                <td>' + v.lot.pt_rate + '</td>\n' +
                        '                                                <td>' + v.lot.pd_rate + '</td>\n' +
                        '                                                <td>' + v.lot.rh_rate + '</td>\n' +
                        '                                                <td>' + v.total + ' € </td>\n' +
                        '                                            </tr>';

                    $tablePurchase.append($newLine);

                    pt_rate = parseFloat(pt_rate) + parseFloat(v.lot.pt_rate)
                    pd_rate = parseFloat(pd_rate) + parseFloat(v.lot.pd_rate)
                    rh_rate = parseFloat(rh_rate) + parseFloat(v.lot.rh_rate)
                    /* Purchase table end */
                    i++;
                }
            })
            if (i !== 0) {
                pt_rate /= i
                pd_rate /= i
                rh_rate /= i
            }
            $tablePurchase.find('.table-info').appendTo($tablePurchase);
            $('#pt-rate').text(pt_rate)
            $('#pd-rate').text(pd_rate)
            $('#rh-rate').text(rh_rate)

            if (isNaN(weight_purchase) || weight_purchase < 0) {
                weight_purchase = 0
            }
            if (isNaN(catalyst_purchase) || catalyst_purchase < 0) {
                catalyst_purchase = 0
            }
            if (isNaN(pt_purchase) || pt_purchase < 0) {
                pt_purchase = 0
            }
            if (isNaN(pd_purchase) || pd_purchase < 0) {
                pd_purchase = 0
            }
            if (isNaN(rh_purchase) || rh_purchase < 0) {
                rh_purchase = 0
            }
            $('#ceramic').val(weight_purchase ?? 0);
            $('#catalyst').val(catalyst_purchase ?? 0);
            $('#pt_purchase').val(pt_purchase ?? 0);
            $('#pd_purchase').val(pd_purchase ?? 0);
            $('#rh_purchase').val(rh_purchase ?? 0);

            resolve(true);
        })
    }


    let $tableCeramic = $('#ceramic-body'),
        $tableDust = $('#dust-body')

    function addNewAnalysis() {
        let i = $tableCeramic.find('tr').length
        if ($tableCeramic.find('tr[data-id=' + i + ']').length) {
            i += 1;
        }
        let $newLine = ' <tr data-id="' + i + '">\n' +
            '                                                <th scope="row"><button type="button" id="deleteRow" class="btn btn-primary deleteRow" data-row="' + i + '">X</button></th>\n' +
            '                                                <td><input class="form-control ceramic-input" data-parsley-type="number" data-type="ceramic" data-m="pt" type="text" name="ceramic_analysis[' + i + '][pt]"></td>\n' +
            '                                                <td><input class="form-control ceramic-input" data-parsley-type="number" data-type="ceramic" data-m="pd" type="text" name="ceramic_analysis[' + i + '][pd]"></td>\n' +
            '                                                <td><input class="form-control ceramic-input" data-parsley-type="number" data-type="ceramic" data-m="rh" type="text" name="ceramic_analysis[' + i + '][rh]"></td>\n' +
            '                                            </tr>';

        $tableCeramic.append($newLine);
        $tableCeramic.find('.table-info').appendTo($tableCeramic);


        let $newLineNew = ' <tr data-id="' + i + '">\n' +
            '                                                <th scope="row"><button type="button" id="deleteRow" class="btn btn-primary deleteRow" data-row="' + i + '">X</button></th>\n' +
            '                                                <td><input data-type="dust" data-m="pt" data-parsley-type="number" class="form-control dust-input" type="text" name="dust_analysis[' + i + '][pt]"></td>\n' +
            '                                                <td><input data-type="dust" data-m="pd" data-parsley-type="number" class="form-control dust-input" type="text" name="dust_analysis[' + i + '][pd]"></td>\n' +
            '                                                <td><input data-type="dust"  data-m="rh" data-parsley-type="number" class="form-control dust-input" type="text" name="dust_analysis[' + i + '][rh]"></td>\n' +
            '                                            </tr>';

        $tableDust.append($newLineNew);
        $tableDust.find('.table-info').appendTo($tableDust);
    }

    $('#addNewAnalysis').on('click', function () {
        addNewAnalysis()
    })
    $('body').on('click', '.deleteRow', function () {
        $tableCeramic.find('tr[data-id="' + $(this).data('row') + '"]').remove();
        $tableDust.find('tr[data-id="' + $(this).data('row') + '"]').remove();
        $('.total_calc').text(0);
        $('.dust-input,.ceramic-input').trigger('change');
    });

    $('body').on('change', '.dust-input,.ceramic-input', function () {
        let $this = $(this),
            $type = $this.data('type')
        if ($type === 'dust') {
            let $m = $this.data('m'),
                $s = 0,
                $i = 0
            $.each($tableDust.find('tr').not('.table-info'), (k, v) => {
                let value = $(v).data('id'),
                    $new = $('input[name="dust_analysis[' + value + '][' + $m + ']"]').val()
                if (typeof $new === 'undefined') {
                    $new = 0
                }
                $s += parseFloat($new);
                $i++;
            });
            $s /= $i
            $s = parseFloat($s).toFixed(3);
            $('#dust-' + $m + '-rate').text($s)
        } else {
            let $m = $this.data('m'),
                $s = 0,
                $i = 0
            $.each($tableCeramic.find('tr').not('.table-info'), (k, v) => {
                let value = $(v).data('id'),
                    $new = $('input[name="ceramic_analysis[' + value + '][' + $m + ']"]').val()
                if (typeof $new === 'undefined') {
                    $new = 0
                }
                $s += parseFloat($new);
                $i++;
            });
            $s /= $i
            $s = parseFloat($s).toFixed(3);
            $('#ceramic-' + $m + '-rate').text($s)
        }
    });

    $('.dust-input,.ceramic-input').trigger('change');
    $purchases.trigger('change');
})

