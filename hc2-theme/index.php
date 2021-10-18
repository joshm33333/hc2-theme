<?php

add_filter('show_admin_bar', '__return_false');
get_header();  ?>

	<body <?php body_class(); ?>> <?php wp_body_open(); ?>
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WXN3R4G" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<div id='h' class='h hcube-content'>
			<?php 
			    if(get_post_meta(get_the_ID(),'hc2_forced_nav',true))echo $content = do_shortcode( apply_filters( 'the_content', get_post_meta(get_the_ID(),'hc2_forced_nav',true) ));
				if(!get_post_meta(get_the_ID(),'hc2_stop_head',true) && get_hc2('settings','global_header_id'))echo $content = do_shortcode( apply_filters( 'the_content', get_the_content(null,null,get_hc2('settings','global_header_id')) ));
				while ( have_posts() ) : the_post(); the_content(); endwhile; 
				if(get_post_meta(get_the_ID(),'hc2_forced_footer',true))echo $content = do_shortcode( apply_filters( 'the_content', get_post_meta(get_the_ID(),'hc2_forced_footer',true) ));
				if(!get_post_meta(get_the_ID(),'hc2_stop_foot',true) && get_hc2('settings','global_footer_id'))echo $content = do_shortcode( apply_filters( 'the_content', get_the_content(null,null,get_hc2('settings','global_footer_id')) ));
				
				if ( !get_post_meta(get_the_ID(),'hc2_stop_chat',true) && get_hc2('settings','facebook_chat') ){
					?>
						<script async custom-element="amp-facebook-page" src="https://cdn.ampproject.org/v0/amp-facebook-page-0.1.js"></script>
						<amp-lightbox layout="nodisplay" id='hcube_chatcontainer' class='hcube_chatcontainer'>
							<div class='hcube_chatbox'>
								<button on="tap:hcube_chatcontainer.close">Close</button>
								<amp-facebook-page 
									width="280px" 
									height="520px" 
									layout="fixed" 
									data-href="<?php echo get_hc2('settings','facebook_chat'); ?>" 
									data-adapt-container-width="true" 
									data-show-facepile="true" 
									data-hide-cover="false" 
									data-small-header="true" 
									data-tabs="messages" 
									data-width="280px" 
									data-height="520px">
								</amp-facebook-page>
								<?php echo do_shortcode( (get_hc2('settings','facebook_chat_text')?get_hc2('settings','facebook_chat_text'):"<p>Don't have Facebook?</p><p>Call us at [hc2 get=telephone type=tel]</p>") ); ?>
							</div>
						</amp-lightbox>
						<div class='chatbutton_container'><button on="tap:hcube_chatcontainer" class='hcube_chatbutton'>Chat with us!</button></div>
					<?php
				}
			?>
					
			<script async custom-element="amp-consent" src="https://cdn.ampproject.org/v0/amp-consent-0.1.js"></script>
			<amp-consent layout="nodisplay" id="consent-element">
				<script type="application/json">
				  {
					"consents": {
					  "my-consent": {
						"checkConsentHref": "<?php echo get_site_url().'/wp-json/hc2/v1/hc2_consent/'; ?>",
						"promptUI": "consent-ui"
					  }
					}
				  }
				</script>
				<div id="consent-ui">
					<div>
						<?php echo get_option('hc2_consent_content'); ?>
					</div>
					<button on="tap:consent-element.accept" role="button">Accept</button>
				</div>
			</amp-consent>
			<?php echo do_shortcode( get_option('hc2_pinned_content') ); ?>
			<div id='hc2_accessarea'></div>
		</div>
			
	</body>
	
<?php wp_footer(); ?>

</html>


