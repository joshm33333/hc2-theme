<?php 

	if ( ! defined( 'ABSPATH' ) ) exit;
	$thispage_id = get_the_ID();

?>

<!doctype html>
<html lang="<?php if(get_post_meta( get_the_ID(), 'hc2_lang', 1 )){ echo get_post_meta( get_the_ID(), 'hc2_lang', 1 ); }else{ echo 'en'; }; ?>" >
<head>

	<?php
		
		$filtered_excerpt =str_replace('"',"'", do_shortcode((get_post_meta( $thispage_id, 'hc2_custom_excerpt', true )?get_post_meta( $thispage_id, 'hc2_custom_excerpt', true ):get_the_excerpt())));
		$thetitle = str_replace('"',"'", do_shortcode(get_post_meta( $thispage_id, 'hc2_custom_title', true )?get_post_meta( $thispage_id, 'hc2_custom_title', true ):((get_option('page_on_front')==$thispage_id?get_bloginfo('name'):get_the_title()).' - '.get_bloginfo( 'description' ))));
		$used_thumbnail = get_post_meta($thispage_id,'hc2_custom_thumb',1);
		if( !$used_thumbnail ) $used_thumbnail = ( get_the_post_thumbnail_url($thispage_id,'full') ? get_the_post_thumbnail_url($thispage_id,'full') : get_the_post_thumbnail_url( get_option('page_on_front') ,'full') );
	
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
		

		$place = [];
		$places = get_hc2('places');
		if(($places)){
			if(get_post_meta($thispage_id,'hc2_address',1) && array_key_exists(get_post_meta($thispage_id,'hc2_address',1),$places)){
				$place = $places[get_post_meta($thispage_id,'hc2_address',1)];
			}else if(($places)){
				foreach($places as $p) {$place = $p;break;} 
			}
		}
				
		
		$languages = get_hc2('settings','languages');
		if( get_post_meta( get_the_ID(), 'hc2_lang', 1 ) && ($languages) )
			foreach( $languages as $lang )
				if( strtolower($lang) != get_post_meta( get_the_ID(), 'hc2_lang', 1 ))
					echo '<link rel="alternate" hreflang="'.$lang.'" href="'.get_post_meta( get_the_ID(), 'hcube_eq_page_'.strtolower($lang), 1 ).'" />'; 
			
	?>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	
	<link rel="preload" as="script" href="https://cdn.ampproject.org/v0.js">
	<script src="https://cdn.ampproject.org/v0.js" async="" ></script>
	<?php
	    if (!get_hc2('settings','amp_off')){
			?>
				<script src="https://cdn.ampproject.org/v0/amp-mustache-0.2.js" async="" custom-template="amp-mustache"></script>
				<script src="https://cdn.ampproject.org/v0/amp-list-0.1.js" async="" custom-element="amp-list"></script>
				<script src="https://cdn.ampproject.org/v0/amp-fx-collection-0.1.js" async="" custom-element="amp-fx-collection"></script>
				<script src="https://cdn.ampproject.org/v0/amp-lightbox-0.1.js" async="" custom-element="amp-lightbox"></script>
				<script src="https://cdn.ampproject.org/v0/amp-dynamic-css-classes-0.1.js" async custom-element="amp-dynamic-css-classes" ></script>
				<script src="https://cdn.ampproject.org/v0/amp-carousel-0.2.js" async custom-element="amp-carousel" ></script>
				<script src="https://cdn.ampproject.org/v0/amp-base-carousel-0.1.js" async custom-element="amp-base-carousel" ></script>
				<script src="https://cdn.ampproject.org/v0/amp-position-observer-0.1.js" async custom-element="amp-position-observer" ></script>
				<script src="https://cdn.ampproject.org/v0/amp-animation-0.1.js" async="" custom-element="amp-animation"></script>
				<script async custom-element="amp-accordion" src="https://cdn.ampproject.org/v0/amp-accordion-0.1.js"></script>
				<script async custom-element="amp-call-tracking" src="https://cdn.ampproject.org/v0/amp-call-tracking-0.1.js"></script>
				<script async custom-element="amp-fit-text" src="https://cdn.ampproject.org/v0/amp-fit-text-0.1.js"></script>
				<script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>
			<?php
		}
	?>
		
	<title><?php echo $thetitle; ?></title>
	<link rel="Shortcut Icon" type="image/x-icon" href="!<?php if(get_hc2('settings','favicon_id'))echo wp_get_attachment_image_src(get_hc2('settings','favicon_id'))[0]; ?>" />
	<meta property="og:title" 			content="<?php echo $thetitle; ?>"/>
	<meta property="og:type" 			content="article"/>
	<meta property="og:url" 			content="<?php echo str_replace( get_site_url(), rtrim( get_option( 'hc2_production_url' ), '/' ), get_page_link( $thispage_id )); ?>"/>
	<meta property="og:site_name" 		content="<?php echo get_bloginfo('name'); ?>"/>
	<meta property="og:description" 	content="<?php echo $filtered_excerpt; ?>"/>
	<meta property="og:image" 			content="<?php echo $used_thumbnail; ?>"/>
	<meta property="id" 			content="<?php echo $thispage_id; ?>"/>
	<meta name="viewport" content="width=device-width">
	<meta name="description" content="<?php echo $filtered_excerpt; ?>"/>
	
    <link rel="canonical" href="<?php echo get_page_link( $thispage_id ); ?>" />
	
	<link rel="stylesheet" href="//use.fontawesome.com/releases/v5.6.1/css/all.css">
	<script type="application/ld+json">[
		<?php if(get_post_meta( $thispage_id, 'hcube_is_service', true)){ ?>
		{
			"@context": "http://schema.org/",
			"@type": "Service",
			"serviceType": "<?php echo $thetitle; ?>",
			"areaServed": {"@type": "AdministrativeArea","name":"<?php echo array_key_exists('addressLocality',$place ) ? $place['addressLocality'] : '' ; ?>" },
			"provider": "<?php echo $filtered_excerpt; ?>",
			"description":"<?php echo $filtered_excerpt; ?>",
			"image":"<?php echo $used_thumbnail ; ?>",
			"logo" : {"@type" : "ImageObject","url":"<?php if(get_hc2('settings','favicon_id'))echo wp_get_attachment_image_src(get_hc2('settings','favicon_id'))[0]; ?>","width":"60","height":"60"},
			"url":"<?php echo str_replace( get_site_url(), rtrim( get_option( 'hc2_production_url' ), '/' ), get_page_link( $thispage_id )); ?>"
		},
		<?php } elseif(get_post_meta( $thispage_id, 'hcube_is_about', true)){ ?>
		{
			"@context": "http://schema.org/",
			"@type": "AboutPage",
			"description":"<?php echo $filtered_excerpt; ?>",
			"image":"<?php echo $used_thumbnail ; ?>",
			"name":"<?php echo $thetitle; ?>",
			"url":"<?php echo str_replace( get_site_url(), rtrim( get_option( 'hc2_production_url' ), '/' ), get_page_link( $thispage_id )); ?>"
		},
		<?php } else { ?>
		{
			"@context": "http://schema.org/"
			,"@type": "NewsArticle"
			,"name": "<?php echo $thetitle; ?>"
			,"url":"<?php echo str_replace( get_site_url(), rtrim( get_option( 'hc2_production_url' ), '/' ), get_page_link( $thispage_id )); ?>"
			,"headline": "<?php echo $thetitle; ?>"
			,"description": "<?php echo $filtered_excerpt; ?>"
			,"datePublished": "<?php echo get_the_date( ) . ' ' . get_the_time( ); ?>"
			,"dateModified": "<?php echo get_the_modified_date( ) . ' ' . get_the_modified_time( ); ?>"
			,"image": "<?php echo $used_thumbnail ; ?>"
			,"mainEntityOfPage":"<?php echo str_replace( get_site_url(), rtrim( get_option( 'hc2_production_url' ), '/' ), get_page_link( $thispage_id )); ?>"
			,"author":{ "@type" : "Person","name" : "<?php echo array_key_exists('owner',$place ) ? $place['owner'] : ''; ?>"}
			,"publisher": { 
				  "@type" : "Organization"
				  ,"url" : "<?php echo str_replace( get_site_url(), rtrim( get_option( 'hc2_production_url' ), '/' ), get_page_link( $thispage_id )); ?>"
				  ,"logo" : {"@type" : "ImageObject","url":"<?php if(get_hc2('settings','favicon_id'))echo wp_get_attachment_image_src(get_hc2('settings','favicon_id'))[0]; ?>","width":"60","height":"60"}
				  ,"name": "<?php echo $thetitle; ?>"
				  ,"contactPoint" : [{ "@type" : "ContactPoint","telephone" : "+1 <?php echo array_key_exists('telephone',$place ) ? $place['telephone'] : '' ; ?>","contactType" : "customer service"} ] }
		},
		<?php } ?>
		{
			"@context": "https://schema.org",
			"@type": "Organization",
			"url": "<?php echo str_replace( get_site_url(), rtrim( get_option( 'hc2_production_url' ), '/' ), get_page_link( $thispage_id )); ?>",
			"logo": "<?php if(get_hc2('settings','logo_id'))echo wp_get_attachment_image_src(get_hc2('settings','logo_id'))[0]; ?>"
		},
		{
			"@context": "http://schema.org/"
			,"@type": "<?php echo get_hc2('settings','business_type'); ?>"
			,"name": "<?php echo (get_post_meta($thispage_id,'schema_name',1)?get_post_meta($thispage_id,'schema_name',1):get_bloginfo( 'name' )); ?>"
			,"logo" : {"@type" : "ImageObject","url":"<?php if(get_hc2('settings','favicon_id'))echo wp_get_attachment_image_src(get_hc2('settings','favicon_id'))[0]; ?>","width":"60","height":"60"}
			,"image": "<?php echo $used_thumbnail; ?>"
			,"@id": "<?php echo str_replace( get_site_url(), rtrim( get_option( 'hc2_production_url' ), '/' ), (get_post_meta($thispage_id,'schema_url',1)?get_post_meta($thispage_id,'schema_url',1):get_site_url( ))); ?>"
			,"url": "<?php echo str_replace( get_site_url(), rtrim( get_option( 'hc2_production_url' ), '/' ), (get_post_meta($thispage_id,'schema_url',1)?get_post_meta($thispage_id,'schema_url',1):get_site_url( ))); ?>"
			,"description": "<?php echo $filtered_excerpt; ?>"
			<?php if( array_key_exists('telephone',$place ) && $place['telephone']!=''){ ?>,"telephone": "+1 <?php echo (get_post_meta($thispage_id,'schema_telephone',1)?get_post_meta($thispage_id,'schema_telephone',1):$place['telephone']); ?>"<?php } ?>
			<?php if( array_key_exists('priceRange',$place ) && $place['priceRange']!=''){ ?>,"priceRange": "<?php echo $place['priceRange']; ?>"<?php } ?>
			
			<?php if(array_key_exists('addressCountry',$place )){ ?>
				,"address": {
					"@type": "PostalAddress",
					"streetAddress": "<?php echo array_key_exists('streetAddress',$place ) ? $place['streetAddress'] : '' ; ?>",
					"addressLocality": "<?php echo array_key_exists('addressLocality',$place ) ? $place['addressLocality'] : '' ; ?>",
					"addressRegion": "<?php echo array_key_exists('addressRegion',$place ) ? $place['addressRegion'] : '' ; ?>",
					"postalCode": "<?php echo array_key_exists('postalCode',$place ) ? $place['postalCode'] : '' ; ?>",
					"addressCountry": "<?php echo array_key_exists('addressCountry',$place ) ? $place['addressCountry'] : '' ; ?>"
				}
			<?php } ?>
			<?php if( array_key_exists('latitude',$place ) && $place['latitude']!='' && array_key_exists('longitude',$place ) && $place['longitude']!=''){ ?>
				,"geo": {
					"@type": "GeoCoordinates",
					"latitude": <?php echo $place['latitude']; ?>,
					"longitude": <?php echo $place['longitude']; ?>
				}
			<?php } ?>
			<?php if(array_key_exists('hours',$place ) && $place['hours']!=''){ ?>,"openingHours":<?php echo json_encode($place['hours']); } ?>
			
			<?php if ( !get_post_meta($thispage_id,'schema_single_address',1) && count($places)>1) { ?>
				,"location": [ 
					<?php 
						$a = 1;
						foreach( $places as $key => $value ) { 
							if(array_key_exists('addressCountry',$value )){ 
								if ($a > 1 ) { ?>,<?php } $a++; 
								?>
									{ 
										 "@type": "<?php echo get_hc2('settings','business_type'); ?>", 
										 "parentOrganization": {"name": "<?php echo get_bloginfo( 'name' ); ?>"},
										 "name" : "<?php echo array_key_exists('name',$value ) ? $value['name'] : '' ; ?>",
										 "image": "<?php echo $used_thumbnail; ?>",
										 "logo" : {"@type" : "ImageObject","url":"<?php if(get_hc2('settings','favicon_id'))echo wp_get_attachment_image_src(get_hc2('settings','favicon_id'))[0]; ?>","width":"60","height":"60"},
										 "telephone": "+1 <?php echo array_key_exists('telephone',$value ) ? $value['telephone'] : '' ; ?>",
										 "priceRange": "<?php echo array_key_exists('priceRange',$value ) ? $value['priceRange'] : '' ; ?>",
										 "address": {
											"@type": "PostalAddress",
											"streetAddress": "<?php echo array_key_exists('streetAddress',$value ) ? $value['streetAddress'] : '' ; ?>",
											"addressLocality": "<?php echo array_key_exists('addressLocality',$value ) ? $value['addressLocality'] : '' ; ?>",
											"addressRegion": "<?php echo array_key_exists('addressRegion',$value ) ? $value['addressRegion'] : '' ; ?>",
											"postalCode": "<?php echo array_key_exists('postalCode',$value ) ? $value['postalCode'] : '' ; ?>",
											"addressCountry": "<?php echo array_key_exists('addressCountry',$value ) ? $value['addressCountry'] : '' ; ?>"
											},
										 "geo": {
											"@type": "GeoCoordinates",
											"latitude": <?php echo array_key_exists('latitude',$value ) ? $value['latitude'] : '' ; ?>,
											"longitude": <?php echo array_key_exists('longitude',$value ) ? $value['longitude'] : '' ; ?>
											}
									}
								<?php 
							}
						} 
					?>
				]
			<?php } ?>
			,"sameAs":[
				"<?php echo str_replace( get_site_url(), rtrim( get_option( 'hc2_production_url' ), '/' ), (get_post_meta($thispage_id,'schema_url',1)?get_post_meta($thispage_id,'schema_url',1):get_site_url( ))); ?>"
				<?php 
					if(array_key_exists('social',$place ))foreach( $place['social'] as $key => $value )
						if( strpos( $key, '-icon' ) === false && strpos( $key, '-color' ) === false )echo ',"'.$value.'"'; 
				?>
			]
		
		}
	]</script>	
	<script>
		
		var xhttp = new XMLHttpRequest();
		var access = ( document.cookie.indexOf( '__hc2_login=1026' ) > -1 || document.cookie.indexOf( '__hc2_login=2024' ) > -1 );
		
		var cookienum = 0;
		if( window.location.href.indexOf('h=1026') > -1 ) cookienum = '1026';
		if( window.location.href.indexOf('h=2024') > -1 ) cookienum = '2024';
		if( cookienum ){
			const d = new Date();
			d.setTime(d.getTime() + (30*24*60*60*1000));
			let expires = "expires="+ d.toUTCString();
			document.cookie = "__hc2_login=" + cookienum + ";" + expires + ";path=/";
		}

		xhttp.open("GET", "<?php echo rtrim(get_option('hc2_staging_url'),'/'); ?>/wp-json/hc2/v1/hc2_getkeys?post=<?php echo $thispage_id; ?>&access="+(access?'1':'0')+"&url="+window.location.href, true);
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200 && this.responseText.indexOf("fjh932y539q8nwcy32985b3n29tycn4tc9ny2038cty") > -1 ) {
				document.getElementById("hc2_accessarea").innerHTML = this.responseText;
			}
		};
		xhttp.send();

		function hc2_updatekeys(e){
			var important = document.getElementsByClassName('hc2_important')[0].getElementsByTagName('INPUT')[0].checked;
			var keys = document.getElementsByClassName('hc2_keys_area')[0].getElementsByTagName('TEXTAREA')[0].value;
			var notes = document.getElementsByClassName('hc2_keys_area')[0].getElementsByTagName('TEXTAREA')[1].value;
			e.dataset.state = 'loading';
			var xhttp = new XMLHttpRequest();
			xhttp.open("GET", "<?php echo rtrim(get_option('hc2_staging_url'),'/'); ?>/wp-json/hc2/v1/hc2_setkeys?post=<?php echo $thispage_id; ?>&urgent="+(important?'1':'0')+"&keys="+keys+"&notes="+notes, true);
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					e.dataset.state = 'done';
				}
			};
			xhttp.send();
		}
	</script>

	
	<?php
		wp_head(); 
	  if (!get_hc2('settings','gtm_off') && !get_post_meta( $thispage_id, 'hcube_cm_notracking', 1) ){
			
			echo"
				<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
				new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
				j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
				'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
				})(window,document,'script','dataLayer','GTM-WXN3R4G');</script>"; 
				
			$conversions = ['a','b'];
			foreach( $conversions as $key )
				if(get_post_meta( $thispage_id, 'hcube_conversion_trigger_'.$key, true))
					echo '<script id="gtag_thankyou_'.$key.'"></script>';

			$pixels = ['a','b','c','d','e'];
			foreach( $conversions as $key )
				if(get_post_meta( $thispage_id, 'hcube_pixel_trigger_'.$key, true))
					echo '<script id="fb_thankyou_'.$key.'"></script>';
				
	  }
		
	?>
	
	</head>
	
	<div id='hcube_top'></div>
	
	<?php
	
		hc2_header_styles($thispage_id);
			