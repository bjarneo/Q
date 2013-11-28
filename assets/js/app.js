(function () {
    // Set active menu
    var menu = jQuery('.nav.nav-pills li a'),
        menuLen = menu.length,
        current = window.location.href;
    while(menuLen--) {
        if(menu[menuLen] == current) {
            jQuery(menu[menuLen]).parent('li').addClass('active');
        } else {
            jQuery(menu[menuLen]).parent('li').removeClass('active');
        }
    }
}) ();