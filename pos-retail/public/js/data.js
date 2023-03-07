$('select[name=date_start]').on('change', function () {
    date_start = $('select[name=date_start]').val();
    console.log(date_start);

    if (date_start == 'reset') {
        controller.table.ajax.url(apiUrl).load();
    } else {
        controller.table.ajax.url(apiUrl + '?date_start=' + date_start).load();
    }
});
