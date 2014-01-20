<?php

/**
	ReduxFramework Sample Config File
	For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
**/

if ( !class_exists( "ReduxFramework" ) ) {
	return;
}

if ( !class_exists( "MSK_Projector_Options" ) ) {
	class MSK_Projector_Options {

		public $args = array();
		public $sections = array();
		public $theme;
		public $ReduxFramework;

		public function __construct( ) {
			$this->theme = wp_get_theme();
			$this->setArguments();
			$this->setSections();

			if ( !isset( $this->args['opt_name'] ) ) return;

			$this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
		}

		public function setSections() {

			/*
			 * SECTION HOMEPAGE
			 */

			$this->sections[] = array(
				'title' => __('Homepage', 'msk-projector'),
				'icon' => 'el-icon-home',
				'fields' => array(
					array(
						'id' => 'home-redirect-section-title',
						'type' => 'info',
						'class' => 'section-title',
						'desc' => '<h3>' . __('Redirection', 'msk-projector') . '</h3>'
					),
					array(
						'id'       => 'home-redirect',
						'type'     => 'switch',
						'title'    => __('Activate 301 redirection on homepage', 'msk-projector'),
						'subtitle' => __('To disable public access to the homepage, enable this option.', 'msk-projector'),
						'default'  => 1,
					),
					array(
						'id'       => 'home-redirect-url',
						'type'     => 'text',
						'title'    => __('Redirection URL', 'msk-projector'),
						'default'  => 'http://www.google.com',
						'validate' => 'url',
						'required' => array('home-redirect', '=', '1')
					),
					array(
						'id' => 'home-content-section-title',
						'type' => 'info',
						'class' => 'section-title',
						'desc' => '<h3>' . __('Content', 'msk-projector') . '</h3>',
					),
					array(
						'id' => 'home-content',
						'type' => 'editor',
						'title' => __('Homepage content', 'msk-projector'),
						'desc' => __('Content to be displayed if no redirection is defined.', 'msk-projector')
					),
				)
			);

			/*
			 * SECTION PROJECT SETTINGS
			 */

			$this->sections[] = array(
				'title' => __('WIP projects', 'msk-projector'),
				'icon' => 'el-icon-lines',
				'fields' => array(

					/*
					 * SUBSECTION PASSWORD FORM
					 */
					array(
						'id' => 'wip-password-section-title',
						'type' => 'info',
						'class' => 'section-title',
						'desc' => '<h3>' . __('Password form content', 'msk-projector') . '</h3>'
					),
					array(
						'id' => 'wip-password-paragraph',
						'type' => 'editor',
						'title' => __('Text displayed before the password field.', 'msk-projector'),
						'default' => __('This page is password-protected. Please enter the password below to see its content.', 'msk-projector')
					),

					/*
					 * SUBSECTION WIP APPEARANCE
					 */

					array(
						'id' => 'wip-appearance-section-title',
						'type' => 'info',
						'class' => 'section-title',
						'desc' => '<h3>' . __('WIP project appearance', 'msk-projector') . '</h3>'
					),
					array(
						'id' => 'wip-appearance-comment-layout',
						'type' => 'image_select',
						'title' => __('Comments sidebar position', 'msk-projector'),
						'subtitle' => __('Display the sidebar on the left or right handside of the page.', 'msk-projector'),
						'options' => array(
							'left' => array('alt' => __('Left', 'msk-projector'), 'img' => ReduxFramework::$_url.'assets/img/comments-left.png'),
							'right' => array('alt' => __('Right', 'msk-projector'), 'img' => ReduxFramework::$_url.'assets/img/comments-right.png'),
						),
						'default' => 'left'
					),
					array(
						'id'       => 'wip-appearance-comment-sidebar-width',
						'type'     => 'text',
						'title'    => __('Comments sidebar width', 'msk-projector'),
						'desc' => __('Don\'t forget to set the unit too, like <em>px</em> or <em>%</em>.', 'msk-projector'),
						'default'  => '350px',
						'compiler' => true
					),
					array(
						'id' => 'wip-appearance-desc-layout',
						'type' => 'image_select',
						'title' => __('Item description position', 'msk-projector'),
						'subtitle' => __('Display the description text to the left or right handside of each item data.', 'msk-projector'),
						'options' => array(
							'left' => array('alt' => __('Left', 'msk-projector'), 'img' => ReduxFramework::$_url.'assets/img/desc-left.png'),
							'right' => array('alt' => __('Right', 'msk-projector'), 'img' => ReduxFramework::$_url.'assets/img/desc-right.png'),
						),
						'default' => 'right'
					),
					array(
						'id' => 'wip-appearance-logo',
						'type' => 'media',
						'url' => true,
						'title' => __('Logo', 'msk-projector'),
						//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
						'subtitle' => __('A small logo can be displayed in the right part of the header bar.', 'msk-projector'),
					),
					array(
						'id'       => 'wip-appearance-logo-url',
						'type'     => 'text',
						'title'    => __('Logo URL', 'msk-projector'),
						'desc'     => __('A link can be assigned to the logo, redirecting the user to your main website for example.', 'msk-projector'),
						'default'  => '',
						'required' => array('wip-appearance-logo', '!=', '')
					),
				)
			);

			/*
			 * SECTION DESIGN
			 */

			$this->sections[] = array(
				'title' => __('Design', 'msk-projector'),
				'icon' => 'el-icon-tint',
				'fields' => array(

					/*
					 * SUBSECTION BACKGROUNDS
					 */

					array(
						'id' => 'design-bg-section-title',
						'type' => 'info',
						'class' => 'section-title',
						'desc' => '<h3>' . __('Backgrounds', 'msk-projector') . '</h3>'
					),
					array(
						'id'=>'design-bg-page',
						'type' => 'background',
						'title' => __('Page background', 'msk-projector'),
						'default' => array(
							'background-color' => '#ffffff'
						),
						'output' => array('body'),
						//'compiler' => true
					),
					array(
						'id'=>'design-bg-comments',
						'type' => 'background',
						'title' => __('Comments sidebar background', 'msk-projector'),
						'default' => array(
							'background-color' => '#f3f2f0'
						),
						'output' => array('#comments'),
						//'compiler' => true
					),
					array(
						'id'=>'design-bg-header',
						'type' => 'background',
						'title' => __('Header background', 'msk-projector'),
						'default' => array(
							'background-color' => '#302d2c'
						),
						'output' => array('#header-bar'),
						//'compiler' => true
					),
					array(
						'id'=>'design-bg-comments-header',
						'type' => 'background',
						'title' => __('Comments header background', 'msk-projector'),
						'default' => array(
							'background-color' => '#56aac2'
						),
						'output' => array('#comments-header'),
						//'compiler' => true
					),
					array(
						'id'=>'design-bg-comments-form-fields',
						'type' => 'background',
						'title' => __('Comment form background', 'msk-projector'),
						'default' => array(
							'background-color' => '#f9f8f5'
						),
						'output' => array('#comment-form .fields-group'),
						//'compiler' => true
					),

					/*
					 * SUBSECTION HEADERS
					 */

					array(
						'id' => 'design-header-section-title',
						'type' => 'info',
						'class' => 'section-title',
						'desc' => '<h3>' . __('Header bar', 'msk-projector') . '</h3>'
					),
					array(
						'id' => 'design-header-title-font',
						'type' => 'typography',
						'title' => __('Project title font', 'msk-projector'),
						'subtitle' => __('Specify the title font properties.', 'msk-projector'),
						'google' => true,
						'units' => 'em',
						'subsets' => false,
						'update_weekly' => true,
						'default' => array(
							'color' => '#ffffff',
							'font-size' => '1.35',
							'font-family' => 'Roboto',
							'font-weight' => '300',
							'line-height' => '1.3',
						),
						'output' => array('#wip-project-title .title'),
						'compiler' => true
					),
					array(
						'id' => 'design-header-version-font',
						'type' => 'typography',
						'title' => __('Project version font', 'msk-projector'),
						'subtitle' => __('The version font is displayed just after the project title.', 'msk-projector'),
						'google' => true,
						'units' => 'em',
						'subsets' => false,
						'update_weekly' => true,
						'default' => array(
							'color' => '#9a9897',
							'font-size' => '.75',
							'font-family' => 'Roboto',
							'font-weight' => '700',
							'line-height' => '1.3',
						),
						'output' => array('#wip-project-title .version')
						//'compiler' => true
					),
					array(
						'id' => 'design-header-border',
						'type' => 'border',
						'title' => __('Header border', 'msk-projector'),
						'subtitle' => __('You can display a border at the bottom of the header bar.', 'msk-projector'),
						'description' => __('Tip : for a nice visual effect, you can set the same color as the comments header background color defined below.', 'msk-projector'),
						'output' => array('.zobzob'),
						'left' => false,
						'right' => false,
						'top' => false,
						'bottom' => true,
						'default' => array(
							'border-color' => '#56aac2',
							'border-style' => 'solid',
							'border-width' => '3'
						),
						'output' => array('#header-bar'),
						//'compiler' => true
					),
					array(
						'id' => 'design-header-comments-icon',
						'type' => 'link_color',
						'title' => __('Comments header icon color', 'msk-projector'),
						'active' => false,
						'default' => array(
							'regular' => '#fff',
							'hover' => '#fafafa',
						),
						'output' => array('#comments-header a'),
						//'compiler' => true
					),


					/*
					 * SUBSECTION COMMENTS
					 */

					array(
						'id' => 'design-comments-section-title',
						'type' => 'info',
						'class' => 'section-title',
						'desc' => '<h3>' . __('Comments sidebar', 'msk-projector') . '</h3>'
					),
					array(
						'id' => 'design-comments-name-font',
						'type' => 'typography',
						'title' => __('Comment author font', 'msk-projector'),
						'google' => true,
						'units' => 'em',
						'subsets' => false,
						'update_weekly' => true,
						'default' => array(
							'color' => '#56aac2',
							'font-size' => '0.925',
							'font-family' => 'Roboto',
							'font-weight' => '700',
							'line-height' => '1.3',
						),
						'output' => array('#comments-list .comment .comment-author h5'),
						//'compiler' => true
					),
					array(
						'id' => 'design-comments-content-font',
						'type' => 'typography',
						'title' => __('Comment content font', 'msk-projector'),
						'google' => true,
						'units' => 'em',
						'subsets' => false,
						'update_weekly' => true,
						'default' => array(
							'color' => '#111111',
							'font-size' => '0.8',
							'font-family' => 'Roboto',
							'font-weight' => '400',
							'line-height' => '1.3',
						),
						'output' => array('#comments-list .comment .comment-content p', '#notify-label'),
						//'compiler' => true
					),
					array(
						'id' => 'design-comments-date-font',
						'type' => 'typography',
						'title' => __('Comment meta data font', 'msk-projector'),
						'google' => true,
						'units' => 'em',
						'subsets' => false,
						'update_weekly' => true,
						'default' => array(
							'color' => '#9a9897',
							'font-size' => '0.8',
							'font-family' => 'Roboto',
							'font-weight' => '300',
							'line-height' => '1.3',
						),
						'output' => array('#comments-list .comment time'),
						//'compiler' => true
					),
					array(
						'id' => 'design-comments-sep-border',
						'type' => 'border',
						'title' => __('Comment divider', 'msk-projector'),
						'output' => array('.zobzob'),
						'left' => false,
						'right' => false,
						'top' => false,
						'bottom' => true,
						'default' => array(
							'border-color' => '#dcdbd9',
							'border-style' => 'dashed',
							'border-width' => '1px'
						),
						'output' => array('#comments-list .comment'),
						//'compiler' => true
					),
					array(
						'id' => 'design-comments-btn-bg',
						'type' => 'link_color',
						'title' => __('\'Add comment\' background color', 'msk-projector'),
						'desc' => __('This is the <strong>background</strong> color of the \'Add comment\' button.', 'msk-projector'),
						'default' => array(
							'regular' => '#d8d6d3',
							'hover' => '#56aac2',
							'active' => '#302d2c',
						),
						'compiler' => true
					),
					array(
						'id' => 'design-comments-btn-txt',
						'type' => 'link_color',
						'title' => __('\'Add comment\' text color', 'msk-projector'),
						'desc' => __('This is the <strong>text</strong> color of the \'Add comment\' button.', 'msk-projector'),
						'default' => array(
							'regular' => '#403e3b',
							'hover' => '#ffffff',
							'active' => '#9a9897',
						),
						'output' => array('#submit'),
						//'compiler' => true
					),

					/*
					 * SUBSECTION WIP PROJECT
					 */

					array(
						'id' => 'design-wip-section-title',
						'type' => 'info',
						'class' => 'section-title',
						'desc' => '<h3>' . __('WIP project data', 'msk-projector') . '</h3>'
					),
					array(
						'id' => 'design-wip-title-font',
						'type' => 'typography',
						'title' => __('Description title font', 'msk-projector'),
						'google' => true,
						'units' => 'em',
						'subsets' => false,
						'update_weekly' => true,
						'default' => array(
							'color' => '#56aac2',
							'font-size' => '1.3',
							'font-family' => 'Roboto',
							'font-weight' => '300',
							'line-height' => '1.3',
						),
						'output' => array('.wip-item .desc .heading h3'),
						//'compiler' => true
					),
					array(
						'id' => 'design-wip-subtitle-font',
						'type' => 'typography',
						'title' => __('Description subtitle font', 'msk-projector'),
						'google' => true,
						'units' => 'em',
						'subsets' => false,
						'update_weekly' => true,
						'default' => array(
							'color' => '#999999',
							'font-size' => '1.125',
							'font-family' => 'Roboto',
							'font-weight' => '700',
							'line-height' => '1.3',
						),
						'output' => array('.wip-item .desc .heading h4'),
						//'compiler' => true
					),
					array(
						'id' => 'design-wip-content-font',
						'type' => 'typography',
						'title' => __('Description content font', 'msk-projector'),
						'google' => true,
						'units' => 'em',
						'subsets' => false,
						'update_weekly' => true,
						'default' => array(
							'color' => '#111111',
							'font-size' => '1',
							'font-family' => 'Roboto',
							'font-weight' => '400',
							'line-height' => '1.3',
						),
						'output' => array('.wip-item .desc p', '.wip-item .desc ul', '.wip-item .desc ol', 'body', 'button, .button'),
						//'compiler' => true
					),

				)
			);


			$this->sections[] = array(
				'type' => 'divide',
			);

			/*
			 * SECTION ADVANCED
			 */

			$this->sections[] = array(
				'title' => __('Advanced settings', 'msk-projector'),
				'icon' => 'el-icon-wrench',
				'fields' => array(

					/*
					 * SUBSECTION ADMIN
					 */

					array(
						'id' => 'advanced-admin-section-title',
						'type' => 'info',
						'class' => 'section-title',
						'desc' => '<h3>' . __('WIP administration page', 'msk-projector') . '</h3>'
					),
					array(
						'id'       => 'advanced-admin-wip-items',
						'type'     => 'text',
						'title'    => __('Max number of WIP items', 'msk-projector'),
						'desc'     => __('What is the maximum of WIP items blocks you\'d like to see on edit pages ?', 'msk-projector'),
						'default'  => 5,
						'validate' => 'numeric',
					),
					array(
						'id'       => 'advanced-admin-wip-items-style',
						'type'     => 'select',
						'title'    => __('WIP items admin style', 'msk-projector'),
						'desc'     => __('If you need more than 8 WIP items in the back-end, you might want to display them as accordion before the tabs layout break.', 'msk-projector'),
						'default'  => 'tabs',
						'options'  => array(
							'tabs' => __('Tabs', 'msk-projector'),
							'accordion' => __('Accordions', 'msk-projector'),
						)
					),
					array(
						'id'       => 'advanced-admin-wip-slug',
						'type'     => 'text',
						'title'    => __('WIP project slug', 'msk-projector'),
						'desc'     => sprintf(__('This slug will be displayed in the URL in %1$s/<strong>slug</strong>/wip-project-name. You might need to visit your <a href="%2$s">site Permalinks settings</a> page to refresh WordPress rewrite rules cache.', 'msk-projector'), home_url(), admin_url('options-permalink.php')),
						'default'  => 'wip',
					),
					array(
						'id' => 'advanced-admin-wip-new-version-data',
						'type' => 'checkbox',
						'title' => __('New version data duplication', 'msk-projector'),
						'desc' => __('Decide which content should be duplicated every time you create a new version of a WIP.', 'msk-projector'),
						'options' => array(
							'notify'                => __('E-mails to notify', 'msk-projector'),
							'content'               => __('Intro content', 'msk-projector'),
							'wip_item_contents'       => __('Every WIP item contents', 'msk-projector'),
						),
						'default' => array(
							'notify'                => 1,
							'content'               => 1,
							'wip_item_contents'       => 1,
						)
					),

					/*
					 * SUBSECTION CUSTOM HTML CSS
					 */

					array(
						'id' => 'advanced-custom-section-title',
						'type' => 'info',
						'class' => 'section-title',
						'desc' => '<h3>' . __('Custom HTML &amp; CSS', 'msk-projector') . '</h3>'
					),
					array(
						'id'       => 'advanced-custom-css',
						'type'     => 'ace_editor',
						'title'    => __('Extra CSS code', 'msk-projector'),
						'subtitle' => __('Paste your CSS code here to customize the theme.', 'msk-projector'),
						'mode'     => 'css',
						'theme'    => 'monokai',
						'default'  => '#your_css { background:red; display:block; }'
					),
					array(
						'id'       => 'advanced-custom-head-html',
						'type'     => 'ace_editor',
						'title'    => __('Extra &lt;head&gt; HTML code', 'msk-projector'),
						'subtitle' => __('Paste your HTML code here, it\'ll be loaded in the header of your site.', 'msk-projector'),
						'desc' => __('That\'s a good place to put your Google Analytics tracking code, for example.', 'msk-projector'),
						'mode'     => 'html',
						'theme'    => 'monokai',
						'default'  => ''
					),
					array(
						'id' => 'advanced-custom-before-content',
						'type' => 'editor',
						'title' => __('Content before project data', 'msk-projector'),
						'desc' => __('Content to be displayed before the WIP project data. HTML is allowed.', 'msk-projector')
					),
					array(
						'id' => 'advanced-custom-after-content',
						'type' => 'editor',
						'title' => __('Content after project data', 'msk-projector'),
						'desc' => __('Content to be displayed after the WIP project data. HTML is allowed.', 'msk-projector')
					),
					array(
						'id'       => 'advanced-custom-email-subject',
						'type'     => 'text',
						'title'    => __('E-mail subject title', 'msk-projector'),
						'subtitle' => __('The title used for new comments notification.', 'msk-projector'),
						'default'  => __('New comment on {{project_title}}', 'msk-projector'),
						'desc' => __('You can use variables in there, like : <ul><li><em>{{project_title}}</em> for the WIP project title</li> <li><em>{{comment_author}}</em> for the new comment author name</li></ul>', 'msk-projector'),
					),
					array(
						'id'       => 'advanced-custom-email-template',
						'type'     => 'ace_editor',
						'title'    => __('E-mail body template', 'msk-projector'),
						'subtitle' => __('The e-mail template used for new comments notification.', 'msk-projector'),
						'mode'     => 'html',
						'theme'    => 'monokai',
						'default'  => __('<h2>New comment on {{project_title}} <small><em>(version {{project_version}})</em></small></h2><p><strong>{{comment_author}}</strong> said :</p><blockquote>{{comment_content}}</blockquote><p><a href="{{project_url}}">See project &raquo;</a></p>', 'msk-projector'),
						'desc' => __('You can use variables in there, like : <ul><li><em>{{project_title}}</em> for the WIP project title</li> <li><em>{{project_version}}</em> for the WIP project version</li> <li><em>{{project_url}}</em> for the link to the WIP project</li> <li><em>{{project_password}}</em> for the WIP project password</li> <li><em>{{comment_author}}</em> for the new comment author name</li> <li><em>{{comment_content}}</em> for the new comment content</li> <li><em>{{comment_date}}</em> for the date of the new comment</li></ul>', 'msk-projector'),
					),
				)
			);

		}

		/**

			All the possible arguments for Redux.
			For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

		 **/
		public function setArguments() {

			$theme = wp_get_theme(); // For use with some settings. Not necessary.

			$this->args = array(

	            // TYPICAL -> Change these values as you need/desire
				'opt_name'          	=> 'msk_opt', // This is where your data is stored in the database and also becomes your global variable name.
				'display_name'			=> $theme->get('Name'), // Name that appears at the top of your panel
				'display_version'		=> $theme->get('Version'), // Version that appears at the top of your panel
				'menu_type'          	=> 'menu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
				'allow_sub_menu'     	=> true, // Show the sections below the admin menu item or not
				'menu_title'			=> __( 'Projector', 'msk-projector' ),
	            'page'		 	 		=> __( 'Projector settings', 'msk-projector' ),
	            'google_api_key'   	 	=> 'AIzaSyAdCvDE0OKfmdenhzsMed1U_FnnPhOsrT8', // Must be defined to add google fonts to the typography module
	            'global_variable'    	=> '', // Set a different name for your global variable other than the opt_name
	            'dev_mode'           	=> false, // Show the time the page took to load, etc
	            'customizer'         	=> true, // Enable basic customizer support

	            // OPTIONAL -> Give you extra features
	            'page_priority'      	=> 26, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
	            'page_parent'        	=> 'themes.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	            'page_permissions'   	=> 'manage_options', // Permissions needed to access the options panel.
	            'menu_icon'          	=> '', // Specify a custom URL to an icon
	            'last_tab'           	=> '', // Force your panel to always open to a specific tab (by id)
	            'page_icon'          	=> 'icon-themes', // Icon displayed in the admin panel next to your menu_title
	            'page_slug'          	=> 'msk-projector', // Page slug used to denote the panel
	            'save_defaults'      	=> true, // On load save the defaults to DB before user clicks save or not
	            'default_show'       	=> false, // If true, shows the default value next to each field that is not the default value.
	            'default_mark'       	=> '', // What to print by the field's title if the value shown is default. Suggested: *
				'intro_text'            => __('<p>Intro This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'msk-projector'),
				'footer_text'           => __('<p>Footer This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'msk-projector'),


	            // CAREFUL -> These options are for advanced use only
	            'transient_time' 	 	=> 60 * MINUTE_IN_SECONDS,
	            'output'            	=> true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
	            'output_tab'            => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
	            'footer_credit'      	=> ' ', // Disable the footer credit of Redux. Please leave if you can help it.

	            'show_import_export' 	=> false, // REMOVE
	            'system_info'        	=> false, // REMOVE

	            'help_tabs'          	=> array(),
	            'help_sidebar'       	=> '', // __( '', $this->args['domain'] );
			);


			$this->args['share_icons'][] = array(
				'url' => 'http://mosaika.fr/services/themes-wordpress/projector-feedback-wordpress-theme/?utm_source=wp_admin&utm_medium=projector_login&utm_campaign=wp_projector_login',
				'title' => __('Visit Porjector theme website', 'msk-projector'),
				'icon' => 'el-icon-globe'
			);
			$this->args['share_icons'][] = array(
			    'url' => 'https://plus.google.com/u/1/+MosaikaFrance/posts',
				'title' => __('Follow us on Google Plus', 'msk-projector'),
			    'icon' => 'el-icon-googleplus'
			);
			$this->args['share_icons'][] = array(
			    'url' => 'http://twitter.com/agencemosaika',
				'title' => __('Follow us on Twitter', 'msk-projector'),
			    'icon' => 'el-icon-twitter'
			);
			$this->args['share_icons'][] = array(
				'url' => 'https://www.facebook.com/agence.mosaika.fr',
				'title' => __('Follow us on Facebook', 'msk-projector'),
				'icon' => 'el-icon-facebook'
			);
			$this->args['share_icons'][] = array(
			    'url' => 'http://fr.linkedin.com/in/psaikali/fr',
				'title' => __('Join Mosaika\'s professional network on Linkedin', 'msk-projector'),
			    'icon' => 'el-icon-linkedin'
			);
			$this->args['share_icons'][] = array(
				'url' => 'http://fr.viadeo.com/fr/profile/pierre.saikali',
				'title' => __('Join Mosaika\'s professional network on Viadeo', 'msk-projector'),
				'icon' => 'el-icon-viadeo'
			);
			$this->args['share_icons'][] = array(
				'url' => 'https://creativemarket.com/mosaika',
				'title' => __('See our premium goodies on Creative Market', 'msk-projector'),
				'icon' => 'el-icon-shopping-cart'
			);

		}
	}
	new MSK_Projector_Options();

}