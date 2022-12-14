<!-- Save a Slide -->

<?php
	
if (!defined('ABSPATH')) exit; // Exit if accessed directly

$showinfo = $this -> Slide() -> data -> showinfo;

if ($this -> language_do()) {
	$languages = $this -> language_getlanguages();
}

?>

<div class="wrap <?php echo $this -> pre; ?> slideshow-gallery slideshow">
	<h1><?php _e('Save a Slide', $this -> plugin_name); ?></h1>
	
	<form action="<?php echo $this -> url; ?>&amp;method=save" method="post" enctype="multipart/form-data">
		
		<?php wp_nonce_field('slideshow-slides-save_' . $this -> Slide() -> data -> id); ?>
		
		<input type="hidden" name="Slide[id]" value="<?php echo $this -> Slide() -> data -> id; ?>" />
		<input type="hidden" name="Slide[order]" value="<?php echo $this -> Slide() -> data -> order; ?>" />
	
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="Slide.title"><?php _e('Title', $this -> plugin_name); ?></label>
					<?php echo $this -> Html -> help(__('This title is for your reference in management and it will also be used to display the title of the slide in the information bar if you have that turned on.', $this -> plugin_name)); ?></th>
					<td>
						<?php if ($this -> language_do()) : ?>
							<?php $titles = $this -> language_split($this -> Slide() -> data -> title); ?>
							<div id="slide-title-tabs">
								<ul>
									<?php foreach ($languages as $language) : ?>
										<li><a href="#slide-title-tabs-<?php echo $language; ?>"><?php echo $this -> language_flag($language); ?></a></li>
									<?php endforeach; ?>
								</ul>
								<?php foreach ($languages as $language) : ?>
									<div id="slide-title-tabs-<?php echo $language; ?>">
										<input type="text" name="Slide[title][<?php echo $language; ?>]" id="Slide_title_<?php echo $language; ?>" value="<?php echo esc_attr(stripslashes($titles[$language])); ?>" class="widefat" />
									</div>
								<?php endforeach; ?>
							</div>
							
							<script type="text/javascript">
							jQuery(document).ready(function() {
								jQuery('#slide-title-tabs').tabs();
							});
							</script>
						<?php else : ?>
							<input class="widefat" type="text" name="Slide[title]" value="<?php echo esc_attr(stripslashes($this -> Slide() -> data -> title)); ?>" id="Slide.title" />
						<?php endif; ?>
                        <span class="howto"><?php _e('Title/name of your slide as it will be displayed to your users.', $this -> plugin_name); ?></span>
						<?php echo (!empty($this -> Slide() -> errors['title'])) ? '<div class="slideshow_error">' . $this -> Slide() -> errors['title'] . '</div>' : ''; ?>
					</td>
				</tr>
				<tr>
					<th><label for="Slide.description"><?php _e('Description', $this -> plugin_name); ?></label>
					<?php echo $this -> Html -> help(__('The description is specifically used for the information bar if you have that turned on.', $this -> plugin_name)); ?></th>
					<td>
						<?php if ($this -> language_do()) : ?>
							<?php $descriptions = $this -> language_split($this -> Slide() -> data -> description); ?>
							<div id="slide-description-tabs">
								<ul>
									<?php foreach ($languages as $language) : ?>
										<li><a href="#slide-description-tabs-<?php echo $language; ?>"><?php echo $this -> language_flag($language); ?></a></li>
									<?php endforeach; ?>
								</ul>
								<?php foreach ($languages as $language) : ?>
									<div id="slide-description-tabs-<?php echo $language; ?>">
										<textarea name="Slide[description][<?php echo $language; ?>]" cols="100%" class="widefat" rows="5"><?php echo esc_attr(stripslashes($descriptions[$language])); ?></textarea>
									</div>
								<?php endforeach; ?>
							</div>
							
							<script type="text/javascript">
							jQuery(document).ready(function() {
								jQuery('#slide-description-tabs').tabs();
							});
							</script>
						<?php else : ?>
							<textarea class="widefat" rows="5" cols="100%" name="Slide[description]"><?php echo esc_attr($this -> Slide() -> data -> description); ?></textarea>
						<?php endif; ?>
                        <span class="howto"><?php _e('Description of your slide as it will be displayed to your users below the title.', $this -> plugin_name); ?></span>
						<?php echo (!empty($this -> Slide() -> errors['description'])) ? '<div class="slideshow_error">' . $this -> Slide() -> errors['description'] . '</div>' : ''; ?>
					</td>
				</tr>
				<tr>
					<th><label for="showinfo_both"><?php _e('Show Information?', $this -> plugin_name); ?></label>
					<?php echo $this -> Html -> help(__('You can choose to show both title and description, only title, only description or not show the information bar at all. Please note that this setting is only effective when the information bar is turned on in configuration or via a parameter in shortcode or hardcode.', $this -> plugin_name)); ?></th>
					<td>
						<label><input onclick="jQuery('#showinfo_div').show();" <?php echo ((empty($showinfo)) || (!empty($showinfo) && $showinfo == "both")) ? 'checked="checked"' : ''; ?> type="radio" name="Slide[showinfo]" value="both" id="showinfo_both" /> <?php _e('Both title and description', $this -> plugin_name); ?></label><br/>
						<label><input onclick="jQuery('#showinfo_div').show();" <?php echo (!empty($showinfo) && $showinfo == "title") ? 'checked="checked"' : ''; ?> type="radio" name="Slide[showinfo]" value="title" id="showinfo_title" /> <?php _e('Title only', $this -> plugin_name); ?></label><br/>
						<label><input onclick="jQuery('#showinfo_div').show();" <?php echo (!empty($showinfo) && $showinfo == "description") ? 'checked="checked"' : ''; ?> type="radio" name="Slide[showinfo]" value="description" id="showinfo_description" /> <?php _e('Description only', $this -> plugin_name); ?></label><br/>
						<label><input onclick="jQuery('#showinfo_div').hide();" <?php echo (!empty($showinfo) && $showinfo == "none") ? 'checked="checked"' : ''; ?> type="radio" name="Slide[showinfo]" value="none" id="showinfo_none" /> <?php _e('None, do not show', $this -> plugin_name); ?></label>
						<span class="howto"><?php _e('Choose how the information bar will be displayed on this slide.', $this -> plugin_name); ?></span>
					</td>
				</tr>
			</tbody>
		</table>
		
		<div id="showinfo_div" style="display:<?php echo (!empty($showinfo) && $showinfo != "none") ? 'block' : 'none'; ?>;">
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="iopacity"><?php _e('Info Opacity', $this -> plugin_name); ?></label>
						<?php echo $this -> Html -> help(__('The opacity of the information bar from 0 to 100 where 0 is transparent and 100 is opague.', $this -> plugin_name)); ?></th>
						<td>
							<input type="text" id="iopacity" class="widefat" style="width:45px;" name="Slide[iopacity]" value="<?php echo empty($this -> Slide() -> data -> iopacity) ? '' : esc_attr(stripslashes($this -> Slide() -> data -> iopacity)); ?>" />
							<span class="howto"><?php _e('A value between 0 and 100. Leave empty for default.', $this -> plugin_name); ?></span>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="checkboxall"><?php _e('Galleries', $this -> plugin_name); ?></label>
					<?php echo $this -> Html -> help(__('You can organize/assign a slide to multiple galleries as needed. It is easy to display a slideshow with the slides of a specific gallery then.', $this -> plugin_name)); ?></th>
					<td>
						<?php if ($galleries = $this -> Gallery() -> select()) : ?>
							<label style="font-weight:bold"><input onclick="jqCheckAll(this,'','Slide[galleries]');" type="checkbox" name="checkboxall" value="checkboxall" id="checkboxall" /> <?php _e('Select All', $this -> plugin_name); ?></label><br/>
							<?php foreach ($galleries as $gallery_id => $gallery_title) : ?>
								<label><input <?php echo (!empty($this -> Slide() -> data -> galleries) && in_array($gallery_id, $this -> Slide() -> data -> galleries)) ? 'checked="checked"' : ''; ?> type="checkbox" name="Slide[galleries][]" value="<?php echo $gallery_id; ?>" id="Slide_galleries_<?php echo $gallery_id; ?>" /> <?php echo __($gallery_title); ?></label><br/>
							<?php endforeach; ?>
						<?php else : ?>
							<span class="error"><?php _e('No galleries are available.', $this -> plugin_name); ?></span>
						<?php endif; ?>
						<span class="howto"><?php _e('Assign this slide to one or more galleries.', $this -> plugin_name); ?></span>
					</td>
				</tr>
                <tr>
                	<th><label for="Slide.type.media"><?php _e('Image Type', $this -> plugin_name); ?></label>
                	<?php echo $this -> Html -> help(__('Do you want to specify a URL to your image or upload the image file manually? Specifying a URL will still copy the image file remotely from the location to your server so uploading is recommended to prevent any restrictions or errors.', $this -> plugin_name)); ?></th>
                    <td>
                    	<label><input onclick="jQuery('#typediv_media').show(); jQuery('#typediv_file').hide(); jQuery('#typediv_url').hide();" <?php echo (empty($this -> Slide() -> data -> type) || $this -> Slide() -> data -> type == "media") ? 'checked="checked"' : ''; ?> type="radio" name="Slide[type]" value="media" id="Slide.type.media" /> <?php _e('Media Upload', $this -> plugin_name); ?></label>
                    	<label><input onclick="jQuery('#typediv_file').show(); jQuery('#typediv_media').hide(); jQuery('#typediv_url').hide();" <?php echo ($this -> Slide() -> data -> type == "file") ? 'checked="checked"' : ''; ?> type="radio" name="Slide[type]" value="file" id="Slide.type.file" /> <?php _e('Upload File', $this -> plugin_name); ?></label>
                        <label><input onclick="jQuery('#typediv_url').show(); jQuery('#typediv_media').hide(); jQuery('#typediv_file').hide();" <?php echo ($this -> Slide() -> data -> type == "url") ? 'checked="checked"' : ''; ?> type="radio" name="Slide[type]" value="url" id="Slide.type.url" /> <?php _e('Specify URL', $this -> plugin_name); ?></label>
                        <?php echo (!empty($this -> Slide() -> errors['type'])) ? '<div class="slideshow_error">' . $this -> Slide() -> errors['type'] . '</div>' : ''; ?>
                        <span class="howto"><?php _e('Do you want to upload an image or specify a local/remote image URL?', $this -> plugin_name); ?></span>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <!-- Choose/upload file with the WordPress media uploader -->
        <div id="typediv_media" style="display:<?php echo (empty($this -> Slide() -> data -> type) || $this -> Slide() -> data -> type == "media") ? 'block' : 'none'; ?>;">
        	<table class="form-table">
        		<tbody>
        			<tr>
        				<th><label for="Slide_mediaupload"><?php _e('Choose Image', $this -> plugin_name); ?></label></th>
        				<td>	        				
        					<div id="Slide_mediaupload_image">
                        		<!-- image goes here -->
                        		<?php if (!empty($this -> Slide() -> data -> image_url)) : ?>
                        			<a href="<?php echo $this -> Slide() -> data -> image_url; ?>" title="<?php echo __($this -> Slide() -> data -> title); ?>" class="colorbox"><img class="img-rounded" src="<?php echo $this -> Html -> otf_image_src($this -> Slide() -> data, 100, 100, 100); ?>" /></a>
                        		<?php endif; ?>
                        	</div>
                        
                        	<input type="button" name="Slide_mediaupload" value="<?php _e('Choose File', $this -> plugin_name); ?>" id="Slide_mediaupload" class="button button-secondary" />
                        	<input type="text" name="Slide[media_file]" readonly="readonly" style="width:50%;" id="Slide_image_file" value="<?php echo esc_attr(stripslashes($this -> Slide() -> data -> image_url)); ?>" />
                        	<input type="hidden" name="Slide[attachment_id]" value="<?php echo esc_attr(stripslashes($this -> Slide() -> data -> attachment_id)); ?>" id="Slide_attachment_id" />
                        	
                        	<?php echo (!empty($this -> Slide() -> errors['media_file'])) ? '<div class="slideshow_error">' . $this -> Slide() -> errors['media_file'] . '</div>' : ''; ?>
                        	
                        	<script type="text/javascript">
                        	jQuery(document).ready(function() {
								var file_frame;
								
								jQuery('#Slide_mediaupload').on('click', function( event ){
									event.preventDefault();
									
									// If the media frame already exists, reopen it.
									if (file_frame) {
										file_frame.open();
										return;
									}
									
									// Create the media frame.
									file_frame = wp.media.frames.file_frame = wp.media({
										title: '<?php _e('Upload a slide', $this -> plugin_name); ?>',
										button: {
											text: '<?php _e('Select as Slide Image', $this -> plugin_name); ?>',
										},
										multiple: false  // Set to true to allow multiple files to be selected
									});
										
									// When an image is selected, run a callback.
									file_frame.on( 'select', function() {
										// We set multiple to false so only get one image from the uploader
										attachment = file_frame.state().get('selection').first().toJSON();
										
										// Do something with attachment.id and/or attachment.url here
										
										jQuery('#Slide_attachment_id').val(attachment.id);
										jQuery('#Slide_image_file').val(attachment.url);
										jQuery('#Slide_mediaupload_image').html('<a href="' + attachment.url + '" class="colorbox" onclick="jQuery.colorbox({href:\'' + attachment.url + '\'}); return false;"><img class="img-rounded" style="width:100px;" src="' + attachment.sizes.thumbnail.url + '" /></a>');
									});
									
									// Finally, open the modal
									file_frame.open();
								});
                        	});
                        	</script>
        				</td>
        			</tr>
        		</tbody>
        	</table>
        </div>
        
        <div id="typediv_file" style="display:<?php echo (!empty($this -> Slide() -> data -> type) && $this -> Slide() -> data -> type == "file") ? 'block' : 'none'; ?>;">
        	<table class="form-table">
            	<tbody>
                	<tr>
                    	<th><label for="Slide.image_file"><?php _e('Choose Image', $this -> plugin_name); ?></label>
                    	<?php echo $this -> Html -> help(__('Simply choose an image file from your computer to upload for this slide. Only .jpg, .png and .gif are supported and in rare cases .bmp but please try and prevent using .bmp files.', $this -> plugin_name)); ?></th>
                        <td>
                        	<input type="file" name="image_file" value="" id="Slide.image_file" />
                            <span class="howto"><?php _e('Choose your image file from your computer. JPG, PNG, GIF are supported.', $this -> plugin_name); ?></span>
                            <?php echo (!empty($this -> Slide() -> errors['image_file'])) ? '<div class="slideshow_error">' . $this -> Slide() -> errors['image_file'] . '</div>' : ''; ?>
                            
                            <?php
							
							if (!empty($this -> Slide() -> data -> type) && $this -> Slide() -> data -> type == "file") {
								if (!empty($this -> Slide() -> data -> image)) {									
									?>
                                    
                                    <input type="hidden" name="Slide[image_oldfile]" value="<?php echo esc_attr(stripslashes($this -> Slide() -> data -> image)); ?>" />
                                    <p><small><?php _e('Current image. Leave the field above blank to keep this image.', $this -> plugin_name); ?></small></p>
                                    <p><a title="<?php echo esc_attr($this -> Slide() -> data -> title); ?>" class="colorbox" href="<?php echo $this -> Slide() -> data -> image_path; ?>"><img src="<?php echo $this -> Html -> otf_image_src($this -> Slide() -> data, 100, 100, 100); ?>" alt="" class="slideshow" /></a></p>
                                    
                                    <?php	
								}
							}
							
							?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div id="typediv_url" style="display:<?php echo ($this -> Slide() -> data -> type == "url") ? 'block' : 'none'; ?>;">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th><label for="Slide.image_url"><?php _e('Image URL', $this -> plugin_name); ?></label>
                        <?php echo $this -> Html -> help(__('Specify an absolute URL to an image file to use for this slide. The image will be copied from the location to your server.', $this -> plugin_name)); ?></th>
                        <td>
                            <input class="widefat" type="text" name="Slide[image_url]" value="<?php echo esc_attr($this -> Slide() -> data -> image_url); ?>" id="Slide.image_url" />
                            <span class="howto"><?php _e('Local or remote image location eg. http://domain.com/path/to/image.jpg', $this -> plugin_name); ?></span>
                            <?php echo (!empty($this -> Slide() -> errors['image_url'])) ? '<div class="slideshow_error">' . $this -> Slide() -> errors['image_url'] . '</div>' : ''; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>    
                
        <table class="form-table">
        	<tbody>
				<tr>
					<th><label for="Slide_uselink_N"><?php _e('Use Link', $this -> plugin_name); ?></label>
					<?php echo $this -> Html -> help(__('Turn this on to specify a link/URL for this slide to link to when it is clicked.', $this -> plugin_name)); ?></th>
					<td>
						<label><input onclick="jQuery('#Slide_uselink_div').show();" <?php echo ($this -> Slide() -> data -> uselink == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="Slide[uselink]" value="Y" id="Slide_uselink_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
						<label><input onclick="jQuery('#Slide_uselink_div').hide();" <?php echo (empty($this -> Slide() -> data -> uselink) || $this -> Slide() -> data -> uselink == "N") ? 'checked="checked"' : ''; ?> type="radio" name="Slide[uselink]" value="N" id="Slide_uselink_N" /> <?php _e('No', $this -> plugin_name); ?></label>
                        <span class="howto"><?php _e('Set this to Yes to link this slide to a link/URL of your choice.', $this -> plugin_name); ?></span>
					</td>
				</tr>
			</tbody>
		</table>
		
		<div id="Slide_uselink_div" style="display:<?php echo ($this -> Slide() -> data -> uselink == "Y") ? 'block' : 'none'; ?>;">
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="Slide.link"><?php _e('Link To', $this -> plugin_name); ?></label>
						<?php echo $this -> Html -> help(__('The absolute URL to take the user to when the slide is clicked.', $this -> plugin_name)); ?></th>
						<td>
							<?php if ($this -> language_do()) : ?>
								<?php $links = $this -> language_split($this -> Slide() -> data -> link); ?>
								<div id="slide-link-tabs">
									<ul>
										<?php foreach ($languages as $language) : ?>
											<li><a href="#slide-link-tabs-<?php echo $language; ?>"><?php echo $this -> language_flag($language); ?></a></li>
										<?php endforeach; ?>
									</ul>
									<?php foreach ($languages as $language) : ?>
										<div id="slide-link-tabs-<?php echo $language; ?>">
											<input type="text" name="Slide[link][<?php echo $language; ?>]" id="Slide_link_<?php echo $language; ?>" value="<?php echo esc_attr(stripslashes($links[$language])); ?>" class="widefat" />
										</div>
									<?php endforeach; ?>
								</div>
								
								<script type="text/javascript">
								jQuery(document).ready(function() {
									jQuery('#slide-link-tabs').tabs();
								});
								</script>
							<?php else : ?>
								<input class="widefat" type="text" name="Slide[link]" value="<?php echo esc_attr($this -> Slide() -> data -> link); ?>" id="Slide.link" />
							<?php endif; ?>
							
                            <span class="howto"><?php _e('Link/URL to go to when a user clicks the slide eg. http://www.domain.com/mypage/', $this -> plugin_name); ?></span>
                        </td>
					</tr>
					<tr>
						<th><label for="Slide_linktarget_self"><?php _e('Link Target', $this -> plugin_name); ?></label>
						<?php echo $this -> Html -> help(__('Depending on the purpose of specifying this link, you may want it to open in the same window or in a new window.', $this -> plugin_name)); ?></th>
						<td>
							<label><input <?php echo (empty($this -> Slide() -> data -> linktarget) || (!empty($this -> Slide() -> data -> linktarget) && $this -> Slide() -> data -> linktarget == "self")) ? 'checked="checked"' : ''; ?> type="radio" name="Slide[linktarget]" value="self" id="Slide_linktarget_self" /> <?php _e('Current Window', $this -> plugin_name); ?></label>
							<label><input <?php echo (!empty($this -> Slide() -> data -> linktarget) && $this -> Slide() -> data -> linktarget == "blank") ? 'checked="checked"' : ''; ?> type="radio" name="Slide[linktarget]" value="blank" id="Slide_linktarget_blank" /> <?php _e('New/Blank Window', $this -> plugin_name); ?></label>
							<span class="howto"><?php _e('Should this link open in the current window or a new window?', $this -> plugin_name); ?></span>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<p class="submit">
			<button class="button-primary" type="submit" name="submit" value="1">
				<i class="fa fa-check fa-fw"></i> <?php _e('Save Slide', $this -> plugin_name); ?>
			</button>
			<div class="slideshow_continueediting">
				<label><input <?php echo (!empty($_REQUEST['continueediting'])) ? 'checked="checked"' : ''; ?> type="checkbox" name="continueediting" value="1" id="continueediting" /> <?php _e('Continue editing', $this -> plugin_name); ?></label>
			</div>
		</p>
	</form>
</div>