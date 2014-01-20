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
					<?php if ($version != '') { ?>
						<span class="version"><?php echo $version; ?></span>
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

				<section id="wip-intro">
					<?php the_content(); ?>
				</section>

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

<?php } } else { ?>


<?php } //endelse ?>

<?php get_footer(); ?>