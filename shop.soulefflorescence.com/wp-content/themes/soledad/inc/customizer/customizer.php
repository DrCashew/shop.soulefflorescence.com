<?php
/**
 * Register theme options in the Customizer
 */
class Penci_Soledad_Customizer {
	/**
	 * Add hooks for customizer
	 */
	public function __construct() {
		add_action( 'customize_register', array( $this, 'register' ) );
		add_action('customize_register', array( $this, 'move_settings' ), 30);
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue' ) );
	}


	/**
	 * Register customizer settings
	 * @param WP_Customize_Manager $wp_customize WordPress customizer manager instance
	 */
	public function register(WP_Customize_Manager $wp_customize) {
		
		require_once get_template_directory() . '/inc/customizer/custom-controls/range-slider.php';
		

		$wp_customize->register_control_type( 'Penci_Range_Slider_Control' );
		
		
		// Register Panels
		require_once get_template_directory() . '/inc/customizer/options/00-panels.php';
		
		// Theme option sections
		require_once get_template_directory() . '/inc/customizer/options/01-general.php';
		require_once get_template_directory() . '/inc/customizer/options/02-topbar.php';
		require_once get_template_directory() . '/inc/customizer/options/03-logo-header.php';
		require_once get_template_directory() . '/inc/customizer/options/04-verticalnav-hamburger.php';
		require_once get_template_directory() . '/inc/customizer/options/05-homepage.php';
		require_once get_template_directory() . '/inc/customizer/options/06-featured-slider.php';
		require_once get_template_directory() . '/inc/customizer/options/07-featured-video.php';
		require_once get_template_directory() . '/inc/customizer/options/08-post-layouts.php';
		require_once get_template_directory() . '/inc/customizer/options/09-sidebar.php';
		require_once get_template_directory() . '/inc/customizer/options/10-single-post.php';
		require_once get_template_directory() . '/inc/customizer/options/11-pages-options.php';
		require_once get_template_directory() . '/inc/customizer/options/12-footer.php';
		require_once get_template_directory() . '/inc/customizer/options/13-social-media.php';
		require_once get_template_directory() . '/inc/customizer/options/14-text-translation.php';
		
		if( class_exists( 'Penci_Soledad_Optimization_General' ) ){
			require_once get_template_directory() . '/inc/customizer/custom-controls/button.php';
			$wp_customize->register_control_type( 'Penci_Custom_Button_Control' );
			require_once get_template_directory() . '/inc/customizer/options/15-speed-optimization.php';
		}
		
		if ( class_exists( 'Penci_Soledad_Portfolio_Shortcode' ) ) {
			require_once get_template_directory() . '/inc/customizer/options/portfolio.php';
		}
		
		if ( class_exists( 'WooCommerce' ) ) {
			require_once get_template_directory() . '/inc/customizer/options/woocommerce.php';
		}
		
		require_once get_template_directory() . '/inc/customizer/options/custom-css.php';
	}

	/**
	 * Move default WordPress settings into Theme Options for better organization.
	 *
	 * @param WP_Customize_Manager $wp_customize WordPress customizer manager instance
	 */
	public function move_settings($wp_customize) {
		// Remove Sections
		$wp_customize->remove_section( 'title_tagline' );
		$wp_customize->remove_section( 'nav' );
		$wp_customize->remove_section( 'static_front_page' );
		$wp_customize->remove_section( 'colors' );
		$wp_customize->remove_section( 'background_image' );
	}
	
	/**
	 * Enqueue script for customizer control
	 */
	public function enqueue(){
		wp_enqueue_style( 'penci-customizer', get_template_directory_uri() . '/inc/customizer/css/customizer.css' );
	}
}

new Penci_Soledad_Customizer;


/**
 * Change customizer preview width
 *
 */
if( ! function_exists( 'pencidesign_customizer_devices_preview_width' ) ){
	add_action( 'customize_controls_print_styles', 'pencidesign_customizer_devices_preview_width' );
	function pencidesign_customizer_devices_preview_width() {
		/* We add a filter to help you can modify it by use a hook */
		$sizes = apply_filters( 'pencidesign_customize_preview_width', array(
			'tablet' => 767,
			'mobile' => 414,
			'mobile_height' => 736,
		) );
		?>
			<style>
				.wp-customizer .preview-tablet .wp-full-overlay-main {
					width: <?php echo absint( $sizes['tablet'] ); ?>px;
					margin-left: 0;
					margin-right: 0;
					left: 50%;
					-webkit-transform: translateX(-50%);
					transform: translateX(-50%);
				}
				.wp-customizer .preview-mobile .wp-full-overlay-main {
					width: <?php echo absint( $sizes['mobile'] ); ?>px;
					height: <?php echo absint( $sizes['mobile_height'] ); ?>px;
					margin-left: 0;
					margin-right: 0;
					left: 50%;
					-webkit-transform: translateX(-50%);
					transform: translateX(-50%);
				}
				.rtl.wp-customizer .preview-tablet .wp-full-overlay-main,
				.rtl.wp-customizer .preview-mobile .wp-full-overlay-main {
					-webkit-transform: translateX(50%);
					transform: translateX(50%);
				}
			</style>
		<?php
	}
}