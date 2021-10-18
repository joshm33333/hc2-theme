<?php

	if ( ! defined( 'ABSPATH' ) ) exit;

	add_filter('admin_title', 'my_admin_title', 10, 2);
	function my_admin_title($admin_title, $title)
	{	
		global $action;
		if( $action == 'edit' ){
			return get_the_title();
		}
		return $title;
	}
			
	add_action( 'admin_footer', 'hcube_admin_head' );
	function hcube_admin_head(){
		
			$fontstring = rtrim(str_replace(' ','+',
				( strpos( get_option('hcube_font_body'), '*' ) === false ? get_option('hcube_font_body').'|' : "" ).
				( strpos( get_option('hcube_font_headingone'), '*' ) === false ? get_option('hcube_font_headingone').'|' : "" ).
				( strpos( get_option('hcube_font_headingtwo'), '*' ) === false ? get_option('hcube_font_headingtwo').'|' : "" ).
				( strpos( get_option('hcube_font_headingthree'), '*' ) === false ? get_option('hcube_font_headingthree').'|' : "" ).
				( strpos( get_option('hcube_font_headingfour'), '*' ) === false ? get_option('hcube_font_headingfour').'|' : "" ).
				( strpos( get_option('hcube_font_headingfive'), '*' ) === false ? get_option('hcube_font_headingfive').'|' : "" ).
				( strpos( get_option('hcube_font_headingsix'), '*' ) === false ? get_option('hcube_font_headingsix').'|' : "" )
			));
			if($fontstring)echo "<link crossorigin  href='https://fonts.googleapis.com/css?family=".$fontstring."&display=swap' rel='stylesheet'>" ;
			?> 
			<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
			
			<style>
				.block-editor-writing-flow a {color: inherit;}
				 .block-editor-writing-flow body, .block-editor-writing-flow p, .block-editor-writing-flow span, .block-editor-writing-flow li, .block-editor-writing-flow a{
					 font-family:<?php if ( substr( get_option('hcube_font_body'), 0, 1 ) === "*" ) {echo str_replace('*','',get_option('hcube_font_body'));}else{echo '"'.get_option('hcube_font_body').'"';}?>}
				 .block-editor-writing-flow h1{font-family:<?php if ( substr( get_option('hcube_font_headingone'), 0, 1 ) === "*" ) {echo str_replace('*','',get_option('hcube_font_headingone'));}else{echo '"'.get_option('hcube_font_headingone').'"';}?>}
				 .block-editor-writing-flow h2{font-family:<?php if ( substr( get_option('hcube_font_headingtwo'), 0, 1 ) === "*" ) {echo str_replace('*','',get_option('hcube_font_headingtwo'));}else{echo '"'.get_option('hcube_font_headingtwo').'"';}?>}
				 .block-editor-writing-flow h3{font-family:<?php if ( substr( get_option('hcube_font_headingthree'), 0, 1 ) === "*" ) {echo str_replace('*','',get_option('hcube_font_headingthree'));}else{echo '"'.get_option('hcube_font_headingthree').'"';}?>}
				 .block-editor-writing-flow h4{font-family:<?php if ( substr( get_option('hcube_font_headingfour'), 0, 1 ) === "*" ) {echo str_replace('*','',get_option('hcube_font_headingfour'));}else{echo '"'.get_option('hcube_font_headingfour').'"';}?>}
				 .block-editor-writing-flow h5{font-family:<?php if ( substr( get_option('hcube_font_headingfive'), 0, 1 ) === "*" ) {echo str_replace('*','',get_option('hcube_font_headingfive'));}else{echo '"'.get_option('hcube_font_headingfive').'"';}?>}
				 .block-editor-writing-flow h6{font-family:<?php if ( substr( get_option('hcube_font_headingsix'), 0, 1 ) === "*" ) {echo str_replace('*','',get_option('hcube_font_headingsix'));}else{echo '"'.get_option('hcube_font_headingsix').'"';}?>}
				 
				[href="admin.php?page=ai1wm_export"] .wp-menu-name:before {content: 'Migration';font-size: 14px;}
				[href="admin.php?page=ai1wm_export"] .wp-menu-name {font-size: 0;}

				.wp-block {max-width: 1200px;}
				.block-editor-writing-flow .is-reusable {width: 100% !important;margin: 0 !important;max-width: 100% !important;}

				.block-editor-writing-flow .hc2-button-fullwidth, .hc2-button-fullwidth * {width: 100% !important;}

				.block-editor-writing-flow .hc2-html-minimize:before {content: 'HTML';border: 1px outset gray;font-family:arial;display: block;background: white;color: #757575;height: 40px;text-align: center;line-height: 2.5;width: 130px;border-radius: 4px;margin: auto;}
				.block-editor-writing-flow .hc2-html-minimize.hc2-html-notice-CSS:before {content: 'CSS';}
				.block-editor-writing-flow .hc2-html-minimize.hc2-html-notice-JavaScript:before {content: 'JavaScript';}
				.block-editor-writing-flow .hc2-html-minimize.hc2-html-notice-PHP:before {content: 'PHP';}
				.block-editor-writing-flow .hc2-html-minimize {max-height: 40px;overflow: hidden;border-radius:4px;}
				.block-editor-writing-flow .hc2-html-minimize div{display:none;}
				.hc2-html-maximize > textarea{max-height:initial !important}

				.hcube_marginbox:before{content: 'Margin';display: block;margin: 8px 12px;font-family: arial;font-size: 10px;}
				.hcube_marginbox + .hcube_marginbox:before{content: 'Padding';}
				.hcube_marginbox{width: 200px;height: 90px;margin: 20px auto auto auto;border: 2px solid #007cba;overflow: hidden;position: relative;}
				.hcube_marginbox input{width: 50px !important;display: block;position: absolute;font-size: 10px !important;float: left;margin-right: 10px;}
				.hcube_marginbox > *:nth-child(1) input{left: 10px;top: 30px;}
				.hcube_marginbox > *:nth-child(2) input{right: 0;top: 30px;}
				.hcube_marginbox > *:nth-child(3) input{left: 75px;top: 10px;}
				.hcube_marginbox > *:nth-child(4) input{left: 75px;top: 50px;}
				.hcube_marginbox label{display: none !important;}

				.hc2_legacy_control.components-button-group {margin-bottom: 20px;}
				.hc2_background_image {  position: absolute !IMPORTANT;left: 0;}
				.wp-block[data-align=full] {max-width: none;}


				.hcube-block-image-minimized img {height: 100px !important;width: auto !important;}
				.hcube-block-image-minimized * {text-align: center;}
				.hcube-block-group-minimized {max-height: 200px;overflow: hidden;}
				.hcube-block-group-minimized:after {box-shadow: inset 0 -100px 30px -80px black;content: '';width: 100%;height: 60px;display: block;position: absolute;bottom: 0;left: 0;}
				.hcube_smallControsl .components-button-group {margin-bottom: 20px;}
				.hcube_indentedControls {padding: 10px 10px 0 10px;border: 2px solid #007cba;margin-bottom: 20px;}

				.menu-item-edit-active > div.menu-item-settings {display: grid !important;grid-template-columns: 50% 50% !IMPORTANT;}
				div.menu-item-settings > * {width: calc(100% - 20px);text-align: right;}
				.update-nag {display: none;}

				[onclick="hc2_clearban(this)"] {display: inline-block;background: #2271b1;color: white;padding: 2px 9px;border-radius: 2px;margin: 2px;cursor: pointer;}
				[onclick="hc2_clearban(this)"]:hover {background:#135e96;}

				.ratelimit_box {height: 300px;width: 500px;overflow: scroll;background: white;padding: 10px;border-radius: 7px;border: 1px solid;box-shadow: 0 5px 5px -5px;}
				.ratelimit_box label {display: inline-block;overflow: hidden;white-space: nowrap;border: 1px solid;padding: 0 5px;margin: 0 5px;}
				.ratelimit_box label:first-child {width: 200px;}

				p.field-link-target:not(#_) {
					display: block !important;
					grid-area: 4 / 2;
				}

				p.field-link-target:not(#_) input {
					float: right;
					margin: 5px;
				}

				.menu-item-actions.description-wide.submitbox {
					grid-area: 5 / 1 / 1 span / 2 span;
					padding-left: 7px;
				}
			</style>

		<?php
	}








			
