<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly
$languages = $this -> language_getlanguages();

?>

<div class="wrap <?php echo $this -> pre; ?> slideshow-gallery">
	<h1><?php _e('Save a Gallery', $this -> plugin_name); ?></h1>
	
	<form action="<?php echo $this -> url; ?>&amp;method=save" method="post">
		
		<?php wp_nonce_field('slideshow-galleries-save_' . $this -> Gallery() -> data -> id); ?>
		
		<input type="hidden" name="Gallery[id]" value="<?php echo $this -> Gallery() -> data -> id; ?>" />
	
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="Gallery_title"><?php _e('Title', $this -> plugin_name); ?></label>
					<?php echo $this -> Html -> help(__('Give this gallery a title/name for your own reference.', $this -> plugin_name)); ?></th>
					<td>
						<?php if ($this -> language_do()) : ?>
							<?php $titles = $this -> language_split($this -> Gallery() -> data -> title); ?>
							<div id="gallery-title-tabs">
								<ul>
									<?php foreach ($languages as $language) : ?>
										<li><a href="#gallery-title-tabs-<?php echo $language; ?>"><?php echo $this -> language_flag($language); ?></a></li>
									<?php endforeach; ?>
								</ul>
								<?php foreach ($languages as $language) : ?>
									<div id="gallery-title-tabs-<?php echo $language; ?>">
										<input type="text" class="widefat" name="Gallery[title][<?php echo $language; ?>]" value="<?php echo esc_attr(stripslashes($titles[$language])); ?>" id="Gallery_title_<?php echo $language; ?>" />
									</div>
								<?php endforeach; ?>
							</div>
							
							<script type="text/javascript">
							jQuery(document).ready(function() {
								jQuery('#gallery-title-tabs').tabs();
							});
							</script>
						<?php else : ?>
							<input type="text" class="widefat" name="Gallery[title]" value="<?php echo esc_attr(stripslashes($this -> Gallery() -> data -> title)); ?>" id="Gallery_title" />
						<?php endif; ?>
						<span class="howto"><?php _e('Title of this gallery for identification purposes.', $this -> plugin_name); ?></span>
						<?php echo (!empty($this -> Gallery() -> errors['title'])) ? '<span class="slideshow_error">' . $this -> Gallery() -> errors['title'] . '</span>' : ''; ?>
					</td>
				</tr>
			</tbody>
		</table>
	
		<p class="submit">
			<button type="submit" class="button-primary" value="1" name="submit">
				<i class="fa fa-check fa-fw"></i> <?php _e('Save Gallery', $this -> plugin_name); ?>
			</button>
			<div class="slideshow_continueediting">
				<label><input <?php echo (!empty($_REQUEST['continueediting'])) ? 'checked="checked"' : ''; ?> type="checkbox" name="continueediting" value="1" id="continueediting" /> <?php _e('Continue editing', $this -> plugin_name); ?></label>
			</div>
		</p>
	</form>
</div>