<?php
// Adding Translation Option
load_theme_textdomain( 'msk-projector', get_template_directory() .'/lang' );
$locale = get_locale();
$locale_file = get_template_directory() ."/lang/$locale.php";
if ( is_readable($locale_file) ) require_once($locale_file);

require_once locate_template('/library/projector.php');
require_once locate_template('/library/inc/redux/framework.php');
require_once locate_template('/library/inc/cuztom/cuztom.php');
require_once locate_template('/library/custom-post-type.php');
require_once locate_template('/library/admin.php');
require_once locate_template('/library/options.php');