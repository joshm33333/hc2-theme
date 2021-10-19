<?php

	if ( ! defined( 'ABSPATH' ) ) exit;

	add_action( 'admin_menu', 'hcube_addprod' );
	function hcube_addprod(){
		add_submenu_page( 'hcube_settings', 'Production', 'Files', 'manage_options', 'hcube_prod', 'hcube_createpage_prod' );
	}	

	add_action('rest_api_init',function(){register_rest_route('hc2/v1','/scan/',array('methods'=>'POST','callback'=>'hcube_scan','permission_callback' => function($request){ return is_user_logged_in();}));});
	function hcube_scan( $request ) { 
		$data = hc2_curl_get_contents( trim(get_option('hc2_production_url'),'/').'/remote_render.php',array('auth'=>'IJDF#(*hj29g()I*%@)_(JGO','scanmedia'=>1));
		update_option( 'hc2_remotedata_medialist', $data );
		update_option( 'hc2_media_last_scan', strtotime( 'now' ) );
		return $data;
	}		

	add_action('rest_api_init',function(){register_rest_route('hc2/v1','/audit_pushimgs/',array('methods'=>'POST','callback'=>'hcube_audit_pushimgs','permission_callback' => function($request){ return is_user_logged_in();}));});
	function hcube_audit_pushimgs( $request ) { 
		//update_option( 'hc2-needspush--'.$_POST['img'], false );

		update_option( 'hc2_media_last_push', strtotime( 'now' ) );
		$data = hc2_curl_get_contents( trim(get_option('hc2_production_url'),'/').'/remote_render.php',array(
			'auth'=>'IJDF#(*hj29g()I*%@)_(JGO',
			'file'=>urlencode($_POST['img']),
			'src' => urlencode( hc2_sanitize_url(get_site_url( ) )),
			'media'=>1));
		return $data;
	}

	function hcube_createpage_prod(){
		
		?>

			<div class="wrap">	
				<h1 class='hcube_title'>Push Files to Production</h1>
		
			<style>

				[data-pushmode="1"] + label { 	margin-left: 13px; } 
				td.hc2_nowrite { 	height: 20px; 	overflow: hidden; 	display:  list-item; 	border: 1px solid; 	padding: 0 5px; 	cursor: pointer; }
				td.hc2_nowrite:hover { 	height: auto; }
				.hc2_folder .wp-core-ui.button-primary {line-height: 1.4;min-height: 21px !IMPORTANT;}
				.hc2_folder,.hc2_folder * {margin-left: 10px !IMPORTANT;}
				.hc2_folder > input {opacity: 0;width: 240px;width: 40px;height: 30px;}
				.hc2_folder > label:before {    content: "\f07b";font-family: "Font Awesome 5 Free";font-size: 13px;margin: 10px;display: inline-block;}
				.hc2_folder > label {position: absolute;left: 0;top: -10px;pointer-events: none;}
				.hc2_folder {position: relative;min-width: 400px;  padding-top: 10px; padding-left: 10px;}
				.hc2_folder > div {margin-top: 10px;}
				[onclick="hc2_send_file(this)"] {margin-left: 30px !important;}
				.hc2_folder > input:checked + label:before {content: "\f07c";}
				.hc2_folder > input:not(:checked) + label + div {display: none;}
				[onclick="hc2_send_file(this)"]:not(.button-primary) {color: gray;text-decoration: line-through;}
				.hc2_push_item.hc2_not_pushed i {display: inline-block;cursor:pointer;color:#007cba;}
				.hc2_push_item.hc2_not_pushed i:hover {color:#025b87;}
				.hc2_push_item p {display: inline;}
				.hc2_push_item:not(.hc2_not_pushed):not(.hc2_sending) i.fa-file-upload {display: none;}
				.hc2_push_item i.fa-file-archive {display: inline-block;cursor:pointer;color:#007cba;}
				.hc2_push_item i.fa-file-archive:hover {color:#025b87;}
				.hc2_push_item.hc2_push_failed * {color: red;}
				[data-compressing='true'] i.fa-file-archive:before {margin-right: -1px;margin-left: 10px;content: '';display: inline-block;border: 2px solid #007cba;border-left: 2px solid transparent;border-top: 2px solid transparent;width: 7px;height: 7px;border-radius: 50%;animation-name: rotate;animation-duration: 1s;animation-iteration-count: infinite;animation-timing-function: linear;}
				[data-compressing='failed'] * {color: red;}
				.hc2_push_item:not(.hc2_not_pushed) p {text-decoration: line-through;color: #b6b6b6;}
				.hc2_advanced{display:none;}
				button.wp-core-ui.button-primary[data-sending="true"]:before {margin-right: 7px;content: '';display: inline-block;border: 2px solid white;border-left: 2px solid transparent;border-top: 2px solid transparent;width: 7px;height: 7px;border-radius: 50%;animation-name: rotate;animation-duration: 1s;animation-iteration-count: infinite;animation-timing-function: linear;}
				@keyframes rotate { 0%{transform: rotate(0deg);}100%{transform: rotate(360deg);}} 
				.hc2_push_item.hc2_sending p {text-decoration: none;font-weight: bold;color: black;}
				.hc2_push_item.hc2_sending i.fa-file-upload:before {margin-right: -1px;margin-left: 10px;content: '';display: inline-block;border: 2px solid #007cba;border-left: 2px solid transparent;border-top: 2px solid transparent;width: 7px;height: 7px;border-radius: 50%;animation-name: rotate;animation-duration: 1s;animation-iteration-count: infinite;animation-timing-function: linear;}
				button.wp-core-ui.button-primary[data-sending="done"]:before {position: relative;margin-right: 7px;content: '';display: inline-block;width: 4px;height: 8px;border: 2px solid white;border-left: none;border-top: none;transform: rotate(27deg);}
				button.wp-core-ui.button-primary[data-sending="true"] {position: relative;background: #b5b5b5;border-color: transparent;pointer-events: none;}
				#hc2_db_load {background: #0073aa;height: 3px;position:absolute;margin-left:-10px;transition: all .2s;}
				#hc2_db_load_b {background: #0073aa;height: 3px;position:absolute;margin-left:-10px;transition: all .2s;}
				#hc2_db_load_c {background: #0073aa;height: 3px;position:absolute;margin-left:-10px;transition: all .2s;}
				button.wp-core-ui.button-primary[data-sending="true"]:focus {outline: none !IMPORTANT;border: none !important;box-shadow: none !important;}
				.hc2_pushall {margin-left: 20px !important;}
				.hc2_advanced_area {position: absolute;top: 20px;right: 20px;}
				.hc2_advanced_area input {margin-right: 10px;vertical-align: middle;width: 100px;}
				td.hc2_advanced > label:first-child {width: 70px;display: inline-block;}
				td.hc2_advanced > div {display: inline-block;width: 25%;white-space: nowrap;overflow: hidden;}
				td.hc2_nowrite * {margin: 0;display: block;}
				.hc2_scan_note {background: #901c1c !important;}
				td#hc2_unpushed_count {color: red;position: absolute;font-weight: bold;}
				.hc2_push_item { display: grid; align-items: center; grid-template-columns: 20px 400px 20px 50px 20px 80px;}
				.hc2_push_item p { margin: 0;}
				.hc2_push_item input { border: none; margin: 0; padding: 0; text-align: right; height: 18px;}
				.hc2_push_item.hc2_pushed { grid-template-columns: 400px 20px 50px 20px 80px;}
				.hc2_push_item label { margin-left: 3px !important;}
				.hc2_push_item span { text-align: right;}

				td > .hc2_folder > div {max-height: initial !important;}
				.hc2_tableitem_radiocover > * {pointer-events: none;}
				.hc2_tableitem_radiocover {cursor: pointer;}
				.hc2_tableitem_radiocover input + label {background: #9c9c9c;display: inline-block;width: 70px;font-size: 12px;padding: 1px 7px;color: white;border-radius: 4px;border: 3px double #505050;}
				.hc2_tableitem_radiocover input:checked + input + label {background: #62c54b;border-color: darkgreen;}
				.hc2_tableitem_radiocover input:checked + label {background: #9d489e;border-color: #582875;}
				.hc2_tableitem_radiocover input {display: none;}
				.hc2_tableitem_radiocover input:checked + input + label:before {content: 'Push';}
				.hc2_tableitem_radiocover input:checked + label:before {content: 'Sync';}
				.hc2_tableitem_radiocover input + label:before {content: 'Do Nothing';}
				[onclick="hc2_update_db(this)"] {margin-top: 20px !important;}
				.hc2_tableitem_radiocover:hover input + label {opacity: .8;}															
				.hc2_tableitem_radiocover.hc2_dis,.hc2_tableitem_radiocover:last-child {pointer-events: none !IMPORTANT;opacity: .5;background: #d0d0d0;}
				.hc2_push_item p {overflow: hidden;white-space: nowrap;}

			</style>
				
				<script>
/*
					function hc2_compress_img(e){
						e.parentNode.dataset.compressing = 'true';
						jQuery.ajax( { 
							url: '<?php echo str_replace("http://","https://",get_rest_url()); ?>hc2/v1/hc2_compressimg', 
							method: 'POST', 
							beforeSend: function ( xhr ) { xhr.setRequestHeader( 'X-WP-Nonce', '<?php echo wp_create_nonce( "wp_rest" ); ?>' ); },
							data:{ 'img' : e.dataset.url, 'compression' : e.parentNode.getElementsByTagName('INPUT')[0].value }
						} ).done( function ( data ) {
							if(data.indexOf('compressed')>-1){
								e.parentNode.className = 'hc2_push_item hc2_not_pushed';
								e.parentNode.dataset.compressing = 'false';
								e.parentNode.getElementsByTagName('SPAN')[0].innerHTML = data.split(':')[1];
							}else{
								e.parentNode.dataset.compressing = 'failed';
							}
						} )
					}
*/

					function hc2_scan_uploads(e){
						e.dataset.sending = 'true';
						jQuery.ajax( { 
							url: '<?php echo str_replace("http://","https://",get_rest_url()); ?>hc2/v1/scan', 
							method: 'POST', 
							beforeSend: function ( xhr ) { xhr.setRequestHeader( 'X-WP-Nonce', '<?php echo wp_create_nonce( "wp_rest" ); ?>' ); }, 
							data:{ 'data' : '0'}
						} ).done( function ( data ) {
							e.dataset.sending = 'done';
							location.reload();
						} )
					}
					
					function hc2_update_img(e,all=false){
						e.parentNode.className = 'hc2_push_item hc2_sending';
						jQuery.ajax( { 
							url: '<?php echo str_replace("http://","https://",get_rest_url()); ?>hc2/v1/audit_pushimgs', 
							method: 'POST', 
							beforeSend: function ( xhr ) { xhr.setRequestHeader( 'X-WP-Nonce', '<?php echo wp_create_nonce( "wp_rest" ); ?>' ); },
							data:{ 'img' : e.dataset.url }
						} ).done( function ( data ) {
							e.parentNode.className = 'hc2_push_item hc2_pushed';
						} )
					}

				</script>
						
				<table class='hcube_settings'>
						<tr><td class='hcube_subsettings_box'><h2>Files</h2></td></tr>
						<tr><td><button class="wp-core-ui button-primary <?php if( get_option( 'hc2_media_last_scan' ) < get_option( 'hc2_media_last_push' ) )echo 'hc2_scan_note'; ?>" type="submit" onclick="hc2_scan_uploads(this)">Scan Uploads<div id='hc2_db_load_c'></div></button><tr><td></td></tr>
						<tr><td>
						
						<?php 
						
							if( get_option( 'hc2_remotedata_medialist' ) ){
								$data = get_option( 'hc2_remotedata_medialist' );
							}else{
								$data = hc2_curl_get_contents( trim(get_option('hc2_production_url'),'/').'/remote_render.php',array('auth'=>'IJDF#(*hj29g()I*%@)_(JGO'));
								update_option( 'hc2_remotedata_medialist', $data );
								update_option( 'hc2_media_last_scan', strtotime( 'now' ) );
							}
							$remotedata = json_decode(($data),1);
						
							update_option( 'hc2_unpushed_count', 0 );
							if($remotedata){
								$x = 0;
								$folders = scandir( ABSPATH . 'wp-content/uploads/' );
								rsort($folders);
								foreach( $folders as $folder ){
									if( $folder != '..' && $folder != '.' ){
										if( is_dir( ABSPATH . 'wp-content/uploads/'.$folder ) ) hc2_create_push_folder( ABSPATH . 'wp-content/uploads/' . $folder, $x ,$remotedata['media'] );
										$x++;
									}
								}
							}
						?>
						
						</td></tr>	
					</table>
				</div>
				
				
				
			<?php
	}
	
	
	function hc2_output_push_folder( $dir,$live_images ){
		$folders = scandir( $dir );
		rsort($folders);
		foreach( $folders as $folder ){
			if( $folder != '..' && $folder != '.' ){
				if( is_dir( $dir.'/'.$folder ) )
					hc2_create_push_folder( $dir.'/'.$folder, 1,$live_images,true );
				else
					hc2_create_push_item( $dir, $folder, ( in_array(str_replace(ABSPATH,'',$dir).'/'.$folder,$live_images) && !get_option( 'hc2-needspush--'.str_replace(ABSPATH,'/',$dir).'/'.$folder ) ) );
			}
		}		
	}
	
	function hc2_create_push_item($dir, $file, $pushed){
		if($file != '.htaccess' && 
			strpos( $file, '.png' ) === false &&
			strpos( $file, '.jpg' ) === false &&
			strpos( $file, '.jpeg' ) === false
		){
			/*
				$size = filesize ($dir.'/'.$file);
				if( strlen( $size ) < 4 ){ 
					$eng_size = $size . ' bytes';
				}else if( strlen( $size ) < 7 ){
					$eng_size = substr( $size, 0, -3) . ' KB';
				}else{
					$eng_size = substr( $size, 0, -6) . ' MB';
				}
				$compression = get_option('hc2-compression--'.str_replace(ABSPATH,'/',$dir).'/'.$file);
			*/
			?>
				<div class="hc2_push_item <?php if($pushed){ echo'hc2_pushed'; }else{ echo 'hc2_not_pushed'; } ?> ">
					<i class="fas fa-file-upload" data-url="<?php echo str_replace(ABSPATH,'/',$dir).'/'.$file; ?>" onclick="hc2_update_img(this)"></i>
					<p><a href='<?php echo get_site_url().str_replace(ABSPATH,'/',$dir).'/'.$file; ?>' target='_blank'><?php echo $file; ?></a></p>
					<?php /* <i class="fas fa-file-archive" data-url="<?php echo str_replace(ABSPATH,'/',$dir).'/'.$file; ?>" onclick="hc2_compress_img(this)"></i>
					<input class="hc2-file-compress" value='<?php echo $compression?$compression:100; ?>' /><label>%</label>
					<span><?php echo $eng_size; ?></span> */ ?>
				</div>
			<?php
		}
	}
	
	function hc2_create_push_folder( $dir, $x,$live_images,$auto=false ){
		$badfolders = ['ithemes-security','hc2-reserved'];
		$filebreak = explode('/',$dir);
		if(!in_array(end($filebreak),$badfolders)){
			?>
				<div class='hc2_folder'>
					<label><?php echo end($filebreak); ?></label>
					<div>
						<?php hc2_output_push_folder( $dir,$live_images ); ?>
					</div>
				</div>
			<?php
		}
	}

	/*
	
	add_action('rest_api_init',function(){register_rest_route('hc2/v1','/hc2_compressimg/',array('methods'=>'POST','callback'=>'hc2_compressimg','permission_callback' => function($request){ return is_user_logged_in();}));});
	function hc2_compressimg( $request ) { 
		$imgstr = $_POST['img'];
		$img = ABSPATH.ltrim($_POST['img'],'/');
		if( get_option( 'hc2-compression--'.$imgstr ) ) {
			$img = ABSPATH.'wp-content/uploads/hc2-reserved/'.get_option( 'hc2-reserved--'.$imgstr );
		}else{
			if (!file_exists(ABSPATH.'wp-content/uploads/hc2-reserved')) mkdir(ABSPATH.'wp-content/uploads/hc2-reserved', 0755, true);
			$targetfilename = strtotime( 'now' ).'-'.end(explode('/',$img));
			update_option( 'hc2-reserved--'.$imgstr, $targetfilename );
			copy( $img, ABSPATH.'wp-content/uploads/hc2-reserved/'.$targetfilename );
		}
		update_option( 'hc2-compression--'.$imgstr, $_POST['compression'] );
		update_option( 'hc2-needspush--'.$imgstr, true );
		hc2_compress( $img, ABSPATH.ltrim($imgstr,'/'), $_POST['compression'] );
		$size = filesize (ABSPATH.ltrim($imgstr,'/'));
		if( strlen( $size ) < 4 ){ 
			$eng_size = $size . ' bytes';
		}else if( strlen( $size ) < 7 ){
			$eng_size = substr( $size, 0, -3) . ' KB';
		}else{
			$eng_size = substr( $size, 0, -6) . ' MB';
		}
		return 'compressed:'.$eng_size;
	}
	
	function hc2_compress($source, $destination, $quality) {
		$info = getimagesize($source);
		if ($info['mime'] == 'image/jpeg') 
			$image = imagecreatefromjpeg($source);
		elseif ($info['mime'] == 'image/gif') 
			$image = imagecreatefromgif($source);
		elseif ($info['mime'] == 'image/png') 
			$image = imagecreatefrompng($source);
		imagejpeg($image, $destination, $quality);
	}
		
		*/