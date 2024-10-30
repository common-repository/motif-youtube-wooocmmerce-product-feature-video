<?php 
	
/*
Plugin Name: Motif Youtube Wooocmmerce Product Feature Video
Plugin URI: http://Motifdev.com
Description: This Motif awesome plugin can add the youtube video as a feature thumbnail instead of picture.
Author: Motif Solutions
Version: 1.0.1
textdomain: motif-feature-video
Author URI: http://motif-solution.com/
Support: http://support@motifsolution.com
Developer: Motif Solutions
*/
	
//If not user for security purpose
if ( ! defined( 'ABSPATH' ) ) exit; 
	
//Exit if woocommerce not installed
if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	function motif_check_woocommerce() {

		// Deactivate the plugin
		deactivate_plugins(__FILE__);
		$error_message = __('<div class="error notice"><p>This plugin requires <a href="http://wordpress.org/extend/plugins/woocommerce/">WooCommerce</a> plugin to be installed and active!</p></div>', 'motif-feature-video');
		die($error_message);
	}

	add_action( 'motif_check_woocommerce', 'my_admin_notice' );
}
	
//Main class
class MOTIF_WOOCOMMERCE_FEATUREVIDEO_MAIN {
	       
    //constructor main class
    public function __construct() {

    	$this->module_constant();

    	add_action('wp_loaded', array($this, 'support_motif_settings_scripts'));

        add_action( 'add_meta_boxes', array($this,'product_video_url_add_meta_box' ));  

        add_action( 'wp_loaded', array($this,'motif_scripts'));

        add_action( 'save_post', array($this,'product_video_url_save' ));

        add_action( 'woocommerce_before_single_product', array($this,'bbloomer_show_video_not_image' ));

        if( is_admin() ) {
			require_once( motif_feature_video_plguin_dir.'motif-woo-youtube-feature-video-admin.php');
		}

		add_action( 'wp_ajax_motif_settingvideo', array($this,'motif_setting_saveing_callback' ));
		add_action( 'wp_ajax_nopriv_motif_settingvideo', array($this,'motif_setting_saveing_callback' ));
    }

     public function support_motif_settings_scripts() {

    	$allow_u_fullsrc = get_option('motif_allowfull_you');	
	 	if($allow_u_fullsrc !='') {
	 		$allow_u_fullsrc = get_option('motif_allowfull_you');	
	 	}else {
	 		$allow_u_fullsrc = ""; 
	 	}
			
		$u_autoplay = get_option('motif_autoplay_you');	
	 	if($u_autoplay !='') {
	 		$u_autoplay = get_option('motif_autoplay_you');	
	 	}else {
	 		$u_autoplay = "autoplay=0"; 
	 	}

	 	$u_controls = get_option('motif_controls_you');	
	 	if($u_controls !='') {
	 		$u_controls = get_option('motif_controls_you');	
	 	}else {
	 		$u_controls = "controls=0"; 
	 	}

	 	$u_related = get_option('motif_related_you');	
	 	if($u_related !='') {
	 		$u_related = get_option('motif_related_you');	
	 	}else {
	 		$u_related = "rel=0"; 
	 	}
			
		$u_title = get_option('motif_title_you');	
	 	if($u_title !='') {
	 		$u_title = get_option('motif_title_you');	
	 	}else {
	 		$u_title = "showinfo=0"; 
	 	}	
			
		$u_width = get_option('motif_wyou');	
	 	if($u_width !='') {
	 		$u_width = get_option('motif_wyou');	
	 	}else {
	 		$u_width = "420px"; 
	 	}	
			
		$u_hight = get_option('motif_hyou');	
	 	if($u_hight !='') {
	 		$u_hight = get_option('motif_hyou');	
	 	}else {
	 		$u_hight = "315px"; 
	 	}	

	 	$allow_v_fullsrc = get_option('motif_allowfull_vimo');	
	 	if($allow_v_fullsrc !='') {
	 		$allow_v_fullsrc = get_option('motif_allowfull_vimo');	
	 	}else {
	 		$allow_v_fullsrc = ""; 
	 	}	

	 	$motif_autoplay_vimo = get_option('motif_autoplay_vimo');	
	 	if($motif_autoplay_vimo !='') {
	 		$motif_autoplay_vimo = get_option('motif_autoplay_vimo');	
	 	}else {
	 		$motif_autoplay_vimo = ""; 
	 	}	

	 	$motif_hvimo = get_option('motif_hvimo');	
	 	if($motif_hvimo !='') {
	 		$motif_hvimo = get_option('motif_hvimo');	
	 	}else {
	 		$motif_hvimo = "315px"; 
	 	}

	 	$motif_wvimo = get_option('motif_wvimo');	
	 	if($motif_wvimo !='') {
	 		$motif_wvimo = get_option('motif_wvimo');	
	 	}else {
	 		$motif_wvimo = "420px"; 
	 	}

		$m_settings = array();

 		$m_settings['allow_u_fullsrc'] = $allow_u_fullsrc;  
 		$m_settings['u_autoplay'] = $u_autoplay;  
 		$m_settings['u_controls'] = $u_controls;   
 		$m_settings['u_related'] = $u_related;    
 		$m_settings['u_title'] = $u_title;    
 		$m_settings['u_width'] = $u_width;    
 		$m_settings['u_hight'] = $u_hight; 

 		$m_settings['allow_v_fullsrc'] = $allow_v_fullsrc; 
 		$m_settings['motif_autoplay_vimo'] = $motif_autoplay_vimo;
 		$m_settings['motif_hvimo'] = $motif_hvimo; 
 		$m_settings['motif_wvimo'] = $motif_wvimo;  


 		return $m_settings;
    }


