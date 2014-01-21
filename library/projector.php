<?php

function msk_opt($opt_name) {
	global $msk_opt;
	if (isset($msk_opt) && array_key_exists($opt_name, $msk_opt)) return $msk_opt[$opt_name];
	else return false;
}

function msk_p($arr, $display = 'block') {
	echo "<a style='display:inline-block;background:#b9e0f5;padding:.35em 1em;margin:1em 0;border-radius:4px;overflow-x:scroll;' href='#' class='pre-closer' onclick='$(this).next().slideToggle();'>X</a>";
	echo "<pre style='display:$display;z-index:9999;position:relative;background:#b9e0f5;padding:1em;margin:-1em 0 1em 0;border-radius:4px;overflow-x:scroll;'>";
	print_r($arr);
	echo "</pre>";
}

add_action('after_setup_theme', 'msk_start', 16);

function msk_start() {
	add_action('init', 'msk_head_cleanup');
	add_filter('the_generator', 'msk_rss_version');
	add_filter('gallery_style', 'msk_gallery_style');
	add_action('wp_enqueue_scripts', 'msk_scripts_and_styles', 999);

	msk_theme_support();

	add_filter('the_content', 'msk_filter_ptags_on_images');
}

function msk_head_cleanup() {
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
	remove_action('wp_head', 'wp_generator');
	add_filter('style_loader_src', 'msk_remove_wp_ver_css_js', 9999);
	add_filter('script_loader_src', 'msk_remove_wp_ver_css_js', 9999);
}

function msk_rss_version() {
	return '';
}

function msk_remove_wp_ver_css_js($src) {
	if (strpos($src, 'ver='))
		$src = remove_query_arg('ver', $src);
	return $src;
}

function msk_gallery_style($css) {
	return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}


function msk_scripts_and_styles() {
	global $wp_styles;

	if (!is_admin()) {
		wp_register_script('mskproj-modernizr', get_stylesheet_directory_uri() . '/library/js/vendor/custom.modernizr.js', array(), '2.5.3', false);
		wp_register_script('foundation-js', get_template_directory_uri() . '/library/js/foundation.min.js', array('jquery'), '', true);
		wp_register_style('mskproj-stylesheet', get_stylesheet_directory_uri() . '/style.css', array(), '', 'all');
		wp_register_style('foundation-icons', get_stylesheet_directory_uri() . '/library/css/icons/foundation-icons.css', array(), '', 'all');

		if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) wp_enqueue_script('comment-reply');

		wp_register_script('mskproj-js', get_stylesheet_directory_uri() . '/library/js/scripts.js', array('jquery'), '', true);

		wp_enqueue_script('mskproj-modernizr');
		wp_enqueue_script('foundation-js');
		wp_enqueue_style('mskproj-stylesheet');
		wp_enqueue_style('foundation-icons');

		$wp_styles->add_data('mskproj-ie-only', 'conditional', 'lt IE 9');

		wp_enqueue_script('mskproj-js');
	}
}


function my_jquery_enqueue() {
	wp_deregister_script('jquery');
	wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js", false, null);
	wp_enqueue_script('jquery');
}
if (!is_admin()) add_action('wp_enqueue_scripts', 'my_jquery_enqueue', 11);


function msk_theme_support() {
	add_theme_support('automatic-feed-links');
}

function msk_filter_ptags_on_images($content) {
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}


/*
 * If not single WIP, redirect to home or to URL set in options
 */
function msk_global_redirect($template) {
	if (!is_singular('msk_wip')) {
		if (msk_opt('home-redirect') == 1) {
			$url = esc_url(msk_opt('home-redirect-url'));
			wp_redirect($url);
			exit();
		} else {
			return TEMPLATEPATH . '/index.php';
		}
	} else {
		return $template;
	}
}
add_filter('template_redirect', 'msk_global_redirect', 99);

/*
 * Remove 'Password' from protected posts title
 */
function msk_remove_password_in_title($title) {
	return '%s';
}
add_filter('protected_title_format', 'msk_remove_password_in_title');

/*
 * Take control of the post password box message
 */
function msk_wip_password_form() {
	global $post;

	$label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );
	$output = '<div class="row"><form id="wip-password-form" action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" class="post-password-form small-12 medium-6 large-4 medium-centered large-centered columns" method="post">';
	$output .= '<div class="wip-password-content">' . wpautop(msk_opt('wip-password-paragraph')) . '</div>';
	$output .= '<div class="fields">';
	$output .= '<label for="' . $label . '">' . __('Password') . '</label>';
	$output .= '<input name="post_password" id="' . $label . '" type="password" required autofocus size="20" />';
	$output .= '<button class="submit" type="submit" name="submit"><i class="fi-lock"></i> ' . __( 'Access' ) . '</button>';
	$output .= '</div>';
	$output .= '</form></div>';

	return $output;
}
add_filter('the_password_form', 'msk_wip_password_form');

/*
 * Remove posts and page admin menu items
 */
function msk_remove_admin_menus(){
	remove_menu_page( 'edit.php' );                   //Posts
	remove_menu_page( 'edit.php?post_type=page' );    //Pages
}
add_action('admin_menu', 'msk_remove_admin_menus');

/*
 * Generate comments
 */
function msk_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	$author_name = $comment->comment_author;
	$author_email = $comment->comment_author_email;	?>

