<?php 
//If not user for security purpose
if ( ! defined( 'ABSPATH' ) ) exit; 

//admin class
class MOTIF_WOOCOMMERCE_FEATUREVIDEO_ADMIN extends MOTIF_WOOCOMMERCE_FEATUREVIDEO_MAIN {
	       
    //constructor main class
    public function __construct() { 

    	add_action('admin_menu', array($this, 'motif_feature_video_pages'));

    	add_action('wp_loaded', array($this, 'support_admin_motif_scripts'));

    	add_action( 'wp_ajax_support_motif_contact', array($this,'support_motif_callback' ));
		add_action( 'wp_ajax_nopriv_support_motif_contact', array($this,'support_motif_callback' ));

    }

    // adding menu and submenu pages
	public function motif_feature_video_pages() {

		add_menu_page(
            'Mofit Settings', __('Motif Settings', 'motif-feature-video'), 'manage_options','motif-support',
	            array($this,'motif_admin_setting_callback'),
            		motif_feature_video_url.'img/motif-menu-cion.png', 10
        );
        
        add_submenu_page('motif-support', 'Support', __('Support', 'motif-feature-video'), 'manage_options', 'motif-settings', array($this,'motif_feature_video_support_callback' ));
	}

	function motif_admin_setting_callback() { ?>
	    
		<div id="extedndons-tabs">

			<div class="motif-tabs-ulli">
				
				<div class="motif-logo-ui">
					<div class="motif_logo"><?php _e('Plugin Options - Powered by Motif Group', 'motif-feature-video'); ?></div>
				</div>

				<ul class="motif_tab_ul">

			        <li>
			            <a href="#m_youtube">
			            	<span class="dashicons dashicons-video-alt3"></span>
			            	<?php _e('Youtube Settings', 'motif-feature-video'); ?></a>
			        </li>
			        <li>
			            <a href="#m_vimo">
			            	<span class="dashicons dashicons-format-video"></span>
			            	<?php _e('Vimeo Settings', 'motif-feature-video'); ?></a>
			        </li>
			        
				</ul>
			
			</div>
			 
			<div class="motif-tabs-content">
				
				<!-- form starts from here -->
				<form id="motiffaq_setting_optionform" action="" method="">

				<div class="motif-top-content">
					
					<h1><?php _e('Motif Feature Video Woocommerce Plugin.', 'motif-feature-video'); ?></h1>

					<div id="option-success"><p><?php _e('Settings Saved!', 'motif-feature-video'); ?></p></div>
					
					<div class="motif-support-actions">
			
						<div class="actions motif-submit">
							<span id="motif-spinner"></span>
							<input onclick="motifsettopt()" class="button button-primary" type="button" name="" value="<?php _e('Save Changes', 'motif-feature-video') ?>">
							<?php wp_nonce_field(); ?>
						</div>
					</div>

				</div>

				<div class="motif-singletab" id="m_youtube">
					
					<h2><?php _e('Youtube Settings', 'motif-feature-video'); ?></h2>
					
					<table class="motif-table-optoin">
						
						<tbody>

							<!-- Allow FullScreen to video -->
							<tr class="motif-option-field">
								<th>
									<div class="option-head">
										<h3><?php _e('Allow FullScreen Play', 'motif-feature-video'); ?></h3>
									</div>
									<span class="description">
										<p><?php _e('Check to hide full screen Video option', 'motif-feature-video'); ?></p>
									</span>
								</th>
								<td>
									<p class="onoff">
										<input <?php echo checked( get_option('motif_allowfull_you'), '1') ?> name="autoplay" type="checkbox" id="fullscreen_you"><label for="fullscreen_you"></label>
									</p>
								</td>
							</tr>


							<!-- Auto play video -->
							<tr class="motif-option-field">
								<th>
									<div class="option-head">
										<h3><?php _e('Auto Play', 'motif-feature-video'); ?></h3>
									</div>
									<span class="description">
										<p><?php _e('Check to Autoplay Video on Product Single Page when your vist', 'motif-feature-video'); ?></p>
									</span>
								</th>
								<td>
									<p class="onoff">
										<input <?php echo checked( get_option('motif_autoplay_you'), 'autoplay=1') ?> name="autoplay" type="checkbox" id="checkboxID"><label for="checkboxID"></label>
									</p>
								</td>
							</tr>

							<!-- Controls video -->
							<tr class="motif-option-field">
								<th>
									<div class="option-head">
										<h3><?php _e('Show Video Controls', 'motif-feature-video'); ?></h3>
									</div>
									<span class="description">
										<p><?php _e('Hide Or Show video Controls in Single Page', 'motif-feature-video'); ?></p>
									</span>
								</th>
								<td>
									<p class="onoff">
										<input <?php echo checked( get_option('motif_controls_you'), 'controls=1') ?> name="autoplay" type="checkbox" id="myoucontrls"><label for="myoucontrls"></label>
									</p>
								</td>
							</tr>

							<!-- Show related video -->
							<tr class="motif-option-field">
								<th>
									<div class="option-head">
										<h3><?php _e('Show Related Videos', 'motif-feature-video'); ?></h3>
									</div>
									<span class="description">
										<p><?php _e('Show related video at the end of video', 'motif-feature-video'); ?></p>
									</span>
								</th>
								<td>
									<p class="onoff">
										<input <?php echo checked( get_option('motif_related_you'), 'rel=0') ?> name="autoplay" type="checkbox" id="myurelated"><label for="myurelated"></label>
									</p>
								</td>
							</tr>

							<!-- Show title video -->
							<tr class="motif-option-field">
								<th>
									<div class="option-head">
										<h3><?php _e('Show title on Videos', 'motif-feature-video'); ?></h3>
									</div>
									<span class="description">
										<p><?php _e('Show/Hide video title on videos..?', 'motif-feature-video'); ?></p>
									</span>
								</th>
								<td>
									<p class="onoff">
										<input <?php echo checked( get_option('motif_title_you'), 'showinfo=0') ?> name="autoplay" type="checkbox" id="myutitle"><label for="myutitle"></label>
									</p>
								</td>
							</tr>

							<!-- Height of youtube -->
							<tr class="motif-option-field">
								<th>
									<div class="option-head">
										<h3><?php _e('Height of youtube frame', 'motif-feature-video'); ?></h3>
									</div>
									<span class="description">
										<p><?php _e('Youtube Video Frame height in pixels (300px)', 'motif-feature-video'); ?></p>
									</span>
								</th>
								<td>
									<input value="<?php echo get_option('motif_hyou'); ?>" id="motif_you_h" class="motif-input-field" type="text">
								</td>
							</tr>

							<!-- Width of youtube -->
							<tr class="motif-option-field">
								<th>
									<div class="option-head">
										<h3><?php _e('Width of youtube frame', 'motif-feature-video'); ?></h3>
									</div>
									<span class="description">
										<p><?php _e('Youtube Video Frame Width in pixels (300px)', 'motif-feature-video'); ?></p>
									</span>
								</th>
								<td>
									<input value="<?php echo get_option('motif_wyou'); ?>" id="motif_you_w" class="motif-input-field" type="text">
								</td>
							</tr>

							<tr class="submit-motif motif-option-field">
								<th></th>
								<td>
									<div class="actions motif-submit">
										<input onclick="motifsettopt()" class="button button-primary" type="button" name="" value="<?php _e('Save Changes', 'motif-feature-video'); ?>">
									</div>
								</td>
							</tr>

						</tbody>

					</table>
				
				</div>

				<div class="motif-singletab" id="m_vimo">
					
					<h2><?php _e('Vimeo Settings', 'motif-feature-video'); ?></h2>
					
					<table class="motif-table-optoin">
						
						<tbody>

							<!-- Allow FullScreen to video -->
							<tr class="motif-option-field">
								<th>
									<div class="option-head">
										<h3><?php _e('Allow FullScreen Play', 'motif-feature-video'); ?></h3>
									</div>
									<span class="description">
										<p><?php _e('Check to hide full screen vimeo Video option', 'motif-feature-video'); ?></p>
									</span>
								</th>
								<td>
									<p class="onoff">
										<input <?php echo checked( get_option('motif_allowfull_vimo'), '1') ?> name="autoplay" type="checkbox" id="fullscreen_vimo"><label for="fullscreen_vimo"></label>
									</p>
								</td>
							</tr>

							<!-- Allow autoplay to video -->
							<tr class="motif-option-field">
								<th>
									<div class="option-head">
										<h3><?php _e('Vimeo Auto Play Video', 'motif-feature-video'); ?></h3>
									</div>
									<span class="description">
										<p><?php _e('Check to Autoplay vimeo video', 'motif-feature-video'); ?></p>
									</span>
								</th>
								<td>
									<p class="onoff">
										<input <?php echo checked( get_option('motif_autoplay_vimo'), 'autoplay=1') ?> name="autoplay" type="checkbox" id="autoplay_vimo"><label for="autoplay_vimo"></label>
									</p>
								</td>
							</tr>

							<!-- Width of youtube -->
							<tr class="motif-option-field">
								<th>
									<div class="option-head">
										<h3><?php _e('Width of vimeo frame', 'motif-feature-video'); ?></h3>
									</div>
									<span class="description">
										<p><?php _e('Vimeo Video Frame Width in pixels (300px)', 'motif-feature-video'); ?></p>
									</span>
								</th>
								<td>
									<input value="<?php echo get_option('motif_wvimo'); ?>" id="motif_vimo_w" class="motif-input-field" type="text">
								</td>
							</tr>

							<!-- Width of youtube -->
							<tr class="motif-option-field">
								<th>
									<div class="option-head">
										<h3><?php _e('Height of vimeo frame', 'motif-feature-video'); ?></h3>
									</div>
									<span class="description">
										<p><?php _e('Vimeo Video Frame Height in pixels (300px)', 'motif-feature-video'); ?></p>
									</span>
								</th>
								<td>
									<input value="<?php echo get_option('motif_hvimo'); ?>" id="motif_vimo_h" class="motif-input-field" type="text">
								</td>
							</tr>

							<tr class="submit-motif motif-option-field">
								<th></th>
								<td>
									<div class="actions motif-submit">
										<input onclick="motifsettopt()" class="button button-primary" type="button" name="" value="<?php _e('Save Changes', 'motif-feature-video'); ?>">
									</div>
								</td>
							</tr>

						</tbody>

					</table>
				
				</div>
			
				</form>


			</div>
		
		</div>

		<script type="text/javascript">
			jQuery( function() {
				jQuery('#extedndons-tabs').tabs().addClass('ui-tabs-vertical ui-helper-clearfix');
			});

			// ajax function for submitting setting option
		  	function motifsettopt() {
		  		
				var ajaxurl = "<?php echo admin_url( 'admin-ajax.php'); ?>";
				// jQuery("html, body").animate({ scrollTop: 0 }, 600);
				var condition = 'setting_motif';

				var youtube_allwofullscr = jQuery("#fullscreen_you").prop('checked')?1:0;
				var youtube_auto = jQuery("#checkboxID").prop('checked')?'autoplay=1':'';
				var youtube_controls = jQuery("#myoucontrls").prop('checked')?'controls=1':'';
				var youtube_related= jQuery("#myurelated").prop('checked')?'rel=1':'';
				var youtube_title= jQuery("#myutitle").prop('checked')?'showinfo=1':'';
				var you_hight = jQuery('#motif_you_h').val();
				var you_width = jQuery('#motif_you_w').val();

				var vimeo_allwofullscr = jQuery("#fullscreen_vimo").prop('checked')?1:0;
				var vimeo_autoplay = jQuery("#autoplay_vimo").prop('checked')?'autoplay=1':0;
				var vimo_hight = jQuery('#motif_vimo_h').val();
				var vimo_width = jQuery('#motif_vimo_w').val();

				jQuery('#motif-spinner').show();
				
				jQuery.ajax({
					url : ajaxurl,
					type : 'post',
					data : {
						action : 'motif_settingvideo',
						
						condition : condition,

						youtube_allwofullscr : youtube_allwofullscr,
						youtube_auto : youtube_auto,
						youtube_controls : youtube_controls,
						youtube_related : youtube_related,
						youtube_title : youtube_title,
						you_hight : you_hight,
						you_width : you_width,

						vimeo_allwofullscr : vimeo_allwofullscr,
						vimeo_autoplay : vimeo_autoplay,
						vimo_hight : vimo_hight,
						vimo_width : vimo_width,

					},
					success : function(response) {
						jQuery("#option-success").show().delay(3000).fadeOut("slow");
					},
					complete: function(){
					    jQuery('#motif-spinner').hide();
					}
				});
		  	}

		</script>

	<?php }
	