	//extednon saving setting option
	function motif_setting_saveing_callback() {
		
		if(isset($_POST['condition']) && $_POST['condition'] == "setting_motif") {
		
			update_option( 'motif_allowshop_popup', $_POST['shop_popup'], null );

			update_option( 'motif_allowfull_you', sanitize_option($_POST['youtube_allwofullscr']), null );
			update_option( 'motif_autoplay_you', sanitize_option($_POST['youtube_auto']), null );
			update_option( 'motif_controls_you',sanitize_option( $_POST['youtube_controls']), null );
			update_option( 'motif_related_you', sanitize_option($_POST['youtube_related']), null );
			update_option( 'motif_title_you', sanitize_option($_POST['youtube_title']), null );
			update_option( 'motif_hyou', sanitize_option($_POST['you_hight']), null );
			update_option( 'motif_wyou', sanitize_option($_POST['you_width']), null );

			update_option( 'motif_allowfull_vimo', sanitize_option($_POST['vimeo_allwofullscr']), null );
			update_option( 'motif_autoplay_vimo', sanitize_option($_POST['vimeo_autoplay']), null );
			update_option( 'motif_hvimo', sanitize_option($_POST['vimo_hight']), null );
			update_option( 'motif_wvimo', sanitize_option($_POST['vimo_width']), null );

		}

		die();
	}


    // Add Meta in Product Page
    function product_video_url_add_meta_box() {
		
		add_meta_box(
			'product_video_url-product-video-url',
			__( 'Motif Product Video Url', 'motif-feature-video' ),
			array($this,'product_video_url_html'),
			'product',
			'normal'
			
		);
	
	}

