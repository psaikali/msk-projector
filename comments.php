<?php if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) die('Please do not load this page directly.'); ?>

<?php if (comments_open()) { ?>

	<section id="respond" class="respond-form">
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="comment-form" data-abide>

			<div class="fields-group">
				<?php
				/*
				 * Get user info, if logged-in
				 * TODO : link this with a registration + login form
				 */

				$current_user = wp_get_current_user();

				$user_name = (is_user_logged_in()) ? $current_user->display_name : '';
				$user_email = (is_user_logged_in()) ? $current_user->user_email : '';

				?>

				<div class="author-field">
					<label for="author"><?php _e('Name', 'msk-projector'); ?></label>
					<input type="text" name="author" id="author" value="<?php echo esc_attr($user_name); ?>" placeholder="<?php esc_attr_e('Your name*', 'msk-projector'); ?>" tabindex="1" required aria-required="true" pattern="[a-zA-Z]+" />
					<small class="error"><?php _e('We need your name.', 'msk-projector'); ?></small>
				</div>

				<div class="email-field">
					<label for="email"><?php _e('E-mail', 'msk-projector'); ?></label>
					<input type="email" name="email" id="email" value="<?php echo esc_attr($user_email); ?>" placeholder="<?php esc_attr_e('Your e-mail*', 'msk-projector'); ?>" tabindex="2" required aria-required="true" />
					<small class="error"><?php _e('A valid e-mail address is required.', 'msk-projector'); ?></small>
				</div>

				<div class="email-field">
					<label for="comment"><?php _e('Comment', 'msk-projector'); ?></label>
					<textarea name="comment" id="comment" rows="10" placeholder="<?php _e('Leave your feedback here...', 'msk-projector'); ?>" tabindex="3" required aria-required="true"></textarea>
					<small class="error"><?php _e('Your feedback is missing !', 'msk-projector'); ?></small>
				</div>

				<label for="notify" id="notify-label">
					<input type="checkbox" name="notify" id="notify" checked="checked" tabindex="4" value="yes" />
					<?php _e('Notify me of follow-up comments by email.', 'msk-projector'); ?>
				</label>
			</div>

			<button name="submit" type="submit" id="submit" class="button" tabindex="5"><i class="fi-plus"></i> <?php _e('Comment', 'msk-projector'); ?></button>

			<?php comment_id_fields(); ?>
			<?php do_action('comment_form', $post->ID); ?>
		</form>
	</section>

<?php } ?>

<?php if (have_comments()) { ?>

	<ul id="comments-list">
		<?php wp_list_comments(array(
			'style' => 'li',
			'type' => 'comment',
			'callback' => 'msk_comments',
			'per_page' => 9999,
			'reverse_top_level' => true,
		)); ?>
	</ul>

<?php } else {
	if (comments_open()) { ?>
		<ul id="comments-list">
			<li><?php _e('No comment yet. Use the form above to add the first comment.', 'msk-projector'); ?></li>
		</ul>
	<?php } ?>

<?php } ?>