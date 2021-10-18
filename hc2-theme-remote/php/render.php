<?php
   
	if ( ! defined( 'ABSPATH' ) ) exit;



		
	function hc2_unrender( $post_id ) {	
		hc2_curl_get_contents( rtrim( get_option( 'hc2_production_url' ), '/' ).'/remote_render.php', array( 
			'auth' => 'IJDF#(*hj29g()I*%@)_(JGO', 
			'deleteurl' => 1, 
			'url' => urlencode(get_post_meta($post_id,'hc2_post_permalink',1))
		)); 
		update_post_meta( $post_id, 'hc2_post_rendered', 0 );

		return 'success';
	}

	add_action ('transition_post_status', 'hc2_transition_post_status' , 3, 3); 
	function hc2_transition_post_status ($new_status, $old_status, $post) {

		if (($old_status == 'future') && ($new_status == 'publish')) {
			hc2_render($post->ID);
		}
	}

	function hc2_render($post_id,$count=true){

		$post = get_post($post_id);
		if( in_array($post->post_type,['page','post','web-story']) && strpos( get_permalink($post_id), '?' ) === false ){
			update_post_meta( $post_id, 'hc2_post_permalink', get_permalink($post_id) );
			update_post_meta( $post_id, 'hc2_post_rendered', 1 );
			update_post_meta( $post_id,'hc2_pushed', date('Y-m-d H:i:s') );
			hc2_curl_get_contents( rtrim( get_option( 'hc2_production_url' ), '/' ).'/remote_render.php', array( 
				'auth' => 'IJDF#(*hj29g()I*%@)_(JGO', 
				'push' => 1, 
				'redirs' => urlencode(get_option('hcube_redirects')), 
				'url' => urlencode(get_permalink($post_id)), 
				'prod' => urlencode(rtrim( get_option( 'hc2_production_url' ), '/' )), 
				'src' => urlencode( hc2_sanitize_url(get_site_url( ) ))
			)); 

		}

		return 'success';
	}