	// Meta box html 
	function product_video_url_html( $post) {
		
		wp_nonce_field( '_product_video_url_nonce', 'product_video_url_nonce' ); 

		$video_type_motif = get_post_meta( $post->ID, 'motif_video_type', true ); 

		$youtube_video_motif = get_post_meta( $post->ID, 'moti_video_youtube', true );

		$dailymotion_video_motif = get_post_meta( $post->ID, 'moti_video_dailmotion', true );

		$vimo_video_motif = get_post_meta( $post->ID, 'moti_video_vimo', true );

		?>

		<!-- main heading -->
		<div class="main_head">
			
			<span><?php _e('Select Video Category', 'motif-feature-video'); ?></span>

			<select id="motif_video_type" name="motif_video_type">
				<option value="none"><?php _e('Select Video Thumbnail Type:', 'motif-feature-video'); ?></option>
				<option value="youtube" <?php selected( $video_type_motif, 'youtube' ); ?>><?php _e('Youtube', 'motif-feature-video'); ?></option>
				<option value="vimo" <?php selected( $video_type_motif, 'vimo' ); ?>><?php _e('Vimeo', 'motif-feature-video'); ?></option>
			</select>

		</div>

		<div class="sub_vidoe_section">
			
			<div id="youtube_featurevideo" class="youtube box">
			
				<div class="video-metabox-seting">
					
					<h3><?php _e('YouTube Video Metabox', 'motif-feature-video'); ?></h3>

					<p><?php _e('Adding video id only e.g <span style="color:red;">Cg7yetjr-c</span> which is after watch?v=', 'motif-feature-video'); ?></p>
					<label for="moti_video_youtube"><?php _e( 'Youtube Video Url', 'motif-feature-video' ); ?></label>
					<input type="text" name="moti_video_youtube" id="moti_video_youtube" value="<?php echo get_post_meta( $post->ID, 'moti_video_youtube', true ); ?>">
				
				</div >
				
				<div class="video-metabox-seting">
					
					<?php if(!empty($youtube_video_motif)) { ?>

						<iframe width="150" height="150" src="https://www.youtube.com/embed/<?php echo $youtube_video_motif ?>" frameborder="0" allowfullscreen></iframe>

					<?php } ?>
				
				</div>

			</div>	

			<div id="vimo_featurevideo" class="vimo box">
			
				<div class="video-metabox-seting">

					<h3><?php _e('Vimeo Video Metabox', 'motif-feature-video'); ?></h3>

					<p><?php _e('Adding video id only e.g <span style="color:red;">34423456</span> which is after vimeo.com/video/', 'motif-feature-video'); ?></p>

					<label for="moti_video_vimo"><?php _e( 'Vimeo Video Id', 'motif-feature-video' ); ?></label>
					<input type="text" name="moti_video_vimo" id="moti_video_vimo" value="<?php echo get_post_meta( $post->ID, 'moti_video_vimo', true ); ?>">
				</div>
				
				<div class="video-metabox-seting">

					<?php if(!empty($vimo_video_motif)) { ?>

						<iframe src="https://player.vimeo.com/video/<?php echo $vimo_video_motif; ?>" width="150" height="150" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>

					<?php } ?>

				</div>	

			</div>

		</div>

		<script>
			jQuery(document).ready(function(){
			    jQuery("#motif_video_type").change(function(){
			        jQuery(this).find("option:selected").each(function(){
			            if(jQuery(this).attr("value")=="youtube"){
			                jQuery(".box").not(".youtube").hide();
			                jQuery(".youtube").show();
			            }
			            else if(jQuery(this).attr("value")=="youtube"){
			                jQuery(".box").not(".youtube").hide();
			                jQuery(".youtube").show();
			            }
			            else if(jQuery(this).attr("value")=="vimo"){
			                jQuery(".box").not(".vimo").hide();
			                jQuery(".vimo").show();
			            }
			            else{
			                jQuery(".box").hide();
			            }
			        });
			    }).change();
			});
		</script>

		<?php

	}

	// Saving meta box information
	function product_video_url_save( $post_id ) {
		
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		if ( ! isset( $_POST['product_video_url_nonce'] ) || ! wp_verify_nonce( $_POST['product_video_url_nonce'], '_product_video_url_nonce' ) ) return;
		if ( ! current_user_can( 'edit_post', $post_id ) ) return;


		if( isset( $_POST['motif_video_type']) && !empty($_POST['motif_video_type'])) :
			update_post_meta( $post_id, 'motif_video_type',sanitize_text_field( $_POST['motif_video_type'] ) );
		endif;

		if( isset( $_POST['moti_video_youtube']) && !empty($_POST['moti_video_youtube'])) :
			update_post_meta( $post_id, 'moti_video_youtube',sanitize_text_field( $_POST['moti_video_youtube'] ) );
		endif;

		if( isset( $_POST['moti_video_vimo']) && !empty($_POST['moti_video_vimo'])) :
			update_post_meta( $post_id, 'moti_video_vimo',sanitize_text_field( $_POST['moti_video_vimo'] ) );
		endif;
	
	}

