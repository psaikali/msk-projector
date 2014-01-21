<?php
/*
This file handles the admin area and functions.
You can use this file to make changes to the dashboard.
It's turned off by default, but you can call it
via the functions file.
*/

/************* DASHBOARD WIDGETS *****************/

// disable default dashboard widgets
function disable_default_dashboard_widgets() {
	// remove_meta_box('dashboard_right_now', 'dashboard', 'core');    // Right Now Widget
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core'); // Comments Widget
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');  // Incoming Links Widget
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');         // Plugins Widget

	// remove_meta_box('dashboard_quick_press', 'dashboard', 'core');  // Quick Press Widget
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');   // Recent Drafts Widget
	remove_meta_box('dashboard_primary', 'dashboard', 'core');         //
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');       //

	// removing plugin dashboard boxes
	remove_meta_box('yoast_db_widget', 'dashboard', 'normal');         // Yoast's SEO Plugin Widget

}

/*
 * Add custom RSS widget on Dashboard
 */
function msk_rss_dashboard_widget() {
	if (function_exists('fetch_feed')) {
		include_once(ABSPATH . WPINC . '/feed.php');               // include the required file
		$feed = fetch_feed('http://mosaika.fr/feed/rss/');         // specify the source feed
		$limit = $feed->get_item_quantity(7);                      // specify number of items
		$items = $feed->get_items(0, $limit);                      // create an array of items
	}
	if ($limit == 0) echo '<div>' . __('The RSS feed is either empty or unavailable.', 'msk-projector') . '</div>';   // fallback message
	else foreach ($items as $item) { ?>
		<h4><a href="<?php echo $item->get_permalink(); ?>" title="<?php echo mysql2date(__('j F Y @ g:i a', 'msk-projector'), $item->get_date('Y-m-d H:i:s')); ?>" target="_blank"><?php echo $item->get_title(); ?></a></h4>
		<p><?php echo substr($item->get_description(), 0, 250); ?>&hellip;</p>
	<?php }
}

function msk_custom_dashboard_widgets() {
	wp_add_dashboard_widget('msk_rss_dashboard_widget', __('Recently on Mosaika.fr blog', 'msk-projector'), 'msk_rss_dashboard_widget');
}

add_action('admin_menu', 'disable_default_dashboard_widgets');
add_action('wp_dashboard_setup', 'msk_custom_dashboard_widgets');


/*
 * Custom CSS & HTML on login page
 */
function msk_login_css() {
	wp_enqueue_style( 'msk_login_css', get_template_directory_uri() . '/library/css/login.css', false );
}

function msk_login_url() {
	return 'http://mosaika.fr/services/themes-wordpress/projector-feedback-wordpress-theme/?utm_source=wp_admin&utm_medium=projector_login&utm_campaign=wp_projector_login';
}

function msk_login_title() {
	return __('Visit Projector theme website', 'msk-projector');
}

add_action( 'login_enqueue_scripts', 'msk_login_css', 10 );
add_filter('login_headerurl', 'msk_login_url');
add_filter('login_headertitle', 'msk_login_title');


/*
 * Customize admin footer
 */
function msk_custom_admin_footer() {
	_e('<em>Projector</em> is a theme developed by <a href="http://mosaika.fr/?utm_source=wp_admin&utm_medium=projector_footer&utm_campaign=wp_projector_footer" target="_blank">Mosaika</a></span>.', 'msk-projector');
}
add_filter('admin_footer_text', 'msk_custom_admin_footer');

/*
 * Admin custom CSS
 */
function msk_admin_custom_css() {
	$rule = array();

	// From 3.0 to 3.7
	$rule[] = '.branch-3-0 #adminmenu #menu-posts-msk_wip div.wp-menu-image img, .branch-3-1 #adminmenu #menu-posts-msk_wip div.wp-menu-image img, .branch-3-2 #adminmenu #menu-posts-msk_wip div.wp-menu-image img,
			   .branch-3-3 #adminmenu #menu-posts-msk_wip div.wp-menu-image img, .branch-3-4 #adminmenu #menu-posts-msk_wip div.wp-menu-image img, .branch-3-5 #adminmenu #menu-posts-msk_wip div.wp-menu-image img,
			   .branch-3-6 #adminmenu #menu-posts-msk_wip div.wp-menu-image img, .branch-3-7 #adminmenu #menu-posts-msk_wip div.wp-menu-image img { display:block !important; }';
	// 3.8, MP6 design
	$rule[] = '#adminmenu #menu-posts-msk_wip div.wp-menu-image:before { content: "\f125"; }';
	$rule[] = '#adminmenu #menu-posts-msk_wip div.wp-menu-image img { display:none; }';

	$rule[] = '#wip_image { width:150px; }';

	$rule[] = '.post-type-msk_wip label[for=ping_status] { display:none; }';

	$rule[] = '.redux-normal.section-title.redux-info-field { padding:0; background:none; text-transform:uppercase; padding-bottom:.5em; margin-bottom:0; border:none; border-bottom:2px solid #df7f31; border-radius:0; }';
	$rule[] = '.redux-normal.section-title.redux-info-field h3 { color:#df7f31; line-height:1; font-size:1.5em; margin:0; }';
	$rule[] = '.redux-normal.section-title.redux-info-field h3:before { font:400 .65em/1 dashicons!important; content: "\f345"; height:.5em; width:.5em; }';
	$rule[] = '.redux-group-tab > h3 { padding-left:1em; font-size:.75em; text-transform:uppercase; }';
	$rule[] = '#redux-header .display_header h2 { background: url(' . get_stylesheet_directory_uri() . '/library/images/projector-logo.png) no-repeat top center; width: 274px; height: 43px; text-indent: -9999px; overflow: hidden; display: block; }';
	$rule[] = '#redux-header .display_header span { float:right; position:relative; top:1em; }';
	$rule[] = '#redux-share a, #redux-sidebar #redux-group-menu li a i { color:#df7f31; }';
	$rule[] = '#redux-share a:hover { background-color:#df7f31; color:#fff; }';

	$rule[] = '.button-secondary.cuztom-button .dashicons { position:relative; top:.25em; }';
	$rule[] = '#wip_settings .cuztom-handle-sortable.js-cuztom-handle-sortable { display:none; }';
	$rule[] = '#wip_settings .cuztom-sortable-item { position:relative; }';
	$rule[] = '#wip_settings .cuztom .cuztom-remove-sortable { position: absolute; top: 50%; z-index: 9999; margin-top: -8px; right: .45em; }';

	echo '<style type="text/css">' . join(' ', $rule) .'</style>';
}
add_action( 'admin_enqueue_scripts', 'msk_admin_custom_css' );

