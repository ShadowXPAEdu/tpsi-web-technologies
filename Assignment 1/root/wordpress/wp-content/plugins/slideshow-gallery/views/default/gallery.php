<?php 

$wrapperid = "slideshow-wrapper" . $unique;
if (!$products) $slides = stripslashes_deep($slides);
$thumbopacity = $this -> get_option('thumbopacity');

?>

<?php if (!empty($slides)) : ?>
	<ul id="slideshow<?php echo $unique; ?>" class="slideshow<?php echo $unique; ?>" style="display:none;">
		<?php if ($frompost) : ?>
			<!-- From a WordPress post/page -->
			<?php foreach ($slides as $slide) : ?>
				<?php setup_postdata($slide -> ID); ?>
				<li>
					<h3 style="opacity:70;"><?php echo __($slide -> post_title); ?></h3>
					<?php 
						
					$full_image_href = wp_get_attachment_image_src($slide -> ID, 'full', false);
					$full_image_url = wp_get_attachment_url($slide -> ID); 
					
					?>										
					<?php if ($options['layout'] != "responsive" && $options['resizeimages'] == "true" && $options['width'] != "auto") : ?>
						<span data-alt="<?php echo $this -> Html() -> sanitize(__($slide -> post_title)); ?>"><?php echo $this -> Html -> otf_image_src($slide, $options['width'], $options['height'], 100); ?></span>
					<?php else : ?>
						<span data-alt="<?php echo $this -> Html() -> sanitize(__($slide -> post_title)); ?>"><?php echo $full_image_href[0]; ?></span>
					<?php endif; ?>
					<p><?php echo __(get_the_excerpt()); ?></p>
					<?php $thumbnail_link = wp_get_attachment_image_src($slide -> ID, array($options['width'], $options['height']), false); ?>
					<a href="<?php echo $full_image_url; ?>" id="<?php echo $unique; ?>imglink<?php echo $slide -> ID; ?>" <?php if ($this -> Html -> is_image($full_image_url)) : ?>class="colorboxslideshow<?php echo $unique; ?>" data-rel="slideshowgroup<?php echo $unique; ?>"<?php endif; ?> title="<?php echo __($slide -> post_title); ?>">
						<?php if ($options['showthumbs'] == "true") : ?>
							<img src="<?php echo $this -> Html -> otf_image_src($slide, $this -> get_option('thumbwidth'), $this -> get_option('thumbheight'), 100); ?>" alt="<?php echo $this -> Html -> sanitize(__($slide -> post_title)); ?>" />
						<?php endif; ?>
					</a>
				</li>
				<?php wp_reset_postdata(); ?>
			<?php endforeach; ?>
		<?php elseif ($featured) : ?>
			<!-- Featured images from posts -->
			<?php foreach ($slides as $slide) : ?>
				<?php 
					
				setup_postdata($slide); 
				global $slideshow_post;
				$slideshow_post = $slide;
				
				?>
				<li>
					<h3 style="opacity:70;"><a target="_self" href="<?php echo get_permalink($slide -> ID); ?>"><?php echo stripslashes(__($slide -> post_title)); ?></a></h3>
					<?php $full_image_href = wp_get_attachment_image_src(get_post_thumbnail_id($slide -> ID), 'full', false); ?>
					<?php $full_image_url = wp_get_attachment_url(get_post_thumbnail_id($slide -> ID)); ?>										
					<?php if ($options['layout'] != "responsive" && $options['resizeimages'] == "true" && $options['width'] != "auto") : ?>
						<span data-alt="<?php echo $this -> Html() -> sanitize(__($slide -> post_title)); ?>"><?php echo $this -> Html -> otf_image_src($slide, $options['width'], $options['height'], 100); ?></span>
					<?php else : ?>
						<span data-alt="<?php echo $this -> Html() -> sanitize(__($slide -> post_title)); ?>"><?php echo $full_image_href[0]; ?></span>
					<?php endif; ?>
					<p><?php echo stripslashes(__(get_the_excerpt())); ?></p>
					<?php $thumbnail_link = wp_get_attachment_image_src(get_post_thumbnail_id($slide -> ID), 'thumbnail', false); ?>
					<?php if ($options['showthumbs'] == "true") : ?>
						<?php if (!empty($slide -> guid)) : ?>
							<a href="<?php echo $slide -> guid; ?>" target="_self" title="<?php echo esc_attr(__($slide -> post_title)); ?>"><img src="<?php echo $this -> Html -> otf_image_src($slide, $this -> get_option('thumbwidth'), $this -> get_option('thumbheight'), 100); ?>" alt="<?php echo $this -> Html -> sanitize(__($slide -> post_title)); ?>" /></a>
						<?php else : ?>
							<a id="<?php echo $unique; ?>imglink<?php echo $slide -> ID; ?>" <?php if ($this -> Html -> is_image($full_image_url)) : ?>class="colorboxslideshow<?php echo $unique; ?>" data-rel="slideshowgroup<?php echo $unique; ?>"<?php endif; ?>><img src="<?php echo $this -> Html -> otf_image_src($slide, $this -> get_option('thumbwidth'), $this -> get_option('thumbheight'), 100); ?>" alt="<?php echo $this -> Html -> sanitize(__($slide -> post_title)); ?>" /></a>
						<?php endif; ?>
					<?php else : ?>
						<a href="<?php echo $slide -> guid; ?>" target="_self" title="<?php echo __($slide -> post_title); ?>"></a>
					<?php endif; ?>
				</li>
				<?php wp_reset_postdata(); ?>
			<?php endforeach; ?>
		<?php elseif ($products) : ?>
			<!-- Shopping Cart plugin products http://tribulant.com/plugins/view/10/wordpress-shopping-cart-plugin -->
			<?php foreach ($slides as $slide) : ?>
				<li>
					<h3 style="opacity:70;"><?php echo stripslashes(__($slide -> title)); ?></h3>
					<?php if ($options['layout'] != "responsive" && $options['resizeimages'] == "true" && $options['width'] != "auto") : ?>
						<span data-alt="<?php echo $this -> Html() -> sanitize(__($slide -> title)); ?>"><?php echo $this -> Html -> otf_image_src($slide, $options['width'], $options['height'], 100); ?></span>
					<?php else : ?>
						<span data-alt="<?php echo $this -> Html() -> sanitize(__($slide -> title)); ?>"><?php echo site_url() . '/' . $slide -> image_url; ?></span>
					<?php endif; ?>
					<p><?php echo substr(stripslashes(__($slide -> description)), 0, 255); ?></p>
					<?php if ($options['showthumbs'] == "true") : ?>
						<?php if (!empty($slide -> post_id)) : ?>
							<a href="<?php echo get_permalink($slide -> post_id); ?>" target="_self" title="<?php echo esc_attr(__($slide -> title)); ?>"><img src="<?php echo $this -> Html -> otf_image_src($slide, $this -> get_option('thumbwidth'), $this -> get_option('thumbheight'), 100); ?>" /></a>
						<?php else : ?>
							<a><img src="<?php echo $this -> Html -> otf_image_src($slide, $this -> get_option('thumbwidth'), $this -> get_option('thumbheight'), 100); ?>" /></a>
						<?php endif; ?>
					<?php else : ?>
						<a href="<?php echo get_permalink($slide -> post_id); ?>" target="_self" title="<?php echo esc_attr(__($slide -> title)); ?>"></a>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		<?php else : ?>
			<!-- From all slides or gallery slides -->
			<?php foreach ($slides as $slide) : ?>				
				<li>
					<h3 style="opacity:<?php echo (!empty($slide -> iopacity)) ? ($slide -> iopacity) : 70; ?>;"><?php echo (!empty($slide -> showinfo) && ($slide -> showinfo == "both" || $slide -> showinfo == "title")) ? __($slide -> title) : ''; ?></h3>
					<?php if ($options['layout'] != "responsive" && $options['resizeimages'] == "true" && $options['width'] != "auto") : ?>
						<span data-alt="<?php echo $this -> Html() -> sanitize(__($slide -> title)); ?>"><?php echo $this -> Html -> otf_image_src($slide, $options['width'], $options['height'], 100); ?></span>
					<?php else : ?>
						<span data-alt="<?php echo $this -> Html() -> sanitize(__($slide -> title)); ?>"><?php echo $slide -> image_path; ?></span>
					<?php endif; ?>
					<p><?php echo (!empty($slide -> showinfo) && ($slide -> showinfo == "both" || $slide -> showinfo == "description")) ? __($slide -> description) : ''; ?></p>
					<?php if ($options['showthumbs'] == "true") : ?>
						<?php if ($slide -> uselink == "Y" && !empty($slide -> link)) : ?>
							<a href="<?php echo __($slide -> link); ?>" title="<?php echo esc_attr(__($slide -> title)); ?>" target="_<?php echo $slide -> linktarget; ?>"><img src="<?php echo $this -> Html -> otf_image_src($slide, $this -> get_option('thumbwidth'), $this -> get_option('thumbheight'), 100); ?>" alt="<?php echo $this -> Html -> sanitize(__($slide -> title)); ?>" /></a>
						<?php elseif ($options['imagesoverlay'] == "true") : ?>
							<a href="<?php echo $slide -> image_path; ?>" id="<?php echo $unique; ?>imglink<?php echo $slide -> id; ?>" <?php if ($this -> Html -> is_image($slide -> image_path)) : ?>class="colorboxslideshow<?php echo $unique; ?>" data-rel="slideshowgroup<?php echo $unique; ?>"<?php endif; ?> target="_<?php echo $slide -> linktarget; ?>" title="<?php echo __($slide -> title); ?>"><img src="<?php echo $this -> Html -> otf_image_src($slide, $this -> get_option('thumbwidth'), $this -> get_option('thumbheight'), 100); ?>" alt="<?php echo $this -> Html -> sanitize(__($slide -> title)); ?>" /></a>
						<?php else : ?>
							<a><img src="<?php echo $this -> Html -> otf_image_src($slide, $this -> get_option('thumbwidth'), $this -> get_option('thumbheight'), 100); ?>" alt="<?php echo $this -> Html -> sanitize(__($slide -> title)); ?>" /></a>
						<?php endif; ?>
					<?php else : ?>
						<?php if ($slide -> uselink == "Y" && !empty($slide -> link)) : ?>
							<a href="<?php echo __($slide -> link); ?>" target="_<?php echo $slide -> linktarget; ?>" title="<?php echo __($slide -> title); ?>"></a>
						<?php elseif ($options['imagesoverlay'] == "true") : ?>
							<a href="<?php echo $slide -> image_path; ?>" id="<?php echo $unique; ?>imglink<?php echo $slide -> id; ?>" <?php if ($this -> Html -> is_image($slide -> image_path)) : ?>class="colorboxslideshow<?php echo $unique; ?>" data-rel="slideshowgroup<?php echo $unique; ?>"<?php endif; ?> target="_<?php echo $slide -> linktarget; ?>" title="<?php echo __($slide -> title); ?>"></a>
						<?php else : ?>
							<a></a>
						<?php endif; ?>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>
	
	<div id="<?php echo $wrapperid; ?>" class="slideshow-wrapper">
		<?php if ($options['showthumbs'] == "true" && $options['thumbsposition'] == "top" && count($slides) > 1) : ?>
			<div id="thumbnails<?php echo $unique; ?>" class="slideshow-thumbnails thumbstop">
				<div class="slideshow-slideleft" id="slideleft<?php echo $unique; ?>" title="<?php _e('Slide Left', $this -> plugin_name); ?>"></div>
				<div class="slideshow-slidearea" id="slidearea<?php echo $unique; ?>">
					<div class="slideshow-slider" id="slider<?php echo $unique; ?>"></div>
				</div>
				<div class="slideshow-slideright" id="slideright<?php echo $unique; ?>" title="<?php _e('Slide Right', $this -> plugin_name); ?>"></div>
				<br style="clear:both; visibility:hidden; height:1px;" />
			</div>
		<?php endif; ?>
	
		<div class="slideshow-fullsize" id="fullsize<?php echo $unique; ?>">
			<?php $navb = false; $navf = false; ?>
			<?php if ($options['shownav'] == "true" && count($slides) > 1) : ?>
				<?php $navb = "imgprev"; ?>
				<div id="imgprev<?php echo $unique; ?>" class="slideshow-imgprev imgnav" title="<?php _e('Previous Image', $this -> plugin_name); ?>"><?php _e('Previous Image', $this -> plugin_name); ?></div>
			<?php endif; ?>
			<a id="imglink<?php echo $unique; ?>" class="slideshow-imglink imglink"><!-- link --></a>
			<?php if ($options['shownav'] == "true" && count($slides) > 1) : ?>
				<?php $navf = "imgnext"; ?>
				<div id="imgnext<?php echo $unique; ?>" class="slideshow-imgnext imgnav" title="<?php _e('Next Image', $this -> plugin_name); ?>"><?php _e('Next Image', $this -> plugin_name); ?></div>
			<?php endif; ?>
			<div id="image<?php echo $unique; ?>" class="slideshow-image"></div>
			<div class="slideshow-information info<?php echo $options['infoposition']; ?>" id="information<?php echo $unique; ?>">
				<h3 class="slideshow-info-heading">info heading</h3>
				<p class="slideshow-info-content">info content</p>
			</div>
		</div>
		
		<?php if ($options['showthumbs'] == "true" && $options['thumbsposition'] == "bottom" && count($slides) > 1) : ?>
			<div id="thumbnails<?php echo $unique; ?>" class="slideshow-thumbnails thumbsbot">
				<div class="slideshow-slideleft" id="slideleft<?php echo $unique; ?>" title="<?php _e('Slide Left', $this -> plugin_name); ?>"></div>
				<div class="slideshow-slidearea" id="slidearea<?php echo $unique; ?>">
					<div class="slideshow-slider" id="slider<?php echo $unique; ?>"></div>
				</div>
				<div class="slideshow-slideright" id="slideright<?php echo $unique; ?>" title="<?php _e('Slide Right', $this -> plugin_name); ?>"></div>
				<br style="clear:both; visibility:hidden; height:1px;" />
			</div>
		<?php endif; ?>
	</div>
	
	<?php ob_start(); ?>
	
	<script type="text/javascript">
	jQuery.noConflict();
	tid('slideshow<?php echo $unique; ?>').style.display = "none";
	tid('<?php echo $wrapperid; ?>').style.display = 'block';
	tid('<?php echo $wrapperid; ?>').style.visibility = 'hidden';
	jQuery("#fullsize<?php echo $unique; ?>").append('<div id="spinner<?php echo $unique; ?>"><i class="fa fa-cog fa-spin"></i></div>');
	tid('spinner<?php echo $unique; ?>').style.visibility = 'visible';

	var slideshow<?php echo $unique; ?> = new TINY.slideshow("slideshow<?php echo $unique; ?>");
	jQuery(document).ready(function() {
		<?php if (empty($options['auto']) || (!empty($options['auto']) && $options['auto'] == "true")) : ?>slideshow<?php echo $unique; ?>.auto = true;<?php else : ?>slideshow<?php echo $unique; ?>.auto = false;<?php endif; ?>
		slideshow<?php echo $unique; ?>.speed = <?php echo $options['autospeed']; ?>;
		slideshow<?php echo $unique; ?>.effect = "<?php echo $options['effect']; ?>";
		slideshow<?php echo $unique; ?>.slide_direction = "<?php echo $options['slide_direction']; ?>";
		slideshow<?php echo $unique; ?>.easing = "<?php echo $options['easing']; ?>";
		slideshow<?php echo $unique; ?>.alwaysauto = <?php echo $options['alwaysauto']; ?>;
		slideshow<?php echo $unique; ?>.autoheight = <?php echo $options['autoheight']; ?>;
		slideshow<?php echo $unique; ?>.autoheight_max = <?php echo (empty($options['autoheight_max'])) ? "false" : $options['autoheight_max']; ?>;
		slideshow<?php echo $unique; ?>.imgSpeed = <?php echo $options['fadespeed']; ?>;
		slideshow<?php echo $unique; ?>.navOpacity = <?php echo (empty($options['navopacity'])) ? 0 : $options['navopacity']; ?>;
		slideshow<?php echo $unique; ?>.navHover = <?php echo (empty($options['navhoveropacity'])) ? 0 : $options['navhoveropacity']; ?>;
		slideshow<?php echo $unique; ?>.letterbox = "#000000";
		slideshow<?php echo $unique; ?>.linkclass = "linkhover";
		slideshow<?php echo $unique; ?>.imagesid = "images<?php echo $unique; ?>";
		slideshow<?php echo $unique; ?>.info = "<?php echo ($options['showinfo'] == "true") ? 'information' . $unique : ''; ?>";
		slideshow<?php echo $unique; ?>.infoonhover = <?php echo (empty($options['infoonhover'])) ? 0 : $options['infoonhover']; ?>;
		slideshow<?php echo $unique; ?>.infoSpeed = <?php echo $options['infospeed']; ?>;
		slideshow<?php echo $unique; ?>.infodelay = <?php echo (empty($options['infodelay'])) ? 0 : $options['infodelay']; ?>;
		slideshow<?php echo $unique; ?>.infofade = <?php echo (empty($options['infofade'])) ? 0 : $options['infofade']; ?>;
		slideshow<?php echo $unique; ?>.infofadedelay = <?php echo (empty($options['infofadedelay'])) ? 0 : $options['infofadedelay']; ?>;
		slideshow<?php echo $unique; ?>.thumbs = "<?php echo ($options['showthumbs'] == "true" && count($slides) > 1) ? 'slider' . $unique : ''; ?>";
		slideshow<?php echo $unique; ?>.thumbOpacity = <?php echo (empty($thumbopacity)) ? 0 : $thumbopacity; ?>;
		slideshow<?php echo $unique; ?>.left = "slideleft<?php echo $unique; ?>";
		slideshow<?php echo $unique; ?>.right = "slideright<?php echo $unique; ?>";
		slideshow<?php echo $unique; ?>.scrollSpeed = <?php echo $options['thumbsspeed']; ?>;
		slideshow<?php echo $unique; ?>.spacing = <?php echo (empty($options['thumbsspacing'])) ? '0' : $options['thumbsspacing']; ?>;
		slideshow<?php echo $unique; ?>.active = "<?php echo $options['thumbsborder']; ?>";
		slideshow<?php echo $unique; ?>.imagesthickbox = "<?php echo $options['imagesoverlay']; ?>";
		jQuery("#spinner<?php echo $unique; ?>").remove();
		slideshow<?php echo $unique; ?>.init("slideshow<?php echo $unique; ?>","image<?php echo $unique; ?>","<?php echo (!empty($options['shownav']) && count($slides) > 1 && $options['shownav'] == "true") ? $navb . $unique : ''; ?>","<?php echo (!empty($options['shownav']) && count($slides) > 1 && $options['shownav'] == "true") ? $navf . $unique : ''; ?>","imglink<?php echo $unique; ?>");
		tid('<?php echo $wrapperid; ?>').style.visibility = 'visible';
		jQuery(window).trigger('resize');
		
		<?php if ($this -> ci_serial_valid()) : ?>
			slideshow<?php echo $unique; ?>.touch(tid('fullsize<?php echo $unique; ?>'));
			
			<?php if ($options['showthumbs'] == "true" && count($slides) > 1) : ?>
				var touchslidesurface = tid('slider<?php echo $unique; ?>');
				slideshow<?php echo $unique; ?>.touchslide(touchslidesurface);
			<?php endif; ?>
		<?php endif; ?>
	});
	
	<?php if ($options['layout'] == "responsive" && $options['resheighttype'] == "%") : ?>
		jQuery(window).resize(function() {
			var width = jQuery('#<?php echo $wrapperid; ?>').width();
			var resheight = <?php echo $options['resheight']; ?>;
			var height = Math.round(((resheight / 100) * width));
			jQuery('#fullsize<?php echo $unique; ?>').height(height);
		});
	<?php endif; ?>
	</script>
	
	<?php
	
	$cssattr['unique'] = $unique;
	$cssattr['wrapperid'] = $wrapperid;
	$cssattr['resizeimages'] = (($options['resizeimages'] == "true") ? "Y" : "N");
	$cssattr['width'] = $options['width'];
	$cssattr['height'] = $options['height'];
	$cssattr['autoheight'] = $options['autoheight'];
	$cssattr['thumbwidth'] = $this -> get_option('thumbwidth');
	$cssattr['thumbheight'] = $this -> get_option('thumbheight');	
	$cssattr['sliderwidth'] = ((($cssattr['thumbwidth'] + $options['thumbsspacing'] + 6) * count($slides)) + 60);
	$cssattr['infohideonmobile'] = $this -> get_option('infohideonmobile');
	$cssattr['thumbhideonmobile'] = $this -> get_option('thumbhideonmobile');
	
	$javascript = ob_get_clean(); 
	global $slideshow_javascript;
	$slideshow_javascript[] = $javascript;
	
	ob_start();
	
	?>
	
	<link rel="stylesheet" property="stylesheet" href="<?php echo $this -> get_css_url($cssattr, $options['layout']); ?>" type="text/css" media="all" />
	
	<!--[if IE 6]>
	<style type="text/css">
	.imglink, #imglink { display: none !important; }
	.linkhover { display: none !important; }
	</style>
	<![endif]-->
	
	<?php
		
	$css = ob_get_clean();

	global $slideshow_css;
	$slideshow_css[] = $css;
	
	$jsoutput = $this -> get_option('jsoutput');
	if (empty($jsoutput) || $jsoutput == "perslideshow") {
		echo '<!-- Slideshow Gallery Javascript BEG -->';
		echo stripslashes($javascript);
		echo '<!-- Slideshow Gallery Javascript END -->';
		
		echo '<!-- Slideshow Gallery CSS BEG -->';
		echo stripslashes($css);
		echo '<!-- Slideshow Gallery CSS END -->';
	}
	
	?>
<?php else : ?>
	<?php _e('No slides are available.', $this -> plugin_name); ?>
<?php endif; ?>