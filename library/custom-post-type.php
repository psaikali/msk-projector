<?php

function msk_post_types() {
	$wip_slug = (msk_opt('advanced-admin-wip-slug')) ? msk_opt('advanced-admin-wip-slug') : 'wip';

	$wip_labels = array(
		'name' => _x( 'WIP', 'post type general name' , 'msk-projector' ),
		'singular_name' => _x( 'WIP', 'post type singular name' , 'msk-projector' ),
		'add_new' => __( 'Add New', 'msk-projector' ),
		'add_new_item' => sprintf( __( 'Add new %s' , 'msk-projector' ), __( 'Work in Progress' , 'msk-projector' ) ),
		'edit_item' => sprintf( __( 'Edit %s' , 'msk-projector' ), __( 'Work in Progress' , 'msk-projector' ) ),
		'new_item' => sprintf( __( 'New %s' , 'msk-projector' ), __( 'WIP' , 'msk-projector' ) ),
		'all_items' => sprintf( __( 'All %s' , 'msk-projector' ), __( 'WIPs' , 'msk-projector' ) ),
		'view_item' => sprintf( __( 'View %s' , 'msk-projector' ), __( 'WIP' , 'msk-projector' ) ),
		'search_items' => sprintf( __( 'Search %a' , 'msk-projector' ), __( 'Works in Progress' , 'msk-projector' ) ),
		'not_found' =>  sprintf( __( 'No %s found' , 'msk-projector' ), __( 'WIP' , 'msk-projector' ) ),
		'not_found_in_trash' => sprintf( __( 'No %s Found In Trash' , 'msk-projector' ), __( 'WIP' , 'msk-projector' ) ),
		'parent_item_colon' => '',
		'menu_name' => __( 'WIP\'s' , 'msk-projector' )
	);

	/*$wip_args = array(
		'labels' => $wip_labels,
		'public' => true,
		'publicly_queryable' => false,
		'exclude_from_search' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => false,
		'rewrite' => array(
			'slug' => $wip_slug,
			'with_front' => false,
			'feeds' => false,
			'pages' => false
		),
		'capability_type' => 'page',
		'hierarchical' => true,
		'supports' => array('title' , 'editor', 'comments', 'page-attributes'),
		'menu_position' => 17,
		'menu_icon' => get_stylesheet_directory_uri() . '/library/images/menu_icon.png'
	);*/

	$wip_args = array(
		'labels'             => $wip_labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => false,
		'query_var'          => true,
		'rewrite'            => array('slug' => $wip_slug),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => 17,
		'supports'           => array( 'title', 'editor', 'comments', 'page-attributes' ),
		'menu_icon'          => get_stylesheet_directory_uri() . '/library/images/menu_icon.png'
	);

	//register_post_type('msk_wip', $wip_args);
	$wip = new Cuztom_Post_Type('msk_wip', $wip_args, $wip_labels);

	//flush_rewrite_rules();

	remove_post_type_support('msk_wip', 'trackbacks');

	$wip_metabox_content_fields = array();
	$wip_metabox_content_tabs = array();

	$wip_metabox_content_style = (msk_opt('advanced-admin-wip-items-style')) ? msk_opt('advanced-admin-wip-items-style') : 'tabs';
	$wip_metabox_content_number = (msk_opt('advanced-admin-wip-items')) ? msk_opt('advanced-admin-wip-items') : 3;

	for ($i = 0; $i < $wip_metabox_content_number; $i++) {
		$wip_metabox_content_fields[$i] = array(
			array(
				'name'          => 'title_' . $i,
				'label'         => __('Title', 'msk-projector'),
				'description'   => __('Define a title here (optional).', 'msk-projector'),
				'type'          => 'text'
			),
			array(
				'name'          => 'subtitle_' . $i,
				'label'         => __('Subtitle', 'msk-projector'),
				'description'   => __('You can display a small explanation below the title (optional).', 'msk-projector'),
				'type'          => 'text'
			),
			array(
				'name'          => 'data_' . $i,
				'label'         => __('Content data', 'msk-projector'),
				'description'   => __('Image or video content', 'msk-projector'),
				'type'          => 'wysiwyg'
			),
			array(
				'name'          => 'desc_' . $i,
				'label'         => __('Description', 'msk-projector'),
				'description'   => __('Describe your image(s) (optional).', 'msk-projector'),
				'type'          => 'wysiwyg'
			),
		);

		$tab_name = sprintf(__('WIP item #%d', 'msk-projector'), $i+1);

		$wip_metabox_content_tabs[$tab_name] = $wip_metabox_content_fields[$i];
	}

	$wip->add_meta_box(
		'wip_content',
		__('WIP project data', 'msk-projector'),
		array(
			$wip_metabox_content_style,
			$wip_metabox_content_tabs
		),
		'normal',
		'default'
	);

	$wip->add_meta_box(
		'data',
		__('Data', 'msk-projector'),
		'msk_post_type_data_metabox',
		'side',
		'high'
	);

	$wip->add_meta_box(
		'wip_settings',
		__('Project settings', 'msk-projector'),
		array(
			array(
				'name'          => 'version',
				'label'         => __('Version', 'msk-projector'),
				'type'          => 'text'
			),
			array(
				'name'          => 'notify',
				'label'         => __('E-mails to notify', 'msk-projector'),
				'type'          => 'text',
				'repeatable'    => true
			),
		),
		'side',
		'high'
	);
}
add_action( 'init', 'msk_post_types', 2);

