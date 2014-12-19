<?php
/* Alternate Styles & Layouts Functions */
global $arras_registered_alt_layouts, $arras_registered_style_dirs;

function register_alternate_layout($id, $name) {
	global $arras_registered_alt_layouts;
	$arras_registered_alt_layouts[$id] = $name;
}

function register_style_dir($dir) {
	global $arras_registered_style_dirs;
	$arras_registered_style_dirs[] = $dir;
}

function is_valid_arras_style($file) {
	return (bool)( !preg_match('/^\.+$/', $file) && preg_match('/^[A-Za-z][A-Za-z0-9\-]*.css$/', $file) );
}

function arras_override_styles() {
?>
<!-- Generated by Arras WP Theme -->
<style type="text/css">
<?php do_action('arras_custom_styles'); ?>
</style>
<?php
}

function arras_add_custom_logo() {
	$arras_logo_id = arras_get_option('logo');
	if ($arras_logo_id != 0) {
		$arras_logo = wp_get_attachment_image_src($arras_logo_id, 'full');

		echo '.blog-name a { background: url(' . $arras_logo[0] . ') no-repeat; text-indent: -9000px; width: ' . $arras_logo[1] . 'px; height: ' . $arras_logo[2] . 'px; display: block; }' . "\n";
	}
}

function arras_layout_styles() {
	$sidebar_size = arras_get_image_size('sidebar-thumb');
	$sidebar_size_w = $sidebar_size['w'];
	
	$single_thumb_size = arras_get_image_size('single-thumb');
	?>
	.featured-stories-summary  { margin-left: <?php echo $sidebar_size_w + 15 ?>px; }
	.single .post .entry-photo img, .single-post .entry-photo img  { width: <?php echo $single_thumb_size['w'] ?>px; height: <?php echo $single_thumb_size['h'] ?>px; }
	<?php
}

function arras_load_styles() {
	global $arras_registered_alt_layouts, $arras_registered_alt_styles;
	
	if ( !defined('ARRAS_INHERIT_LAYOUT') || ARRAS_INHERIT_LAYOUT == true ) {
		if ( count( $arras_registered_alt_layouts ) > 0 ) {
			$layout = ( defined( 'ARRAS_FORCE_LAYOUT' ) ) ? ARRAS_FORCE_LAYOUT : arras_get_option( 'layout' );
			wp_enqueue_style( 'arras-layout', get_template_directory_uri() . '/css/layouts/' . $layout . '.css', false, '2011-12-12', 'all' );
		}
	}
	
	if ( !defined('ARRAS_INHERIT_STYLES') || ARRAS_INHERIT_STYLES == true ) {
		$scheme = arras_get_option( 'style' );
		if ( !isset( $scheme ) ) $scheme = 'default';
	
		$css_path = '/css/styles/' . $scheme;
	
		if ( is_rtl() )
			$css_path .= '-rtl';
		
		wp_enqueue_style( 'arras', get_template_directory_uri() . $css_path . '.css', false, '2011-12-12', 'all' );
	}

	// add user css
	if ( !ARRAS_CHILD ) {
		wp_enqueue_style( 'arras-user', get_template_directory_uri() . '/user.css', false, '2011-12-12', 'all' ); 
	} else {
		if ( is_rtl() )
			wp_enqueue_style( 'arras-child', get_stylesheet_directory_uri() . '/rtl.css', false, '2011-12-12', 'all' );
		else
			wp_enqueue_style( 'arras-child', get_stylesheet_directory_uri() . '/style.css', false, '2011-12-12', 'all' );
	}
	
	// load other custom styles
	do_action( 'arras_load_styles' );
}

function arras_add_custom_background() {
	global $arras_custom_bg_options;
	
	if ( !isset( $arras_custom_bg_options ) )
		$arras_custom_bg_options = maybe_unserialize( get_option( 'arras_custom_bg_options' ) );
	
	if ( !$arras_custom_bg_options['enable'] )
		return false;
	
	if ( isset( $arras_custom_bg_options['id'] ) )
		$img = wp_get_attachment_image_src( $arras_custom_bg_options['id'], 'full' );
	
	if ($arras_custom_bg_options['wrap']) $css_class = 'body';
	else $css_class ='#wrapper';
	
	echo $css_class . '{ background: ';
	if ( isset( $img ) ) {
		echo ' url(' . $img[0] . ') ' . $arras_custom_bg_options['pos-x'] . ' ' . $arras_custom_bg_options['pos-y'] . ' ' . $arras_custom_bg_options['attachment'] . ' ' . $arras_custom_bg_options['repeat'] . ' ';
	}
	
	if ( isset( $arras_custom_bg_options['color'] ) )
		echo $arras_custom_bg_options['color'];
	
	echo ' !important; }';
	
	if ($arras_custom_bg_options['foreground']) {
		?>
		#main { background: url(<?php echo get_template_directory_uri() ?>/images/foreground.png) !important; }
		<?php
	}
}

/* End of file styles.php */
/* Location: ./library/styles.php */