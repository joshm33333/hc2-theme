<?php
   
	if ( ! defined( 'ABSPATH' ) ) exit;
	
	remove_filter('the_content', 'wptexturize');
	
			function hc2_php_decode_array(){
				return array(
					'＜'=>'<',
					'＞'=>'>',
					'【' =>'[',
					'】' =>']',
					'″' => '"',
					'”' => '"',
					'”' => '"',
					'“' => '"',
					'‘' => "'",
					'’' => "'"
				);
			}
				
			function hc2_php_decode($script){
				$arr = hc2_php_decode_array();
				foreach( $arr as $old => $new )
					$script = str_replace( $old, $new, $script );
				return  html_entity_decode($script);
			}
		
			function hc2_return_php($content){
				if( get_post_meta( get_post()->ID, 'hc2_post_mode', true ) != 'php' ) return hc2_eval( hc2_php_decode($content) );
				return "＜?php ".hc2_php_decode($content)." ?＞";
			}
			
	add_action( 'get_header', 'hc2_get_header', -50 );
	function hc2_get_header(){
		$post_id = get_the_ID();
		$post = get_post($post_id);
		if( !is_admin() && $post_id && in_array($post->post_type,['page','post']) ){
			$donotcontain = [ 'preview=true', 'admin-ajax.php', 'nav-menus.php', '.xml', 'hc2_render=wQ91OepQ1Fa2YKpJ2t0CX8kuRPWQvlFFGryJ2U4p9eaymH083GPIoXh1szPNNZJzQ7k0xotX6yvYD3L8', 'hcube_render=true', '/wp-cron.php', '/wp-json', '/wp-content/', '/wp-admin/', '/wp-includes/', '/wp-login.php', '/feed/', '/favicon.ico', 'wc-ajax' ];
			$override = false;
			foreach( $donotcontain as $donot ) if( strpos($_SERVER['REQUEST_URI'],$donot)!==false ) $override = true;
			if( $override || !get_option('hc2_production_url') || strpos($_SERVER['HTTP_HOST'],hc2_sanitize_url(get_option('hc2_production_url')))!==false || (( isset($_COOKIE['__hc2_login']) && $_COOKIE['__hc2_login'] == ( get_option('full_sync_mode')?'2849':'1026') ) || ( isset($_GET['h']) && $_GET['h']==( get_option('full_sync_mode')?'2849':'1026') ) )){
				setcookie("__hc2_login", ( get_option('full_sync_mode')?'2849':'1026'), strtotime( '+30 days' ), '/');
			}else{
				exit;
			}
			
			if( !$override ){ 
					
				if( !get_hc2('settings','compatibility_mode') && get_post_meta( $post_id , 'hc2_post_mode', true ) != "wordpress" ){
					$rendered = get_post_meta( $post_id, 'hc2_post_rendered', 1 );
					if( !$rendered ){
						$rendered = str_replace('id="h"','id="h" data-rdate="prior"',file_get_contents( get_permalink($post_id).'?hc2_render=wQ91OepQ1Fa2YKpJ2t0CX8kuRPWQvlFFGryJ2U4p9eaymH083GPIoXh1szPNNZJzQ7k0xotX6yvYD3L8' ));
						update_post_meta( $post_id, 'hc2_post_rendered', $rendered );
				
						if( get_post_meta( $post_id , 'hc2_post_mode', true ) != 'html' && get_post_meta( $post_id , 'hc2_post_mode', true ) != 'php' ){ 
							if(get_option('page_on_front')==$post_id){
								$fp = fopen(ABSPATH.'index.html', 'w' );fwrite( $fp, hc2_process_output($rendered) );fclose( $fp ); 
							}else{
								if (!file_exists(ABSPATH.$post->post_name)) {mkdir(ABSPATH.$post->post_name, 0755, true);}
								$fp = fopen(ABSPATH.$post->post_name.'/index.html', 'w' );fwrite( $fp, hc2_process_output($rendered) );fclose( $fp ); 
							}
						}
						$rendered = str_replace('data-rdate="prior"','data-rdate="now"',$rendered);
					}else{
						$rendered = str_replace('id="h"','id="h" data-rdate="prior"',$rendered);
					}
					if( get_post_meta( $post_id , 'hc2_post_mode', true ) == 'php' ) {
						$obs = ob_get_level();
						for( $o = 0; $o < $obs; $o++ )ob_end_flush();
						try {
							ob_start();
							eval ( get_post_meta($post_id,'hc2_php_head',1).hc2_php_decode('?>'.$rendered) );	
							echo hc2_remove_unused_amp(hc2_move_css(ob_get_clean()));
						} catch (ParseError $e) {
							error_log( $e->getMessage() );
						}		
						exit;
					}else{
						echo hc2_process_output($rendered);
						exit;
					}
				}
				
			}
			
		}
	}

	function buffer_start() { ob_start("process_output"); } 
	function buffer_end() { ob_end_flush(); }

	if( !is_admin() && $post_id )add_action('after_setup_theme', 'buffer_start');
	if( !is_admin() && $post_id )add_action('shutdown', 'buffer_end');
	
	function hc2_process_output($buffer) {  
		
		$buffer = hc2_move_css($buffer);
		$buffer = hc2_remove_unused_links($buffer);
		$buffer = hc2_remove_unused_scripts($buffer);
		$buffer = hc2_remove_unused_amp($buffer);
		
		return $buffer; 
	}
	
							function hc2_move_css($buffer){

								$new_styles = [];
								$new_sections = [];
								$styles = explode( '<style', $buffer );
								foreach( $styles as $style ) {
									if( strpos($style,'</style>')!==false ){
										$newstr = str_replace('</style>','', strstr( $style, '</style>' ) );
										if( substr_count( $newstr, '{' ) > substr_count( $newstr, '}' ) ) $newstr = $newstr . '}';
										array_push( $new_sections, $newstr );
									}else{
										array_push( $new_sections, $style );
									}
									array_push( $new_styles, strstr( ltrim( strstr( $style, '>' ), '>' ), '</style>', true ) );
								}
								$buffer = implode( '', $new_sections );
								$buffer = str_replace( '</head>', '<style>'.implode( '', $new_styles ).'</style></head>', $buffer );
								
								return $buffer; 
							}
							
							function hc2_remove_unused_links($buffer){
							
								$links_to_remove = array( 'wp-block-library-css', 'grw_css-css' );
								foreach( $links_to_remove as $link ){
									if( strpos($buffer,$link)!==false ){
										$buffsa = explode($link,$buffer);
										$beforelist = explode( '<link', $buffsa[0] );
										array_pop( $beforelist );
										$before = implode( '<link', $beforelist ); 
										$after = ltrim( strstr( $buffsa[1], '>' ) , '>' );
										$buffer = $before . $after;
									}
								}
								
								return $buffer; 
							}
							
							function hc2_remove_unused_scripts($buffer){
							
								$scripts_to_remove = array( 'rplg_js-js', 'rplg_blazy-js', 'wp-embed-js' );
								foreach( $scripts_to_remove as $script ){
									if( strpos($buffer,$script)!==false ){
										$buffsa = explode($script,$buffer);
										$beforelist = explode( '<script', $buffsa[0] );
										array_pop( $beforelist );
										$before = implode( '<script', $beforelist );
										$after = ltrim( strstr( $buffsa[1], '>' ) , '>' );
										$buffer = $before . $after;
									}
								}
								
								return $buffer; 
							}
							
							function hc2_remove_unused_amp($buffer){
							   if (!get_hc2('settings','amp_off')){
								//'amp-fx-collection','amp-animation','amp-position-observer'
								$unused_remove = array( 
									array( '/amp-mustache', 'amp-mustache' ),
									array( '/amp-list', '<amp-list' ),
									array( '/amp-lightbox', '<amp-lightbox' ),
									array( '/amp-dynamic-css-classes', '<amp-call-tracking' ),
									array( '/amp-call-tracking', '<amp-call-tracking' ),
									array( '/amp-accordion', '<amp-accordion' ),
									array( '/amp-fit-text', '<amp-fit-text' ),
									array( '/amp-carousel', '<amp-carousel' ),
									array( '/amp-base-carousel', '<amp-base-carousel' )
								);
							
								if (!get_hc2('settings','amp_off'))foreach( $unused_remove as $item ){
									if( strpos($buffer,$item[1])===false ){
										$buffsa = explode($item[0],$buffer);
										$beforelist = explode( '<script', $buffsa[0] );
										array_pop( $beforelist );
										$before = implode( '<script', $beforelist );
										$after = ltrim( strstr( $buffsa[1], '>' ) , '>' );
										$buffer = $before . $after;
									}
								}
								
							  }
							  return $buffer; 
							}
	
	
	
	add_filter( 'save_post', 'hc2_function_save_post', 50, 2 );
	function hc2_function_save_post( $post_id, $post ){
		if( strpos($_SERVER['REQUEST_URI'],'nav-menus.php')===false ){
			if(file_exists(ABSPATH . 'index.html'))unlink( ABSPATH . 'index.html' );
			if( $post->post_name != '' && $post->post_name != '.' && $post->post_name != '..' && $post->post_name != '/' && $post->post_name && strlen( $post->post_name ) )
				hc2_rrmdir( ABSPATH . $post->post_name );
			if ( wp_is_post_revision( $post_id ) ) return;	
			if ( $post->post_type == 'post' || $post->post_type == 'page' ){
					if( get_hc2( 'settings','edit_mode' ) || ( get_option('hc2_production_url') && strpos($_SERVER['HTTP_HOST'],hc2_sanitize_url(get_option('hc2_production_url')))===false ) ){
						update_post_meta( $post->ID, 'hc2_post_rendered', false );
						update_post_meta( $post->ID, 'hc2_php_head', '' );
					}
			}else{
				hc2_delete_allfiles();
				$postsQuery = get_posts(array('numberposts' => -1,'post_type'=> array( 'post', 'page' )));
				foreach( $postsQuery as $post ) {
					if( get_hc2( 'settings','edit_mode' ) || ( get_option('hc2_production_url') && strpos($_SERVER['HTTP_HOST'],hc2_sanitize_url(get_option('hc2_production_url')))===false ) ){
						update_post_meta( $post->ID, 'hc2_post_rendered', false );
						update_post_meta( $post->ID, 'hc2_php_head', '' );
					}
				}
			}
		}
	} 
	
	add_action('rest_api_init',function(){register_rest_route('hc2/v1','/renderall/',array('methods'=>'POST','callback'=>'hcube_renderall','permission_callback' => function($request){ return is_user_logged_in();}));});
	function hcube_renderall( $request ) { 
		hc2_delete_allfiles();
		$postsQuery = get_posts(array('numberposts' => -1,'post_type'=> array( 'post', 'page' )));
		foreach( $postsQuery as $post ) {
				if( get_hc2( 'settings','edit_mode' ) || ( get_option('hc2_production_url') && strpos($_SERVER['HTTP_HOST'],hc2_sanitize_url(get_option('hc2_production_url')))===false ) ){
					update_post_meta( $post->ID, 'hc2_post_rendered', false );
					update_post_meta( $post->ID, 'hc2_php_head', '' );
				}
			}
		return 'done';
	}
		
	add_action( 'update_option', 'hc2_function_option', -10, 3 );
	function hc2_function_option( $name, $old ,$new ){
		if(!get_option('hc2_combine_render')){
			if( $old != $new && strpos($name,'rewrite')===false && strpos($name,'transient')===false && strpos($name,'cron')===false ){
				$postsQuery = get_posts(array('numberposts' => -1,'post_type'=> array( 'post', 'page' )));
				foreach( $postsQuery as $post ) {
					if( get_hc2( 'settings','edit_mode' ) || ( get_option('hc2_production_url') && strpos($_SERVER['HTTP_HOST'],hc2_sanitize_url(get_option('hc2_production_url')))===false ) ){
						update_post_meta( $post->ID, 'hc2_post_rendered', false );
						update_post_meta( $post->ID, 'hc2_php_head', '' );
					}
				}
			}
		}
	}
		
	function hc2_delete_allfiles(){
		$objects = scandir( ABSPATH );
		foreach ( $objects as $object )
			if( $object == 'index.html' || ( $object && $object != '/' && $object != '.' && $object != '..' && $object != 'wp-content' && $object != 'wp-admin' && $object != 'wp-includes' && is_dir( ABSPATH . $object ) ) )
				hc2_rrmdir( ABSPATH . $object );
	}
	
	function hc2_rrmdir($dir) { 
	   if (is_dir($dir)) { 
		 $objects = scandir($dir); 
		 foreach ($objects as $object) { 
		   if ($object != "." && $object != "..") { 
			 if (is_dir($dir."/".$object))
			   hc2_rrmdir($dir."/".$object);
			 else
			   unlink($dir."/".$object); 
		   } 
		 }
		 rmdir($dir); 
	   }else{
		   unlink($dir); 
	   }
	 }
	
	