function msk_post_type_data_metabox($data) {
	echo '<div class="dashicons dashicons-admin-links"></div><strong> ' . __('Private link', 'msk-projector') . ' : </strong><br>';

	if ($data->post_status == 'publish') {
		echo '<a target="_blank" href="' . get_permalink($data->ID) . '" title="' . __('See WIP page', 'msk-projector') . '">' . str_replace(get_home_url(), '', get_permalink($data->ID)) . '</a>';
	} else {
		_e('Please publish this WIP project first.', 'msk-projector');
	}

	echo '<hr>';

	echo '<div class="dashicons dashicons-lock"></div><strong> ' . __('Visibility', 'msk-projector') . ' : </strong><br>';

	$onclick = "jQuery('#post-visibility-select').slideDown(); jQuery('html, body').animate({scrollTop: jQuery('#submitdiv').offset().top - 75 }, 2000);";

	if ($data->post_password == '') {
		echo __('Not protected', 'msk-projector') . ' <small><a href="javascript:void();" onClick="' . $onclick . '">' . __('Set a password', 'msk-projector') . '</a></small>';
	} else {
		echo __('Password protected', 'msk-projector') . ' <small><a href="javascript:void();" onClick="' . $onclick . '">' . __('Modify password', 'msk-projector') . '</a></small>';
	}

	echo '<hr>';

	$parent_id = ($data->post_parent == 0 ) ? $data->ID : $data->post_parent;
	$new_version_link = admin_url('admin.php?action=msk_wip_new_version&post=' . $data->ID . '&parentwip=' . $parent_id);
	echo '<a class="button-secondary cuztom-button" href="' . $new_version_link . '"><i class="dashicons dashicons-networking"></i> ' . __('Create new version', 'msk-projector') . '</a>';

}

function msk_post_type_custom_column_headings($columns) {
	$columns = array_slice($columns, 0, 1, true) + array('wip_image' => __('Image #1', 'msk-projector')) + array_slice($columns, 1, count($columns) - 2, true) + array('wip_version' => __('Version', 'msk-projector')) + array('wip_password' => __('Password', 'msk-projector')) + array_slice($columns, count($columns) - 2, count($columns), true);
	return $columns;
}
add_filter( 'manage_edit-msk_wip_columns', 'msk_post_type_custom_column_headings', 10, 2 );

function msk_post_type_custom_column( $column_name, $id ) {
	$post = get_post($id);
	$post_data = get_post_custom($id);

	switch ( $column_name ) {
		case 'wip_image' :
			if (isset($post_data['_wip_content_data_0'])) {
				$html = $post_data['_wip_content_data_0'][0];
				preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $html, $image);
				if (!empty($image)) {
					if ($post->post_parent == 0) {
						echo '<img src="' . $image['src'] . '" width="150px" />';
					} else {
						echo '<div style="text-align:right;"><i class="dashicons dashicons-arrow-right-alt"></i> &nbsp;<img src="' . $image['src'] . '" width="75px" style="float:right;" /></div>';
					}
				}
			}
			break;

		case 'wip_password' :
			$password = $post->post_password;

			if ($password == '') {
				echo '<em class="pass-public">' . __('Public', 'msk-projector') . '</em>';
			} else {
				echo '<em class="pass-public">' . $password . '</em>';
			}
			break;

		case 'wip_version' :
			if (isset($post_data['_wip_settings_version'])) echo $post_data['_wip_settings_version'][0];
			break;

		default:
			break;
	}

}
add_action( 'manage_pages_custom_column', 'msk_post_type_custom_column', 10, 2 );

function msk_post_type_enter_title_here( $title ) {
	if ( get_post_type() == 'msk_wip' ) {
		$title = __( 'Enter WIP project title here...' , 'msk-projector' );
	}
	return $title;
}
add_filter( 'enter_title_here', 'msk_post_type_enter_title_here' );

?>