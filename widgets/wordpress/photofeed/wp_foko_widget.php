<?php
/*
Plugin Name: Foko PhotoFeed Wordpress Widget
Description: A widget that displays your company's photo feeds from Foko
Version: 0.1
Author: Foko Inc.
Author URI: http://www.foko.co
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

add_action('widgets_init', 'foko_widget');
add_action( 'wp_enqueue_scripts', 'add_stylesheet' );
add_action( 'wp_enqueue_scripts', 'add_javascript' );

function add_javascript(){
	wp_register_script( 'main_foko', plugins_url('main_foko.js', __FILE__) );
	if (!wp_script_is('jquery', 'enqueued')){
		wp_enqueue_script( 'jquery' );
	}
	if (!wp_script_is('jquery-masonry', 'enqueued')){
		wp_enqueue_script( 'jquery-masonry' );		
	}
	if (!wp_script_is('jquery-migrate', 'enqueued')){
		wp_enqueue_script( 'jquery-migrate' );		
	}
	wp_register_script( 'imagesloaded', plugins_url('imagesloaded.pkgd.min.js', __FILE__) );
	wp_enqueue_script( 'imagesloaded' );
}

function add_stylesheet(){
	wp_register_style( 'foko_style', plugins_url('foko_style.css', __FILE__) );
    wp_enqueue_style( 'foko_style' );
    if (!wp_style_is('font-awesome', 'enqueued')){
		wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' );
	}    
}

function foko_widget() {
	register_widget('wp_foko_widget');
}

class wp_foko_widget extends WP_Widget {

	function wp_foko_widget() {
		$widget_ops = array('classname' => 'wp_foko_widget', 'description' => __('Displays your most popular photo feeds in the company', 'wp_foko_widget') );
		$control_ops = array('id_base' => 'foko-widget' );
		$this->WP_Widget('foko-widget', __('Foko', 'wp_foko_widget'), $widget_ops, $control_ops);
	}

	function widget($args, $instance) {

		extract($args);

		$title = apply_filters('widget_title', $instance['title'] );
		$displayNum = $instance['displayNum'];
		$atoken = $instance['atoken'];
		$user_email = $instance['user_input'];
		$hashtag = $instance['hashtag_input'];
		$description = $instance['description'];

		if (!$displayNum)
			$displayNum = 20;
		if (intval($displayNum)>40)
			$displayNum = 40;


		echo $before_widget;


		if(!empty($title)) { echo $before_title . $title . $after_title; };
		if (!empty($description)){
			echo '<div class="description">'.$description.'</div>';
		}
		if ( $atoken ){
			if ($user_email && !$hashtag){
				$displayData = $this->scrape_foko($atoken, $displayNum, $user_email, null);
			}
			else if (!$user_email && $hashtag){
				$displayData = $this->scrape_foko($atoken, $displayNum, NULL, $hashtag);
			}
			else if ($user_email && $hashtag){
				$displayData = $this->scrape_foko($atoken, $displayNum, $user_email, $hashtag);
			}
			else{
				$displayData = $this->scrape_foko($atoken, $displayNum, NULL, NULL);
			}

			wp_localize_script( 'main_foko', 'passedData', $displayData);
			wp_enqueue_script( 'main_foko');

			if ($displayData == null){
				echo 'No data was found according to your input information, please verify the provided information was correct';
			}else{

				echo '<div class="outer_photo_wrapper" id="outer_photo_wrapper">';
				echo '<div id="loading"></div>';
				echo '<div class="photo_wrapper" id="photo_wrapper">';

				for ($i = 0; $i < intval($displayData[5]); $i++){
					echo '<div class="foko_item">';
					echo '<a class="foko_item_link" href="'.$displayData[1][$i].'" target="_blank">';
					echo '<div class="view third-effect">';			
					echo '<div class="mask"><span class="center_helper"></span>';
					echo '<span class="info">';
					echo '<i class="fa fa-search fa-lg" id="foko-search-icon"></i></span></div>';
					echo '<img id="image_link" src="'.$displayData[0][$i].'" alt="'.$i.'">';
					echo '</div></a>';
					echo '<div class="photo_info">';
					echo '<p class="photo_description">';
					echo '<span title="'.$displayData[4][$i].'"class="caption">'.$displayData[3][$i].'</span></p>';
					echo '<div class="meta_info">';
					echo '<span class="likes" style="font-size: 11px">';
					echo '<i class="fa fa-heart" style="color:rgb(221, 148, 148)"></i>  '.$displayData[2][$i].'</span>';
					echo '</div></div></div>';
				}

				echo '</div></div>';
			}
		}else{
			echo 'Please provide your Access Token.';
		}

		echo $after_widget;
	}

	// function debug_to_console($data) {
	// 		echo("<script>console.log(".json_encode($data).");</script>");
	// }

	function form($instance) {
		?>

		<!-- Widget Title: Text Input -->
		<p>
			<div for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></div>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Description: Text Input -->
		<p>
			<div for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e('Description:', 'example'); ?></div>
			<input id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" value="<?php echo $instance['description']; ?>" style="width:100%;" />
		</p>

		<!-- Access Token: Text Input-->
		<p>
			<div for="<?php echo $this->get_field_id( 'atoken' ); ?>"><?php _e('Access Token:', 'example'); ?></div>
			<div for="<?php echo $this->get_field_id( 'atoken' ); ?>"><?php _e('Please use the following link to obtain an Access Token if you don&apos;t already have one: ', 'example'); ?><a class="access_token_link" href="mailto:api@foko.co">Get Access Token</a></div>
			<input id="<?php echo $this->get_field_id( 'atoken' ); ?>" name="<?php echo $this->get_field_name( 'atoken' ); ?>" value="<?php echo $instance['atoken']; ?>" style="width:100%;" />
		</p>

		<p>
			<div for="<?php echo $this->get_field_id( 'configure_display' ); ?>"><?php _e('Configure your display:', 'example'); ?></div> 
		</p>

		<!-- Number of Photos: Text Input -->
		<p>
			<div for="<?php echo $this->get_field_id( 'displayNum' ); ?>"><?php _e('How many photos do you want to display (maximum 40, default is 20):', 'example'); ?></div>
			<input id="<?php echo $this->get_field_id( 'displayNum' ); ?>" name="<?php echo $this->get_field_name( 'displayNum' ); ?>" value="<?php echo $instance['displayNum']; ?>" style="width:100%;" />
		</p>

		<p>
			<div style="font-weight:900;" for="<?php echo $this->get_field_id( 'default_display' ); ?>"><?php _e('This widget by default displays the most recent photos from across your company.', 'example'); ?></div> 
		</p>

		<p class="hashtag_input">
			<div for="<?php echo $this->get_field_id( 'hashtag_input' ); ?>"><?php _e('If you do not want to show a standard company feed, you can enter a hashtag (e.g #hashtag) to instead show a feed of that tag:', 'example'); ?></div>
			<input id="<?php echo $this->get_field_id( 'hashtag_input' ); ?>" name="<?php echo $this->get_field_name( 'hashtag_input' ); ?>" value="<?php echo $instance['hashtag_input']; ?>" style="width:100%;" />
		</p>

		<p class="user_input">
			<div for="<?php echo $this->get_field_id( 'user_input' ); ?>"><?php _e('If you do not want to show a standard company feed, you can enter the email address of a certain user to instead show a feed from that user:', 'example'); ?></div>
			<input id="<?php echo $this->get_field_id( 'user_input' ); ?>" name="<?php echo $this->get_field_name( 'user_input' ); ?>" value="<?php echo $instance['user_input']; ?>" style="width:100%;" />
		</p>

	<?php

	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['description'] = trim(strip_tags($new_instance['description']));
		$instance['displayNum'] = trim(strip_tags($new_instance['displayNum']));
		$instance['atoken'] = trim(strip_tags($new_instance['atoken']));
		$instance['hashtag_input'] = trim(strip_tags($new_instance['hashtag_input']));
		$instance['user_input'] = trim(strip_tags($new_instance['user_input']));
		return $instance;
	}

	function get_indices($haystack, $needle){
		$returns = array();
		$position = 0;
		while(strpos($haystack, $needle, $position) > -1){
			$index = strpos($haystack, $needle, $position);
			$returns[] = $index;
			$position = $index + strlen($needle);
		}
		return $returns;
	}


	function scrape_foko($atoken, $displayNum, $email, $hashtag) {
		$encodedEmail = urlencode($email);
		$encodedHashtag = urlencode($hashtag);
		$baseURL = 'https://cloud.foko.co/api/v1/';
		if ($email != NULL && $hashtag == NUll){
			$photoData = wp_remote_get($baseURL.'photofeeds?access_token='.$atoken.'&email='.$encodedEmail.'&limit='.intval($displayNum).'&descending=updatedAt', array( 'timeout' => 120));
		}
		else if ($email == NULL && $hashtag != NULL){
			$photoData = wp_remote_get($baseURL.'photofeeds?access_token='.$atoken.'&hashtags='.$encodedHashtag.'&limit='.intval($displayNum).'&descending=updatedAt', array( 'timeout' => 120));
		}
		else if ($email != NULL && $hashtag != NULL){
			$photoData = wp_remote_get($baseURL.'photofeeds?access_token='.$atoken.'&email='.$encodedEmail.'&hashtags='.$encodedHashtag.'&limit='.intval($displayNum).'&descending=updatedAt', array( 'timeout' => 120));
		}
		else{
			$photoData = wp_remote_get($baseURL.'photofeeds?access_token='.$atoken.'&limit='.intval($displayNum).'&descending=updatedAt', array( 'timeout' => 120));
		}

		$photoJSON = json_decode($photoData['body'], true);
		

		$mediumImgURL = array();
		$largeImgURL = array();
		$numLikes = array();
		$description = array();
		$fullDescription = array();
		$leftIndex = array();
		$rightIndex = array();
		$correctedDescription = "";

		if ($photoJSON == null){
			$data = NULL;
		}else{
			for ($i=0; $i<count($photoJSON); $i++){
				array_push($mediumImgURL, $photoJSON[$i]["mediumImage"].'&access_token='.$atoken);
				array_push($largeImgURL, $photoJSON[$i]["largeImage"].'&access_token='.$atoken);
				array_push($numLikes, $photoJSON[$i]['likeCount']);
				if (strpos(htmlspecialchars($photoJSON[$i]['description']), htmlspecialchars("<span")) > -1){
					$leftIndex = $this->get_indices(htmlspecialchars($photoJSON[$i]['description']), htmlspecialchars("<"));
					$rightIndex = $this->get_indices(htmlspecialchars($photoJSON[$i]['description']), htmlspecialchars(">"));
					for ($j = count($leftIndex) - 1; $j > 0; ){
						$correctedDescription = substr_replace(htmlspecialchars($photoJSON[$i]['description']), '', $leftIndex[$j], ($rightIndex[$j] - $leftIndex[$j] + strlen(htmlspecialchars(">"))));
						$correctedDescription = substr_replace($correctedDescription, htmlspecialchars("@"), $leftIndex[$j-1], ($rightIndex[$j-1] - $leftIndex[$j-1] + strlen(htmlspecialchars(">"))));
						$j = $j-2;
					}
				}else{
					$correctedDescription = $photoJSON[$i]['description'];
				}

				if (strlen($correctedDescription)>17){
					array_push($description, substr($correctedDescription, 0, 14)." ...");
				}else{
					array_push($description, $correctedDescription);
				}
	
				array_push($fullDescription, $correctedDescription);	
			}
			$data = array($mediumImgURL, $largeImgURL, $numLikes, $description, $fullDescription, count($photoJSON));
		}
		return $data;

	}
}
?>