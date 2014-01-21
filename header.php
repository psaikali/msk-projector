<!doctype html>

<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->

<head>
	<meta charset="utf-8">

	<title><?php wp_title(''); ?></title>

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="HandheldFriendly" content="True" />
	<meta name="MobileOptimized" content="320" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<?php if (msk_opt('wip-appearance-favicon')) {
		$favicon = msk_opt('wip-appearance-favicon');
		$favicon_url = $favicon['url'];
		if ($favicon_url != '') echo '<link rel="icon" href="' . $favicon_url . '" />';
	} ?>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>