/*
 * Register duplication WIP action
 */
function msk_create_wip_new_version() {
	if (!(isset($_GET['post']) || isset($_POST['post'])  || ( isset($_REQUEST['action']) && 'msk_wip_new_version' == $_REQUEST['action']))) {
		wp_die(__('Are you really trying to duplicate a WIP project ?!', 'msk-projector'));
	}

	// Get original post data
	$post_id = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);
	$wip_post = get_post($post_id);
	$wip_post_data = get_post_custom($post_id);
	$parent = (isset($_GET['parentwip']) ? $_GET['parentwip'] : $_POST['parentwip']);

	$wip_new_version_settings = msk_opt('advanced-admin-wip-new-version-data');

	// Copy content
	$wip_content = (isset($wip_new_version_settings['content']) && $wip_new_version_settings['content'] == 1) ? $wip_post->post_content : '';

	$new_wip_post_args = array(
		'comment_status' => $wip_post->comment_status,
		'post_author' => $wip_post->post_author,
		'post_content' => $wip_content,
		'post_parent' => $parent,
		'post_password' => $wip_post->post_password,
		'post_status' => 'draft',
		'post_title' => $wip_post->post_title,
		'post_type' => 'msk_wip',
	);

	// Create duplicate version
	$new_wip_post = wp_insert_post($new_wip_post_args);

	if (!$new_wip_post) {
		wp_die(__('Error trying to create a new version of this WIP.', 'msk-projector'));
	} else {
		// Copy emails to notify
		if (isset($wip_new_version_settings['notify']) && $wip_new_version_settings['notify'] == 1) {
			$notify_emails = get_post_meta($post_id, '_wip_settings_notify', true);
			update_post_meta($new_wip_post, '_wip_settings_notify', $notify_emails);
		}

		// Copy WIP item datas
		if (isset($wip_new_version_settings['wip_item_contents']) && $wip_new_version_settings['wip_item_contents'] == 1) {
			$i = 0;

			// Populate $wip_items array with data
			while (array_key_exists("_wip_content_title_$i", $wip_post_data)) {
				if ($wip_post_data["_wip_content_title_$i"][0] != '' OR $wip_post_data["_wip_content_data_$i"][0] != ''  OR $wip_post_data["_wip_content_desc_$i"][0] != '') {
					// Title
					if (isset($wip_post_data["_wip_content_title_$i"]) && $wip_post_data["_wip_content_title_$i"][0] != '')
						update_post_meta($new_wip_post, "_wip_content_title_$i", $wip_post_data["_wip_content_title_$i"][0]);

					// Subtitle
					if (isset($wip_post_data["_wip_content_subtitle_$i"]) && $wip_post_data["_wip_content_subtitle_$i"][0] != '')
						update_post_meta($new_wip_post, "_wip_content_subtitle_$i", $wip_post_data["_wip_content_subtitle_$i"][0]);

					// Data
					if (isset($wip_post_data["_wip_content_data_$i"]) && $wip_post_data["_wip_content_data_$i"][0] != '')
						update_post_meta($new_wip_post, "_wip_content_data_$i", $wip_post_data["_wip_content_data_$i"][0]);

					// Desc
					if (isset($wip_post_data["_wip_content_desc_$i"]) && $wip_post_data["_wip_content_desc_$i"][0] != '')
						update_post_meta($new_wip_post, "_wip_content_desc_$i", $wip_post_data["_wip_content_desc_$i"][0]);
				}
				$i++;
			}
		}

		// Redirect to new post
		wp_redirect(admin_url('post.php?action=edit&post=' . $new_wip_post . '&msk_notice_newversion=1'));
	}
}
add_action('admin_action_msk_wip_new_version', 'msk_create_wip_new_version');

/*
 * Admin notice on new version
 */
function msk_wip_admin_notices(){
	global $pagenow;
	if ($pagenow == 'post.php' && isset($_GET['msk_notice_newversion']) && $_GET['msk_notice_newversion'] == 1) {
		global $post;

		echo '<div class="error"><p>' . sprintf(__('A new version of <strong>%s</strong> has been created and you are currently editing it.', 'msk-projector'),  $post->post_title) . '</p></div>';
	}
}
add_action('admin_notices', 'msk_wip_admin_notices');

/*
 * Disable robots crawling option on theme activation
 */
function msk_make_site_private() {
	update_option('blog_public', 0);
}
add_action('after_switch_theme', 'msk_make_site_private', 10);