$(document).ready(() => {
    let token = $('meta[name="csrf-token"]').attr('content'),
        $wasteTypes = $('#waste_types'),
        $stocks = $('#stocks'),
        $tableStock = $('#stock-body'),
        $dateStart = $('#date_start'),
        $dateFinish = $('#date_finish'),
        $id = $('#id_page'),
        $userId = $('#user_id'),
        $owner = $('#owner'),
        $prevLotSum = $('#previous_info'),
        $searchName = $('#searchName'),
        $tableWaste = $('#wastes-body')
//----------------------------------//
    $owner.change(() => {
        $('#form').submit();
    })
    $searchName.change(() => {
        $('#form').submit();
    })

    $wasteTypes.select2({
        "placeholder": $wasteTypes.data('placeholder'),
        "width": '100%'
    });

    $stocks.select2(
        {
            ajax: {
                url: $stocks.data('url'),
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-Token': token
                },
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        userId: $userId.val(),
                        purchaseReport: true
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
            placeholder: $stocks.data('placeholder'),
            language: {
                // You can find all of the options in the language files provided in the
                // build. They all must be functions that return the string that should be
                // displayed.
                inputTooShort: function () {
                    return $stocks.data('start');
                },
                searching: function () {
                    return $stocks.data('searching');
                },
                noResults: function () {
                    return $stocks.data('noResults');
                },
            }
        });


    $userId.select2(
        {
            ajax: {
                url: $userId.data('url'),
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-Token': token
                },
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        start: $dateStart.val(),
                        finish: $dateFinish.val()
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
            placeholder: $userId.data('placeholder'),
            language: {
                // You can find all of the options in the language files provided in the
                // build. They all must be functions that return the string that should be
                // displayed.
                inputTooShort: function () {
                    return $userId.data('start');
                },
                searching: function () {
                    return $userId.data('searching');
                },
                noResults: function () {
                    return $userId.data('noResults');
                },
            }
        });

    $owner.select2(
        {
            ajax: {
                url: $owner.data('url'),
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
                    return $owner.data('start');
                },
                searching: function () {
                    return $owner.data('searching');
                },
                noResults: function () {
                    return $owner.data('noResults');
                },
            }
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


    $stocks.change(() => {

        $.ajax({
            'url': $stocks.data('info'),
            'method': 'POST',
            'data': {"stocks": $stocks.val()},
            'dataType': 'json',
            'success': (data) => {
                generateStockTable(data);
                calcTotal();
            }
        })
    })
    $wasteTypes.change(() => {
        $.ajax({
            'url': $wasteTypes.data('info'),
            'method': 'POST',
            'data': {"wastes": $wasteTypes.val(), "id": $id.val()},
            'dataType': 'json',
            'success': (data) => {
                generateWasteTable(data).then(() => {
                    calcWastes();
                    calcTotal();
                });
            }
        })

    })

    function generateStockTable(data) {
        $tableStock.find('tr').not('.table-info').remove();
        let total = 0;
        $.each(data, (k, v) => {
            if (k !== 'error') {
                let prevSum = 0;
                const obj = jQuery.parseJSON($prevLotSum.val());
                let f = false;
                if (typeof obj !== 'undefined') {
                    prevSum = obj[k]
                    if (typeof prevSum !== 'undefined') {
                        prevSum = prevSum.total;
                        if (typeof prevSum !== 'undefined') {
                            if (parseFloat(prevSum) !== parseFloat(v.total)) {
                                f = true;
                            }
                        }
                    }
                }
                let prevText = '';
                if (f) {
                    prevText = ' <span style="color:#ff0000;">(Было ' + prevSum + '€) </span>';
                }
                let $newLine = ' <tr data-id="' + k + '">\n' +
                    '                                                <th scope="row">' + k + '</th>\n' +
                    '                                                <td>' + v.name + '</td>\n' +
                    '                                                <td>' + v.total + ' € ' + prevText + '</td>\n' +
                    '                                            </tr>';
                $tableStock.append($newLine);
                total += parseFloat(v.total);
            }
        })
        $tableStock.find('.table-info').appendTo($tableStock);
        $('#summaryStock').text(total.toFixed(2) + '€')
    }

    function generateWasteTable(data) {
        return new Promise((resolve) => {
            let $tbody = $tableWaste, tCatalogList = [], catalogList = []
            $.each(data, (k, v) => {
                catalogList.push(v.id);
            });
            $.each($tbody.find('tr').not('.table-info'), (k, v) => {
                if (catalogList.indexOf($(v).data('id')) !== -1) {
                    tCatalogList.push(parseInt($(v).data('id')));
                } else {
                    $(v).remove()
                }
            });
            $.each(data, (k, v) => {
                if (k !== 'error') {
                    if (tCatalogList.indexOf(v.id) === -1) {
                        let $newLine = ' <tr data-id="' + v.id + '">\n' +
                            '                                                <td>' + v.name + '</td>\n' +
                            '                                                <td><input type="number" class="form-control sum-wastes" id="' + v.id + '-sum" name="wastes_sum[' + v.id + ']" value="' + parseFloat(v.sum).toFixed(2) + '"></td>\n' +
                            '                                            </tr>';
                        $tableWaste.append($newLine);
                    }
                }
            })
            $tableWaste.find('.table-info').appendTo($tableWaste);
            resolve(true);
        });
    }

    $tableWaste.on('change', '.sum-wastes', calcWastes)
    $tableWaste.on('change', '.sum-wastes', calcTotal)
    $wasteTypes.on('select2:unselect', function () {
        setTimeout(calcWastes, 500)
    });
    $wasteTypes.on('select2:unselect', function () {
        setTimeout(calcTotal, 502)
    });


    function calcWastes() {
        let total = 0;
        $(".sum-wastes").each(function () {
            const input = $(this); // This is the jquery object of the input, do what you will
            total += parseFloat(input.val())
        });
        $('#summaryWastes').text(total.toFixed(2) + '€')
    }

    function calcTotal() {

        let valueWastes = parseFloat($('#summaryWastes').text()), valueLots = parseFloat($('#summaryStock').text())
        let sum = valueWastes + valueLots;

        $('#summaryTotal').val(sum.toFixed(2) + '€');
    }

    $dateFinish.on('change', function () {
        $stocks.val(null).trigger('change');
    })
    $userId.on('change', function () {
        $stocks.val(null).trigger('change');
    })
    $dateStart.on('change', function () {
        $stocks.val(null).trigger('change');
    })
    $('#form').parsley();
    $stocks.trigger('change');
    $wasteTypes.trigger('change')
})

