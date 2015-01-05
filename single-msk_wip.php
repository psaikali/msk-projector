<?php get_header(); ?>

<?php if (have_posts()) { while (have_posts()) { the_post();

	/*
	 * Get theme options
	 */
	$comment_layout = msk_opt('wip-appearance-comment-layout');
	$desc_layout = msk_opt('wip-appearance-desc-layout');
	$logo_layout = ($comment_layout == 'left') ? 'right' : 'left';
	$logo = msk_opt('wip-appearance-logo');
	$logo_url = msk_opt('wip-appearance-logo-url');
	$project_title_classes = (isset($logo['url']) && $logo['url'] != '') ? 'has-' . $logo_layout . '-logo has-' . $comment_layout . '-comments' : 'has-' . $comment_layout . '-comments';

	/*
	 * Get WIP post data
	 */

	$id = $post->ID;
	$post_meta = get_post_custom($id);
	$title = $post->post_title;
	$version = $post_meta['_wip_settings_version'][0];
	$url = get_permalink($id);
	$comments_nb = $post->comment_count;

	$show_comments = (comments_open() || $comments_nb > 0) ? TRUE : FALSE;

	$parent = ($post->post_parent == 0) ? $id : $post->post_parent;

	$wip_children = get_children(array(
		'post_parent' => $parent,
		'post_type' => 'msk_wip',
		'post_status' => 'publish',
		'numberposts' => -1,
		'orderby' => 'date',
		'order' => 'ASC'
	));

	$show_versions_nav = (!empty($wip_children)) ? TRUE : FALSE;

	$wip_items = array();

	$i = 0;

	// Populate $wip_items array with data
	while (array_key_exists("_wip_content_title_$i", $post_meta)) {
		if ($post_meta["_wip_content_title_$i"][0] != '' OR $post_meta["_wip_content_data_$i"][0] != ''  OR $post_meta["_wip_content_desc_$i"][0] != '') {
			$wip_items[] = array(
				'title' => $post_meta["_wip_content_title_$i"][0],
				'subtitle' => $post_meta["_wip_content_subtitle_$i"][0],
				'data' => $post_meta["_wip_content_data_$i"][0],
				'desc' => $post_meta["_wip_content_desc_$i"][0],
			);
		}
		$i++;
	}

	/*
	 * HTML stuff
	 */

	$data_classes = array('data', 'small-12', 'medium-8', 'large-9', 'columns');
	$desc_classes = array('desc', 'small-12', 'medium-4', 'large-3', 'columns');

	if ($desc_layout == 'left') {
		$data_classes[] = 'medium-push-4';
		$data_classes[] = 'large-push-3';
		$desc_classes[] = 'medium-pull-8';
		$desc_classes[] = 'large-pull-9';
	} ?>


	<div id="page" class="off-canvas-wrap">
		<div class="inner-wrap">
			<nav id="header-bar" class="tab-bar">
				<?php if ($show_comments && !post_password_required($post)) { ?>
				<section id="comments-header" class="<?php echo $comment_layout; ?>-small">
					<a class="<?php echo $comment_layout; ?>-off-canvas-toggle"><i class="fi-comments"></i></a>
				</section>
				<?php } ?>

				<section id="wip-project-title" class="middle <?php echo $project_title_classes; ?>">
					<h1 class="title">
						<?php the_title(); ?>

						<?php if ($version != '') {
							// If this WIP doesn't have siblings nor children
							if (!$show_versions_nav) {
								echo '<span class="version">' . $version . '</span>';

							// If this WIP has siblings or children
							} else {
								echo '<span data-dropdown="versions" class="dropdown version">' . $version .'</span>';
								echo '<ul id="versions" data-dropdown-content class="f-dropdown">';

								// Store parent WIP post and add it as first entry of $wip_children array
								$parent_of_child = new stdClass();
								$parent_of_child->ID = ($post->post_parent == 0) ? $id : $post->post_parent;
								array_unshift($wip_children, $parent_of_child);

								foreach ($wip_children as $child) {
									if ($child->ID == $id) {
										echo '<li class="active"><a href="#">' . $version . '</a></li>';
									} else {
										$child_url = get_permalink($child->ID);
										$child_version_meta = get_post_meta($child->ID, '_wip_settings_version', true);
										$child_version = (isset($child_version_meta) && !empty($child_version_meta)) ? $child_version_meta : '?';
										echo '<li><a title="' . sprintf(__('See version %s', 'msk-projector'), $child_version) . '" href="' . $child_url . '">' . $child_version . '</a></li>';
									}
								}

								echo '</ul>';
							} ?>
						<?php } ?>
					</h1>
				</section>

				<?php if (isset($logo['url']) && $logo['url'] != '') { ?>
				<section id="logo" class="<?php echo $logo_layout; ?>-small">
					<?php if ($logo_url != '') { ?><a target="_blank" href="<?php echo esc_url($logo_url); ?>"><?php } ?><img src="<?php echo $logo['url']; ?>" /><?php if ($logo_url != '') { ?></a><?php } ?>
				</section>
				<?php } ?>
			</nav>

			<?php if (!post_password_required($post)) { ?>

				<section id="content" class="row row-container">

					<?php echo msk_opt('advanced-custom-before-content'); ?>

					<?php if ($post->post_content != '') { ?>
					<section id="wip-intro">
						<?php the_content(); ?>
					</section>
					<?php } ?>

					<?php foreach ($wip_items as $j=>$item) { ?>

					<article id="wip-item-<?php echo $j+1; ?>" class="wip-item row">
						<section class="<?php echo join(' ', $data_classes); ?>">
							<?php echo apply_filters('the_content', $item['data']); ?>
						</section>

						<aside class="<?php echo join(' ', $desc_classes); ?>">
							<?php if ($item['title'] != '' OR $item['subtitle'] != '') { ?>
							<header class="heading">
								<?php if ($item['title'] != '') echo '<h3>' . $item['title'] . '</h3>'; ?>
								<?php if ($item['subtitle'] != '') echo '<h4>' . $item['subtitle'] . '</h4>'; ?>
							</header>
							<?php } ?>

							<?php echo apply_filters('the_content', $item['desc']); ?>
						</aside>
					</article>

					<?php } ?>

					<?php echo msk_opt('advanced-custom-after-content'); ?>
				</section>

				<?php if ($show_comments) { ?>
				<aside id="comments" class="<?php echo $comment_layout; ?>-off-canvas-menu">
					<?php comments_template(); ?>
				</aside>
				<?php } ?>

				<a class="exit-off-canvas"></a>

			<?php } else { ?>

				<section id="content" class="row row-container">
					<?php the_content(); ?>
				</section>

			<?php } ?>
		</div>
	</div>

<?php } } ?>

<?php get_footer(); ?>