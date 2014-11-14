<?php
/*
Plugin Name: Foko Widget
Description: An awesome Foko widget
Version: 0.1
Author: Harry Luo
Author URI: http://codeforthepeople.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
$tmp="hello";

add_action('widgets_init', 'foko_widget');
add_action( 'wp_enqueue_scripts', 'add_stylesheet' );
add_action( 'wp_enqueue_scripts', 'add_javascript' );

function add_javascript(){
	wp_register_script( 'main_foko', plugins_url('main_foko.js', __FILE__) );
	if (!wp_script_is('jquery', 'enqueued')){
		wp_enqueue_script( 'jquery' );
	}
	wp_register_script( 'isotope', plugins_url('isotope.pkgd.min.js', __FILE__) );
	wp_register_script( 'imagesloaded', plugins_url('imagesloaded.pkgd.min.js', __FILE__) );
	wp_enqueue_script( 'isotope' );
	wp_enqueue_script( 'imagesloaded' );
}

function add_stylesheet(){
	wp_register_style( 'foko_style', plugins_url('foko_style.css', __FILE__) );
    wp_enqueue_style( 'foko_style' );
    if (!wp_style_is('font-awesome', 'enqueued')){
		wp_enqueue_style( 'font-awesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' );
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
			$this->debug_to_console($displayData);

			if ($displayData == null){
				echo 'No data was found according to your input information, please verify the provided information was correct';
			}else{
				echo '<div class="photo_wrapper" id="photo_wrapper">';

				for ($i = 0; $i < intval($displayData[5]); $i++){
					echo '<div class="foko_item">';
					echo '<div class="view third-effect">';			
					echo '<div class="mask"><span class="center_helper"></span>';
					echo '<span class="info"><a class="photo-link" href="#" alt="'.$i.'">';
					echo '<i class="fa fa-search fa-lg" id="foko-search-icon"></i></a></span></div>';
					echo '<img src="'.$displayData[0][$i].'"/>';
					echo '</div>';
					echo '<div class="photo_info">';
					echo '<p class="photo_description">';
					echo '<span class="caption">'.$displayData[3][$i].'</span></p>';
					echo '<div class="meta_info">';
					echo '<span class="likes" style="font-size: 11px">';
					echo '<i class="fa fa-heart" style="color:rgb(221, 148, 148)"></i>  '.$displayData[2][$i].'</span>';
					echo '</div></div></div>';
				}

				echo '</div>';
			}
		}else{
			echo 'Please provide your Access Token.';
		}

		echo $after_widget;
	}

	function debug_to_console($data) {
			echo("<script>console.log(".json_encode($data).");</script>");
	}

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
			<div for="<?php echo $this->get_field_id( 'display_method' ); ?>"><?php _e('This widget will display the 20 most recent photos from your company&apos;s photo feeds by default. You can choose to display photos from specific users or hashtags by entering the corresponding infromation in the text box below.', 'example'); ?></div> 
		</p>

		<!-- Number of Photos: Text Input -->
		<p>
			<div for="<?php echo $this->get_field_id( 'displayNum' ); ?>"><?php _e('How many photos do you want to display:', 'example'); ?></div>
			<input id="<?php echo $this->get_field_id( 'displayNum' ); ?>" name="<?php echo $this->get_field_name( 'displayNum' ); ?>" value="<?php echo $instance['displayNum']; ?>" style="width:100%;" />
		</p>

		<p class="hashtag_input">
			<div for="<?php echo $this->get_field_id( 'hashtag_input' ); ?>"><?php _e('Please enter the hashtag: e.g #hashtag', 'example'); ?></div>
			<input id="<?php echo $this->get_field_id( 'hashtag_input' ); ?>" name="<?php echo $this->get_field_name( 'hashtag_input' ); ?>" value="<?php echo $instance['hashtag_input']; ?>" style="width:100%;" />
		</p>

		<p class="user_input">
			<div for="<?php echo $this->get_field_id( 'user_input' ); ?>"><?php _e('Please enter the company email of user:', 'example'); ?></div>
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

	function scrape_foko($atoken, $displayNum, $email, $hashtag) {
		if ($email != NULL && $hashtag == NUll){
			$encodedEmail = urlencode($email);
			$photoData = wp_remote_get('https://harry-dev.parseapp.com/api/v1/photofeeds?access_token='.$atoken.'&email='.$encodedEmail.'&limit='.intval($displayNum).'&descending=updatedAt');
		}
		else if ($email == NULL && $hashtag != NULL){
			$encodedHashtag = urlencode($hashtag);
			$photoData = wp_remote_get('https://harry-dev.parseapp.com/api/v1/photofeeds?access_token='.$atoken.'&hashtags='.$encodedHashtag.'&limit='.intval($displayNum).'&descending=updatedAt');
		}
		else if ($email != NULL && $hashtag != NULL){
			$encodedEmail = urlencode($email);
			$encodedHashtag = urlencode($hashtag);
			$photoData = wp_remote_get('https://harry-dev.parseapp.com/api/v1/photofeeds?access_token='.$atoken.'&email='.$encodedEmail.'&hashtags='.$encodedHashtag.'&limit='.intval($displayNum).'&descending=updatedAt');
		}
		else{
			$photoData = wp_remote_get('https://harry-dev.parseapp.com/api/v1/photofeeds?access_token='.$atoken.'&limit='.intval($displayNum).'&descending=updatedAt');
		}

		$photoJSON = json_decode($photoData['body'], true);
		
		$this->debug_to_console($photoJSON);

		$smallImgURL = array();
		$largeImgURL = array();
		$numLikes = array();
		$description = array();
		$fullDescription = array();

		if ($photoJSON == null){
			$data = NULL;
		}else{
			for ($i=0; $i<count($photoJSON); $i++){
				array_push($smallImgURL, $photoJSON[$i]["smallImage"].'&access_token='.$atoken);
				array_push($largeImgURL, $photoJSON[$i]["largeImage"].'&access_token='.$atoken);
				array_push($numLikes, $photoJSON[$i]['likeCount']);
				if ($photoJSON[$i]['description']){
					if (strlen($photoJSON[$i]['description'])>17){
						array_push($description, substr($photoJSON[$i]['description'], 0, 14)." ...");
					}else{
						array_push($description, $photoJSON[$i]['description']);
					}
				}else{
					array_push($description, "no comments...");
				}

				array_push($fullDescription, $photoJSON[$i]['description']);	
			}
			$data = array($smallImgURL, $largeImgURL, $numLikes, $description, $fullDescription, count($photoJSON));
		}
		return $data;

	}
}
?>