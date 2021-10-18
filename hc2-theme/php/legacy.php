<?php

	if ( ! defined( 'ABSPATH' ) ) exit;
	
	add_action('init', 'hcube_block_callbacks');
	function hcube_block_callbacks() {
		register_block_type( 'hcube/wufoo', array(
			'attributes'=> array( 
				'unique' => array( 'type' => 'string', 'default' => '', ),
				'formurl' => array( 'type' => 'string', 'default' => '', ), 
				'frameheight' => array( 'type' => 'string', 'default' => '', ), 
			),
			'render_callback' => 'hc2_wufoo_shortcode'
		) );
		
		register_block_type( 'hcube/icon', array(
			'attributes'=> array( 
				'unique' => array( 'type' => 'string', 'default' => '', ),
				'bgcolor' => array( 'type' => 'string', 'default' => 'transparent', ), 
				'fgcolor' => array( 'type' => 'string', 'default' => '#000', ), 
				'iconstring' => array( 'type' => 'string', 'default' => '<i class="fas fa-phone"></i>', ), 
			),
			'render_callback' => 'icon_shortcode'
		) );
		
		register_block_type( 'hcube/sociallinks', array(
			'attributes'=> array( 
				'unique' => array( 'type' => 'string', 'default' => '', ),
				'color' => array( 'type' => 'string', 'default' => '#000', ), 
				'alignment' => array( 'type' => 'string', 'default' => 'left' ),
				'size' => array( 'type' => 'number', 'default' => 16, ),
				'mod' => array( 'type' => 'string', 'default' => '' ),
				'id' => array( 'type' => 'string', 'default' => 'this-id', ),
			),
			'render_callback' => 'sociallinks_shortcode'
		) );
		
		register_block_type( 'hcube/contact', array(
			'attributes'=> array( 
				'unique' => array( 'type' => 'string', 'default' => '', ),
				'mod' => array( 'type' => 'string', 'default' => '' ),
				'id' => array( 'type' => 'string', 'default' => 'this-id', ),
				'color' => array( 'type' => 'string', 'default' => '#000', ), 
				'tag' => array( 'type' => 'boolean', 'default' => true, ), 
				'alignment' => array( 'type' => 'string', 'default' => 'left', ),
				'size' => array( 'type' => 'number', 'default' => 16, ),
				'style' => array( 'type' => 'string', 'default' => 'link',  ),
				'addressmultiline' => array( 'type' => 'boolean', 'default' => true,  ),
				'name' => array( 'type' => 'boolean', 'default' => false,  ),
				'phone' => array( 'type' => 'boolean', 'default' => true,  ),
				'phoneb' => array( 'type' => 'boolean', 'default' => false,  ),
				'email' => array( 'type' => 'boolean', 'default' => false,  ),
				'website' => array( 'type' => 'boolean', 'default' => false,  ),
				'address' => array( 'type' => 'boolean', 'default' => false,  ),
				'hours' => array( 'type' => 'boolean', 'default' => false,  ),
				'streetaddress' => array( 'type' => 'boolean', 'default' => true,  ),
				'city' => array( 'type' => 'boolean', 'default' => true,  ),
				'state' => array( 'type' => 'boolean', 'default' => true,  ),
				'postalcode' => array( 'type' => 'boolean', 'default' => true,  ),
				'country' => array( 'type' => 'boolean', 'default' => false,  )
			),
			'render_callback' => 'contact_shortcode'
		) );
		
		
	}
	
	add_shortcode('nav', 'nav_shortcode');function nav_shortcode($atts, $content = null) {
		if(!is_admin())return wp_nav_menu(array('walker' => new rc_scm_walker,'echo' => false,'theme_location' => $atts['menu'],'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>'));
	}
	
	add_shortcode('page', 'page_shortcode');function page_shortcode($atts, $content = null) {return get_the_title( );}
	add_shortcode('year', 'date_shortcode');function date_shortcode($atts, $content = null) {return date("Y");}	
	add_shortcode('date', 'postdate_shortcode');function postdate_shortcode($atts, $content = null) {return  get_the_date( );}
	add_shortcode('wufoo', 'hc2_wufoo_shortcode');
	function hc2_wufoo_shortcode($atts, $content = null) {
		$a = shortcode_atts(array( 'formurl' => '', 'frameheight' => '' ), $atts );
		if(strpos($a['formurl'],'wufoo.com')!==false) $result = '	<iframe sandbox="allow-popups allow-same-origin allow-forms allow-scripts allow-top-navigation allow-top-navigation-by-user-activation" title="Embedded Wufoo Form" height="'.$a['frameheight'].'" allowTransparency="true" frameborder="0" scrolling="no" style="width:100%;border:none" src="'.str_replace('forms','embed',$a['formurl']).'/"><a href="'.$a['formurl'].'">Click here to fill out our form.</a></iframe>';
		return $result;}
		
	add_shortcode('icon', 'icon_shortcode');
	function icon_shortcode($atts, $content = null) {
		$i = uniqid (rand(),false);
		$a = shortcode_atts(array( 'iconstring' => '<i class="fas fa-phone"></i>', 'bgcolor' => 'transparent', 'fgcolor' => '#000' ), $atts );
		
		return '<div id="hcube-icon-'.$i.'" class="hcube-icon">'.$a['iconstring'].'</div>
			<style>
				div#hcube-icon-'.$i.' i{background-color:'.$a['bgcolor'].'}
				div#hcube-icon-'.$i.' i:before{color:'.$a['fgcolor'].'}
			</style>';}
			
	add_shortcode('social', 'sociallinks_shortcode');
	function sociallinks_shortcode($atts, $content = null) {
		return '<span style="width: 100%;display: inline-block;text-align:'.(array_key_exists('alignment',$atts)?$atts['alignment']:'').'">'.hc2_get_function(array( 'get' => 'social', 'color' => $atts['color'] ), $content).'</span>';
	}
	add_shortcode('get', 'contact_shortcode');
	add_shortcode('contact', 'contact_shortcode');
	function contact_shortcode($atts, $content = null) {
		
		$place = [];
		$places = get_hc2('places');
		if($places){
			foreach($places as $p) {$place = $p;break;}
		
			if( array_key_exists('hours',$atts) && $atts['hours'] ){
				if($atts['hours']!='1'){
					$place = $places[$atts['hours']];
				}
				if($place['hours'])return splithours( json_encode($place['hours']), (array_key_exists('color',$atts)?$atts['color']:'') );	
			}
			
			
			if( array_key_exists('phone',$atts) && $atts['phone'] )
				if($place['telephone'])return $place['telephone'];
		}
		
		return 'Legacy shortcode';
	}
			
	function splithours( $str, $color ){
		$pms = ['12','13','14','15','16','17','18','19','20','21','22','23'];
		$ams = ['24','1','2','3','4','5','6','7','8','9','10','11'];
		$pmg = ['12','1','2','3','4','5','6','7','8','9','10','11'];
		$amg = ['12','1','2','3','4','5','6','7','8','9','10','11'];
		$amn = 'am';
		$pmn = 'pm';
		if( get_option( 'hcube_military_time' ) ){
			$amn = '';
			$pmn = '';
			$pmg = ['12','13','14','15','16','17','18','19','20','21','22','23'];
			$amg = ['24','1','2','3','4','5','6','7','8','9','10','11'];
		}
			
		$result = str_replace('-','"[[]] ',str_replace(' 0',' ',str_replace('-0','-',$str)));
		
		foreach( $pms as $p => $pm ){
			$pmsplit = explode( ' '.$pms[$p].':', $result );
			for( $ps = 1 ; $ps < count( $pmsplit ) ; $ps++ ) $pmsplit[$ps] = str_replace_first( '"', $pmn.'"', $pmsplit[$ps] );
			$result = implode( ' '.$pmg[$p].'[]:', $pmsplit );}
		
		foreach( $ams as $a => $am ){
			$amsplit = explode( ' '.$ams[$a].':', $result );
			for( $as = 1 ; $as < count( $amsplit ) ; $as++ ) $amsplit[$as] = str_replace_first( '"', $amn.'"', $amsplit[$as] );
			$result = implode( ' '.$amg[$a].'[]:', $amsplit );}

		if( get_post_meta( get_post_meta( get_the_ID(), 'hcube_mainpage', true), 'hcube_language', true) == 'fr' ) 
			$result = str_replace('Mo','Lundi',str_replace('Tu','Mardi',str_replace('We','Mercredi',str_replace('Th','Jeudi',str_replace('Fr','Vendredi',str_replace('Sa','Samedi',str_replace('Su','Dimanche',$result)))))));
		else $result = str_replace('Mo','Monday',str_replace('Tu','Tuesday',str_replace('We','Wednesday',str_replace('Th','Thursday',str_replace('Fr','Friday',str_replace('Sa','Saturday',str_replace('Su','Sunday',$result)))))));
		
		$result = str_replace('-',' - ',str_replace('"','',str_replace(',',', ',str_replace('","','</i><i style="color:'.$color.'" class="hcube_hrs_left">',str_replace(' ','</i><i style="color:'.$color.'" class="hcube_hrs_right">',str_replace(']','',str_replace('[','',str_replace('"[[]] ','-',$result))))))));
		
		return '<i style="color:'.$color.'" class="hcube_hrs"><i style="color:'.$color.'" class="hcube_hrs_left">'.$result.'</i></i>';
	}		
	function str_replace_first($from, $to, $content)
	{
		$from = '/'.preg_quote($from, '/').'/';

		return preg_replace($from, $to, $content, 1);
	}	
	


	add_action( 'edit_user_profile', 'custom_user_profile_fields' );
	function custom_user_profile_fields($user){ 
		?>
			<h3>More Information</h3>
			
			<table class="form-table"><tr><td>Your User ID is <?php echo $user->ID; ?></td></tr></table>
			<table class="form-table">
				<tr><th><label for="jobtitle">Job Title</label></th><td><input type="text" class="regular-text" name="jobtitle" value="<?php echo esc_attr( get_the_author_meta( 'jobtitle', $user->ID ) ); ?>" id="jobtitle" /></td></tr>
				<tr><th><label for="image">Image URI</label></th><td><input type="text" class="regular-text" name="image" value="<?php echo esc_attr( get_the_author_meta( 'image', $user->ID ) ); ?>" id="image" /></td></tr>
				<tr><th><label for="profile">Profile URI</label></th><td><input type="text" class="regular-text" name="profile" value="<?php echo esc_attr( get_the_author_meta( 'profile', $user->ID ) ); ?>" id="profile" /></td></tr>
				<tr><th><label for="gender">Gender</label></th><td><input type="text" class="regular-text" name="gender" value="<?php echo esc_attr( get_the_author_meta( 'gender', $user->ID ) ); ?>" id="gender" /></td></tr>
				<tr><th><label for="birthdate">Birthdate</label></th><td><input type="text" class="regular-text" name="birthdate" value="<?php echo esc_attr( get_the_author_meta( 'birthdate', $user->ID ) ); ?>" id="birthdate" /></td></tr>
				<tr><th><label for="telephone">Telephone</label></th><td><input type="text" class="regular-text" name="telephone" value="<?php echo esc_attr( get_the_author_meta( 'telephone', $user->ID ) ); ?>" id="telephone" /></td></tr>
			</table>
		<?php
	}
	add_action('user_register', 'save_custom_user_profile_fields');
	add_action('profile_update', 'save_custom_user_profile_fields');
	function save_custom_user_profile_fields($user_id){
		if(!current_user_can('manage_options'))return false;
		update_user_meta($user_id, 'jobtitle', $_POST['jobtitle']);
		update_user_meta($user_id, 'image', $_POST['image']);
		update_user_meta($user_id, 'profile', $_POST['profile']);
		update_user_meta($user_id, 'gender', $_POST['gender']);
		update_user_meta($user_id, 'birthdate', $_POST['birthdate']);
		update_user_meta($user_id, 'telephone', $_POST['telephone']);
	}
	
	
	
			
			
	add_shortcode('user', 'user_shortcode');
	function user_shortcode($atts, $content = null) {
		$i = uniqid (rand(),false);
		$a = shortcode_atts( array( 'id' => '0', 'name' => '0', 'description' => '0', 'shortdescription' => '0', 'jobtitle' => '0', 'image' => '0', 'sameas' => '0', 'social' => '0', 'profile' => '0', 'gender' => '0', 'birthdate' => '0', 'telephone' => '0', 'email' => '0', 'render' => '0' ), $atts );
		
		$id = ( $a['id'] == 'this' ? get_the_author_meta('ID') : $a['id'] ) ;
		
		if( $a['name'] == '1' ) return get_the_author_meta( 'first_name', $id ) . ' ' . get_the_author_meta( 'last_name', $id );
		if( $a['gender'] == '1' ) return get_the_author_meta( 'gender', $id );
		if( $a['birthdate'] == '1' ) return get_the_author_meta( 'birthdate', $id );
		if( $a['telephone'] == '1' ) return get_the_author_meta( 'telephone', $id );
		if( $a['email'] == '1' ) return get_the_author_meta( 'user_email', $id );
		if( $a['profile'] == '1' ) return get_the_author_meta( 'profile', $id );
		if( $a['description'] == '1' ) return str_replace('-br-',"<br>",str_replace('"',"'",get_the_author_meta( 'description', $id )));
		if( $a['shortdescription'] == '1' ) return str_replace('"',"'",get_the_author_meta( 'shortdescription', $id ));
		if( $a['jobtitle'] == '1' ) return get_the_author_meta( 'jobtitle', $id );
		if( $a['image'] == '1' && $a['render'] == '1' ) return '<img alt="' . get_the_author_meta( 'first_name', $id ) . ' ' . get_the_author_meta( 'last_name', $id ) . '" width="140" height="140" layout="responsive" src="' . get_the_author_meta( 'image', $id ) . '" />';
		if( $a['image'] == '1' ) return get_the_author_meta( 'image', $id );
		
		$cl["facebook"] = ["fab fa-facebook-f", "Facebook" ];
		$cl["twitter"] = ["fab fa-twitter", "Twitter" ];
		$cl["linkedin"] = ["fab fa-linkedin", "Linkedin" ];
		$cl["youtube"] = ["fab fa-youtube", "Youtube" ];
		$cl["google"] = ["fab fa-google", "Google" ];
		$cl["instagram"] = ["fab fa-instagram", "Instagram" ];
		$cl["yelp"] = ["fab fa-yelp", "Yelp" ];
			
		if( $a['social'] == '1' ) {
			$result = "<b class='hcube-social' data-id='hcube-social-".$i."'>";
			foreach ($cl as $key => $value){
				if( get_the_author_meta( 'hcube_social_'.$key, $id ) && get_the_author_meta( 'hcube_social_'.$key, $id ) != '' ){
					$result .= '<a target="_blank" data-vars-name="Social Profile Author - '.$value[1].'" rel="'.$value[1].'" aria-label="'.$value[1].'" href="'.get_the_author_meta( 'hcube_social_'.$key, $id ).'"><i class="'.$value[0].'"></i></a>
					<style>[data-id="hcube-social-'.$i.'"] i{color:inherit;font-size:inherit;}[data-id="hcube-social-'.$i.'"]{text-align:inherit;}</style>';}}
			return $result."</b>";}
			
		if( $a['sameas'] == '1' ) {
			$result = "";
			foreach ($cl as $key => $value)
				if( get_the_author_meta( 'hcube_social_'.$key, $id ) && get_the_author_meta( 'hcube_social_'.$key, $id ) != '' )
					$result .= '"'.get_the_author_meta( 'hcube_social_'.$key, $id ).'",';
			return substr($result, 0, -1);}}