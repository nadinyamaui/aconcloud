/*   
 Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.5
 Version: 1.8.0
 Author: Sean Ngu
 Website: http://www.seantheme.com/color-admin-v1.8/admin/
 */

var handleBootstrapWizards = function () {
    "use strict";
    $("#wizard").bwizard();
};

var FormWizard = function () {
    "use strict";
    return {
        //main function
        init: function () {
            handleBootstrapWizards();
        }
    };
}();