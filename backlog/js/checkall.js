$('#selectall').click (function () {
    var checkedStatus = this.checked;
    $('.table tbody tr').find(':checkbox').each(function () {
        $(this).prop('checked', checkedStatus);
    });
});