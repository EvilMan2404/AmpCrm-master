$(document).ready(() => {
    $('#form').parsley();
    let token = $('meta[name="csrf-token"]').attr('content')

    $('#buttonSave').click(() => {
        $('#form').submit();
    })

})

