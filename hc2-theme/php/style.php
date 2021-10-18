<?php
		
		
	function hc2_header_styles($thispage_id){ 
		?>
		<style amp-custom>
		
			<?php
				
			$site_colors = get_hc2('settings','site_colors');
			if(($site_colors)){
				$h = 1;
				foreach( $site_colors as $color ) { 
					echo ':not(#_) .has-hcube-color-slug-'.$h.'-background-color{background-color:'.$color['color'].'}'; 
					echo ':not(#_) .has-hcube-color-slug-'.$h.'-color{color:'.$color['color'].'}'; 
					$h++;
				}
			}
			

			?>
a.hc2_editme {
    position: fixed;
    z-index: 999999999999;
    display: block;
    left: 0px;
    bottom: 0px;
    padding: 7px;
    opacity: 0;
    font-size: 25px;
}

a.hc2_editme:before {content: '✎';color: #f0971f;}

a.hc2_editme:hover {
    opacity: 1;
}
  img{max-width: 100%;height: auto;}
				body{background:<?php echo get_hc2('settings','body_color'); ?>}
			
				 body, p, p *, span, span *, li, li *, a:not(#_), a *{font-family:<?php if ( substr( get_option('hcube_font_body'), 0, 1 ) === "*" ) {echo str_replace('*','',get_option('hcube_font_body'));}else{echo '"'.get_option('hcube_font_body').'"';}?>}
				 h1,h1 *{font-family:<?php if ( substr( get_option('hcube_font_headingone'), 0, 1 ) === "*" ) {echo str_replace('*','',get_option('hcube_font_headingone'));}else{echo '"'.get_option('hcube_font_headingone').'"';}?>}
				 h2,h2 *{font-family:<?php if ( substr( get_option('hcube_font_headingtwo'), 0, 1 ) === "*" ) {echo str_replace('*','',get_option('hcube_font_headingtwo'));}else{echo '"'.get_option('hcube_font_headingtwo').'"';}?>}
				 h3,h3 *{font-family:<?php if ( substr( get_option('hcube_font_headingthree'), 0, 1 ) === "*" ) {echo str_replace('*','',get_option('hcube_font_headingthree'));}else{echo '"'.get_option('hcube_font_headingthree').'"';}?>}
				 h4,h4 *{font-family:<?php if ( substr( get_option('hcube_font_headingfour'), 0, 1 ) === "*" ) {echo str_replace('*','',get_option('hcube_font_headingfour'));}else{echo '"'.get_option('hcube_font_headingfour').'"';}?>}
				 h5,h5 *{font-family:<?php if ( substr( get_option('hcube_font_headingfive'), 0, 1 ) === "*" ) {echo str_replace('*','',get_option('hcube_font_headingfive'));}else{echo '"'.get_option('hcube_font_headingfive').'"';}?>}
				 h6,h6 *{font-family:<?php if ( substr( get_option('hcube_font_headingsix'), 0, 1 ) === "*" ) {echo str_replace('*','',get_option('hcube_font_headingsix'));}else{echo '"'.get_option('hcube_font_headingsix').'"';}?>}

				html{min-width:<?php if(get_hc2('settings','mobile_zoom_target')){ echo get_hc2('settings','mobile_zoom_target'); }else{ echo '450px'; } ?>;}

				/* Text meant only for screen readers. */
				.screen-reader-text {border: 0;clip: rect(1px, 1px, 1px, 1px);clip-path: inset(50%);height: 1px;margin: -1px;overflow: hidden;padding: 0;position: absolute;width: 1px;word-wrap: normal !important;}
				*{-webkit-tap-highlight-color: transparent !important;}
				.screen-reader-text:focus {background-color: #eee;clip: auto !important;clip-path: none;color: #444;display: block;font-size: 1em;height: auto;left: 5px;line-height: normal;padding: 15px 23px 14px;text-decoration: none;top: 5px;width: auto;z-index: 100000; /* Above WP toolbar. */}
					
				.fa-facebook-f{color:#3b5998}.fa-twitter{color:#1da1f2}.fa-linkedin{color:#007bb5}.fa-youtube{color:#ff0000}.fa-google{color:#db4437}.fa-snapchat{color:#fffc00}.fa-instagram{color:#c32aa3}.fa-pinterest{color:#bd081c}.fa-yelp{color:#cd2222}.fa-at{color:#000000}.fa-rss{color:#f39838}
				a.hcube-contact-button{padding:20px;border:1px solid;display: inline-block;}
					
				:root:not(#_) blockquote.wp-block-quote > p {border-color: inherit;}
				blockquote > p{ color:inherit;}
				blockquote > cite{ opacity:.7}
				blockquote.wp-block-quote {padding: 10px 20px;border-left: 3px solid black;}
				blockquote.wp-block-quote {padding: 0px;}
				blockquote p {color: inherit !important;}

.wp-block-image[data-parent-height="true"] > figure {
    display: block;
}

label.hc2-hashtag-box:before {content: '#';}

label.hc2-hashtag-box {
  color: #007cff;
  white-space:nowrap;
}

a.hcube-hashtag-link:before {
  font-family: "Font Awesome 5 Brands";
  font-weight: 900;
  font-size: 15px;
}

a.hcube-hashtag-link.hc2-hashtag-facebook:before {
  color: #3b5998;
}

a.hcube-hashtag-link.hc2-hashtag-linkedin:before {
  color: #007bb5;
}

a.hcube-hashtag-link.hc2-hashtag-instagram:before {
  color: #c32aa3;
}

a.hcube-hashtag-link.hc2-hashtag-pinterest:before {
  color: #bd081c;
}

a.hcube-hashtag-link.hc2-hashtag-twitter:before {
  color: #1da1f2;
}

label.hc2-hashtag-box a {
  text-decoration: none !important;  padding: 0 0 0 6px;
}



				.hcube_blog_grid .hcube_blog_item {margin: 20px;}
				.hcube_blog_grid h2:not(#_):not(#_){margin-top: -10px;}
				.hcube_blog_item h2 {font-size: 36px;margin-top: 0px;}
				.hcube_blog_item *:not(h2) {text-decoration: none;}
				.hcube_blog_item > a:focus {background: none;}
				.hcube_blog_grid .hcube_blog_item {width: calc( 33% - 40px );display: inline-block;vertical-align: top;margin-top: 20px;}
				.hcube_blog_grid .hcube_blog_item > a > div {width: 100%;padding: 20px 10px;}
				.hcube_blog_thumb {display: inline-block;text-align: center;padding-left: 20px;box-sizing: border-box;    position: relative;    height: 240px;}
				.hcube_blog_grid .hcube_blog_thumb {  height: 200px;}
				.hcube_blog_list .hcube_blog_thumb {display: inline-block;width: 30%;margin-left:5%;}
				.hcube_blog_preview {display: inline-block;width: 60%;vertical-align: top;height: 100%;padding: 0px 20px 20px 20px;box-sizing: border-box;}
				.hcube_blog_list [data-image=''] .hcube_blog_thumb {display: none;}
				.hcube_blog_list [data-image=''] .hcube_blog_preview {width:90%;margin-left:5%;}
				.hcube_blog_list .hcube_blog_item {margin-bottom: 40px;}
				#h .hcube_blog_list h2 {margin-top: 0;}
				.hcube_blog_list .hcube_blog_item > a:after {display: block;position: absolute;content: '';width: 80%;height: 1px;background: #cacaca;border-bottom: 1px solid #ececec;bottom: -14px;left: 10%;}
				@media (max-width:1000px){
					.hcube_blog_grid .hcube_blog_item {width: 50%;}
				}
				@media (max-width:800px){
					.hcube_blog_thumb { float: left; margin-right: 20px; margin-bottom: 20px; margin-top: 20px; }
					.hcube_blog_preview { display: inline; width: 100%;}
					.hcube_blog_thumb > * { height: auto;}
				}
				@media (max-width:600px){
					.hcube_blog_grid .hcube_blog_item {width: 100%;margin-left:0;margin-right:0;}
					.hcube_blog_thumb:not(#_) {width:100%;padding-right:20px;margin:0;float:none;}
				}
				.hcube_blog_squares .hcube_blog_item:nth-child(1) h2:not(#_) ,
				.hcube_blog_squares .hcube_blog_item:nth-child(11) h2:not(#_) {font-size: 28px;}
				.hcube_blog_squares .hcube_blog_item:nth-child(1) .hcube_blog_preview ,
				.hcube_blog_squares .hcube_blog_item:nth-child(11) .hcube_blog_preview {padding: 20px;}
				.hcube_blog_squares .hcube_blog_item:nth-child(1) ,
				.hcube_blog_squares .hcube_blog_item:nth-child(11) {width: 66%;height: 600px;}

				.hcube_blog_squares .hcube_blog_preview {    position: relative;width: 100%;height: 100%;display: table-cell;vertical-align: middle;padding: 0;background: #0000008f;transition: all .2s;text-decoration: none;padding-top: 30px;}
				.hcube_blog_squares h4,.hcube_blog_squares p {display: none;}
				.hcube_blog_squares .hcube_blog_preview h2:not(#_) {position: relative;font-size: 18px;padding: 10px 20px;color: white;text-decoration: none;margin: 0;/* border-bottom: 10px solid #5ab0e3; */}
				.hcube_blog_squares .hcube_blog_preview h2:not(#_):before {content: 'Read More';color: white;background: #5ab0e3;display: block;width: 120px;padding: 8px 14px;font-size: 16px;margin: auto auto 10px auto;box-shadow: 0 10px 10px -10px black;}
				.hcube_blog_squares {margin-bottom: 160px;}
				.hcube_blog_squares .hcube_blog_item:hover .hcube_blog_preview {background: #000000cc;}
				.hcube_blog_squares .hcube_monthly {padding-top: 100px;overflow: auto;padding-bottom:50px;}
				.hcube_blog_squares h2 {width: 100%;display: block;position: absolute;text-align: center;top: -15px;}
				.hcube_blog_squares .hcube_blog_item {    position: relative;display: table;width: 33%;overflow: hidden;height: 200px;float: left;box-sizing: border-box;   border: 1px solid #5ab0e3;box-shadow: 0 30px 30px -30px black;}
				.hcube_blog_squares a {width: 100%;height: 100%;display: table-row;    position: relative;}
				.hcube_blog_squares .hcube_blog_thumb, .hcube_blog_squares amp-img {position: absolute;width: 100%;height: 100%;left: 0;top: 0;}

				@media (max-width:900px){
					.hcube_blog_squares .hcube_blog_item:not(#_):not(#_):not(#_){width:100%;height:200px;}
					.hcube_blog_squares .hcube_blog_item h2:not(#_):not(#_):not(#_){font-size:18px;}
				}
						
				amp-img.cover img {object-fit:cover;}
						
				i.hcube_hrs, i.hcube_hrs i {display: inline-grid;font-style: initial;}
				.hcube-menu-open.hcube_pickerbox_iframe, .hcube-menu-open.hcube_pickerbox{display: block;}
				i.hcube_hrs_left {grid-column-start: 1;margin-right: 20px;grid-column-end: 1;}
				.hcube-block-column > wp-block-group.has-background {height: 100%;}
				i.hcube_hrs_right {grid-column-start: 2;grid-column-end: 2;}

				a:not(.wp-block-button__link):hover *,:not(.menu-item) > a:not(.wp-block-button__link):hover{text-decoration:underline}
				amp-accordion > section > :first-child {padding: 10px 20px;}
				li{color: inherit;}
				p a, ol a, ul li:not(.menu-item) a {text-decoration:underline}
				.wp-block-button {outline: none;}
				[data-full-width="true"] > figure {padding: 0;margin: 0;}

				hr.wp-block-separator.is-style-default {width: 300px;}
				hr{border-top-width: 0;border-left-width: 0;border-right-width: 0;}
				blockquote.wp-block-quote {border-left: 3px solid #000;}
				amp-lightbox:not([hidden]):not(#hcube_chatcontainer) > * {margin: auto;background: #fff;position: relative;height: auto;box-sizing: border-box;width: 100%;border: 20px solid white;max-width: 900px;overflow-y: auto;border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;box-shadow: 0 40px 40px -20px black;}
				amp-lightbox:not([hidden]) > div > div > .wp-block-button:nth-child(1) + .wp-block-spacer,amp-lightbox:not([hidden]) > div > div > .wp-block-buttons:nth-child(1) + .wp-block-spacer {display: none;}
				amp-lightbox:not([hidden]) > div > div > .wp-block-button:nth-child(1) > *,amp-lightbox:not([hidden]) > div > div > .wp-block-buttons:nth-child(1) > *,amp-lightbox:not([hidden]) > div > div > .wp-block-buttons:nth-child(1) > * > *{box-shadow:none;position: absolute;top: 0;right: 0;margin: 0;border-radius: 0;width: 100%;text-align: right;box-sizing: border-box;font-weight: bold;box-shadow: none !important;}
				:root:not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_) amp-lightbox:not([hidden]) {display: grid;max-width: 100%;background: #00000070 !important;z-index: 11111111111;}
				amp-lightbox:not([hidden]) > div > div > .wp-block-button:nth-child(1),amp-lightbox:not([hidden]) > div > div > .wp-block-buttons:nth-child(1) {margin-bottom: 60px;float:none;}

				amp-lightbox:not([hidden]) .wp-block-embed-youtube {margin: 0;padding: 0;box-shadow: 0 10px 10px -10px black;}
				:root:not(#_) amp-carousel > div {max-width: initial;}
				#h > amp-base-carousel {max-width: initial;}
				amp-carousel > div > div > [aria-hidden] {transition: all .2s;}
				.hcube_raised_anchor {top: -285px;display: block;position: absolute;}
				amp-carousel > div > div > [aria-hidden="true"] {opacity: 0;}
				amp-accordion > section > :first-child[aria-expanded="true"]:before {background:#5b6098;   content:'-';}
				amp-accordion > section > :first-child[aria-expanded="true"] {color:#5b6098;   }
				amp-accordion > section > :first-child {background:none;   border:none;outline:none;}
				amp-accordion > section > :first-child:hover {color:#5b6098}
				amp-accordion > section > :first-child:hover:before {background:#5b6098;   }
				amp-accordion > section > :first-child:before {background:#333;   content:'+';    color:white;width:15px;height:15px;display:inline-block;font-size:14px;text-align:center;font-weight:400;margin-right:10px;vertical-align:top;margin-top:7px;}
				a:focus {outline: none;background:rgba(0,0,0,.2);}

				.hc2_customsocial{background-size: contain;background-position: center center;width: 1em;height: 1em;display: inline-block;margin: 2px !important;padding: 2px;vertical-align: sub;}
				
				.hcube-icon {text-align: center;}	
				li{position:relative}
				.wp-block-button[data-full-width='true'],.wp-block-button[data-full-width='true'] > * {    width: 100%;box-sizing: border-box;}.hcube-content{width:100%;}
				.hcube-icon i {width: 50px;height: 50px;display: inline-block;border-radius: 50%;}
				.hcube-block-column{margin: 0 auto;  max-width:100%;}
				li.blocks-gallery-item > figure {padding: 0;}
				p {z-index: 0;position: relative;}
				[data-anchor-id]{position: relative;}
				.hcube-icon i:before {line-height: 50px;font-size: 25px;}
					
					
				blockquote.wp-block-quote {font-style: italic;}
				:not(#_) amp-img.amp-wp-enforced-sizes[layout="intrinsic"] > img {object-fit: cover;}
					
				a[role='button'] {cursor: pointer;}
				body:not(#_), html:not(#_) {margin-top: 0px !important;}
				p:empty{display:none;}
				body{min-width: 320px;}
				.hcube-contact p{margin:0;}
				.hcube-contact a{text-decoration:none;}
					
				b.hcube-social {white-space: nowrap;}
				b.hcube-social a{text-decoration:none;}
				b.hcube-social i{margin: 0 6px;}
					
				div.wp-block-columns>div.wp-block-column{flex-grow:1;}
					
				div.hcube-content > [data-full-width='true']:not(.wp-block-video):not(.wp-block-image) > *{box-sizing: border-box;max-width:1200px;margin-left: auto;    margin-right: auto;}
				.fas:not(#_):before{font-family: "Font Awesome 5 Free";font-weight: 900;}
				.fab:not(#_):before {font-family: "Font Awesome 5 Brands";font-weight: 900;}

				.fas:not(#_),.fab:not(#_) {font-family: unset;font-weight: unset;}

				p.fas:not(#_):before,p.fab:not(#_):before {margin-right: 10px;}
				.wp-block-video[data-full-width='true'],.wp-block-image[data-full-width='true']{width:100%;max-width:initial;    margin: 0;float:left;padding: 0;}
				.wp-block-video[data-full-width='true']:not([data-parent-height="true"]), .wp-block-image[data-full-width='true'] img {width: 100%;height: auto !IMPORTANT;}
				.wp-block-image img {height: auto;}
				i[class=''] {display: none;}
				div.hcube-content > div.wp-block-columns {padding:0;position:relative;}
				.wp-block-group {display: block;}
				.wp-block-video[data-fixed-height='true'],.wp-block-image[data-fixed-height='true']  {height:100vh;width:100%;position: relative;}
				.wp-block-video[data-parent-height='true'],.wp-block-image[data-parent-height='true']  {height:100%;width:100%;position: relative;}
				.wp-block-video[data-position-absolute='true'],.wp-block-image[data-position-absolute='true']  {position: absolute;}
				.wp-block-image[data-position-absolute='true']  {display: block;}
				div.wp-block-column:not(:first-child) {margin-left: 0;}
				
				h1[id]:before,h2[id]:before,h3[id]:before,h4[id]:before,h5[id]:before,h6[id]:before { content: ''; display: block; position: relative; width: 0; height: 5em; margin-top: -5em }

				amp-fit-text h1:not(#_):not(#_):not(#_):not(#_) {font-size: inherit;margin: 0;}
				amp-fit-text h1:not(#_):not(#_):not(#_):not(#_){padding:0}
				amp-fit-text h2:not(#_):not(#_):not(#_):not(#_){padding:0}
				amp-fit-text h3:not(#_):not(#_):not(#_):not(#_){padding:0}
				amp-fit-text h4:not(#_):not(#_):not(#_):not(#_){padding:0}
				amp-fit-text h5:not(#_):not(#_):not(#_):not(#_){padding:0}
				amp-fit-text h6:not(#_):not(#_):not(#_):not(#_){padding:0}

				ul:not(.sub-menu):not(.blocks-gallery-grid), ol{
				padding-right: 20px;}
				.wp-block-button.alignleft{margin-left: 20px;}
				.wp-block-button.alignright{margin-right: 20px;}
				.wp-block-button{margin-bottom: 10px;z-index: 1;}
				.wp-block-button + .wp-block-button.alignleft{margin-left: 10px;}
				.wp-block-button.alignright + .wp-block-button{margin-right: 10px;}
				div.wp-block-columns,div.wp-block-column {margin-bottom: 0;}
				.wp-block-group{position: relative;padding: .1px;}
				.wp-block-group{box-sizing: border-box;max-width:1200px;margin-left: auto;    margin-right: auto;}
				.wp-block-group:not(amp-lightbox)>div{box-sizing: border-box;max-width:1200px;margin-left: auto;    margin-right: auto;}

					.amp-carousel-button{ z-index:1;}
				[data-top-padding='quarter'] > * { padding-top: 15vh;}
				[data-top-padding='half'] > * { padding-top: 34vh;}
				[data-top-padding='threequarters'] > * { padding-top: 50vh;}
				.has-normal-font-size:not(#_) {font-size:16px;}
				.has-small-font-size:not(#_) {font-size:13px;}
				.has-medium-font-size:not(#_) {font-size:20px;}
				.has-large-font-size:not(#_) {font-size:36px;}
				.has-huge-font-size:not(#_) {font-size:48px;}		
						
				:root .wp-google-powered:not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_) {position: relative;width: 140px;}
				:root .wp-google-left > * {display:none;}
				.wp-google-time:not(#_) {display: none;			}
				:root:not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_) .wp-gr .wp-google-rating {color: #e7711b;font-size: 20px;margin: 0 6px 0 0;vertical-align: middle;}
				.grwbutton_write:not(#_),.grwbutton:not(#_),.grwbutton_more:not(#_){   margin-bottom: -110px;float: right;}.wp-google-url:not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_) {border: 1px solid #3079ed;border-radius: 2px;color: #fff;max-width: 120px;text-align: center;}
				.wp-gr .wp-google-rating {color: #e7711b!important;font-size: 20px!important;margin: 0 6px 0 0!important;vertical-align: middle!important;}
				.grwbutton_write:not(#_) > *,.grwbutton:not(#_) > *,.grwbutton_more:not(#_) > * { background-color: #4d90fe;background-image: -webkit-linear-gradient(top,#4d90fe,#4787ed);border: 1px solid #3079ed !important;border-radius: 2px !important;color: #fff !important;font-size: 11px;font-weight: bold;height: 27px;line-height: 27px;padding: 0 8px;font-family: arial,sans-serif;position: relative;z-index: 1000000;margin: 40px;}
				.grwbutton_write:not(#_) > *:hover,.grwbutton:not(#_) > *:hover,.grwbutton_more:not(#_) > *:hover {background-color: #4d90fe;background-image: -webkit-linear-gradient(top,#4d90fe,#4787ed);border-color: #2f5bb7 !important;}
				.fusion-footer-widget-column{margin-bottom:15px;}
				.wpac .wp-google-list {border: 1px solid #d5d5d5 !important;box-shadow: 0 2px 4px #d5d5d5 !important;padding: 40px !important;}
				.wpac .wp-google-name:not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_) span {font-size: 28px !important;font-weight: normal !important;font-family: arial,sans-serif !important;}
				.wp-gr.wpac .wp-google-left:not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_) img {display: none;}
				.wpac .wp-google-name:not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_) {margin-bottom: 10px !important;}
				span.wp-more-toggle {display: none;}
				.wp-block-button.grwbutton_more:not(#_) {text-align: left;margin-bottom: 0px;margin-top: -100px;}
				.wpac .wp-google-list:not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_) {border: 1px solid #d5d5d5 !important;box-shadow: 0 2px 4px #d5d5d5 !important;padding: 40px !important;padding-bottom: 100px !important;}
				:root:not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_) .wp-gr .wp-google-stars .wp-star {padding: 0 4px 0 0;line-height: 22px;}
				:root:not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_) .wp-gr .wp-google-review {margin-top: 15px;}
				span.wp-more:not(#_) {display: inline;}		
				a.wp-google-url:not(#_) {display: none;}
				.wp-block-video[data-fixed-height='true']  > *,.wp-block-image[data-fixed-height='true']  > *,.wp-block-video[data-parent-height='true']  > *,.wp-block-image[data-parent-height='true'] * {position: absolute;top: 0;bottom: 0;width: 100%;min-height: 100% !IMPORTANT;overflow: hidden;}

				.wp-block-video[data-fixed-height='true']  > * > *,
				.wp-block-image[data-fixed-height='true']  > * > *,
				.wp-block-video[data-parent-height='true']  > * > *,
				.wp-block-image[data-parent-height='true']  > * > *,
				.wp-block-video[data-fixed-height='true']  > video,
				.wp-block-image[data-fixed-height='true']  > img,
				.wp-block-video[data-parent-height='true']  > video,
				.wp-block-image[data-parent-height='true']  > img{min-width: 100%;min-height: 100%;max-height: initial;max-width: initial;width: auto;height: auto;position: absolute;left: 50%;transform: translateX(-50%);
    object-fit: cover;
    max-height: 100%;
    max-width: 100%;}

				.is-style-position-absolute {position: absolute;}
				@media (max-width:800px){
					.wp-block-image:not([data-mobileoff="true"]) > figure {width: 100%;text-align: center;}
				}
						

				div.hcube-content > .hcube_blog_item {display: block;margin-top: 50px;padding: 0;overflow: hidden;margin-bottom: 50px;height: auto;}
				.hidden{display:none;	}
				.hcube_blog_item:after {pointer-events: none;}

				img.hcube_imagePreview {background: black;height: 70px;margin-bottom: 20px;padding: 10px;}
				a {text-decoration: none;color: inherit;font-family: inherit;}

				.chatbutton_container {position: fixed;bottom: 30px;left: 0;right: 0;margin: auto;width: 2000px;max-width: 100%;z-index: 1000;}
				@media (max-width:1000px) and (min-width:800px){
					.wp-block-image .alignright,.wp-block-image .alignleft {max-width: 60%;
				}}
				button.hcube_chatbutton {position: absolute;right: 40px;bottom: 40px;width: 200px;height: 60px;padding-right:70px;font-weight: bold;font-size: 18px;text-shadow: 1px 1px 2px black, -1px -1px 2px black,-1px 1px 2px black, 1px -1px 2px black;text-align:right;background: url(<?php echo get_site_url(); ?>/wp-content/themes/hc2-theme/assets/fblogo.png);background-size: contain;background-position: 100% center;background-repeat:no-repeat;border: none;cursor: pointer;color:#fff;}
				.hcube-mega-media > div {background: transparent !important;}

				@keyframes bounce { 
				  0%, 20%, 47.5%, 52.5%, 80%, 100% {transform: translateY(0);}
				  50% {transform: translateY(-20px);}
				} 

				.hcube_chatbutton { animation-name: bounce;animation-duration: 10s; animation-fill-mode: both; animation-timing-function: cubic-bezier(0.79, 0.1, 0.47, 1.59); animation-iteration-count: infinite;}
				.hcube_chatbox {margin: auto;left: 0;right: 0;position: absolute;width: 320px;max-width: 100%;background: white;border: 1px solid #ccc;top: calc( ( 100vh - 630px ) / 2 );height:630px;z-index: 10000000000;padding: 20px;border-radius: 5px;box-sizing:border-box;box-shadow: 0 20px 20px -20px black;}

				amp-lightbox#hcube_chatcontainer {background: #00000059 !important;z-index: 100000000000;}
				.h amp-fit-text h1 ,.h amp-fit-text h2 ,.h amp-fit-text h3 ,.h amp-fit-text h4 ,.h amp-fit-text h5 ,.h amp-fit-text h6 ,.h amp-fit-text p {font-size: inherit;}
										
				.wp-block-buttons.alignleft {text-align: left;}
				.wp-block-buttons.alignright {text-align: right;}

				.hcube_chatbox > p {margin-bottom: 1px;}
				@media (max-width:700px){
					.wp-block-hcube-locations amp-img:not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_){width:100%;margin-left:auto;margin-right:auto;}
				}
				.hcube_chatbox > button {padding: 4px 20px;margin-top: -8px;font-size: 16px;float: right;margin-bottom: 10px;background: #00a3fe;color: white;border: none;border-radius: 3px;cursor: pointer;}
				.hcube_chatbox p {margin-top: 0;text-align: center;}
				@media (max-width:600px){
					:root:not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_) .wpac .wp-google-list:not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_) {    padding-top: 100px;}
				}
				.cookiebox {position: sticky;bottom: 0;width: 100%;z-index: 11111111111111;}
				.cookiebox.cookieboxb {background: #242424;pointer-events: none;height: 51px;position: static;margin-top: -51px;}
				.cookiebox.cookieboxb.cookiebox_alt_closed {height: 130px;margin-top: -129px;}
				div#cookiebox_inner {background: #373737;text-align: center;cursor: pointer;}

				div#cookiebox_inner * {color: white;display: inline-block;}
				a.wp-block-button.aligncenter:not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_) {display: table !important;    margin: auto;}
				a.wp-block-button.alignright:not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_) {display: table;margin: auto;margin-right: 0;}
				.wp-block-button.aligncenter {text-align: center;}

				.wp-block-button.alignright {text-align: right;}
				.confirm {border: 1px solid;padding: 10px 20px;margin: 10px;}

				div#cookiebox_inner.cookiebox_inner_closed,.pass_visit {display: none;}
				p, h1, h2, h3, h4, h5, cite, figure, .hcube-social { padding-left: 20px;padding-right: 20px;box-sizing: border-box;}
				
				/*new since hc2*/
				.wp-block-group{overflow:hidden;}
				.alignfull,.wp-block-group.alignfull>div{max-width: initial !important;}
				.alignwide,.wp-block-group.alignwide>div {max-width: 1400px !important;}
				.wp-block-cover {box-sizing: border-box !important;}
				*{font-family:arial}
				amp-call-tracking a{display: none;white-space:nowrap;}
				amp-call-tracking a.hc2_act_initial{display: inline;}
				.wp-block-video *{height:auto !important;max-height:initial !important;min-height:initial !important;}
				amp-call-tracking {display: inline !IMPORTANT;}
				.h > * {max-width: 1200px;margin-left: auto;margin-right: auto;}
				figure[amp-fx="parallax"].alignfull  > * > * {left: 50% !important;transform:translateX(-50%);}
				figure[amp-fx="parallax"].alignfull, figure[amp-fx="parallax"].alignfull * {padding: 0;margin: 0;min-height: 100% !important;height: 100% !important;max-width: initial !important;width: auto;}
				nav[data-full-width="true"] {max-width: 100%;}
				i.hcube_hrs {margin: 0 20px;}
				figcaption {display: none !important;}
				:root:not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_) .alignfull, :root:not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_) .wp-block-group.alignfull > div{ max-width:100%; }
				body {margin: 0 !IMPORTANT;}
				.elementor-image img{ display: initial !important; }
				sub > img:not(amp-img) {height: auto !important;display: inline !important;}
				.wp-block-columns > .wp-block-group {display: none;}
				figure.alignright{float: right;}
				figure.alignleft{float: left;}

				div#consent-ui {max-width: 1200px;margin: auto;text-align: center;padding: 7px;}
				div#consent-ui div {display: inline;margin-right: 10px;}
				amp-consent {background: #212326;color: white;border-top: 2px solid black;bottom: -1px !IMPORTANT;}
				div#consent-ui button {background: #3c3c3c;color: white;border: none;padding: 7px 24px;font-size: 14px;}
				hr {border-color: #8f8f8f;}
				amp-img amp-img:not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_):not(#_) {display: none !IMPORTANT;}

				@media (max-width:800px){
					.wp-block-cover .wp-block-cover__inner-container {width: 100% !important;}
				}
				nav a:focus,nav a:active{outline:1px solid !important;}
				input[type='date']{-webkit-appearance: none;}
				input[type='submit']{-webkit-appearance: none;}
.wp-google-list {
    max-height: 500px;
    overflow: hidden;
    position: relative;
}

.wp-google-list:after {
    width: 100%;
    content: '';
    height: 120px;
    bottom: 0;
    left: 0;
    position: absolute;
    box-shadow: inset 0 -40px 60px 30px white;
}
.i-amphtml-layout-responsive, [layout=responsive][width][height]:not(.i-amphtml-layout-responsive), [width][height][heights]:not([layout]):not(.i-amphtml-layout-responsive), [width][height][sizes]:not([layout]):not(.i-amphtml-layout-responsive) {
    display: inline-block;
}

amp-consent#consent-element {
    max-width: initial !important;
}

amp-list[layout="responsive"]{min-width:100%;min-height:200px;}
#h > amp-list > div {
    max-width: 1200px !important;
    margin: auto !important;
    text-align: center;
}
:root{--wp-admin-theme-color:#007cba;--wp-admin-theme-color-darker-10:#006ba1;--wp-admin-theme-color-darker-20:#005a87}#start-resizable-editor-section{display:none}.wp-block-audio figcaption{margin-top:.5em;margin-bottom:1em}.wp-block-audio audio{width:100%;min-width:300px}.wp-block-button__link{color:#fff;background-color:#32373c;border:none;border-radius:1.55em;box-shadow:none;cursor:pointer;display:inline-block;font-size:1.125em;padding:.667em 1.333em;text-align:center;text-decoration:none;overflow-wrap:break-word}.wp-block-button__link:active,.wp-block-button__link:focus,.wp-block-button__link:hover,.wp-block-button__link:visited{color:#fff}.wp-block-button__link.aligncenter{text-align:center}.wp-block-button__link.alignright{text-align:right}.wp-block-button.is-style-squared,.wp-block-button__link.wp-block-button.is-style-squared{border-radius:0}.wp-block-button.no-border-radius,.wp-block-button__link.no-border-radius{border-radius:0!important}.is-style-outline>.wp-block-button__link,.wp-block-button__link.is-style-outline{border:2px solid}.is-style-outline>.wp-block-button__link:not(.has-text-color),.wp-block-button__link.is-style-outline:not(.has-text-color){color:#32373c}.is-style-outline>.wp-block-button__link:not(.has-background),.wp-block-button__link.is-style-outline:not(.has-background){background-color:transparent}.wp-block-buttons .wp-block-button{display:inline-block;margin-right:.5em;margin-bottom:.5em}.wp-block-buttons .wp-block-button:last-child{margin-right:0}.wp-block-buttons.alignright .wp-block-button{margin-right:0;margin-left:.5em}.wp-block-buttons.alignright .wp-block-button:first-child{margin-left:0}.wp-block-buttons.alignleft .wp-block-button{margin-left:0;margin-right:.5em}.wp-block-buttons.alignleft .wp-block-button:last-child{margin-right:0}.wp-block-button.aligncenter,.wp-block-buttons.aligncenter,.wp-block-calendar{text-align:center}.wp-block-calendar tbody td,.wp-block-calendar th{padding:.25em;border:1px solid #ddd}.wp-block-calendar tfoot td{border:none}.wp-block-calendar table{width:100%;border-collapse:collapse}.wp-block-calendar table th{font-weight:400;background:#ddd}.wp-block-calendar a{text-decoration:underline}.wp-block-calendar table caption,.wp-block-calendar table tbody{color:#40464d}.wp-block-categories.alignleft{margin-right:2em}.wp-block-categories.alignright{margin-left:2em}.wp-block-code code{white-space:pre-wrap;overflow-wrap:break-word}.wp-block-columns{display:flex;margin-bottom:1.75em;flex-wrap:wrap}@media (min-width:782px){.wp-block-columns{flex-wrap:nowrap}}.wp-block-columns.has-background{padding:1.25em 2.375em}.wp-block-columns.are-vertically-aligned-top{align-items:flex-start}.wp-block-columns.are-vertically-aligned-center{align-items:center}.wp-block-columns.are-vertically-aligned-bottom{align-items:flex-end}.wp-block-column{flex-grow:1;min-width:0;word-break:break-word;overflow-wrap:break-word}@media (max-width:599px){.wp-block-column{flex-basis:100%!important}}@media (min-width:600px) and (max-width:781px){.wp-block-column:not(:only-child){flex-basis:calc(50% - 1em)!important;flex-grow:0}.wp-block-column:nth-child(2n){margin-left:2em}}@media (min-width:782px){.wp-block-column{flex-basis:0;flex-grow:1}.wp-block-column[style*=flex-basis]{flex-grow:0}.wp-block-column:not(:first-child){margin-left:2em}}.wp-block-column.is-vertically-aligned-top{align-self:flex-start}.wp-block-column.is-vertically-aligned-center{-ms-grid-row-align:center;align-self:center}.wp-block-column.is-vertically-aligned-bottom{align-self:flex-end}.wp-block-column.is-vertically-aligned-bottom,.wp-block-column.is-vertically-aligned-center,.wp-block-column.is-vertically-aligned-top{width:100%}.wp-block-cover,.wp-block-cover-image{position:relative;background-size:cover;background-position:50%;min-height:430px;height:100%;width:100%;display:flex;justify-content:center;align-items:center;padding:1em;box-sizing:border-box}.wp-block-cover-image.has-parallax,.wp-block-cover.has-parallax{background-attachment:fixed}@supports (-webkit-overflow-scrolling:touch){.wp-block-cover-image.has-parallax,.wp-block-cover.has-parallax{background-attachment:scroll}}@media (prefers-reduced-motion:reduce){.wp-block-cover-image.has-parallax,.wp-block-cover.has-parallax{background-attachment:scroll}}.wp-block-cover-image.is-repeated,.wp-block-cover.is-repeated{background-repeat:repeat;background-size:auto}.wp-block-cover-image.has-background-dim:not([class*=-background-color]),.wp-block-cover.has-background-dim:not([class*=-background-color]){background-color:#000}.wp-block-cover-image.has-background-dim:before,.wp-block-cover.has-background-dim:before{content:"";background-color:inherit}.wp-block-cover-image.has-background-dim:not(.has-background-gradient):before,.wp-block-cover-image .wp-block-cover__gradient-background,.wp-block-cover.has-background-dim:not(.has-background-gradient):before,.wp-block-cover .wp-block-cover__gradient-background{position:absolute;top:0;left:0;bottom:0;right:0;z-index:1;opacity:.5}.wp-block-cover-image.has-background-dim.has-background-dim-10 .wp-block-cover__gradient-background,.wp-block-cover-image.has-background-dim.has-background-dim-10:not(.has-background-gradient):before,.wp-block-cover.has-background-dim.has-background-dim-10 .wp-block-cover__gradient-background,.wp-block-cover.has-background-dim.has-background-dim-10:not(.has-background-gradient):before{opacity:.1}.wp-block-cover-image.has-background-dim.has-background-dim-20 .wp-block-cover__gradient-background,.wp-block-cover-image.has-background-dim.has-background-dim-20:not(.has-background-gradient):before,.wp-block-cover.has-background-dim.has-background-dim-20 .wp-block-cover__gradient-background,.wp-block-cover.has-background-dim.has-background-dim-20:not(.has-background-gradient):before{opacity:.2}.wp-block-cover-image.has-background-dim.has-background-dim-30 .wp-block-cover__gradient-background,.wp-block-cover-image.has-background-dim.has-background-dim-30:not(.has-background-gradient):before,.wp-block-cover.has-background-dim.has-background-dim-30 .wp-block-cover__gradient-background,.wp-block-cover.has-background-dim.has-background-dim-30:not(.has-background-gradient):before{opacity:.3}.wp-block-cover-image.has-background-dim.has-background-dim-40 .wp-block-cover__gradient-background,.wp-block-cover-image.has-background-dim.has-background-dim-40:not(.has-background-gradient):before,.wp-block-cover.has-background-dim.has-background-dim-40 .wp-block-cover__gradient-background,.wp-block-cover.has-background-dim.has-background-dim-40:not(.has-background-gradient):before{opacity:.4}.wp-block-cover-image.has-background-dim.has-background-dim-50 .wp-block-cover__gradient-background,.wp-block-cover-image.has-background-dim.has-background-dim-50:not(.has-background-gradient):before,.wp-block-cover.has-background-dim.has-background-dim-50 .wp-block-cover__gradient-background,.wp-block-cover.has-background-dim.has-background-dim-50:not(.has-background-gradient):before{opacity:.5}.wp-block-cover-image.has-background-dim.has-background-dim-60 .wp-block-cover__gradient-background,.wp-block-cover-image.has-background-dim.has-background-dim-60:not(.has-background-gradient):before,.wp-block-cover.has-background-dim.has-background-dim-60 .wp-block-cover__gradient-background,.wp-block-cover.has-background-dim.has-background-dim-60:not(.has-background-gradient):before{opacity:.6}.wp-block-cover-image.has-background-dim.has-background-dim-70 .wp-block-cover__gradient-background,.wp-block-cover-image.has-background-dim.has-background-dim-70:not(.has-background-gradient):before,.wp-block-cover.has-background-dim.has-background-dim-70 .wp-block-cover__gradient-background,.wp-block-cover.has-background-dim.has-background-dim-70:not(.has-background-gradient):before{opacity:.7}.wp-block-cover-image.has-background-dim.has-background-dim-80 .wp-block-cover__gradient-background,.wp-block-cover-image.has-background-dim.has-background-dim-80:not(.has-background-gradient):before,.wp-block-cover.has-background-dim.has-background-dim-80 .wp-block-cover__gradient-background,.wp-block-cover.has-background-dim.has-background-dim-80:not(.has-background-gradient):before{opacity:.8}.wp-block-cover-image.has-background-dim.has-background-dim-90 .wp-block-cover__gradient-background,.wp-block-cover-image.has-background-dim.has-background-dim-90:not(.has-background-gradient):before,.wp-block-cover.has-background-dim.has-background-dim-90 .wp-block-cover__gradient-background,.wp-block-cover.has-background-dim.has-background-dim-90:not(.has-background-gradient):before{opacity:.9}.wp-block-cover-image.has-background-dim.has-background-dim-100 .wp-block-cover__gradient-background,.wp-block-cover-image.has-background-dim.has-background-dim-100:not(.has-background-gradient):before,.wp-block-cover.has-background-dim.has-background-dim-100 .wp-block-cover__gradient-background,.wp-block-cover.has-background-dim.has-background-dim-100:not(.has-background-gradient):before{opacity:1}.wp-block-cover-image.alignleft,.wp-block-cover-image.alignright,.wp-block-cover.alignleft,.wp-block-cover.alignright{max-width:290px;width:100%}.wp-block-cover-image:after,.wp-block-cover:after{display:block;content:"";font-size:0;min-height:inherit}@supports ((position:-webkit-sticky) or (position:sticky)){.wp-block-cover-image:after,.wp-block-cover:after{content:none}}.wp-block-cover-image.aligncenter,.wp-block-cover-image.alignleft,.wp-block-cover-image.alignright,.wp-block-cover.aligncenter,.wp-block-cover.alignleft,.wp-block-cover.alignright{display:flex}.wp-block-cover-image .wp-block-cover__inner-container,.wp-block-cover .wp-block-cover__inner-container{width:100%;z-index:1;color:#fff}.wp-block-cover-image .wp-block-subhead:not(.has-text-color),.wp-block-cover-image h1:not(.has-text-color),.wp-block-cover-image h2:not(.has-text-color),.wp-block-cover-image h3:not(.has-text-color),.wp-block-cover-image h4:not(.has-text-color),.wp-block-cover-image h5:not(.has-text-color),.wp-block-cover-image h6:not(.has-text-color),.wp-block-cover-image p:not(.has-text-color),.wp-block-cover .wp-block-subhead:not(.has-text-color),.wp-block-cover h1:not(.has-text-color),.wp-block-cover h2:not(.has-text-color),.wp-block-cover h3:not(.has-text-color),.wp-block-cover h4:not(.has-text-color),.wp-block-cover h5:not(.has-text-color),.wp-block-cover h6:not(.has-text-color),.wp-block-cover p:not(.has-text-color){color:inherit}.wp-block-cover-image.is-position-top-left,.wp-block-cover.is-position-top-left{align-items:flex-start;justify-content:flex-start}.wp-block-cover-image.is-position-top-center,.wp-block-cover.is-position-top-center{align-items:flex-start;justify-content:center}.wp-block-cover-image.is-position-top-right,.wp-block-cover.is-position-top-right{align-items:flex-start;justify-content:flex-end}.wp-block-cover-image.is-position-center-left,.wp-block-cover.is-position-center-left{align-items:center;justify-content:flex-start}.wp-block-cover-image.is-position-center-center,.wp-block-cover.is-position-center-center{align-items:center;justify-content:center}.wp-block-cover-image.is-position-center-right,.wp-block-cover.is-position-center-right{align-items:center;justify-content:flex-end}.wp-block-cover-image.is-position-bottom-left,.wp-block-cover.is-position-bottom-left{align-items:flex-end;justify-content:flex-start}.wp-block-cover-image.is-position-bottom-center,.wp-block-cover.is-position-bottom-center{align-items:flex-end;justify-content:center}.wp-block-cover-image.is-position-bottom-right,.wp-block-cover.is-position-bottom-right{align-items:flex-end;justify-content:flex-end}.wp-block-cover-image.has-custom-content-position.has-custom-content-position .wp-block-cover__inner-container,.wp-block-cover.has-custom-content-position.has-custom-content-position .wp-block-cover__inner-container{margin:0;width:auto}.wp-block-cover__video-background{position:absolute;top:50%;left:50%;transform:translateX(-50%) translateY(-50%);width:100%;height:100%;z-index:0;object-fit:cover}.wp-block-cover-image-text,.wp-block-cover-text,section.wp-block-cover-image h2{color:#fff}.wp-block-cover-image-text a,.wp-block-cover-image-text a:active,.wp-block-cover-image-text a:focus,.wp-block-cover-image-text a:hover,.wp-block-cover-text a,.wp-block-cover-text a:active,.wp-block-cover-text a:focus,.wp-block-cover-text a:hover,section.wp-block-cover-image h2 a,section.wp-block-cover-image h2 a:active,section.wp-block-cover-image h2 a:focus,section.wp-block-cover-image h2 a:hover{color:#fff}.wp-block-cover-image .wp-block-cover.has-left-content{justify-content:flex-start}.wp-block-cover-image .wp-block-cover.has-right-content{justify-content:flex-end}.wp-block-cover-image.has-left-content .wp-block-cover-image-text,.wp-block-cover.has-left-content .wp-block-cover-text,section.wp-block-cover-image.has-left-content>h2{margin-left:0;text-align:left}.wp-block-cover-image.has-right-content .wp-block-cover-image-text,.wp-block-cover.has-right-content .wp-block-cover-text,section.wp-block-cover-image.has-right-content>h2{margin-right:0;text-align:right}.wp-block-cover-image .wp-block-cover-image-text,.wp-block-cover .wp-block-cover-text,section.wp-block-cover-image>h2{font-size:2em;line-height:1.25;z-index:1;margin-bottom:0;max-width:580px;padding:.44em;text-align:center}.wp-block-embed.alignleft,.wp-block-embed.alignright,.wp-block[data-align=left]>[data-type="core/embed"],.wp-block[data-align=right]>[data-type="core/embed"]{max-width:360px;width:100%}.wp-block-embed.alignleft .wp-block-embed__wrapper,.wp-block-embed.alignright .wp-block-embed__wrapper,.wp-block[data-align=left]>[data-type="core/embed"] .wp-block-embed__wrapper,.wp-block[data-align=right]>[data-type="core/embed"] .wp-block-embed__wrapper{min-width:280px}.wp-block-embed{margin-bottom:1em}.wp-block-embed figcaption{margin-top:.5em;margin-bottom:1em}.wp-block-embed iframe{max-width:100%}.wp-block-embed__wrapper{position:relative}.wp-embed-responsive .wp-has-aspect-ratio .wp-block-embed__wrapper:before{content:"";display:block;padding-top:50%}.wp-embed-responsive .wp-has-aspect-ratio iframe{position:absolute;top:0;right:0;bottom:0;left:0;height:100%;width:100%}.wp-embed-responsive .wp-embed-aspect-21-9 .wp-block-embed__wrapper:before{padding-top:42.85%}.wp-embed-responsive .wp-embed-aspect-18-9 .wp-block-embed__wrapper:before{padding-top:50%}.wp-embed-responsive .wp-embed-aspect-16-9 .wp-block-embed__wrapper:before{padding-top:56.25%}.wp-embed-responsive .wp-embed-aspect-4-3 .wp-block-embed__wrapper:before{padding-top:75%}.wp-embed-responsive .wp-embed-aspect-1-1 .wp-block-embed__wrapper:before{padding-top:100%}.wp-embed-responsive .wp-embed-aspect-9-16 .wp-block-embed__wrapper:before{padding-top:177.77%}.wp-embed-responsive .wp-embed-aspect-1-2 .wp-block-embed__wrapper:before{padding-top:200%}.wp-block-file{margin-bottom:1.5em}.wp-block-file.aligncenter{text-align:center}.wp-block-file.alignright{text-align:right}.wp-block-file .wp-block-file__button{background:#32373c;border-radius:2em;color:#fff;font-size:.8em;padding:.5em 1em}.wp-block-file a.wp-block-file__button{text-decoration:none}.wp-block-file a.wp-block-file__button:active,.wp-block-file a.wp-block-file__button:focus,.wp-block-file a.wp-block-file__button:hover,.wp-block-file a.wp-block-file__button:visited{box-shadow:none;color:#fff;opacity:.85;text-decoration:none}.wp-block-file *+.wp-block-file__button{margin-left:.75em}.blocks-gallery-grid,.wp-block-gallery{display:flex;flex-wrap:wrap;list-style-type:none;padding:0;margin:0}.blocks-gallery-grid .blocks-gallery-image,.blocks-gallery-grid .blocks-gallery-item,.wp-block-gallery .blocks-gallery-image,.wp-block-gallery .blocks-gallery-item{margin:0 1em 1em 0;display:flex;flex-grow:1;flex-direction:column;justify-content:center;position:relative;width:calc(50% - 1em)}.blocks-gallery-grid .blocks-gallery-image:nth-of-type(2n),.blocks-gallery-grid .blocks-gallery-item:nth-of-type(2n),.wp-block-gallery .blocks-gallery-image:nth-of-type(2n),.wp-block-gallery .blocks-gallery-item:nth-of-type(2n){margin-right:0}.blocks-gallery-grid .blocks-gallery-image figure,.blocks-gallery-grid .blocks-gallery-item figure,.wp-block-gallery .blocks-gallery-image figure,.wp-block-gallery .blocks-gallery-item figure{margin:0;height:100%}@supports ((position:-webkit-sticky) or (position:sticky)){.blocks-gallery-grid .blocks-gallery-image figure,.blocks-gallery-grid .blocks-gallery-item figure,.wp-block-gallery .blocks-gallery-image figure,.wp-block-gallery .blocks-gallery-item figure{display:flex;align-items:flex-end;justify-content:flex-start}}.blocks-gallery-grid .blocks-gallery-image img,.blocks-gallery-grid .blocks-gallery-item img,.wp-block-gallery .blocks-gallery-image img,.wp-block-gallery .blocks-gallery-item img{display:block;max-width:100%;height:auto;width:100%}@supports ((position:-webkit-sticky) or (position:sticky)){.blocks-gallery-grid .blocks-gallery-image img,.blocks-gallery-grid .blocks-gallery-item img,.wp-block-gallery .blocks-gallery-image img,.wp-block-gallery .blocks-gallery-item img{width:auto}}.blocks-gallery-grid .blocks-gallery-image figcaption,.blocks-gallery-grid .blocks-gallery-item figcaption,.wp-block-gallery .blocks-gallery-image figcaption,.wp-block-gallery .blocks-gallery-item figcaption{position:absolute;bottom:0;width:100%;max-height:100%;overflow:auto;padding:3em .77em .7em;color:#fff;text-align:center;font-size:.8em;background:linear-gradient(0deg,rgba(0,0,0,.7),rgba(0,0,0,.3) 70%,transparent);box-sizing:border-box;margin:0}.blocks-gallery-grid .blocks-gallery-image figcaption img,.blocks-gallery-grid .blocks-gallery-item figcaption img,.wp-block-gallery .blocks-gallery-image figcaption img,.wp-block-gallery .blocks-gallery-item figcaption img{display:inline}.blocks-gallery-grid figcaption,.wp-block-gallery figcaption{flex-grow:1}.blocks-gallery-grid.is-cropped .blocks-gallery-image a,.blocks-gallery-grid.is-cropped .blocks-gallery-image img,.blocks-gallery-grid.is-cropped .blocks-gallery-item a,.blocks-gallery-grid.is-cropped .blocks-gallery-item img,.wp-block-gallery.is-cropped .blocks-gallery-image a,.wp-block-gallery.is-cropped .blocks-gallery-image img,.wp-block-gallery.is-cropped .blocks-gallery-item a,.wp-block-gallery.is-cropped .blocks-gallery-item img{width:100%}@supports ((position:-webkit-sticky) or (position:sticky)){.blocks-gallery-grid.is-cropped .blocks-gallery-image a,.blocks-gallery-grid.is-cropped .blocks-gallery-image img,.blocks-gallery-grid.is-cropped .blocks-gallery-item a,.blocks-gallery-grid.is-cropped .blocks-gallery-item img,.wp-block-gallery.is-cropped .blocks-gallery-image a,.wp-block-gallery.is-cropped .blocks-gallery-image img,.wp-block-gallery.is-cropped .blocks-gallery-item a,.wp-block-gallery.is-cropped .blocks-gallery-item img{height:100%;flex:1;object-fit:cover}}.blocks-gallery-grid.columns-1 .blocks-gallery-image,.blocks-gallery-grid.columns-1 .blocks-gallery-item,.wp-block-gallery.columns-1 .blocks-gallery-image,.wp-block-gallery.columns-1 .blocks-gallery-item{width:100%;margin-right:0}@media (min-width:600px){.blocks-gallery-grid.columns-3 .blocks-gallery-image,.blocks-gallery-grid.columns-3 .blocks-gallery-item,.wp-block-gallery.columns-3 .blocks-gallery-image,.wp-block-gallery.columns-3 .blocks-gallery-item{width:calc(33.33333% - .66667em);margin-right:1em}.blocks-gallery-grid.columns-4 .blocks-gallery-image,.blocks-gallery-grid.columns-4 .blocks-gallery-item,.wp-block-gallery.columns-4 .blocks-gallery-image,.wp-block-gallery.columns-4 .blocks-gallery-item{width:calc(25% - .75em);margin-right:1em}.blocks-gallery-grid.columns-5 .blocks-gallery-image,.blocks-gallery-grid.columns-5 .blocks-gallery-item,.wp-block-gallery.columns-5 .blocks-gallery-image,.wp-block-gallery.columns-5 .blocks-gallery-item{width:calc(20% - .8em);margin-right:1em}.blocks-gallery-grid.columns-6 .blocks-gallery-image,.blocks-gallery-grid.columns-6 .blocks-gallery-item,.wp-block-gallery.columns-6 .blocks-gallery-image,.wp-block-gallery.columns-6 .blocks-gallery-item{width:calc(16.66667% - .83333em);margin-right:1em}.blocks-gallery-grid.columns-7 .blocks-gallery-image,.blocks-gallery-grid.columns-7 .blocks-gallery-item,.wp-block-gallery.columns-7 .blocks-gallery-image,.wp-block-gallery.columns-7 .blocks-gallery-item{width:calc(14.28571% - .85714em);margin-right:1em}.blocks-gallery-grid.columns-8 .blocks-gallery-image,.blocks-gallery-grid.columns-8 .blocks-gallery-item,.wp-block-gallery.columns-8 .blocks-gallery-image,.wp-block-gallery.columns-8 .blocks-gallery-item{width:calc(12.5% - .875em);margin-right:1em}.blocks-gallery-grid.columns-1 .blocks-gallery-image:nth-of-type(1n),.blocks-gallery-grid.columns-1 .blocks-gallery-item:nth-of-type(1n),.wp-block-gallery.columns-1 .blocks-gallery-image:nth-of-type(1n),.wp-block-gallery.columns-1 .blocks-gallery-item:nth-of-type(1n){margin-right:0}.blocks-gallery-grid.columns-2 .blocks-gallery-image:nth-of-type(2n),.blocks-gallery-grid.columns-2 .blocks-gallery-item:nth-of-type(2n),.wp-block-gallery.columns-2 .blocks-gallery-image:nth-of-type(2n),.wp-block-gallery.columns-2 .blocks-gallery-item:nth-of-type(2n){margin-right:0}.blocks-gallery-grid.columns-3 .blocks-gallery-image:nth-of-type(3n),.blocks-gallery-grid.columns-3 .blocks-gallery-item:nth-of-type(3n),.wp-block-gallery.columns-3 .blocks-gallery-image:nth-of-type(3n),.wp-block-gallery.columns-3 .blocks-gallery-item:nth-of-type(3n){margin-right:0}.blocks-gallery-grid.columns-4 .blocks-gallery-image:nth-of-type(4n),.blocks-gallery-grid.columns-4 .blocks-gallery-item:nth-of-type(4n),.wp-block-gallery.columns-4 .blocks-gallery-image:nth-of-type(4n),.wp-block-gallery.columns-4 .blocks-gallery-item:nth-of-type(4n){margin-right:0}.blocks-gallery-grid.columns-5 .blocks-gallery-image:nth-of-type(5n),.blocks-gallery-grid.columns-5 .blocks-gallery-item:nth-of-type(5n),.wp-block-gallery.columns-5 .blocks-gallery-image:nth-of-type(5n),.wp-block-gallery.columns-5 .blocks-gallery-item:nth-of-type(5n){margin-right:0}.blocks-gallery-grid.columns-6 .blocks-gallery-image:nth-of-type(6n),.blocks-gallery-grid.columns-6 .blocks-gallery-item:nth-of-type(6n),.wp-block-gallery.columns-6 .blocks-gallery-image:nth-of-type(6n),.wp-block-gallery.columns-6 .blocks-gallery-item:nth-of-type(6n){margin-right:0}.blocks-gallery-grid.columns-7 .blocks-gallery-image:nth-of-type(7n),.blocks-gallery-grid.columns-7 .blocks-gallery-item:nth-of-type(7n),.wp-block-gallery.columns-7 .blocks-gallery-image:nth-of-type(7n),.wp-block-gallery.columns-7 .blocks-gallery-item:nth-of-type(7n){margin-right:0}.blocks-gallery-grid.columns-8 .blocks-gallery-image:nth-of-type(8n),.blocks-gallery-grid.columns-8 .blocks-gallery-item:nth-of-type(8n),.wp-block-gallery.columns-8 .blocks-gallery-image:nth-of-type(8n),.wp-block-gallery.columns-8 .blocks-gallery-item:nth-of-type(8n){margin-right:0}}.blocks-gallery-grid .blocks-gallery-image:last-child,.blocks-gallery-grid .blocks-gallery-item:last-child,.wp-block-gallery .blocks-gallery-image:last-child,.wp-block-gallery .blocks-gallery-item:last-child{margin-right:0}.blocks-gallery-grid.alignleft,.blocks-gallery-grid.alignright,.wp-block-gallery.alignleft,.wp-block-gallery.alignright{max-width:290px;width:100%}.blocks-gallery-grid.aligncenter .blocks-gallery-item figure,.wp-block-gallery.aligncenter .blocks-gallery-item figure{justify-content:center}.wp-block-group{box-sizing:border-box}h1.has-background,h2.has-background,h3.has-background,h4.has-background,h5.has-background,h6.has-background{padding:1.25em 2.375em}.wp-block-image{margin-bottom:1em}.wp-block-image img{max-width:100%}.wp-block-image.aligncenter{text-align:center}.wp-block-image.alignfull img,.wp-block-image.alignwide img{width:100%}.wp-block-image .aligncenter,.wp-block-image .alignleft,.wp-block-image .alignright{display:table}.wp-block-image .aligncenter>figcaption,.wp-block-image .alignleft>figcaption,.wp-block-image .alignright>figcaption{display:table-caption;caption-side:bottom}.wp-block-image .alignleft{float:left;margin:.5em 1em .5em 0}.wp-block-image .alignright{float:right;margin:.5em 0 .5em 1em}.wp-block-image .aligncenter{margin-left:auto;margin-right:auto}.wp-block-image figcaption{margin-top:.5em;margin-bottom:1em}.is-style-circle-mask img,.is-style-rounded img{border-radius:9999px}@supports ((-webkit-mask-image:none) or (mask-image:none)) or (-webkit-mask-image:none){.is-style-circle-mask img{-webkit-mask-image:url('data:image/svg+xml;utf8,<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="50"/></svg>');mask-image:url('data:image/svg+xml;utf8,<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="50"/></svg>');mask-mode:alpha;-webkit-mask-repeat:no-repeat;mask-repeat:no-repeat;-webkit-mask-size:contain;mask-size:contain;-webkit-mask-position:center;mask-position:center;border-radius:0}}.wp-block-latest-comments__comment{line-height:1.1;list-style:none;margin-bottom:1em}.has-avatars .wp-block-latest-comments__comment{min-height:2.25em;list-style:none}.has-avatars .wp-block-latest-comments__comment .wp-block-latest-comments__comment-excerpt,.has-avatars .wp-block-latest-comments__comment .wp-block-latest-comments__comment-meta{margin-left:3.25em}.has-dates .wp-block-latest-comments__comment,.has-excerpts .wp-block-latest-comments__comment{line-height:1.5}.wp-block-latest-comments__comment-excerpt p{font-size:.875em;line-height:1.8;margin:.36em 0 1.4em}.wp-block-latest-comments__comment-date{display:block;font-size:.75em}.wp-block-latest-comments .avatar,.wp-block-latest-comments__comment-avatar{border-radius:1.5em;display:block;float:left;height:2.5em;margin-right:.75em;width:2.5em}.wp-block-latest-posts.alignleft{margin-right:2em}.wp-block-latest-posts.alignright{margin-left:2em}.wp-block-latest-posts.wp-block-latest-posts__list{list-style:none}.wp-block-latest-posts.wp-block-latest-posts__list li{clear:both}.wp-block-latest-posts.is-grid{display:flex;flex-wrap:wrap;padding:0}.wp-block-latest-posts.is-grid li{margin:0 1.25em 1.25em 0;width:100%}@media (min-width:600px){.wp-block-latest-posts.columns-2 li{width:calc(50% - .625em)}.wp-block-latest-posts.columns-2 li:nth-child(2n){margin-right:0}.wp-block-latest-posts.columns-3 li{width:calc(33.33333% - .83333em)}.wp-block-latest-posts.columns-3 li:nth-child(3n){margin-right:0}.wp-block-latest-posts.columns-4 li{width:calc(25% - .9375em)}.wp-block-latest-posts.columns-4 li:nth-child(4n){margin-right:0}.wp-block-latest-posts.columns-5 li{width:calc(20% - 1em)}.wp-block-latest-posts.columns-5 li:nth-child(5n){margin-right:0}.wp-block-latest-posts.columns-6 li{width:calc(16.66667% - 1.04167em)}.wp-block-latest-posts.columns-6 li:nth-child(6n){margin-right:0}}.wp-block-latest-posts__post-author,.wp-block-latest-posts__post-date{display:block;color:#555;font-size:.8125em}.wp-block-latest-posts__post-excerpt{margin-top:.5em;margin-bottom:1em}.wp-block-latest-posts__featured-image a{display:inline-block}.wp-block-latest-posts__featured-image img{height:auto;width:auto}.wp-block-latest-posts__featured-image.alignleft{margin-right:1em}.wp-block-latest-posts__featured-image.alignright{margin-left:1em}.wp-block-latest-posts__featured-image.aligncenter{margin-bottom:1em;text-align:center}.block-editor-image-alignment-control__row .components-base-control__field{display:flex;justify-content:space-between;align-items:center}.block-editor-image-alignment-control__row .components-base-control__field .components-base-control__label{margin-bottom:0}ol.has-background,ul.has-background{padding:1.25em 2.375em}.wp-block-media-text{
  /*!rtl:begin:ignore*/direction:ltr;
  /*!rtl:end:ignore*/display:-ms-grid;display:grid;-ms-grid-columns:50% 1fr;grid-template-columns:50% 1fr;-ms-grid-rows:auto;grid-template-rows:auto}.wp-block-media-text.has-media-on-the-right{-ms-grid-columns:1fr 50%;grid-template-columns:1fr 50%}.wp-block-media-text.is-vertically-aligned-top .wp-block-media-text__content,.wp-block-media-text.is-vertically-aligned-top .wp-block-media-text__media{-ms-grid-row-align:start;align-self:start}.wp-block-media-text.is-vertically-aligned-center .wp-block-media-text__content,.wp-block-media-text.is-vertically-aligned-center .wp-block-media-text__media,.wp-block-media-text .wp-block-media-text__content,.wp-block-media-text .wp-block-media-text__media{-ms-grid-row-align:center;align-self:center}.wp-block-media-text.is-vertically-aligned-bottom .wp-block-media-text__content,.wp-block-media-text.is-vertically-aligned-bottom .wp-block-media-text__media{-ms-grid-row-align:end;align-self:end}.wp-block-media-text .wp-block-media-text__media{
  /*!rtl:begin:ignore*/-ms-grid-column:1;grid-column:1;-ms-grid-row:1;grid-row:1;
  /*!rtl:end:ignore*/margin:0}.wp-block-media-text .wp-block-media-text__content{direction:ltr;
  /*!rtl:begin:ignore*/-ms-grid-column:2;grid-column:2;-ms-grid-row:1;grid-row:1;
  /*!rtl:end:ignore*/padding:0 8%;word-break:break-word}.wp-block-media-text.has-media-on-the-right .wp-block-media-text__media{
  /*!rtl:begin:ignore*/-ms-grid-column:2;grid-column:2;-ms-grid-row:1;grid-row:1
  /*!rtl:end:ignore*/}.wp-block-media-text.has-media-on-the-right .wp-block-media-text__content{
  /*!rtl:begin:ignore*/-ms-grid-column:1;grid-column:1;-ms-grid-row:1;grid-row:1
  /*!rtl:end:ignore*/}.wp-block-media-text__media img,.wp-block-media-text__media video{max-width:unset;width:100%;vertical-align:middle}.wp-block-media-text.is-image-fill figure.wp-block-media-text__media{height:100%;min-height:250px;background-size:cover}.wp-block-media-text.is-image-fill figure.wp-block-media-text__media>img{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);border:0}@media (max-width:600px){.wp-block-media-text.is-stacked-on-mobile{-ms-grid-columns:100%!important;grid-template-columns:100%!important}.wp-block-media-text.is-stacked-on-mobile .wp-block-media-text__media{-ms-grid-column:1;grid-column:1;-ms-grid-row:1;grid-row:1}.wp-block-media-text.is-stacked-on-mobile .wp-block-media-text__content{-ms-grid-column:1;grid-column:1;-ms-grid-row:2;grid-row:2}}.wp-block-navigation:not(.has-background) .wp-block-navigation__container .wp-block-navigation-link:not(.has-text-color){color:#1e1e1e}.wp-block-navigation:not(.has-background) .wp-block-navigation__container .wp-block-navigation__container{background-color:#fff}.items-justified-left>ul{justify-content:flex-start}.items-justified-center>ul{justify-content:center}.items-justified-right>ul{justify-content:flex-end}.wp-block-navigation-link{display:flex;align-items:center;position:relative;margin:0}.wp-block-navigation-link .wp-block-navigation__container:empty{display:none}.wp-block-navigation__container{list-style:none;margin:0;padding-left:0;display:flex;flex-wrap:wrap}.is-vertical .wp-block-navigation__container{display:block}.has-child>.wp-block-navigation-link__content{padding-right:.5em}.has-child .wp-block-navigation__container{border:1px solid rgba(0,0,0,.15);background-color:inherit;color:inherit;position:absolute;left:0;top:100%;width:-webkit-fit-content;width:-moz-fit-content;width:fit-content;z-index:2;opacity:0;transition:opacity .1s linear;visibility:hidden}.has-child .wp-block-navigation__container>.wp-block-navigation-link>.wp-block-navigation-link__content{flex-grow:1}.has-child .wp-block-navigation__container>.wp-block-navigation-link>.wp-block-navigation-link__submenu-icon{padding-right:.5em}@media (min-width:782px){.has-child .wp-block-navigation__container{left:1.5em}.has-child .wp-block-navigation__container .wp-block-navigation__container{left:100%;top:-1px}.has-child .wp-block-navigation__container .wp-block-navigation__container:before{content:"";position:absolute;right:100%;height:100%;display:block;width:.5em;background:transparent}.has-child .wp-block-navigation__container .wp-block-navigation-link__submenu-icon svg{transform:rotate(0)}}.has-child:hover{cursor:pointer}.has-child:hover>.wp-block-navigation__container{visibility:visible;opacity:1;display:flex;flex-direction:column}.has-child:focus-within{cursor:pointer}.has-child:focus-within>.wp-block-navigation__container{visibility:visible;opacity:1;display:flex;flex-direction:column}.wp-block-navigation-link__content{color:inherit;text-decoration:none;padding:.5em 1em}.wp-block-navigation-link__content+.wp-block-navigation-link__content{padding-top:0}.has-text-color .wp-block-navigation-link__content{color:inherit}.wp-block-navigation-link__label{word-break:normal;overflow-wrap:break-word}.wp-block-navigation-link__submenu-icon{height:inherit;padding:.375em 1em .375em 0}.wp-block-navigation-link__submenu-icon svg{fill:currentColor}@media (min-width:782px){.wp-block-navigation-link__submenu-icon svg{transform:rotate(90deg)}}.is-small-text{font-size:.875em}.is-regular-text{font-size:1em}.is-large-text{font-size:2.25em}.is-larger-text{font-size:3em}.has-drop-cap:not(:focus):first-letter{float:left;font-size:8.4em;line-height:.68;font-weight:100;margin:.05em .1em 0 0;text-transform:uppercase;font-style:normal}p.has-background{padding:1.25em 2.375em}p.has-text-color a{color:inherit}.wp-block-post-author{display:flex;flex-wrap:wrap}.wp-block-post-author__byline{width:100%;margin-top:0;margin-bottom:0;font-size:.5em}.wp-block-post-author__avatar{margin-right:1em}.wp-block-post-author__bio{margin-bottom:.7em;font-size:.7em}.wp-block-post-author__content{flex-grow:1;flex-basis:0}.wp-block-post-author__name{font-weight:700;margin:0}.wp-block-pullquote{padding:3em 0;margin-left:0;margin-right:0;text-align:center}.wp-block-pullquote.alignleft,.wp-block-pullquote.alignright{max-width:290px}.wp-block-pullquote.alignleft p,.wp-block-pullquote.alignright p{font-size:1.25em}.wp-block-pullquote p{font-size:1.75em;line-height:1.6}.wp-block-pullquote cite,.wp-block-pullquote footer{position:relative}.wp-block-pullquote .has-text-color a{color:inherit}.wp-block-pullquote:not(.is-style-solid-color){background:none}.wp-block-pullquote.is-style-solid-color{border:none}.wp-block-pullquote.is-style-solid-color blockquote{margin-left:auto;margin-right:auto;text-align:left;max-width:60%}.wp-block-pullquote.is-style-solid-color blockquote p{margin-top:0;margin-bottom:0;font-size:2em}.wp-block-pullquote.is-style-solid-color blockquote cite{text-transform:none;font-style:normal}.wp-block-pullquote cite{color:inherit}.wp-block-quote.is-large,.wp-block-quote.is-style-large{margin-bottom:1em;padding:0 1em}.wp-block-quote.is-large p,.wp-block-quote.is-style-large p{font-size:1.5em;font-style:italic;line-height:1.6}.wp-block-quote.is-large cite,.wp-block-quote.is-large footer,.wp-block-quote.is-style-large cite,.wp-block-quote.is-style-large footer{font-size:1.125em;text-align:right}.wp-block-rss.alignleft{margin-right:2em}.wp-block-rss.alignright{margin-left:2em}.wp-block-rss.is-grid{display:flex;flex-wrap:wrap;padding:0;list-style:none}.wp-block-rss.is-grid li{margin:0 1em 1em 0;width:100%}@media (min-width:600px){.wp-block-rss.columns-2 li{width:calc(50% - 1em)}.wp-block-rss.columns-3 li{width:calc(33.33333% - 1em)}.wp-block-rss.columns-4 li{width:calc(25% - 1em)}.wp-block-rss.columns-5 li{width:calc(20% - 1em)}.wp-block-rss.columns-6 li{width:calc(16.66667% - 1em)}}.wp-block-rss__item-author,.wp-block-rss__item-publish-date{display:block;color:#555;font-size:.8125em}.wp-block-search .wp-block-search__inside-wrapper{display:flex;flex:auto;flex-wrap:nowrap;max-width:100%}.wp-block-search .wp-block-search__label{width:100%}.wp-block-search .wp-block-search__input{flex-grow:1;min-width:3em;border:1px solid #949494}.wp-block-search .wp-block-search__button{margin-left:.625em;word-break:normal}.wp-block-search .wp-block-search__button svg{min-width:1.5em;min-height:1.5em}.wp-block-search.wp-block-search__button-only .wp-block-search__button{margin-left:0}.wp-block-search.wp-block-search__button-inside .wp-block-search__inside-wrapper{padding:4px;border:1px solid #949494}.wp-block-search.wp-block-search__button-inside .wp-block-search__inside-wrapper .wp-block-search__input{border-radius:0;border:none;padding:0 0 0 .25em}.wp-block-search.wp-block-search__button-inside .wp-block-search__inside-wrapper .wp-block-search__input:focus{outline:none}.wp-block-search.wp-block-search__button-inside .wp-block-search__inside-wrapper .wp-block-search__button{padding:.125em .5em}.wp-block-separator.is-style-wide{border-bottom-width:1px}.wp-block-separator.is-style-dots{background:none!important;border:none;text-align:center;max-width:none;line-height:1;height:auto}.wp-block-separator.is-style-dots:before{content:"\00b7 \00b7 \00b7";color:currentColor;font-size:1.5em;letter-spacing:2em;padding-left:2em;font-family:serif}.wp-block-custom-logo .aligncenter{display:table}.wp-block-social-links{display:flex;flex-wrap:wrap;justify-content:flex-start;padding-left:0;padding-right:0;text-indent:0;margin-left:0}.wp-block-social-links .wp-social-link a,.wp-block-social-links .wp-social-link a:hover{text-decoration:none;border-bottom:0;box-shadow:none}.wp-social-link{display:block;width:36px;height:36px;border-radius:9999px;margin:0 8px 8px 0;transition:transform .1s ease}@media (prefers-reduced-motion:reduce){.wp-social-link{transition-duration:0s}}.wp-social-link a{padding:6px;display:block;line-height:0;transition:transform .1s ease}.wp-social-link a,.wp-social-link a:active,.wp-social-link a:hover,.wp-social-link a:visited,.wp-social-link svg{color:currentColor;fill:currentColor}.wp-social-link:hover{transform:scale(1.1)}.wp-block-social-links.aligncenter{justify-content:center;display:flex}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link{background-color:#f0f0f0;color:#444}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-amazon{background-color:#f90;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-bandcamp{background-color:#1ea0c3;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-behance{background-color:#0757fe;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-codepen{background-color:#1e1f26;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-deviantart{background-color:#02e49b;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-dribbble{background-color:#e94c89;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-dropbox{background-color:#4280ff;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-etsy{background-color:#f45800;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-facebook{background-color:#1778f2;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-fivehundredpx{background-color:#000;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-flickr{background-color:#0461dd;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-foursquare{background-color:#e65678;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-github{background-color:#24292d;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-goodreads{background-color:#eceadd;color:#382110}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-google{background-color:#ea4434;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-instagram{background-color:#f00075;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-lastfm{background-color:#e21b24;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-linkedin{background-color:#0d66c2;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-mastodon{background-color:#3288d4;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-medium{background-color:#02ab6c;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-meetup{background-color:#f6405f;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-pinterest{background-color:#e60122;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-pocket{background-color:#ef4155;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-reddit{background-color:#fe4500;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-skype{background-color:#0478d7;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-snapchat{background-color:#fefc00;color:#fff;stroke:#000}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-soundcloud{background-color:#ff5600;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-spotify{background-color:#1bd760;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-tumblr{background-color:#011835;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-twitch{background-color:#6440a4;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-twitter{background-color:#1da1f2;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-vimeo{background-color:#1eb7ea;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-vk{background-color:#4680c2;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-wordpress{background-color:#3499cd;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-yelp{background-color:#d32422;color:#fff}.wp-block-social-links:not(.is-style-logos-only) .wp-social-link-youtube{background-color:red;color:#fff}.wp-block-social-links.is-style-logos-only .wp-social-link{background:none;padding:4px}.wp-block-social-links.is-style-logos-only .wp-social-link svg{width:28px;height:28px}.wp-block-social-links.is-style-logos-only .wp-social-link-amazon{color:#f90}.wp-block-social-links.is-style-logos-only .wp-social-link-bandcamp{color:#1ea0c3}.wp-block-social-links.is-style-logos-only .wp-social-link-behance{color:#0757fe}.wp-block-social-links.is-style-logos-only .wp-social-link-codepen{color:#1e1f26}.wp-block-social-links.is-style-logos-only .wp-social-link-deviantart{color:#02e49b}.wp-block-social-links.is-style-logos-only .wp-social-link-dribbble{color:#e94c89}.wp-block-social-links.is-style-logos-only .wp-social-link-dropbox{color:#4280ff}.wp-block-social-links.is-style-logos-only .wp-social-link-etsy{color:#f45800}.wp-block-social-links.is-style-logos-only .wp-social-link-facebook{color:#1778f2}.wp-block-social-links.is-style-logos-only .wp-social-link-fivehundredpx{color:#000}.wp-block-social-links.is-style-logos-only .wp-social-link-flickr{color:#0461dd}.wp-block-social-links.is-style-logos-only .wp-social-link-foursquare{color:#e65678}.wp-block-social-links.is-style-logos-only .wp-social-link-github{color:#24292d}.wp-block-social-links.is-style-logos-only .wp-social-link-goodreads{color:#382110}.wp-block-social-links.is-style-logos-only .wp-social-link-google{color:#ea4434}.wp-block-social-links.is-style-logos-only .wp-social-link-instagram{color:#f00075}.wp-block-social-links.is-style-logos-only .wp-social-link-lastfm{color:#e21b24}.wp-block-social-links.is-style-logos-only .wp-social-link-linkedin{color:#0d66c2}.wp-block-social-links.is-style-logos-only .wp-social-link-mastodon{color:#3288d4}.wp-block-social-links.is-style-logos-only .wp-social-link-medium{color:#02ab6c}.wp-block-social-links.is-style-logos-only .wp-social-link-meetup{color:#f6405f}.wp-block-social-links.is-style-logos-only .wp-social-link-pinterest{color:#e60122}.wp-block-social-links.is-style-logos-only .wp-social-link-pocket{color:#ef4155}.wp-block-social-links.is-style-logos-only .wp-social-link-reddit{color:#fe4500}.wp-block-social-links.is-style-logos-only .wp-social-link-skype{color:#0478d7}.wp-block-social-links.is-style-logos-only .wp-social-link-snapchat{color:#fff;stroke:#000}.wp-block-social-links.is-style-logos-only .wp-social-link-soundcloud{color:#ff5600}.wp-block-social-links.is-style-logos-only .wp-social-link-spotify{color:#1bd760}.wp-block-social-links.is-style-logos-only .wp-social-link-tumblr{color:#011835}.wp-block-social-links.is-style-logos-only .wp-social-link-twitch{color:#6440a4}.wp-block-social-links.is-style-logos-only .wp-social-link-twitter{color:#1da1f2}.wp-block-social-links.is-style-logos-only .wp-social-link-vimeo{color:#1eb7ea}.wp-block-social-links.is-style-logos-only .wp-social-link-vk{color:#4680c2}.wp-block-social-links.is-style-logos-only .wp-social-link-wordpress{color:#3499cd}.wp-block-social-links.is-style-logos-only .wp-social-link-yelp{background-color:#d32422;color:#fff}.wp-block-social-links.is-style-logos-only .wp-social-link-youtube{color:red}.wp-block-social-links.is-style-pill-shape .wp-social-link{width:auto}.wp-block-social-links.is-style-pill-shape .wp-social-link a{padding-left:16px;padding-right:16px}.wp-block-spacer{clear:both}p.wp-block-subhead{font-size:1.1em;font-style:italic;opacity:.75}.wp-block-table{overflow-x:auto}.wp-block-table table{width:100%}.wp-block-table .has-fixed-layout{table-layout:fixed;width:100%}.wp-block-table .has-fixed-layout td,.wp-block-table .has-fixed-layout th{word-break:break-word}.wp-block-table.aligncenter,.wp-block-table.alignleft,.wp-block-table.alignright{display:table;width:auto}.wp-block-table.aligncenter td,.wp-block-table.aligncenter th,.wp-block-table.alignleft td,.wp-block-table.alignleft th,.wp-block-table.alignright td,.wp-block-table.alignright th{word-break:break-word}.wp-block-table .has-subtle-light-gray-background-color{background-color:#f3f4f5}.wp-block-table .has-subtle-pale-green-background-color{background-color:#e9fbe5}.wp-block-table .has-subtle-pale-blue-background-color{background-color:#e7f5fe}.wp-block-table .has-subtle-pale-pink-background-color{background-color:#fcf0ef}.wp-block-table.is-style-stripes{border-spacing:0;border-collapse:inherit;background-color:transparent;border-bottom:1px solid #f0f0f0}.wp-block-table.is-style-stripes tbody tr:nth-child(odd){background-color:#f0f0f0}.wp-block-table.is-style-stripes.has-subtle-light-gray-background-color tbody tr:nth-child(odd){background-color:#f3f4f5}.wp-block-table.is-style-stripes.has-subtle-pale-green-background-color tbody tr:nth-child(odd){background-color:#e9fbe5}.wp-block-table.is-style-stripes.has-subtle-pale-blue-background-color tbody tr:nth-child(odd){background-color:#e7f5fe}.wp-block-table.is-style-stripes.has-subtle-pale-pink-background-color tbody tr:nth-child(odd){background-color:#fcf0ef}.wp-block-table.is-style-stripes td,.wp-block-table.is-style-stripes th{border-color:transparent}.wp-block-text-columns,.wp-block-text-columns.aligncenter{display:flex}.wp-block-text-columns .wp-block-column{margin:0 1em;padding:0}.wp-block-text-columns .wp-block-column:first-child{margin-left:0}.wp-block-text-columns .wp-block-column:last-child{margin-right:0}.wp-block-text-columns.columns-2 .wp-block-column{width:50%}.wp-block-text-columns.columns-3 .wp-block-column{width:33.33333%}.wp-block-text-columns.columns-4 .wp-block-column{width:25%}.wp-block-video{margin-left:0;margin-right:0}.wp-block-video video{max-width:100%}@supports ((position:-webkit-sticky) or (position:sticky)){.wp-block-video [poster]{object-fit:cover}}.wp-block-video.aligncenter{text-align:center}.wp-block-video figcaption{margin-top:.5em;margin-bottom:1em}.wp-block-post-featured-image a{display:inline-block}:root .has-pale-pink-background-color{background-color:#f78da7}:root .has-vivid-red-background-color{background-color:#cf2e2e}:root .has-luminous-vivid-orange-background-color{background-color:#ff6900}:root .has-luminous-vivid-amber-background-color{background-color:#fcb900}:root .has-light-green-cyan-background-color{background-color:#7bdcb5}:root .has-vivid-green-cyan-background-color{background-color:#00d084}:root .has-pale-cyan-blue-background-color{background-color:#8ed1fc}:root .has-vivid-cyan-blue-background-color{background-color:#0693e3}:root .has-vivid-purple-background-color{background-color:#9b51e0}:root .has-white-background-color{background-color:#fff}:root .has-very-light-gray-background-color{background-color:#eee}:root .has-cyan-bluish-gray-background-color{background-color:#abb8c3}:root .has-very-dark-gray-background-color{background-color:#313131}:root .has-black-background-color{background-color:#000}:root .has-pale-pink-color{color:#f78da7}:root .has-vivid-red-color{color:#cf2e2e}:root .has-luminous-vivid-orange-color{color:#ff6900}:root .has-luminous-vivid-amber-color{color:#fcb900}:root .has-light-green-cyan-color{color:#7bdcb5}:root .has-vivid-green-cyan-color{color:#00d084}:root .has-pale-cyan-blue-color{color:#8ed1fc}:root .has-vivid-cyan-blue-color{color:#0693e3}:root .has-vivid-purple-color{color:#9b51e0}:root .has-white-color{color:#fff}:root .has-very-light-gray-color{color:#eee}:root .has-cyan-bluish-gray-color{color:#abb8c3}:root .has-very-dark-gray-color{color:#313131}:root .has-black-color{color:#000}:root .has-vivid-cyan-blue-to-vivid-purple-gradient-background{background:linear-gradient(135deg,#0693e3,#9b51e0)}:root .has-vivid-green-cyan-to-vivid-cyan-blue-gradient-background{background:linear-gradient(135deg,#00d084,#0693e3)}:root .has-light-green-cyan-to-vivid-green-cyan-gradient-background{background:linear-gradient(135deg,#7adcb4,#00d082)}:root .has-luminous-vivid-amber-to-luminous-vivid-orange-gradient-background{background:linear-gradient(135deg,#fcb900,#ff6900)}:root .has-luminous-vivid-orange-to-vivid-red-gradient-background{background:linear-gradient(135deg,#ff6900,#cf2e2e)}:root .has-very-light-gray-to-cyan-bluish-gray-gradient-background{background:linear-gradient(135deg,#eee,#a9b8c3)}:root .has-cool-to-warm-spectrum-gradient-background{background:linear-gradient(135deg,#4aeadc,#9778d1 20%,#cf2aba 40%,#ee2c82 60%,#fb6962 80%,#fef84c)}:root .has-blush-light-purple-gradient-background{background:linear-gradient(135deg,#ffceec,#9896f0)}:root .has-blush-bordeaux-gradient-background{background:linear-gradient(135deg,#fecda5,#fe2d2d 50%,#6b003e)}:root .has-purple-crush-gradient-background{background:linear-gradient(135deg,#34e2e4,#4721fb 50%,#ab1dfe)}:root .has-luminous-dusk-gradient-background{background:linear-gradient(135deg,#ffcb70,#c751c0 50%,#4158d0)}:root .has-hazy-dawn-gradient-background{background:linear-gradient(135deg,#faaca8,#dad0ec)}:root .has-pale-ocean-gradient-background{background:linear-gradient(135deg,#fff5cb,#b6e3d4 50%,#33a7b5)}:root .has-electric-grass-gradient-background{background:linear-gradient(135deg,#caf880,#71ce7e)}:root .has-subdued-olive-gradient-background{background:linear-gradient(135deg,#fafae1,#67a671)}:root .has-atomic-cream-gradient-background{background:linear-gradient(135deg,#fdd79a,#004a59)}:root .has-nightshade-gradient-background{background:linear-gradient(135deg,#330968,#31cdcf)}:root .has-midnight-gradient-background{background:linear-gradient(135deg,#020381,#2874fc)}:root .has-link-color a{color:#00e;color:var(--wp--style--color--link,#00e)}.has-small-font-size{font-size:.8125em}.has-normal-font-size,.has-regular-font-size{font-size:1em}.has-medium-font-size{font-size:1.25em}.has-large-font-size{font-size:2.25em}.has-huge-font-size,.has-larger-font-size{font-size:2.625em}.has-text-align-center{text-align:center}.has-text-align-left{text-align:left}.has-text-align-right{text-align:right}#end-resizable-editor-section{display:none}.aligncenter{clear:both}
  
  <?php 
		if( !get_hc2('settings','formstyles_off') ){
			?>
  
				  
				  .activedemand-wrapper{
					padding:0 !important;
				}

				.activedemand-wrapper label{
					margin:0 0 5px 0 !important;
				}

				.activedemand-wrapper select, .activedemand-wrapper textarea, .activedemand-wrapper input:not([type=checkbox]):not([type=radio]){
					width:100% !important;
					max-width:400px;
				}
				.activedemand-wrapper input{
					border: 1px solid #ccd0d9 !important;
					border-radius: 3px !important;
					padding: 7px 8px 7px !important;
					font-family: National\ 2,sans-serif !important;
				}
				.activedemand-wrapper select{
					border: 1px solid #ccd0d9 !important;
					border-radius: 3px !important;  
					padding: 11px 0px 7px !important;
					font-family: National\ 2,sans-serif !important;
				}
				.activedemand-wrapper textarea {
					border: 1px solid #ccd0d9 !important;
					border-radius: 3px !important;
					padding: 10px 14px !important;
					font-family: National\ 2,sans-serif !important;
					color: #282828 !important;
				}

				button.btn.activedemand-button {
					background: gray !important;
					border-radius:3px !important;
					padding: 10px 30px !important;
				}
				.container-fluid {
					padding: 0 20px !important;
				}

				.activedemand-text-wrapper h3 {
					display: none;
				}

				.activedemand-text-wrapper p {
					margin-top: 0 !important;
				}
				  
				.activedemand-text-wrapper .checkbox {
					margin-bottom: 5px;
				}
				#activedemand_forms_0:empty:before {
					content: '';
					border-radius: 50%;
					width:20px;
					height:20px;   
					margin:30px auto;
					border: 5px solid gray;
					border-bottom: 5px solid transparent;
					display: block;
					animation: 1s ad_rotate 0s linear both infinite;
				}
				.activedemand-button input {
					background: gray !important;
					cursor: pointer !important;
				}
				.activedemand-button {
					background: gray !important;
					cursor: pointer !important;
					border-radius: 4px !important;
					padding: 4px 13px !important;
				}

				.activedemand-button span {
					color: white;
					cursor: pointer !important;
					font-size: 14px !important;
				}
				.activedemand-wrapper .form-group > * {
				  display: block;
				}

				.activedemand-wrapper .form-group > * .required {
				  color: red;
				  font-size: 24px;
				  line-height: .1;
				  vertical-align: middle;
				}
			<?php
		}
	?>
@keyframes ad_rotate{
    0%{
        transform:rotate(0deg);
    }
    100%{
        transform:rotate(360deg);
    }
}
.hc2_keys {
    position: fixed;
    z-index: 999999999999;
    display: block;
    left: 40px;
    bottom: 0px;
    font-size: 25px;
}
a.hc2_editme {
    position: fixed;
    z-index: 999999999999;
    display: block;
    left: 0px;
    bottom: 0px;
    padding: 7px;
    opacity:1;
    font-size: 25px;
    text-decoration:none !important;
}
a.hc2_editme:before {
    color:#000;
}
a.hc2_editme:hover:before {
    background-color:#f0971f;
    border-radius:4px;
}
#hc2_accessarea {
    opacity: 0;
}
#hc2_accessarea:hover {
    opacity: 1;
}

span.hc2_keys_icon:before {
    content: 'κ';
    color: #000;
    font-weight:bold;
    font-size:32px;
    z-index:1;
    position:relative;
}

.hc2_keys_area {
    display:none;
    position: absolute;
    background:#f0971f;
    padding:5px;
    border-radius:4px;
}
.hc2_keys_icon:hover + div,.hc2_keys_area:hover{
    display:grid;
    bottom: 6px;
    left:-5px;
}

.hc2_keys_area textarea {
    height:200px;
    padding:5px;
    border-radius:4px;
    border:none !important;
    width:300px;
    grid-area:1 / 1 / 1 span / 2 span;
}
.hc2_keys_area button {
    float:right;
    border-radius:2px;
    padding:4px 20px;
    cursor:pointer;
    background:#fff;
    border:1px solid transparent;
    grid-area:3 / 2 / 1 span / 1 span;
}
.hc2_keys_area button:hover {
    border: 1px solid white;
}

.hc2_important label {
    font-size: 12px;
    vertical-align: middle;
}
.hc2_important input {
    cursor:pointer;
}
.hc2_important {
    grid-area:2 / 1 / 1 span / 1 span;
    padding:4px 0;
    margin-left:-4px;
}
.hc2_score {
    grid-area:2 / 2 / 1 span / 1 span;
    text-align:right;
    padding:4px 0;
}
.hc2_score *{
    font-size: 12px !important;
    margin-left:5px;
    vertical-align: middle;
}
.hc2_score [data-scorecolor="orange"]{
    color:#8a5900;
    background:white;  
    padding:2px 5px;
}
.hc2_keys_area [data-state="loading"]:after {
    animation: load 1s linear infinite;
    content:'';
    display:inline-block;
    width:8px;
    height:8px;
    border:2px solid #000;
    border-top:2px solid transparent;
    border-radius:50%;
    margin:0 5px;
    vertical-align:top;
}

@keyframes load{
    0%{transform:rotate(0deg)}
    100%{transform:rotate(360deg)}
}

.hc2_keys_area [data-state="loading"] {
    background:#f0971f !important;
    border:1px solid black !important;
    color:black !important;
}

.hc2_keys_area [data-state="done"]:after {
    content:'✓';
    font-size:12px;
    display:inline-block;
    margin:0 5px;
}
.hc2_keys_area textarea + textarea {
    grid-area: 2 / 3 / 1 span / 1 span;
    margin-left: 5px;
}

.hc2_score {
    grid-area: 3 / 3 / 1 span / 1 span;
    padding: 5px 10px;
}

.hc2_keys_area button {grid-area: 4 / 3 / 1 span / 1 span;}

.hc2_important {
    grid-area: 3 / 1 / 1 span / 1 span;
}

.hc2_important input {
    margin: 10px;
}

.hc2_keys_area:before {content: 'Keywords';grid-area: 1 / 1 / 1 span / 2 span;font-size: 14px;padding: 4px;}

.hc2_keys_area:after {content: 'Notes';font-size: 14px;padding: 4px;}

.hc2_keys_area textarea {
    grid-area: 2 / 1 / 1 span / 2 span;
}

.hc2_keys_area {
    display: none;
    position: absolute;
    background: #bdbdbd;
    padding: 5px;
    border-radius: 4px;
    border:2px solid #818181;
}

a.hc2_editme:hover:before {
    background: #bdbdbd;
}

.hc2_keys_area [data-state="loading"] {
    background: #8d8d8d !important;
}
.wp-block-cover > img {
  position: absolute !important;
  min-width: 100% !important;
  min-height: 100% !important;
}

.wp-block-cover {
  overflow: hidden;
}


[data-scorecolor='green'] {
    color: #258318 !important;
}
[data-scorecolor='yellow'] {
    color: #505610 !important;
}
[data-scorecolor='orange'] {
    color: #70360a !important;
}
[data-scorecolor='red'] {
    color: #951003 !important;
}
[data-scorecolor] {
    font-weight:bold !important;
}

.wp-block-buttons.is-content-justification-center { text-align: center }
				<?php 					
					echo get_option('hcube_globals_styles' );
				?>
			</style>
			<?php
				echo get_option('hcube_globals_scripts' );
			?>
		<?php
	}
	

	