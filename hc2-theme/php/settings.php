<?php

	if ( ! defined( 'ABSPATH' ) ) exit;
	
	add_action('rest_api_init',function(){register_rest_route('hc2/v1','/addresses/',array('methods'=>'GET','callback'=>'hc2_addresses','permission_callback' => '__return_true'));});
	function hc2_addresses( $request ) { 
		hc2_prepare_amp_rest_api();
		echo '['.json_encode(get_hc2('places')).']'; 
	}
				
    add_action( 'admin_init', 'hcube_registersettings' );
	function hcube_registersettings(){   
		
		register_setting( 'hcube_option_group', 'hc2_' );
		register_setting( 'hcube_option_group', 'hcube_analytics' );
		register_setting( 'hcube_option_group', 'hcube_conversion_config' );
		register_setting( 'hcube_option_group', 'hcube_conversion_triggers' );
		register_setting( 'hcube_option_group', 'hcube_facebookpixel' );
		register_setting( 'hcube_option_group', 'hcube_font_body' );
		register_setting( 'hcube_option_group', 'hcube_font_headingone' );
		register_setting( 'hcube_option_group', 'hcube_font_headingtwo' );
		register_setting( 'hcube_option_group', 'hcube_font_headingthree' );
		register_setting( 'hcube_option_group', 'hcube_font_headingfour' );
		register_setting( 'hcube_option_group', 'hcube_font_headingfive' );
		register_setting( 'hcube_option_group', 'hcube_font_headingsix' );
		register_setting( 'hcube_option_group', 'hc2_consent_content' );
		register_setting( 'hcube_option_group', 'hc2_pinned_content' );
		register_setting( 'hcube_option_group', 'hcube_bing' );
		register_setting( 'hcube_option_group', 'hcube_clarity' );
		
	}
	
	if( !get_option('hc2_consent_content') )
		update_option('hc2_consent_content','This website uses cookies.');
	
	function hcube_font_list($result,$select){
        $font_list = '<option '.(	"*Arial, Helvetica, sans-serif"							== get_option($select)?'selected="seclected"':'').'>*Arial, Helvetica, sans-serif</option>';  
        $font_list.= '<option '.(	"*Arial Black, Gadget, sans-serif"						== get_option($select)?'selected="seclected"':'').'>*Arial Black, Gadget, sans-serif</option>';  
        $font_list.= '<option '.(	"*Comic Sans MS, cursive, sans-serif"					== get_option($select)?'selected="seclected"':'').'>*Comic Sans MS, cursive, sans-serif</option>';  
        $font_list.= '<option '.(	"*Impact, Charcoal, sans-serif"							== get_option($select)?'selected="seclected"':'').'>*Impact, Charcoal, sans-serif</option>';  
        $font_list.= '<option '.(	"*Lucida Sans Unicode, Lucida Grande, sans-serif"		== get_option($select)?'selected="seclected"':'').'>*Lucida Sans Unicode, Lucida Grande, sans-serif</option>';  
        $font_list.= '<option '.(	"*Tahoma, Geneva, sans-serif"							== get_option($select)?'selected="seclected"':'').'>*Tahoma, Geneva, sans-serif</option>';  
        $font_list.= '<option '.(	"*Trebuchet MS, Helvetica, sans-serif"					== get_option($select)?'selected="seclected"':'').'>*Trebuchet MS, Helvetica, sans-serif</option>';  
        $font_list.= '<option '.(	"*Verdana, Geneva, sans-serif"							== get_option($select)?'selected="seclected"':'').'>*Verdana, Geneva, sans-serif</option>';   
        $font_list.= '<option '.(	"*Georgia, serif"										== get_option($select)?'selected="seclected"':'').'>*Georgia, serif</option>';  
        $font_list.= '<option '.(	"*Palatino Linotype, Book Antiqua, Palatino, serif"		== get_option($select)?'selected="seclected"':'').'>*Palatino Linotype, Book Antiqua, Palatino, serif</option>';  
        $font_list.= '<option '.(	"*Times New Roman, Times, serif"						== get_option($select)?'selected="seclected"':'').'>*Times New Roman, Times, serif</option>';  
        $font_list.= '<option '.(	"*Courier New, Courier, monospace"						== get_option($select)?'selected="seclected"':'').'>*Courier New, Courier, monospace</option>';  
        $font_list.= '<option '.(	"*Lucida Console, Monaco, monospace"					== get_option($select)?'selected="seclected"':'').'>*Lucida Console, Monaco, monospace</option>'; 
		foreach ( $result->items as $font ) {
            $font_list.= '<option '.($font->family==get_option($select)?'selected="seclected"':'').'>'.$font->family.'</option>';    			
        }
		return $font_list;
	}
	
	function get_hc2($field1=false,$field2=false,$field3=false){
		$array = json_decode(get_option('hc2_'),1);
		if( !$field1 )return is_array($array);
		
		if( !is_array($array) || !array_key_exists($field1,$array) )return false;
		if($field2 === false)return $array[$field1];
		
		if( is_numeric($field2) ){
			$x=0;
			foreach($array[$field1] as $key => $val){
				$x++;
				if($x == $field2) {
					$field2 = $key;
					break;
				}
			}
		}
		
		if(!array_key_exists($field2,$array[$field1]))return false;
		if($field3 === false)return $array[$field1][$field2];
		
		if(!array_key_exists($field3,$array[$field1][$field2]))return false;
		return $array[$field1][$field2][$field3];
	}
	function isJson($string) {
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}
	
	if( !get_hc2() ) add_action('admin_notices', 'hcube_fail_htaccess_business_details');
	function hcube_fail_htaccess_business_details(){echo '<div class="notice notice-warning"><p>Business details has errors.</p></div>';}
	
	add_action('after_setup_theme','hcube_theme_support', 16);
	function hcube_theme_support() { 
		add_theme_support( 'editor-color-palette', hc2_site_colors() ); 
		add_theme_support( 'align-wide' );
	}
	function hc2_site_colors(){ 
		$colors = array();
		$site_colors = get_hc2('settings','site_colors');
		if(($site_colors)){
			$h = 1;
			foreach( $site_colors as $color ) { 
				array_push( $colors, array( 'name' => $color['name'], 'slug' => 'hcube_color_slug_'.$h, 'color' => $color['color'] ) );
				$h++;
			}
		}
		return $colors; 
	}
	
	add_action( 'admin_init', 'hcube_registerlangs' );
	function hcube_registerlangs(){
		$languages = get_hc2('settings','languages');
		foreach( $languages as $lang )update_option('hc2_lang_id_'.$lang,wp_create_category($lang));
	}
	
	add_action( 'admin_menu', 'hcube_addsettings' );
	function hcube_addsettings(){ 
		add_menu_page( 'Settings', 'H-Cube Tools', 'manage_options', 'hcube_settings', 'hcube_createpage_settings', 'dashicons-screenoptions', 90 );
		add_submenu_page('hcube_settings', 'Settings', 'Settings', 'manage_options', 'hcube_settings' );
	}
								
    function hcube_createpage_settings(){
		
        ?>
			<div class="wrap">
				<script>
					function hc2_toggleme(t){
						if(t.parentNode.dataset.open != 'true'){t.parentNode.dataset.open = 'true';}
						else if(t.parentNode.dataset.open == 'true'){t.parentNode.dataset.open = 'false';}
					}

				</script>
				<style>
					[onclick*="hc2_toggleme(this)"] {padding:10px;font-family:arial;letter-spacing: 1px;height: 20px;margin-bottom: 20px;overflow: hidden;}
					[onclick*="hc2_toggleme(this)"][data-open='true'] {height: auto;}
					[onclick*="hc2_toggleme(this)"]:before {content: 'Example';display: block;border: 1px solid;width: 100px;text-align: center;cursor: pointer;margin-bottom:20px;}
					[onclick*="hc2_toggleme(this)"][data-open='true']:before {content: 'Close';display: block;border: 1px solid;width: 100px;text-align: center;cursor: pointer;}
					td.hcube_code > div + div {display: none;padding: 0 20px 20px 20px;}	
					td.hcube_code[data-open='true'] > div + div {display: block !important;}
					.hcube_settings td>h3 {font-size: 14px;}
					.hcube_settings td>h2 {font-size: 24px;}
					h3 + input {display: inline-block;}
					h3 {display: inline-block;margin-right: 20px;}
				</style>
				<form method="post" action="options.php">	
					<?php settings_fields( 'hcube_option_group' ); ?>
					<?php do_settings_sections( 'hcube_option_group' );	?>			
					<h1 class='hcube_title'>Settings</h1>
					<table class='hcube_settings'>
						
						<tr><td class='hcube_subsettings_box'><h2>Business Details</h2><div class='hcube_subsettings_toggle' data-target='hcube_locations'></div></td></tr>
						
								
								
						<tr><td><table class='hcube_submenu hcube_locations'>
							<tr><td class='hcube_code' colspan=3><div onclick="hc2_toggleme(this);">Example</div><div>
								{</br>
								&nbsp;&nbsp;&nbsp;&nbsp;"settings" : {</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"languages" : [ "EN" ],</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"business_type" : "Dentist",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"favicon_id" : 0,</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"logo_id" : 0,</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"mobile_zoom_target" : "450px",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"global_header_id" : 0,</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"global_footer_id" : 0,</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"megamenu_post_id" : 0,</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"use_authors" : 0,</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"edit_mode" : 0,</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"google_api_key" : "",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"facebook_chat" : "",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"facebook_chat_text" : "",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"body_color" : "#ffffff",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"site_colors" : [</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{ "name": "White", "color": "#ffffff" },</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{ "name": "Black", "color": "#000000" }</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]</br>
								&nbsp;&nbsp;&nbsp;&nbsp;},</br>
								&nbsp;&nbsp;&nbsp;&nbsp;"places" : {</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"My First Location" : {</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"name" : "Saldan Construction Group - Toronto",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"telephone" : "(647) 282-6044",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"fax" : "(647) 282-6044",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"owner" : "Dr. Gray",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"email" : "drgray@thisbusiness.com",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"website" : "drgray.com",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"hours" : [</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"Mo-Th 09:00-19:00",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"Fr,Su 10:00-17:00",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"Sa 9:00-17:00"</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;],</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"alt-hours" : [</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"&lt;b&gt;Monday - Thursday&lt;/b&gt; 9:00am - 7:00pm&lt;/br&gt;",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"&lt;b&gt;Friday, Sunday&lt;/b&gt; 10:00am - 5:00pm&lt;/br&gt;",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"&lt;b&gt;Saturday&lt;/b&gt; 9:00am - 5:00pm&lt;/br&gt;"</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;],</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"priceRange" : "$-$$$",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"streetAddress" : "3 Navy Wharf Court, Suite 2901",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"addressLocality" : "Toronto",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"addressLocalityPre" : "NE",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"addressRegion" : "ON",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"postalCode" : "M5V 3V1",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"addressCountry" : "CA",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"latitude" : 43.640267,</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"longitude" : -79.391006,</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"social" : {</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"facebook" : "facebook.com",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"twitter" : "twitter.com",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"pinterest" : "pinterest.com",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"linkedin" : "linkedin.com",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"youtube" : "youtube.com",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"google" : "google.com",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"instagram" : "instagram.com",</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"yelp" : "yelp.com"</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;},</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"My Second Location" : {&nbsp;&nbsp;&nbsp;&nbsp;</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}</br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</br>
								&nbsp;&nbsp;&nbsp;&nbsp;}</br>
								}</br>		
							</div></td></tr>
						
							<tr><td colspan=3><textarea style='min-height: 400px;width: 1000px;max-width:100%;' class='' name="hc2_" ><?php echo esc_attr(get_option('hc2_')); ?></textarea></td></tr>
						
						</table></td></tr>
						
						<tr><td class='hcube_subsettings_box'><h2>Consent Content</h2><div class='hcube_subsettings_toggle' data-target='hcube_fonts'></div></td></tr>
						<tr><td><table class='hcube_submenu hcube_fonts'><tr>
						
								<tr><td colspan=2><textarea style='min-height: 80px;width: 600px;max-width:100%;' class='' name="hc2_consent_content" ><?php echo esc_attr(get_option('hc2_consent_content')); ?></textarea></td></tr>
						
						<tr><td class='hcube_subsettings_box'><h2>Pinned Bar Content</h2><div class='hcube_subsettings_toggle' data-target='hcube_fonts'></div></td></tr>
						<tr><td><table class='hcube_submenu hcube_fonts'><tr>
						
								<tr><td colspan=2><textarea style='min-height: 80px;width: 600px;max-width:100%;' class='' name="hc2_pinned_content" ><?php echo esc_attr(get_option('hc2_pinned_content')); ?></textarea></td></tr>
								
								
								
								
						</tr></table></td></tr>
						
						<tr><td class='hcube_subsettings_box'><h2>Fonts</h2><div class='hcube_subsettings_toggle' data-target='hcube_fonts'></div></td></tr>
						<tr><td><table class='hcube_submenu hcube_fonts'><tr>
						
								<?php
									$url = "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyBqEsszV2wuNZxFnOcSbMnOaYRWCjKqS3A";
									$ch = curl_init();curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);curl_setopt($ch, CURLOPT_HEADER, false);curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);curl_setopt($ch, CURLOPT_URL, $url);curl_setopt($ch, CURLOPT_REFERER, $url);curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
									$result = json_decode(curl_exec($ch));curl_close($ch);
	
								?>
		
								<tr><td ><h3>Body</h3></td>					<td><select class=' hcube_fontselect' name="hcube_font_body"><?php echo hcube_font_list($result,'hcube_font_body'); ?></select></td><td class="hcube_font_preview"><p style='font-family:"<?php echo get_option('hcube_font_body');?>"' class="hcube_font_body">Welcome to H-cube Marketing.</p></td></tr>
								<tr><td ><h3>Heading 1</h3></td>			<td><select class=' hcube_fontselect' name="hcube_font_headingone"><?php echo hcube_font_list($result,'hcube_font_headingone'); ?></select></td><td class="hcube_font_preview"><h1 style='font-family:"<?php echo get_option('hcube_font_headingone');?>"' class="hcube_font_headingone">Welcome to H-cube Marketing.</h1></td></tr>
								<tr><td ><h3>Heading 2</h3></td>			<td><select class=' hcube_fontselect' name="hcube_font_headingtwo"><?php echo hcube_font_list($result,'hcube_font_headingtwo'); ?></select></td><td class="hcube_font_preview"><h2 style='font-family:"<?php echo get_option('hcube_font_headingtwo');?>"' class="hcube_font_headingtwo">Welcome to H-cube Marketing.</h2></td></tr>
								<tr><td ><h3>Heading 3</h3></td>			<td><select class=' hcube_fontselect' name="hcube_font_headingthree"><?php echo hcube_font_list($result,'hcube_font_headingthree'); ?></select></td><td class="hcube_font_preview"><h3 style='font-family:"<?php echo get_option('hcube_font_headingthree');?>"' class="hcube_font_headingthree">Welcome to H-cube Marketing.</h3></td></tr>
								<tr><td ><h3>Heading 4</h3></td>			<td><select class=' hcube_fontselect' name="hcube_font_headingfour"><?php echo hcube_font_list($result,'hcube_font_headingfour'); ?></select></td><td class="hcube_font_preview"><h4 style='font-family:"<?php echo get_option('hcube_font_headingfour');?>"' class="hcube_font_headingfour">Welcome to H-cube Marketing.</h4></td></tr>
								<tr><td ><h3>Heading 5</h3></td>			<td><select class=' hcube_fontselect' name="hcube_font_headingfive"><?php echo hcube_font_list($result,'hcube_font_headingfive'); ?></select></td><td class="hcube_font_preview"><h5 style='font-family:"<?php echo get_option('hcube_font_headingfive');?>"' class="hcube_font_headingfive">Welcome to H-cube Marketing.</h5></td></tr>
								<tr><td ><h3>Heading 6</h3></td>			<td><select class=' hcube_fontselect' name="hcube_font_headingsix"><?php echo hcube_font_list($result,'hcube_font_headingsix'); ?></select></td><td class="hcube_font_preview"><h6 style='font-family:"<?php echo get_option('hcube_font_headingsix');?>"' class="hcube_font_headingsix">Welcome to H-cube Marketing.</h6></td></tr>
								
								<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>			
								<script>WebFont.load({google: { families: ["<?php echo get_option('hcube_font_body').'","'.get_option('hcube_font_headingone').'","'.get_option('hcube_font_headingtwo').'","'.get_option('hcube_font_headingthree').'","'.get_option('hcube_font_headingfour').'","'.get_option('hcube_font_headingfive').'","'.get_option('hcube_font_headingsix'); ?>"] } });</script>
								<script>jQuery('.hcube_fontselect').on('change',function(e){var ele = e.delegateTarget;jQuery('.'+ele.name).css( 'font-family',ele.options[ele.selectedIndex].value.replace('*','') );WebFont.load({google: { families: [ele.options[ele.selectedIndex].value] } });});</script>
						
						</tr></table></td></tr>
						<tr><td><?php submit_button();?></td></tr>
					</table>				
				</form>
			</div>
        <?php }
		
		