	// motif support
	public function motif_feature_video_support_callback() { ?>
         
        <div class="wrap motif-support">
			
			<div class="motif_pageTitle  ">
        		<h1 class="pageTitle-heading"><?php _e('Welcome to Motif Support</h1><p class="pageTitle-intro">We’re here to help.', 'motif-feature-video'); ?></p>
        	</div>

			<div class="about-text"><?php _e('Get additional customization coverage and support from Motif, we are the people who know your Motif products best. Find out if your product is still in issue or learn more about purchasing Motif products.', 'motif-feature-video'); ?> 
			</div>
			
			
			<div class="motif-support-form">
				
				<h5 id="motif_sup_success"><?php _e('Your message has been successfully sent. We will contact you very soon!', 'motif-feature-video'); ?></h5>

				<form id="motif-support-form" class="cf">
				  <div class="half left cf">
				    <input type="text" id="input-name" placeholder="<?php _e('Name', 'motif-feature-video');?>">
				    <input data-parsley-required type="email" id="input-email" placeholder="<?php _e('Email Address', 'motif-feature-video');?>">
				    <input type="text" id="input-subject" placeholder="<?php _e('Subject', 'motif-feature-video');?>">
				  </div>
				  <div class="half right cf">
				    <textarea data-parsley-required name="message" type="text" id="input-message" placeholder="<?php _e('Message', 'motif-feature-video');?>"></textarea>
				  </div>  
				  <input type="button" id="input-submit" value="Submit" onclick="motifupport()">
				</form>

				<div class="motif-socials">
					<ul class="motif-social-left">
						<li>
							<a target="_blank" href="javascript:void();">
								<img src="<?php echo motif_feature_video_url.'img/motif-fb.png'; ?>">
							</a>
						</li>
						<li>
							<a target="_blank" href="javascript:void();">
								<img src="<?php echo motif_feature_video_url.'img/motif-google.png'; ?>">
							</a>
						</li>
						<li>
							<a target="_blank" href="javascript:void();">
								<img src="<?php echo motif_feature_video_url.'img/motif-logo.png'; ?>">
							</a>
						</li>
						<li>
							<a target="_blank" href="javascript:void();">
								<img src="<?php echo motif_feature_video_url.'img/motif-twi.png'; ?>">
							</a>
						</li>
						<li>
							<a target="_blank" href="javascript:void();">
								<img src="<?php echo motif_feature_video_url.'img/motif-link.png'; ?>">
							</a>
						</li>
					</ul>
				</div>

			</div>
			
		</div>
    	
    	<script type="text/javascript">
			
			function motifupport() { 
				
				jQuery('#motif-support-form').parsley().validate();	
				
				var ajaxurl = "<?php echo admin_url( 'admin-ajax.php'); ?>";

				var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
				
				var condition = 'motif_support_contact';
				var motif_username = jQuery('#input-name').val();
				var motif_useremail = jQuery('#input-email').val();
				var motif_message = jQuery('#input-message').val();
				var motif_subject = jQuery('#input-subject').val();
			
				if(motif_username == '' && motif_useremail == '' && motif_message == '' && motif_subject == '') {
					return false;
				}else if (motif_message == '') { 
					return false;
				}else if (!pattern.test(motif_useremail)) {
					return false;
				}else {

					jQuery.ajax({
						url : ajaxurl,
						type : 'post',
						data : {
							action : 'support_motif_contact',
							condition : condition,
							motif_username : motif_username,
							motif_useremail : motif_useremail,
							motif_message : motif_message,
							motif_subject : motif_subject,		

						},
						success : function(response) {
							jQuery('#motif_sup_success').show().delay(3000).fadeOut();
							jQuery('#motif-support-form').each(function() {
								this.reset(); 
							});
						}
					});
				}
			}

		</script>


    <?php }

