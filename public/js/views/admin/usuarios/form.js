/**
 * Created by developer on 12-03-2015.
 */
$(document).ready(function () {
    $('#add-new-rol').click(function () {
        var parent = $('#layout-row').parent();
        var row = $('#layout-row').clone();
        row.show();
        row.removeAttr('id');
        parent.append('<tr>' + row.html() + '</tr>');
    });

    $(document).on('click', '.delete-rol', function () {
        $(this).closest('tr').remove();
    });
});