<?php

/* Меняем картинку логотипа WP в админке */
function my_admin_logo() {
    echo '<style type="text/css">#header-logo { background:url('.get_bloginfo('template_directory').'/core/images/general/favicon.ico) no-repeat 0 0 !important; }</style>';
}
add_action('admin_head', 'my_admin_logo');