	// removing thumbnail and adding vidoes  
	function bbloomer_show_video_not_image() {
	  	
	  	global $product;
	 	
	 	$id = $product->get_id();
		
		$motif_videourlyoutube = get_post_meta( $id, 'moti_video_youtube', true );

		$motif_videourlvimo = get_post_meta( $id, 'moti_video_vimo', true );

		$motif_videourldaily = get_post_meta( $id, 'moti_video_dailmotion', true );

		$motif_videotype = get_post_meta( $id, 'motif_video_type', true );

		if(!empty($motif_videourlyoutube) && ($motif_videotype == 'youtube')  ) {
			
			if ( is_single() ) {
			 
			remove_action( 'woocommerce_before_single_product_summary','woocommerce_show_product_images', 20 );
			remove_action( 'woocommerce_product_thumbnails','woocommerce_show_product_thumbnails', 20 );
			add_action( 'woocommerce_before_single_product_summary', array($this,'bbloomer_show_product_youtube'), 20 );
			
			}
		}

		if(!empty($motif_videourlvimo) && ($motif_videotype == 'vimo')  ) {
			
			if ( is_single() ) {
			 
			remove_action( 'woocommerce_before_single_product_summary','woocommerce_show_product_images', 20 );
			remove_action( 'woocommerce_product_thumbnails','woocommerce_show_product_thumbnails', 20 );
			add_action( 'woocommerce_before_single_product_summary', array($this,'bbloomer_show_product_vimo'), 20 );
			
			}
		}
	}

	// adding video for spacfic product youtube
	function bbloomer_show_product_youtube() {

		global $product;
  		
  		$motif_videourl = get_post_meta( $product->get_id(), 'moti_video_youtube', true );
		$setings = $this->support_motif_settings_scripts();
		?>


		<div class="woocommerce-product-gallery">
		 
			<iframe width="<?php echo $setings['u_width']; ?>" height="<?php echo $setings['u_hight']; ?>" src="https://www.youtube.com/embed/<?php echo $motif_videourl.'?'.$setings['u_controls'].'&'.$setings['u_related'].'&'.$setings['u_autoplay'].'&'.$setings['u_title']; ?>" frameborder="0" <?php echo ($setings['allow_u_fullsrc']) ? 'allowfullscreen' : "" ?> ></iframe>

		</div>

	<?php }


	// adding video for spacfic product vimo
	function bbloomer_show_product_vimo() {

		global $product;
  		
  		$motif_videourl = get_post_meta( $product->get_id(), 'moti_video_vimo', true ); 
		$setings = $this->support_motif_settings_scripts();
  		?>

		<div class="woocommerce-product-gallery">

			<iframe src="https://player.vimeo.com/video/<?php echo $motif_videourl.'?'.$setings['motif_autoplay_vimo']; ?>" width="<?php echo $setings['motif_wvimo']; ?>" height="<?php echo $setings['motif_hvimo']; ?>" <?php echo ($setings['allow_v_fullsrc']) ? 'allowfullscreen' : "" ?>></iframe>


		</div>

	<?php }

	//module constant 
	public function module_constant() {

		if ( !defined( 'motif_feature_video_url' ) )
	    define( 'motif_feature_video_url', plugin_dir_url( __FILE__ ) );

	    if ( !defined( 'motif_feature_video_basename' ) )
	    define( 'motif_feature_video_basename', plugin_basename( __FILE__ ) );

	    if ( ! defined( 'motif_feature_video_plguin_dir' ) )
	    define( 'motif_feature_video_plguin_dir', plugin_dir_path( __FILE__ ) );
	}

	// scripts 
	public function motif_scripts() { 

		wp_enqueue_script('jquery');

		wp_enqueue_style( 'motif_styles-css', plugins_url( 'Asset/style.css', __FILE__ ), false );

		if ( function_exists( 'load_plugin_textdomain' ) )
		load_plugin_textdomain( 'motif-feature-video', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	} 


} new MOTIF_WOOCOMMERCE_FEATUREVIDEO_MAIN();



