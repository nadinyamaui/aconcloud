/*   
 Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.5
 Version: 1.8.0
 Author: Sean Ngu
 Website: http://www.seantheme.com/color-admin-v1.8/admin/
 */

var handleDataTableFixedHeader = function () {
    "use strict";

    if ($('#data-table').length !== 0) {
        var table = $('#data-table').DataTable({
            "lengthMenu": [20, 40, 60]
        });
        new $.fn.dataTable.FixedHeader(table);
    }
};

var TableManageFixedHeader = function () {
    "use strict";
    return {
        //main function
        init: function () {
            handleDataTableFixedHeader();
        }
    };
}();