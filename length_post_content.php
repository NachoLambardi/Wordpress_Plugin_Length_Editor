<?php
/*
Plugin Name: Max Lentgh Content
Plugin URI: https://github.com/NachoLambardi/
Description: Limited Post Content
Author: Nacho Lambardi
Author URI: https://github.com/NachoLambardi/
Version: 1.0
License: GLPv2 or later
*/


function plugin_menu() {	//Function to add a page into the Wordpress Menu.
		add_menu_page('Settings plugin Max Length Content',
			'Max Length Content',
			'administrator',
			'max-length-content-settings',
			'content_page_settings',
			'dashicons-admin-generic'
			);
}
add_action( 'admin_menu','plugin_menu' );

function content_page_settings() {
?>
	<div class="wrap">
		<h2><?php esc_html_e( 'Plugin Max Length Content Editor', 'max-length-content' ); ?></h2>
		<form method="POST" action="options.php">
			<?php
				$setting_name = 'max-length-content-settings-group';
				settings_fields( $setting_name );
				do_settings_sections( $setting_name );
			?>
			<label><?php esc_html_e( 'Max Length: ', 'max-length-content' ); ?></label>
				<input type="text" name="<?php echo esc_attr( $setting_name ); ?>" id="max_length_value" value="<?php echo get_option('max_length_value'); ?>" />
			<?php submit_button(); ?>
		</form>
	</div>
<?php
}

function max_length_content_settings()	{
	register_setting(
		'max-length-content-settings-group',
		'max_length_value',
		'intval'
		);
}
add_action( 'admin_init', 'max_length_content_settings' );

function max_length_action( $content ) {
	if ( ( '$post' === get_post_type() ) && ! is_singular( 'post' ) ) {
		$len_post = get_option( 'max_length_value' );
		$content = mb_substr( $content, 3, intval( $len_post ) );
	}
	return $content;
}
add_filter( 'the_content','max_length_action' );
