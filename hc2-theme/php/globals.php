<?php

	if ( ! defined( 'ABSPATH' ) ) exit;


	if( !get_option('hc2_global_php_default') )update_option('hc2_global_php_default',array(array('name'=>'New','code'=>'')));


	if(!isset($_GET['globalsoff']) && !isset($_POST['hcube_globals_php']) && strpos($_SERVER['REQUEST_URI'],'wp-login')===false){
		$arr = get_option('hcube_globals_php',get_option('hc2_global_php_default'));
		if(is_array($arr))
			foreach($arr as $ar)
				if($ar['code'])
					try {
						eval( $ar['code'] );
					} catch (ParseError $e) {
						error_log( $e->getMessage() );
					}
	}

	add_action( 'admin_menu', 'hcube_addglobs' );
	function hcube_addglobs(){
		add_submenu_page( 'hcube_settings', 'Global Code', 'Global Code', 'manage_options', 'hcube_globals', 'hcube_createpage_globals' );
		add_submenu_page( 'hcube_settings', 'Script Manager', 'Script Manager', 'manage_options', 'hcube_globalphp', 'hcube_createpage_globalphp' );
	}

	add_action( 'admin_init', 'hcube_registerglobals' );
	function hcube_registerglobals(){ 
		register_setting( 'hcube_globals_group', 'hcube_globals_styles' );
		register_setting( 'hcube_globals_group', 'hcube_globals_scripts' );
	}
	
	add_action('rest_api_init',function(){register_rest_route('hc2/v1','/hc2_global_php/',array('methods'=>'POST','callback'=>'hc2_global_php','permission_callback' => function($request){ return is_user_logged_in();} ));});
	function hc2_global_php( $request ) {  
		$arr = $_POST['hcube_globals_php'];
		foreach ($arr as $a => $ar) $arr[$a]['code'] = stripslashes($ar['code']);
		update_option('hcube_globals_php',$arr);
		return $_POST;
	}
		
    function hcube_createpage_globals(){
		
        ?>
			<div class="wrap">
			
				<h1 class='hcube_title'>Global Code</h1>
				
				<button class='hc2_global_button button button-secondary hc2_button-selected' data-group='hc2_global_button' data-target='hcube_global_css' data-all='hcube_global_tab' onclick='hc2_global_tab(this)'>Global CSS</button>
				<button class='hc2_global_button button button-secondary' data-group='hc2_global_button' data-target='hcube_global_js' data-all='hcube_global_tab' onclick='hc2_global_tab(this)'>Global Javascript</button>
				
				<form method="post" action="options.php">
					<?php settings_fields( 'hcube_globals_group' ); ?>
					<?php do_settings_sections( 'hcube_globals_group' );	?>		
					
					<table class='hcube_global_tab hcube_global_css'>
						<tr><td><h2>CSS</h2></td></tr>
						<tr><td colspan=3><textarea name="hcube_globals_styles" ><?php echo esc_textarea(get_option('hcube_globals_styles')); ?></textarea></td></tr>
						<tr><td><?php submit_button();?></td></tr>
					</table>	
						
					<table style='display:none;' class='hcube_global_tab hcube_global_js'>
						<tr><td><h2>Javascript</h2></td></tr>
						<tr><td colspan=3><textarea name="hcube_globals_scripts" ><?php echo esc_textarea(get_option('hcube_globals_scripts')); ?></textarea></td></tr>
						<tr><td><?php submit_button();?></td></tr>
					</table>	
					
				</form>
				<script>
					function hc2_global_tab(e){
						var buttons = document.querySelectorAll('[data-group="'+e.dataset.group+'"]');
						for( var t = 0; t < buttons.length; t++ )buttons[t].className = 'button button-secondary';
						e.className = 'button button-secondary hc2_button-selected';
						var tabs = document.getElementsByClassName(e.dataset.all);
						for( var t = 0; t < tabs.length; t++ )tabs[t].style.display = 'none';
						document.getElementsByClassName(e.dataset.target)[0].style.display = 'block';
					}
				</script>
				<style>
					button.button.hc2_button-selected {background: white;color: black;font-weight: bold;}
					textarea {white-space: nowrap;min-height: 700px;width: 1400px;max-width: calc(100vw - 200px);font-family: monospace;}
					h1.hcube_title {margin-bottom: 18px;}
				</style>
			</div>
        <?php }
		
    function hcube_createpage_globalphp(){
		
        ?>
			<div class="wrap">
			
				<h1 class='hcube_title'>Script Manager</h1>
					<table class='hcube_global_tab hcube_global_php'>
						
						<tr><td colspan=3>
							<button class='button button-primary' onclick='hc2_save_php(this)'>Save Changes</button>
							<button class='button button-secondary' onclick='hc2_create_php(this)'>New Tab</button>
							<div class='hc2_php_container'>
								<?php 
									$arr = get_option('hcube_globals_php',get_option('hc2_global_php_default')); 
									foreach( $arr as $ar ) if($ar['name']!=''){
										?>
											<div>
												<button class='button button-secondary' data-group='hc2_php_button' data-target='hcube_global_php_tab_<?php echo str_replace(' ','',$ar['name']); ?>' data-all='hcube_global_php_tab' onclick='hc2_global_tab(this)'><?php echo $ar['name']; ?></button>
												<div style='display:none;' class='hcube_global_php_tab_<?php echo str_replace(' ','',$ar['name']); ?> hcube_global_php_tab'>
													<input onchange='hc2_change_php_name(this)' class='hc2_global_php_name' value="<?php echo esc_attr($ar['name']); ?>"/>
													<textarea class='hc2_global_php' ><?php echo esc_textarea($ar['code']); ?></textarea>
												</div>
											</div>
										<?php
									}
								?>
							</div>
						</td></tr>
						<script>
							function hc2_change_php_name(e){
								e.parentNode.parentNode.getElementsByTagName('button')[0].innerHTML = e.value;
							}
							function hc2_save_php(e){
								var texts = document.getElementsByClassName('hc2_global_php');
								var inps = document.getElementsByClassName('hc2_global_php_name');
								var vals = [];
								for( var t = 0; t < texts.length; t++ )vals[t]={name:inps[t].value, code:texts[t].value};
								jQuery.ajax( { 
									url: '<?php echo get_rest_url(); ?>hc2/v1/hc2_global_php/', 
									method: 'POST', 
									beforeSend: function ( xhr ) { xhr.setRequestHeader( 'X-WP-Nonce', '<?php echo wp_create_nonce( "wp_rest" ); ?>' ); },
									data:{ 'hcube_globals_php' : vals }
								} ).done( function ( data ) {
									location.reload();
								} )
							}
							function hc2_global_tab(e){
								var buttons = document.querySelectorAll('[data-group="'+e.dataset.group+'"]');
								for( var t = 0; t < buttons.length; t++ )buttons[t].className = 'button button-secondary';
								e.className = 'button button-secondary hc2_button-selected';
								var tabs = document.getElementsByClassName(e.dataset.all);
								for( var t = 0; t < tabs.length; t++ )tabs[t].style.display = 'none';
								document.getElementsByClassName(e.dataset.target)[0].style.display = 'block';
							}
							function hc2_create_php(e){
								var texts = document.getElementsByClassName('hc2_global_php');
								var ele = document.createElement("DIV");   
								ele.innerHTML = "<button class='button button-secondary' data-group='hc2_php_button' data-target='hcube_global_php_ntab_"+texts.length+"' data-all='hcube_global_php_tab' onclick='hc2_global_tab(this)'>New</button><div style='display:none;' class='hcube_global_php_ntab_"+texts.length+" hcube_global_php_tab'><input onchange='hc2_change_php_name(this)' class='hc2_global_php_name' value='New'/><textarea class='hc2_global_php' ></textarea><div>";             
								document.getElementsByClassName('hc2_php_container')[0].appendChild(ele); 
							}
						</script>
						<style>
							.hc2_php_container {    position: relative;}
							.hc2_php_container div > div {position: absolute; top: 100px; left: 0;}
							.hc2_php_container > div {width: auto; display: inline;}
							.hc2_php_container button {padding: 4px 20px; cursor: pointer;}
							[onclick="hc2_create_php(this)"] {margin-bottom: 20px; padding: 4px 40px; background: #008a00; color: white; border: 1px solid; border-radius: 4px; cursor: pointer;}
							table.hcube_global_tab.hcube_global_php {position: relative; max-width:1400px;}
							input.hc2_global_php_name {width: 100%;}
							textarea {white-space: nowrap;min-height: 700px;width: 1400px;max-width: calc(100vw - 200px);font-family: monospace;}
							button.button.hc2_button-selected {background: white;color: black;font-weight: bold;}
							.hc2_php_container button {margin: 10px 10px 10px 0px !IMPORTANT;}
							.hc2_php_container {border: 1px solid;background: #e1e1e1;margin-top: 10px;padding: 0px 4px 0 13px;border-radius: 3px;}
							.hc2_php_container input {margin-bottom: 5px;border-radius:3px;border:1px solid;padding: 4px;}
							.hc2_php_container button:empty {border: 2px solid red;line-height: 1;}
							.hc2_php_container button:empty:before {content: 'Delete Permanently';}
							h1.hcube_title {margin-bottom: 18px;}
							table.hcube_global_tab.hcube_global_php {margin-top: 8px;}										
						</style>
					</table>	
			</div>
        <?php }
	

	
		