<li id="comment-<?php comment_ID(); ?>" <?php comment_class('clearfix'); ?>>
	<header class="comment-author">
		<h5><?php echo $author_name; ?></h5>
		<?php if ($comment->comment_approved == '0') { ?><small class="label info"><?php _e('Awaiting moderation.', 'msk-projector') ?></small><?php } ?>
	</header>
	<article class="comment-content clearfix">
		<?php comment_text() ?>
	</article>
	<time><i class="fi-clock"></i> <?php echo sprintf(__('%s ago', 'msk-projector'), human_time_diff(get_comment_time('U'), current_time('timestamp'))); ?></time>
<?php }

/*
 * Add comment author email to 'notify' post meta
 */
function msk_save_comment_meta_data($comment_id) {
	global $post;
	$post_id = $post->ID;

	// Get comment
	$comment = get_comment($comment_id);

	// Get post author email address
	$post_author_email = get_the_author_meta('user_email', $post->post_author);

	// Get notified emails
	$existing_emails = get_post_meta($post_id, '_wip_settings_notify', true);

	// If user wants notification and users isn't in notified emails array yet
	if (isset($_POST['notify']) && $_POST['notify'] == 'yes' && !in_array($comment->comment_author_email, $existing_emails)) {
		$existing_emails[] = $comment->comment_author_email;
		update_post_meta($post_id, '_wip_settings_notify', $existing_emails);
	}

	$notify_emails = $existing_emails;
	if (!in_array($post_author_email, $notify_emails)) $notify_emails[] = $post_author_email;

	$variables = array(
		'project_title'             => $post->post_title,
		'project_version'           => get_post_meta($post_id, '_wip_settings_version', true),
		'project_url'               => get_permalink($post_id),
		'project_password'          => $post->post_password,
		'comment_author'            => $comment->comment_author,
		'comment_content'           => wpautop($comment->comment_content),
		'comment_date'              => $comment->comment_date,
	);

	$template_body = msk_opt('advanced-custom-email-template');
	$template_subject = msk_opt('advanced-custom-email-subject');

	foreach($variables as $key=>$value){
		$template_body = str_replace('{{' . $key . '}}', $value, $template_body);
		$template_subject = str_replace('{{' . $key . '}}', $value, $template_subject);
	}

	$subject = $template_subject;
	$body = $template_body;

	$headers[] = 'Content-type: text/html';
	$headers[] = 'From: ' . $comment->comment_author . ' <' . $comment->comment_author_email . '>' . "\r\n";
	$headers[] = 'Reply-To: ' . $comment->comment_author_email;

	wp_mail($notify_emails, $subject, $body, $headers);
}
add_action('comment_post', 'msk_save_comment_meta_data');

/*
 * Let's design this sh*t based on the options
 */

// Display the CSS (generated output is stored in msk_projector_generated_css option)
function msk_outputs_design_styles() {
	$output = '<style type="text/css">';
	$output .= get_option('msk_projector_generated_css', '');
	$output .= '</style>';
	echo $output;
}
add_action('wp_head', 'msk_outputs_design_styles');

// Store the value in msk_projector_generated_css option everytime a compiling option is saved
function msk_generate_design_styles() {
	$sidebar_width = msk_opt('wip-appearance-comment-sidebar-width');
	$project_title_height = msk_opt('design-header-title-font');
	$access_bg = msk_opt('design-password-btn-bg');
	$submit_bg = msk_opt('design-comments-btn-bg');

	$css = '';
	//$css .= '#header-bar { height:' . $project_title_height['font-size'] . '; }';
	//$css .= '#comments-header, #logo { width:' . $project_title_height['font-size'] . '; height:' . $project_title_height['font-size'] . '; }';

	$css .= '#wip-project-title { margin-left: ' . $project_title_height['font-size'] . '; }';

	$css .= '.left-off-canvas-menu, .right-off-canvas-menu { width:' . $sidebar_width . '; }';
	$css .= ".move-right > .inner-wrap {-webkit-transform: translate3d($sidebar_width, 0, 0);-moz-transform: translate3d($sidebar_width, 0, 0);-ms-transform: translate3d($sidebar_width, 0, 0);-o-transform: translate3d($sidebar_width, 0, 0);transform: translate3d($sidebar_width, 0, 0);}.move-left > .inner-wrap {-webkit-transform: translate3d(-$sidebar_width, 0, 0);-moz-transform: translate3d(-$sidebar_width, 0, 0);-ms-transform: translate3d(-$sidebar_width, 0, 0);-o-transform: translate3d(-$sidebar_width, 0, 0);transform: translate3d(-$sidebar_width, 0, 0);}";

	$css .= '#wip-password-form .fields button { background:' . $access_bg['regular'] . '; } #wip-password-form .fields button:hover { background:' . $access_bg['hover'] . '; } #wip-password-form .fields button:active { background:' . $access_bg['active'] . '; }';
	$css .= '#submit { background:' . $submit_bg['regular'] . '; } #submit:hover { background:' . $submit_bg['hover'] . '; } #submit:active { background:' . $submit_bg['active'] . '; }';

	update_option('msk_projector_generated_css', $css);
}
add_action('redux/options/msk_opt/compiler', 'msk_generate_design_styles');

/*
 * Add extra CSS and HTML
 */
function msk_extra_head_css_html() {
	$extra_css = msk_opt('advanced-custom-css');
	if ($extra_css != '') echo '<style type="text/css">' . $extra_css . '</style>';
	$extra_html = msk_opt('advanced-custom-head-html');
	if ($extra_html != '') echo $extra_html;
}
add_action('wp_head', 'msk_extra_head_css_html', 500);