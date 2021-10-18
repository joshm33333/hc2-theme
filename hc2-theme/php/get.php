<?php
   
	if ( ! defined( 'ABSPATH' ) ) exit;
	
	add_shortcode('hc2', 'hc2_get_function');
	function hc2_get_function($atts, $content = null) {
		$a = shortcode_atts(array( 'place' => '','get' => '','color' => '','type' => '','hashtag' => '' ), $atts);	


		if($a['get']=='year'){
			return date("Y");
			
		}
		
		if( $atts['hashtag'] ){
			$str = '<label class="hc2-hashtag-box">'.$a['hashtag'];
				if( in_array('twitter',$atts) ) $str .= '<a class="hcube-hashtag-link hc2-hashtag-twitter fab fa-twitter" data-vars-name="hashtag-twitter-'.$a['hashtag'].'" href="https://twitter.com/hashtag/'.$a['hashtag'].'"></a>';
				if( in_array('facebook',$atts) ) $str .= '<a class="hcube-hashtag-link hc2-hashtag-facebook fab fa-facebook-f" data-vars-name="hashtag-facebook-'.$a['hashtag'].'" href="https://www.facebook.com/hashtag/'.$a['hashtag'].'"></a>';
				if( in_array('instagram',$atts) ) $str .= '<a class="hcube-hashtag-link hc2-hashtag-instagram fab fa-instagram" data-vars-name="hashtag-instagram-'.$a['hashtag'].'" href="https://www.instagram.com/explore/tags/hashtag/'.$a['hashtag'].'"></a>';
				if( in_array('pinterest',$atts) ) $str .= '<a class="hcube-hashtag-link hc2-hashtag-pinterest fab fa-pinterest" data-vars-name="hashtag-pinterest-'.$a['hashtag'].'" href="https://www.pinterest.ca/search/pins/?q='.$a['hashtag'].'"></a>';
				if( in_array('linkedin',$atts) ) $str .= '<a class="hcube-hashtag-link hc2-hashtag-linkedin fab fa-linkedin" data-vars-name="hashtag-linkedin-'.$a['hashtag'].'" href="https://www.linkedin.com/search/results/content/?keywords='.$a['hashtag'].'"></a>';
			return $str.'</label>';

		}
				
		
		$places = get_hc2('places');
		if($places){
			
			$selected_place = false;
			
			if( $a['place'] && !is_numeric($a['place']) ){
				$selected_place = $places[ $a['place'] ];
			}
			
			if( !$selected_place ){
				$p = 1;
				foreach($places as $place) {
					
					if( $a['place'] && is_numeric($a['place']) ){
						if( $a['place'] == $p ){
							$selected_place = $place;
							break;
						}
					}else{
						$selected_place = $place;
						break;
					}
					$p ++ ;
				} 
			}
			
			
			if($a['type']=='tel'){
				$numbers = json_decode(get_option('hc2_act_numbers'),1);
				$number = json_decode(json_encode($selected_place),1)[$a['get']];	
				$formatted = str_replace('(','',str_replace(')','',str_replace('-','',str_replace(' ','',$number))));
				return '<a class="hcube-contact-link" data-vars-name="'.$a['get'].'" href="tel:'.$formatted.'">'.$number.'</a>';

			}


			if($a['type']=='mailto'){
				return "<a data-vars-name='Mailto Link' href='mailto:".$selected_place['email']."'>".$selected_place['email']."</a>";
			}
			
			
			if($a['get']=='social'){
				$cl = [];
				$cl["facebook"] = ["fab fa-facebook-f", "Facebook" ];
				$cl["twitter"] = ["fab fa-twitter", "Twitter" ];
				$cl["pinterest"] = ["fab fa-pinterest", "Pwitter" ];
				$cl["linkedin"] = ["fab fa-linkedin", "Linkedin" ];
				$cl["youtube"] = ["fab fa-youtube", "Youtube" ];
				$cl["google"] = ["fab fa-google", "Google" ];
				$cl["instagram"] = ["fab fa-instagram", "Instagram" ];
				$cl["yelp"] = ["fab fa-yelp", "Yelp" ];

				$social = $selected_place['social'];
				$result = "<b class='hcube-social'>";
				foreach ($social as $key => $value)
					$result .= '
						<a target="_blank" data-vars-name="Social Profile - '.$cl[$key][1].'" rel="'.$cl[$key][1].'" aria-label="'.$cl[$key][1].'" href="'.$value.'" data-amp-original-style="color:">
							<i style="color:'.$a['color'].'" class="'.$cl[$key][0].'"></i></a>';
							
				$social = $selected_place['customsocial'];
				foreach ($social as $key => $value)
					$result .= '
						<a target="_blank" data-vars-name="Social Profile - '.$key.'" rel="'.$key.'" aria-label="'.$key.'" href="'.$value[0].'" data-amp-original-style="color:">
							<i class="hc2_customsocial" style="filter:opacity(.1) drop-shadow(0 0 0 '.$a['color'].') drop-shadow(0 0 0 '.$a['color'].') drop-shadow(0 0 0 '.$a['color'].') drop-shadow(0 0 0 '.$a['color'].') drop-shadow(0 0 0 '.$a['color'].');background-image:url('.wp_get_attachment_image_src($value[1], 'full')[0].')"></i></a>';

				return $result."</b>";
			}
		
			return json_decode(json_encode($selected_place),1)[$a['get']];
		}
	
	}
