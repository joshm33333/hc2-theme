<?php

	if ( ! defined( 'ABSPATH' ) ) exit;

	add_action( 'admin_menu', 'hcube_addtools' );
	function hcube_addtools(){
		add_submenu_page( 'hcube_settings', 'Tools', 'Tools', 'manage_options', 'hcube_tools', 'hcube_createpage_tools' );
	}

	add_action( 'admin_init', 'hcube_registertools' );
	function hcube_registertools(){ 
		register_setting( 'hcube_tools_group', 'hcube_redirects' );
		register_setting( 'hcube_tools_group', 'hcube_backup_domain' );
		register_setting( 'hcube_tools_group', 'hcube_backup_table' );
	}
	

	add_action('rest_api_init',function(){register_rest_route('hc2/v1','/audit_newurl/',array('methods'=>'POST','callback'=>'hcube_audit_newurl','permission_callback' => function($request){ return is_user_logged_in();}));});
	function hcube_audit_newurl( $request ) { 

		update_option('hc2_production_url',$_POST['newurl']);
		
		return 'updating';
	}

	$hcube_json_redirects = json_decode('['.get_option('hcube_redirects').']', true);
	if(!is_array($hcube_json_redirects)){
		add_action('admin_notices', 'hcube_fail_redirects');
		function hcube_fail_redirects(){echo '<div class="notice notice-warning"><p>Redirects have errors.</p></div>';}
	}
	

	add_action('rest_api_init',function(){register_rest_route('hc2/v1','/replacepost/',array('methods'=>'POST','callback'=>'hcube_replacefunction','permission_callback' => function($request){ return is_user_logged_in();}));});
	function hcube_replacefunction( $request ) { 
		global $wpdb;
		$rows = $wpdb->get_results("SELECT ID, post_title, post_type FROM ".$wpdb->prefix."posts WHERE post_excerpt LIKE '%".str_replace("'","''",$_POST['find'])."%' OR post_content LIKE '%".str_replace("'","''",$_POST['find'])."%' ;");
		if( $_POST['replace_on'] == 'true' ){
			if( $_POST['replace_content'] == 'true' ) $wpdb->query("UPDATE ".$wpdb->prefix."posts SET post_content = replace(post_content, '".str_replace("'","''",$_POST['find'])."', '".str_replace("'","''",$_POST['replace'])."');");
			if( $_POST['replace_excerpt'] == 'true' ) $wpdb->query("UPDATE ".$wpdb->prefix."posts SET post_excerpt = replace(post_excerpt, '".str_replace("'","''",$_POST['find'])."', '".str_replace("'","''",$_POST['replace'])."');");
		}
		$return = '';
		foreach($rows as $row){
			update_post_meta( $row->ID, 'hc2_post_rendered', false );
			if($row->post_type == 'post' || $row->post_type == 'page' || $row->post_type == 'wp_block')$return .= '<div><p>'.$row->post_title.'</p></div>';
		}
		return $return;
	}
	
	
	
    function hcube_createpage_tools(){
			
        ?>
			<div class="wrap">	
				<h1 class='hcube_title'>Tools</h1>
				<table class='hcube_settings'>
				
				
				<script>

					function hc2_update_prod(e,fr){
						jQuery.ajax( { 
							url: '<?php echo str_replace("http://","https://",get_rest_url()); ?>hc2/v1/audit_newurl', 
							method: 'POST', 
							beforeSend: function ( xhr ) { xhr.setRequestHeader( 'X-WP-Nonce', '<?php echo wp_create_nonce( "wp_rest" ); ?>' ); },
							data:{ 'newurl' : document.getElementById('hc2_new_produrl').value }
						} ).done( function ( data ) {
							location.reload();
							
						} )
					}

				</script>
						<tr><td class='hcube_subsettings_box'><h2>Production URL</h2></td></tr>
						<tr><td class=''><input id='hc2_new_produrl' type="text" name="hc2_production_url" value="<?php echo esc_attr(get_option('hc2_production_url')); ?>"/></td></tr>	
						<tr><td class=''><button class='hcube_bluebutton hcube_replaceall_button' onclick="hc2_update_prod(this,0)" >Update</button></td></tr>	
						

				
						<tr><td class='hcube_subsettings_box'><h2>Find and Replace</h2><div class='hcube_subsettings_toggle' data-target='hcube_find'></div></td></tr>
						<tr><td>
								<table class='hcube_submenu hcube_find'>
									<tr><td ><h3>Find</h3></td>				<td><input class='' id='hcube_find' /></td></tr>
									<tr><td ><h3>Replace With</h3></td>		<td>
										<input type='checkbox' class='hc2_replace_on' id='hcube_replace_on' />
										<input class='' id='hcube_replace' />
										<div><input type='checkbox' class='hc2_replace_content' checked id='hcube_replace_content' /> <label>Post Content</label></div>
										<div><input type='checkbox' class='hc2_replace_content' checked id='hcube_replace_excerpt' /> <label>Post Excerpt</label></div>
									</td></tr>
								
									<tr><td><button class='hcube_bluebutton hcube_replaceall_button' onclick='hcube_replacefunc(this)'>Run</button></td></tr>	
									<tr><td id='hc2_replace_occ'></td></tr>	
									<script>
									
													
										function hcube_replacefunc( e ){
											e.dataset.loading = 'true';
											jQuery.ajax( { 
												url: '<?php echo get_rest_url(); ?>hc2/v1/replacepost/', 
												method: 'POST', 
												beforeSend: function ( xhr ) { xhr.setRequestHeader( 'X-WP-Nonce', '<?php echo wp_create_nonce( "wp_rest" ); ?>' ); },
												data:{ 
													'find': jQuery('#hcube_find')[0].value , 
													'replace': jQuery('#hcube_replace')[0].value ,
													'replace_on': jQuery('#hcube_replace_on')[0].checked  ,
													'replace_content': jQuery('#hcube_replace_content')[0].checked  ,
													'replace_excerpt': jQuery('#hcube_replace_excerpt')[0].checked 
												}
											} ).done( function ( data ) {
												e.dataset.loading = 'false';
												document.getElementById('hc2_replace_occ').innerHTML = data;
												
											} )
										}
									
									</script>
									</td><td></td></tr>
								</table>
							</form>
						</td></tr>	

						
						<tr><td class='hcube_subsettings_box'><h2>Redirects</h2><div class='hcube_subsettings_toggle' data-target='hcube_redirect'></div></td></tr>
						<tr><td>
							<form method="post" action="options.php">	
								<?php settings_fields( 'hcube_tools_group' ); ?>
								<?php do_settings_sections( 'hcube_tools_group' );	?>	
								<table class='hcube_submenu hcube_redirect'>
									<tr><td><div class='hcube_code' onclick="hc2_toggleme(this)">	{ </br>&nbsp;&nbsp;&nbsp;&nbsp;"match" : "/old-url",</br>&nbsp;&nbsp;&nbsp;&nbsp;"redirect" : "/new-url"</br>},</br>{ </br>&nbsp;&nbsp;&nbsp;&nbsp;"match" : "/old-url-b",</br>&nbsp;&nbsp;&nbsp;&nbsp;"redirect" : "/new-url-b"</br>},</div></td></tr>
								
									<tr><td><textarea style="min-height:400px;min-width:900px;" class='' name="hcube_redirects" ><?php echo esc_attr(get_option('hcube_redirects')); ?></textarea></td></tr>
									
									<tr><td><input class='hcube_bottom' type="submit" value="Save"></td></tr>	
								</table>
							</form>
						</td></tr>							
					
				</table>
				<script>
					function hc2_toggleme(t){
						if(t.dataset.open != 'true'){t.dataset.open = 'true';}
						else if(t.dataset.open == 'true'){t.dataset.open = 'false';}
					}
				</script>
				<style>
					[onclick="hc2_toggleme(this)"] {padding:10px;font-family:arial;letter-spacing: 1px;height: 20px;margin-bottom: 20px;overflow: hidden;}
					[onclick="hc2_toggleme(this)"][data-open='true'] {height: auto;}
					[onclick="hc2_toggleme(this)"]:before {content: 'Example';display: block;border: 1px solid;width: 100px;text-align: center;cursor: pointer;margin-bottom:20px;}
					[onclick="hc2_toggleme(this)"][data-open='true']:before {content: 'Close';display: block;border: 1px solid;width: 100px;text-align: center;cursor: pointer;}
					.hcube_settings td>h3 {font-size: 14px;}
					.hcube_settings td>h2 {font-size: 24px;}
					td#hc2_replace_occ p {margin: 0;}			
					.hcube_settings h3 {margin-top: 0;font-size: 1.2em;font-weight: 400;}
					.hcube_settings h2 {margin-top: 20px;font-size: 20px;color: #000;margin-bottom: 20px}
					.hcube_renderlist,.hcube_replacelist {margin: 0;white-space: nowrap}
					.hcube_renderlist *,.hcube_replacelist * {vertical-align: text-bottom}
					.hcube_renderlist>div,.hcube_replacelist>div {display: inline-block}
					.hcube_renderlist>div:nth-child(3),.hcube_replacelist>div:nth-child(3) {width: 300px;overflow: hidden}
					i.fas.fa-arrow-circle-up {color: #000;cursor: pointer;font-size: 14px;line-height: .6}
					table.hcube_settings th:hover {cursor: pointer;outline: 1px solid #7a9eef}
					td.hcube_subsettings_box>h3 {position: absolute;right: 100px;top: 8px}
					li.hcube_renderlist[data-type=block] {background: #e4e4e4}
					.inlineimages_list i.fas.fa-window-close {display: inline}
					.cpanellist td {padding: 0 10px}
					i.fas.fa-arrow-circle-up:hover {opacity: 1}
					.hcube_renderlist>div:nth-child(4),.hcube_replacelist>div:nth-child(4) {margin-left: 20px}
					.hcube_renderlist i,.hcube_replacelist i {margin: 3px 10px;font-size: 10px;opacity: .3}
					.hucbe_value {padding-bottom: 20px;padding-left: 40px}
					.hcube_settings . {margin-bottom: 20px;margin-left: 20px}
					input.hcube_colorselect {border-left-width: 10px}
					.hcube_replace {font-size: 18px}
					.hcube_replace_id {display: inline-block;width: 70px;white-space: nowrap}
					.hcube_replace_id+.hcube_replace_id {display: inline-block;width: 300px;overflow: hidden;margin-right: 20px;white-space: nowrap;vertical-align: bottom}
					input[type=submit],button.hcube_bluebutton {display: inline-block;text-decoration: none;font-size: 13px;line-height: 30px;height: 28px;margin: 0;padding: 0 10px 1px;cursor: pointer;border-width: 1px;border-style: solid;-webkit-appearance: none;border-radius: 3px;white-space: nowrap;box-sizing: border-box;background: #0085ba;border-color: #0073aa #006799 #006799;box-shadow: 0 1px 0 #006799;color: #fff;text-decoration: none;text-shadow: 0 -1px 1px #006799,1px 0 1px #006799,0 1px 1px #006799,-1px 0 1px #006799}
					.hcube_rendering i.fas.fa-circle-notch,.hcube_replaceing i.fas.fa-circle-notch {animation-name: spin;animation-duration: 2000ms;animation-iteration-count: infinite;animation-timing-function: linear;opacity: 1;color: blue}
					i.fas.fa-check {color: #4caf50;opacity: 1}
					@keyframes spin {from {    transform: rotate(0deg)}
					to {transform: rotate(360deg)}}
					td.code_container i {vertical-align: top;margin-top: 9px;}
					button.hcube_redbutton {display: inline-block;text-decoration: none;font-size: 13px;line-height: 30px;height: 28px;margin: 0;padding: 0 10px 1px;cursor: pointer; border-width: 1px;border-style: solid;-webkit-appearance: none;border-radius: 3px;white-space: nowrap;box-sizing: border-box;background: #ba0000;border-color: #a00 #900 #900;box-shadow: 0 1px 0 #900;color: #fff;text-decoration: none;text-shadow: 0 -1px 1px #900,1px 0 1px #900,0 1px 1px #006799,-1px 0 1px #006799}
					button.hcube_renderstop_button,button.hcube_replacestop_button {display: none}
					h2 i:not(.status_icon) {width: 30px;display: inline-block;font-style: normal;font-size: 15px;color: #666;}
					textarea. {width: 650px;min-height: 240px;font-family: monospace!important}
					td.hcube_subsettings_box.hcube_grey h2,td.hcube_subsettings_box.hcube_grey h2 i {color: #9e9e9e}
					td.hcube_subsettings_box.hcube_grey .hcube_subsettings_toggle:before {border-color: #d2d2d2}
					td.hcube_subsettings_box.hcube_grey {opacity: .5}
					p {max-width: 600px;white-space: pre-wrap;}
					td {display: inline-block;}
					[data-loading="true"] {background: gray !IMPORTANT;text-shadow: 0 0 BLACK !important;border-color: black !important;box-shadow: none !important;}
					table.hcube_submenu.hcube_find td {vertical-align: top;padding: 5px;}
					table.hcube_submenu.hcube_find [type='checkbox'] {vertical-align: initial;}
					table.hcube_submenu.hcube_find td div {display: block;margin-left: 30px;}
					table.hcube_submenu.hcube_find .hc2_replace_content {vertical-align: bottom;}
					table.hcube_submenu.hcube_find .hc2_replace_on:not(:checked) + *, table.hcube_submenu.hcube_find .hc2_replace_on:not(:checked) + * + *, table.hcube_submenu.hcube_find .hc2_replace_on:not(:checked) + * + * + * {opacity: .2 !important;}

				</style>
			</div>
        <?php }
		
		
		
		
		