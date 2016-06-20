<?php
/*
Plugin Name: Photospace
Plugin URI: http://thriveweb.com.au/the-lab/wordpress-gallery-plugin-photospace-2/
Description: A image gallery plugin for WordPress built using Galleriffic.
<a href="http://www.twospy.com/galleriffic/>galleriffic</a>
Author: Dean Oakley
Author URI: http://deanoakley.com/
Version: 2.3.5
*/

/*  Copyright 2010  Dean Oakley  (email : contact@deanoakley.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) {
	die('Illegal Entry');
}

//============================== Photospace options ========================//
class photospace_plugin_options {

	public static function PS_getOptions() {
		$options = get_option('ps_options');

		if (!is_array($options)) {

			$options['enable_history'] = false;

			$options['show_captions'] = false;
			$options['show_play'] = false;
			$options['show_next_prev'] = false;
			$options['auto_play'] = false;
			$options['delay'] = 3500;
			$options['transition_speed'] = 300;

			$options['thumbnail_width'] = 50;
			$options['thumbnail_height'] = 50;
			$options['thumbnail_crop'] = true;

			$options['medium_width'] = 300;
			$options['medium_height'] = 300;
			$options['medium_crop'] = true;

			$options['main_col_width'] = '400';
			$options['main_col_height'] = '500';

			$options['num_thumb'] = '9';
			$options['thumb_col_width'] = '181';
			$options['thumbnail_margin'] = 10;

			$options['gallery_width'] = '600';
			$options['gallery_height'] = false;

			$options['play_text'] = 'Play Slideshow';
			$options['pause_text'] = 'Pause Slideshow';
			$options['previous_text'] = '&lsaquo; Previous Photo';
			$options['next_text'] = 'Next Photo &rsaquo;';

			update_option('ps_options', $options);
		}
		return $options;
	}

	public static function update() {
		if(isset($_POST['ps_save'])) {
			$options = photospace_plugin_options::PS_getOptions();

			if (isset($_POST['enable_history'])) {
				$options['enable_history'] = (bool)true;
			} else {
				$options['enable_history'] = (bool)false;
			}

			if (isset($_POST['show_captions'])) {
				$options['show_captions'] = (bool)true;
			} else {
				$options['show_captions'] = (bool)false;
			}
			if (isset($_POST['show_play'])) {
				$options['show_play'] = (bool)true;
			} else {
				$options['show_play'] = (bool)false;
			}
			if (isset($_POST['show_next_prev'])) {
				$options['show_next_prev'] = (bool)true;
			} else {
				$options['show_next_prev'] = (bool)false;
			}
			if (isset($_POST['auto_play'])) {
				$options['auto_play'] = (bool)true;
			} else {
				$options['auto_play'] = (bool)false;
			}
			$options['delay'] = stripslashes($_POST['delay']);
			$options['transition_speed'] = stripslashes($_POST['transition_speed']);

			$options['thumbnail_width'] = stripslashes($_POST['thumbnail_width']);
			$options['thumbnail_height'] = stripslashes($_POST['thumbnail_height']);
			if (isset($_POST['thumbnail_crop'])) {
				$options['thumbnail_crop'] = (bool)true;
			} else {
				$options['thumbnail_crop'] = (bool)false;
			}

			$options['medium_width'] = stripslashes($_POST['medium_width']);
			$options['medium_height'] = stripslashes($_POST['medium_height']);
			if (isset($_POST['medium_crop'])) {
				$options['medium_crop'] = (bool)true;
			} else {
				$options['medium_crop'] = (bool)false;
			}

			$options['main_col_width'] = stripslashes($_POST['main_col_width']);
			$options['main_col_height'] = stripslashes($_POST['main_col_height']);

			$options['num_thumb'] = stripslashes($_POST['num_thumb']);
			$options['thumb_col_width'] = stripslashes($_POST['thumb_col_width']);
			$options['thumbnail_margin'] =  stripslashes($_POST['thumbnail_margin']);

			$options['gallery_width'] = stripslashes($_POST['gallery_width']);
			if (isset($_POST['gallery_height'])) {
				$options['gallery_height'] = (bool)true;
			} else {
				$options['gallery_height'] = (bool)false;
			}

			$options['play_text'] = stripslashes($_POST['play_text']);
			$options['pause_text'] = stripslashes($_POST['pause_text']);
			$options['previous_text'] = stripslashes($_POST['previous_text']);
			$options['next_text'] = stripslashes($_POST['next_text']);

			update_option('ps_options', $options);

		} else {
			photospace_plugin_options::PS_getOptions();
		}

		add_submenu_page( 'options-general.php', 'Gallery Settings', 'Gallery', 'edit_theme_options', basename(__FILE__), array('photospace_plugin_options', 'display'));
	}

	public static function display() {

		$options = photospace_plugin_options::PS_getOptions();
		?>

		<div id="photospace_admin" class="wrap">

			<h2>Gallery Settings</h2>

			<form method="post" action="#" enctype="multipart/form-data">

				<table class="form-table">
					<tbody>
						<tr>
							<th>Formatting</th>
							<td>
								<fieldset>
									<legend class="screen-reader-text">
										<span>Formatting</span>
									</legend>
									<label for="enable_history">
										<input name="enable_history" id="enable_history" type="checkbox" value="checkbox" <?php if($options['enable_history']) echo "checked='checked'"; ?> /> Enable history
									</label>
									<br>
									<label for="show_captions">
										<input name="show_captions" id="show_captions" type="checkbox" value="checkbox" <?php if($options['show_captions']) echo "checked='checked'"; ?> /> Show title / caption / description
									</label>
									<br>
									<label for="show_play">
										<input name="show_play" id="show_play" type="checkbox" value="checkbox" <?php if($options['show_play']) echo "checked='checked'"; ?> /> Show play / pause control
									</label>
									<br>
									<label for="show_next_prev">
										<input name="show_next_prev" id="show_next_prev" type="checkbox" value="checkbox" <?php if($options['show_next_prev']) echo "checked='checked'"; ?> /> Show next / previous controls
									</label>
									<br>
									<label for="auto_play">
										<input name="auto_play" id="auto_play" type="checkbox" value="checkbox" <?php if($options['auto_play']) echo "checked='checked'"; ?> /> Auto play slide show
									</label>
								</fieldset>
							</td>
						</tr>
						<tr>
							<th>
								<label for="delay">Slide delay (in ms)</label>
							</th>
							<td>
								<input name="delay" id="delay" type="number" value="<?php echo($options['delay']); ?>" />
							</td>
						</tr>
						<tr>
							<th>
								<label for="transition_speed">Transition Speed (in ms)</label>
							</th>
							<td>
								<input name="transition_speed" id="transition_speed" type="number" value="<?php echo($options['transition_speed']); ?>" />
							</td>
						</tr>
					</tbody>
				</table>

				<h3 class="title">Image sizes</h3>

				<p>Images that are already on the server will not change size until you regenerate the thumbnails. Use <a title="http://wordpress.org/extend/plugins/ajax-thumbnail-rebuild/" href="http://wordpress.org/extend/plugins/ajax-thumbnail-rebuild/">AJAX thumbnail rebuild</a> or <a title="http://wordpress.org/extend/plugins/regenerate-thumbnails/" href="http://wordpress.org/extend/plugins/regenerate-thumbnails/">Regenerate Thumbnails</a></p>

				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row">Thumbnail size</th>
							<td>
								<label for="thumbnail_width">Width</label>
								<input name="thumbnail_width" id="thumbnail_width" type="number" value="<?php echo($options['thumbnail_width']); ?>" class="small-text" />
								<label for="thumbnail_height">Height</label>
								<input name="thumbnail_height" id="thumbnail_height" type="number" value="<?php echo($options['thumbnail_height']); ?>" class="small-text" />
								<br>
								<input name="thumbnail_crop" id="thumbnail_crop" type="checkbox" value="checkbox" <?php if($options['thumbnail_crop']) echo "checked='checked'"; ?> />
								<label for="thumbnail_crop">Crop thumbnail to exact dimensions (normally thumbnails are proportional)</label>
							</td>
						</tr>
						<tr>
							<th scope="row">Medium size</th>
							<td>
								<label for="medium_width">Width</label>
								<input name="medium_width" id="medium_width" type="number" value="<?php echo($options['medium_width']); ?>" class="small-text" />
								<label for="medium_height">Height</label>
								<input name="medium_height" id="medium_height" type="number" value="<?php echo($options['medium_height']); ?>" class="small-text" />
								<br>
								<input name="medium_crop" id="medium_crop" type="checkbox" value="checkbox" <?php if($options['medium_crop']) echo "checked='checked'"; ?> />
								<label for="medium_crop">Crop medium images to exact dimensions (normally medium images are proportional)</label>
							</td>
						</tr>
						<tr>
							<th scope="row">Large size</th>
							<td>
								<fieldset>
									<legend class="screen-reader-text">
										<span>Large size</span>
									</legend>
									<label for="main_col_width">Max Width</label>
									<input name="main_col_width" id="main_col_width" type="number" value="<?php echo($options['main_col_width']); ?>" class="small-text" />
									<label for="main_col_height">Max Height</label>
									<input name="main_col_height" id="main_col_height" type="number" value="<?php echo($options['main_col_height']); ?>" class="small-text" />
								</fieldset>
							</td>
						</tr>
					</tbody>
				</table>

				<h3 class="title">Thumbnails</h3>

				<table class="form-table">
					<tbody>
						<tr>
							<th>
								<label for="num_thumb">Number of thumbnails</label>
							</th>
							<td>
								<input name="num_thumb" id="num_thumb" type="number" value="<?php echo($options['num_thumb']); ?>" />
							</td>
						</tr>
						<tr>
							<th>
								<label for="thumb_col_width">Thumbnail column width</label>
							</th>
							<td>
								<input name="thumb_col_width" id="thumb_col_width" type="number" value="<?php echo($options['thumb_col_width']); ?>" />
							</td>
						</tr>
						<tr>
							<th>
								<label for="thumbnail_margin">Thumbnail margin</label>
							</th>
							<td>
								<input name="thumbnail_margin" id="thumbnail_margin" type="number" value="<?php echo($options['thumbnail_margin']); ?>" />
							</td>
						</tr>
					</tbody>
				</table>

				<h3 class="title">Gallery</h3>

				<table class="form-table">
					<tbody>
						<tr>
							<th>
								<label for="gallery_width">Gallery width</label>
							</th>
							<td>
								<input name="gallery_width" id="gallery_width" type="number" value="<?php echo($options['gallery_width']); ?>" />
								<br>
								<p>(at least Thumbnail column + Main image width)</p>
							</td>
						</tr>
						<tr>
							<th>Fill to height</th>
							<td>
								<fieldset>
									<legend class="screen-reader-text">
										<span>Fill to height</span>
									</legend>
									<label for="gallery_height">
										<input name="gallery_height" id="gallery_height" type="checkbox" value="checkbox" <?php if($options['gallery_height']) echo "checked='checked'"; ?> /> Allow the gallery images to fill browser height
									</label>
							</td>
						</tr>
					</tbody>
				</table>

				<h3 class="title">Slideshow controls</h3>

				<table class="form-table">
					<tbody>
						<tr>
							<th>
								<label for="play_text">Play text</label>
							</th>
							<td>
								<input name="play_text" id="play_text" type="text" value="<?php echo($options['play_text']); ?>" />
							</td>
						</tr>
						<tr>
							<th>
								<label for="pause_text">Pause text</label>
							</th>
							<td>
								<input name="pause_text" id="pause_text" type="text" value="<?php echo($options['pause_text']); ?>" />
							</td>
						</tr>
						<tr>
							<th>
								<label for="previous_text">Previous text</label>
							</th>
							<td>
								<input name="previous_text" id="previous_text" type="text" value="<?php echo($options['previous_text']); ?>" />
							</td>
						</tr>
						<tr>
							<th>
								<label for="next_text">Next text</label>
							</th>
							<td>
								<input name="next_text" id="next_text" type="text" value="<?php echo($options['next_text']); ?>" />
							</td>
						</tr>
					</tbody>
				</table>

				<p class="submit">
					<input type="submit" name="ps_save" id="submit" class="button-primary" value="Save Changes" />
				</p>

			</form>

		</div>

		<?php
	}
}

function PS_getOption($option) {
  global $mytheme;
  return $mytheme->option[$option];
}

// register functions
add_action('admin_menu', array('photospace_plugin_options', 'update'));

$options = get_option('ps_options');

add_theme_support( 'post-thumbnails' );
add_image_size('photospace_thumbnails', $options['thumbnail_width'], $options['thumbnail_height'], $options['thumbnail_crop']);
add_image_size('photospace_medium', $options['medium_width'], $options['medium_height'], $options['medium_crop']);
add_image_size('photospace_full', $options['main_col_width'], $options['main_col_height']);

//============================== insert HTML header tag ========================//

function photospace_scripts_method() {
	wp_enqueue_script('jquery');
	$photospace_wp_plugin_path = site_url()."/wp-content/plugins/galleriffic-wordpress";
	wp_enqueue_script( 'galleriffic', 		$photospace_wp_plugin_path . '/jquery.galleriffic.js');
}
add_action('wp_enqueue_scripts', 'photospace_scripts_method');

function photospace_scripts_method_history() {
	$photospace_wp_plugin_path = site_url()."/wp-content/plugins/galleriffic-wordpress";
	wp_enqueue_script( 'history', 		$photospace_wp_plugin_path . '/jquery.history.js');
}
if ($options['enable_history']) {
	add_action('wp_enqueue_scripts', 'photospace_scripts_method_history');
}

function photospace_wp_headers() {

	$options = get_option('ps_options');

	echo '<style type="text/css">';

	if(!empty($options['thumbnail_width']))
		echo '
				.photospace .thumbnail-container li {
					width:'. $options['thumbnail_width'] .'px;
				}
		';

	if(!empty($options['thumbnail_height']) && !$options['gallery_height'])
		echo '
				.photospace .thumbnail-container li {
					height:'. $options['thumbnail_height'] .'px;
				}
		';

	if(!empty($options['medium_width']))
		echo '
				.photospace .medium-container li {
					width:'. $options['medium_width'] .'px;
				}
		';

	if(!empty($options['medium_height']))
		echo '
				.photospace .medium-container li {
					height:'. $options['medium_height'] .'px;
				}
		';

	if(!empty($options['main_col_width']))
		echo '
				.photospace .slideshow-container,
				.photospace .slideshow a.advance-link {
					width:'. $options['main_col_width'] .'px;
				}
		';

	if(!empty($options['main_col_height']) && !$options['gallery_height'])
		echo '
			@media only screen and (max-width: 1199px) and (min-width: 992px), only screen and (min-width: 1200px) {
				.photospace .slideshow a.advance-link,
				.photospace .slideshow .image-wrapper img {
					max-height:'. $options['main_col_height'] .'px !important;
					max-width: 100% !important;
				}
				.photospace .slideshow-container {
					height:'. $options['main_col_height'] .'px !important;
				}
			}
		';

	if(!empty($options['thumb_col_width']))
		echo '
				.photospace .thumbnail-container {
					max-width:'. $options['thumb_col_width'] .'px !important;
				}
		';

	if(!empty($options['thumbnail_margin']))
		echo '
				.photospace .thumbnail-container li a {
					margin-bottom:'. $options['thumbnail_margin'] .'px !important;
					margin-right:'. $options['thumbnail_margin'] .'px !important;
				}
		';

	if(!empty($options['gallery_width']))
		echo '
				.photospace .slideshow-container {
					max-width:'. $options['gallery_width'] .'px;
				}
		';

	echo '</style>';

	echo "<!--	photospace [ END ] --> \n";
}
add_action( 'wp_head', 'photospace_wp_headers', 10 );

add_shortcode( 'gallery', 'photospace_shortcode' );
add_shortcode( 'photospace', 'photospace_shortcode' );

function photospace_shortcode( $atts ) {

	global $post;
	global $photospace_count;

	$options = get_option('ps_options');

	if ( ! empty( $atts['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $atts['orderby'] ) )
			$atts['orderby'] = 'post__in';
		$atts['include'] = $atts['ids'];
	}

	extract(shortcode_atts(array(
		'id'								=> intval($post->ID),
		'show_captions'			=> $options['show_captions'],
		'show_play'					=> $options['show_play'],
		'show_next_prev'		=> $options['show_next_prev'],
		'auto_play'					=> $options['auto_play'],
		'delay'							=> $options['delay'],
		'transition_speed'	=> $options['transition_speed'],
		'num_thumb'					=> $options['num_thumb'],
		'num_preload'				=> $options['num_thumb'],
		'gallery_height'		=> $options['gallery_height'],
		'horizontal_thumb'	=> 0,
		'order'							=> 'ASC',
		'orderby'						=> 'menu_order ID',
		'include'						=> '',
		'exclude'						=> '',
		'sync_transitions'	=> 1

	), $atts));

	$photospace_count += 1;
	$post_id = intval($post->ID) . '_' . $photospace_count;

	if ( 'RAND' == $order )
		$orderby = 'none';

	$thumb_style_init = "display: none; opacity: 0; cursor: default;";
	$thumb_style_on  = "{'opacity': '1', 'display': 'inline-block', 'cursor': 'pointer'}";
	$thumb_style_off  = "{'opacity': '0.3', 'display': 'inline-block', 'cursor': 'default'}";

	$photospace_wp_plugin_path = site_url()."/wp-content/plugins/photospace";

	$output_buffer ='

		<div id="gallery_'.$post_id.'" class="photospace">

			<div id="thumbs_'.$post_id.'" class="thumbnail-container" >
				';

				if($horizontal_thumb){
						$output_buffer .='<a class="pageLink prev" style="'. $thumb_style_init . '" href="#" title="Previous Page"></a>';
				}

				$output_buffer .='
				<ul class="thumbs noscript" id="thumbs-shuffle">
				';

				if ( !empty($include) ) {
					$include = preg_replace( '/[^0-9,]+/', '', $include );
					$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

					$attachments = array();
					foreach ( $_attachments as $key => $val ) {
						$attachments[$val->ID] = $_attachments[$key];
					}
				} elseif ( !empty($exclude) ) {
					$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
					$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
				} else {
					$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
				}

				if ( !empty($attachments) ) {
					foreach ( $attachments as $aid => $attachment ) {

						$img = wp_get_attachment_image_src( $aid , 'photospace_full');
						$thumb = wp_get_attachment_image_src( $aid , 'photospace_thumbnails');
						$medium = wp_get_attachment_image_src( $aid , 'photospace_medium');
						$full = wp_get_attachment_image_src( $aid , 'full');
						$_post = get_post($aid);

						$image_title = esc_attr($_post->post_title);
						$image_alttext = get_post_meta($aid, '_wp_attachment_image_alt', true);
						$image_caption = $_post->post_excerpt;
						$image_description = $_post->post_content;

						// print "<pre>";
						// print_r($image_title);
						// print "</pre>";

						$image_slug = preg_replace('/[^A-Za-z0-9 ]/', '', $image_alttext);
						$image_slug = strtolower(str_replace(' ', '-', $image_slug));

						$output_buffer .='
							<li class="thumb-item">
								<a class="thumb-bg thumb" href="' . $img[0] . '" name="' . $image_slug . '" title="' . $image_title . '" >
									<img src="' . $thumb[0] . '" class="thumb-img" data-bg-mobile="' . $medium[0] . '" data-bg-desktop="' . $thumb[0] . '" alt="' . $image_alttext . '" title="' . $image_title . '" data-caption="' .  $image_caption . '" data-desc="' .  $image_description . '" />';
									if($image_caption != ''){
										$output_buffer .='
											<span class="thumb-caption">' .  $image_caption . '</span>
										';
									}
								$output_buffer .='
								</a>
								';

								$output_buffer .='
								<div class="caption">
									';
									if($show_captions){

										if($image_caption != ''){
											$output_buffer .='
												<div class="image-caption">' .  $image_caption . '</div>
											';
										}

										if($image_description != ''){
											$output_buffer .='
											<div class="image-desc">' .  $image_description . '</div>
											';
										}
									}

								$output_buffer .='
									<div id="view" class="view"><a href="javascript:void(0);">View All</a></div>
								</div>
								';

							$output_buffer .='
							</li>
						';
						}
					}

				$output_buffer .='
				</ul>
			</div>

			<div id="loading_'.$post_id.'" class="loader">
				<div class="loader-inner ball-scale">
					<div></div>
				</div>
			</div>
			<div id="slides_'.$post_id.'" class="slideshow-container">
				<div id="slideshow_'.$post_id.'" class="slideshow"></div>
				<div id="controls_'.$post_id.'" class="controls"></div>
				<div id="caption_'.$post_id.'" class="caption-container"></div>
			</div>
		</div>';

	$output_buffer .= "

		<script type='text/javascript'>

			jQuery(document).ready(function($) {

				var windowHeight = $(window).height() - 135;
				var breakpoint = 768;
				var altbreakpoint = 991;

				$.fn.showSlides = function() {
					var gallery = $('.slideshow-container')
					var thumbs = $('.thumbnail-container')

					thumbs.fadeOut()
					setTimeout(function() {
						gallery.fadeIn()

						if (typeof jQuery.fn.resizeImage === 'function') {
							$('.slideshow-container').resizeImage();
						}
					}, 500);
				}

				$.fn.showThumbs = function () {
					var gallery = $('.slideshow-container')
					var thumbs = $('.thumbnail-container')

					gallery.fadeOut()
					setTimeout(function() {
						thumbs.fadeIn()
					}, 500);
				}

				$('.slideshow-container').hide();
				$('.thumbnail-container').hide();
				$('.controls').hide();
				$('.photospace').css({'height': windowHeight});
				$('.loader').show();

				$(document).on('click', '.view a', function(e) {
					e.preventDefault()
					$(e).showThumbs()
				});

				$(document).on('click', '.thumb', function(e) {
					e.preventDefault()
					$(e).showSlides()

					$(this).parent().addClass('selected').siblings().removeClass('selected')

					if ($(window).innerWidth() <= breakpoint) {
						e.preventDefault()
						e.stopPropagation()
					}
				});

				// We only want these styles applied when javascript is enabled
				$('.slideshow-container').css('display', 'block');

				// Initialize Advanced Galleriffic Gallery
				var gallery = $('#thumbs_".$post_id."').galleriffic({
					delay:											" . intval($delay) . ",
					numThumbs:									" . intval($num_thumb) . ",
					preloadAhead:								'-1',
					enableTopPager:							false,
					enableBottomPager:					false,
					imageContainerSel:					'#slideshow_".$post_id."',
					controlsContainerSel:				'#controls_".$post_id."',
					captionContainerSel:				'#caption_".$post_id."',
					loadingContainerSel:				'#loading_".$post_id."',
					renderSSControls:						" . intval($show_play) . ",
					renderNavControls:					" . intval($show_next_prev) . ",
					playLinkText:								'". $options['play_text'] ."',
					pauseLinkText:							'". $options['pause_text'] ."',
					prevLinkText:								'". $options['previous_text'] ."',
					nextLinkText:								'". $options['next_text'] ."',
					enableHistory:							" . intval($options['enable_history']) . ",
					autoStart:									" . intval($auto_play) . ",
					enableKeyboardNavigation:		true,
					syncTransitions:						false,
					defaultTransitionDuration:	" . intval($transition_speed) . ",

					onTransitionOut:						function(slide, caption, isSync, callback) {
						slide.fadeTo(this.getDefaultTransitionDuration(isSync), 0.0, callback);
						caption.fadeTo(this.getDefaultTransitionDuration(isSync), 0.0);
					},
					onTransitionIn:							function(slide, caption, isSync) {
						var duration = this.getDefaultTransitionDuration(isSync);
						slide.fadeTo(duration, 1.0);
						$('.controls').fadeTo(duration, 1.0);

						// Position the caption at the bottom of the image and set its opacity
						var slideImage = slide.find('img');
						caption.fadeTo(duration, 1.0);

						if (typeof jQuery.fn.resizeImage === 'function') {
							$('.slideshow-container').resizeImage();
						}

					},
					onPageTransitionOut:				function(callback) {
						this.hide();
						// setTimeout(callback, 100); // wait a bit
					},
					onPageTransitionIn:					function() {
						this.fadeTo('fast', 1.0);
					}

				});";

				if($gallery_height){
					$output_buffer .= "
						jQuery.fn.resizeImage = function () {
							var containerWidth = $('#main').width();
							if ($('.slideshow-container img').height() !== 0 && $('.slideshow-container img').width() !== 0 && $('.slideshow-container img').height() !== 'undefined' && $('.slideshow-container img').width() !== 'undefined') {
								var currentHeight = $('.slideshow-container img').height();
								var currentWidth = $('.slideshow-container img').width();
							}

							var ratio = Math.min(containerWidth / currentWidth, windowHeight / currentHeight);
							var width = Math.round(ratio * currentWidth);
							var height = Math.round(ratio * currentHeight);

							$('.slideshow-container, .loader, .aside').css({'height': windowHeight});
							$('.thumbnail-container').css({'max-height': windowHeight});
							$('.slideshow').css({'height': windowHeight, 'max-width': containerWidth});
							$('.thumbs').css({'height': windowHeight, 'max-width': containerWidth});

							if (currentWidth < currentHeight) {
								$('.slideshow-container img').css({'height': '100%'})
							} else if (currentHeight < currentWidth) {
								$('.slideshow-container img').css({'width': width})
							}

						}

						$(window).on('resize orientationchange', function() {
							windowHeight = $(window).height() - 135;

							$('.slideshow-container').resizeImage();
						});
					";
				}

				if ($options['enable_history']) {
					$output_buffer .= "

						function pageload(hash) {
							if(hash) {
								$.galleriffic.gotoImage(hash);
							} else {
								gallery.gotoIndex(0);
							}
						}

						$.historyInit(pageload, 'advanced.html');

						$('a[rel=history]').live('click', function(e) {
							if (e.button != 0) return true;

							var hash = this.href;
							hash = hash.replace(/^.*#/, '');

							$.historyLoad(hash);

							return false;
						});
					";
				}

			$output_buffer .= "

			});

		</script>

		";

		return $output_buffer;
}