    // motif support callback email function
    function support_motif_callback () {
		
		if(isset($_POST['condition']) && $_POST['condition'] == "motif_support_contact") {

			$suppextemail = sanitize_email($_POST['motif_useremail']);
			$support_subject = sanitize_text_field($_POST['motif_subject']);
			$support_message = sanitize_text_field($_POST['motif_message']);
			$suppextfname = sanitize_text_field($_POST['motif_username']);
		
			$to = "Motifdev@gmail.com";
			$subject = $support_subject;
			
			$admin_emailsup = get_option('admin_email');

			$message = "
			<html>
			<head>
			<title>Motif Support Email (Product Inquiry)</title>
			</head>
			<body>
			<p>This email contains HTML Tags!</p>
			<table>
			<tr>
			<th>User Information</th>
			<th>Message</th>
			</tr>
			<tr>
			<td>Dear Motif Admin a user name with $suppextfname and email with ($suppextemail)</td>
			<td>Have some query regarding Porduct inquiry Woo extension, Message is $support_message</td>
			</tr>
			</table>
			</body>
			</html>
			";

			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";

			// More headers
			$headers .= 'From: <'.$admin_emailsup.'>' . "\r\n";

			mail($to,$subject,$message,$headers);

		}

		die();
	}


    //admin init function
	function support_admin_motif_scripts() { 
		
		wp_enqueue_script('jquery');

		wp_enqueue_script('jquery-ui-tabs');	

		wp_enqueue_script('parsley-js', plugins_url( 'Asset/parsley.min.js', __FILE__ ), false );

		wp_enqueue_style('parsley-css', plugins_url( 'Asset/parsley.css', __FILE__ ), false );

		wp_enqueue_style('backend-css', plugins_url( 'Asset/back-style.css', __FILE__ ), false );

	} 

} new MOTIF_WOOCOMMERCE_FEATUREVIDEO_ADMIN();

