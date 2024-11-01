<?php
/*
Plugin Name: WP Grow Button
Plugin URI: http://wordpress.org/extend/plugins/wp-grow-button/
Description: Grow!" is the platform to support Publishers who create the contents what you like.You can support them financially, and share it with your friends.
Version: 1.0.6
Author: Grow.inc jun takeno.
Author URI: http://blog.growbutton.com/
*/
/*  Copyright 2011 Grow.inc jun takeno(email : jun@grw.sc)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    Apache2 License (http://www.apache.org/licenses/LICENSE-2.0) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('GROWBUTTON_BRAND_NAME' , 'Grow Button');

//define('WP_GROWBUTTON_DIRPATH', ABSPATH . 'wp-content/plugins' . strrchr(dirname(__FILE__),'/') . "/");
define('WP_GROWBUTTON_DIRPATH', WP_PLUGIN_DIR . '/wp-grow-button');


//propety name
define(WP_GROWBUTTON_OPTIONS_APIKEY , 'grouwbutton_apikey');
define(WP_GROWBUTTON_OPTIONS_BUTTON_TYPE , 'grouwbutton_type');
define(WP_GROWBUTTON_OPTIONS_POSITION , 'grouwbutton_position');

/********************************************:
 * 管理画面
 */
add_action('admin_menu', 'admin_growbutton_menu');
function admin_growbutton_menu() {
  add_options_page(GROWBUTTON_BRAND_NAME . 'Options', GROWBUTTON_BRAND_NAME , 8, 'growbuttonoptions', 'wp_growbutton_options');
}
function wp_growbutton_options() {
	require_once(WP_GROWBUTTON_DIRPATH. '/modules/admin.php');
}

/*********************************************:
 * コンテンツページ
 */
function wp_growbutton_wp_head(){
	$title     = wp_title( '|', true, 'right' );
	$type      = 'blog';
	$url       = get_bloginfo('home');
	$site_name = get_bloginfo('name');
	$image_url = "";
	
	$meta = '<meta property="og:title" content="' . $title .' />' .
			'<meta property="og:type" content="' . $type .' />' .
			'<meta property="og:url" content="' . $url .'" />' .
			'<meta property="og:image" content="' . $image_url .'" />' .
			'<meta property="og:site_name" content="' . $site_name .'" />';
			
	echo $meta;
}

/**
 * Growボタンの出力情報のみ
 */
function wp_growbutton_the_content_out($title = '' , $site_name = '' , $link = null, $title = null , $button_type = 'rectangle' , $image_url = ""){
	$out = '<div class="growbutton">' . 
		   '<span style="display: none;" itemscope itemref="' . $button_type . '" itemtype="http://growbutton.com/ns#button">'.
		   '<span itemprop="url">' . $link . '</span>'.
		   '<span itemprop="title">' . $title . '</span>'.
		   '<span itemprop="image">' . $image_url .'</span>' . 
		   '<span itemprop="site_name">'. $site_name . '</span>'.
		   '</div>';
		   
	return $out;
}

/**
 * add_filter the_content.
 */
function wp_growbutton_the_content( $content ){
	if( is_feed() || is_404() || is_robots() || is_comments_popup() || (function_exists( 'is_ktai' ) && is_ktai()) ){
       return $content;
    }
	
	$title       = get_the_title();
	$site_name   = get_bloginfo('name');
	
	$link        = get_permalink();
	$button_type = get_option(WP_GROWBUTTON_OPTIONS_BUTTON_TYPE);
	
	$image_url = '';
	
	$image_id = get_post_thumbnail_id();
    $image_url = wp_get_attachment_image_src($image_id,'thumbnail', true); 
	
	$out = wp_growbutton_the_content_out($title , $site_name , $link , $title , $button_type , $image_url[0]);
    
	$position = get_option(WP_GROWBUTTON_OPTIONS_POSITION);
    if($position == 'none' ){
        return $content;
    }elseif( $position == 'bottom' ){
        return "{$content}{$out}";
    }else{
    	//top
    	return "{$out}{$content}";
    }
	
    return $content;
}

/**
 * wp_footerが呼ばれる直前で呼ばれる
 */
function wp_growbutton_wp_footer(){
	$apikey      = get_option(WP_GROWBUTTON_OPTIONS_APIKEY);
	$button_type = get_option(WP_GROWBUTTON_OPTIONS_BUTTON_TYPE);
	
	if($apikey && !is_preview()){
		echo '<script type="text/javascript" src="http://growbutton.com/javascripts/button.js?apikey=' . $apikey . '&shape=' . $button_type .'&insert=false"></script>';
	}
}

/**
 * 初期化処理
 */
function wp_growbutton_init(){
	//add_action('wp_head', 'wp_growbutton_wp_head');
    add_action('wp_footer', 'wp_growbutton_wp_footer');
    add_filter('the_content', 'wp_growbutton_the_content');
}

require_once WP_GROWBUTTON_DIRPATH . '/modules/widget.php';
add_action( 'init', 'wp_growbutton_init' );
?>