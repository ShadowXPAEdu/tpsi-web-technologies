<?php
	
if (!defined('ABSPATH')) exit; // Exit if accessed directly	
	
?>

<div class="wrap <?php echo $this -> pre; ?> slideshow">
	<h1><?php echo sprintf(__('View Gallery: %s', $this -> plugin_name), __($gallery -> title)); ?></h1>
	
	<div style="float:none;" class="subsubsub"><?php echo $this -> Html -> link(__('&larr; All Galleries', $this -> plugin_name), $this -> url, array('title' => __('All Galleries', $this -> plugin_name))); ?></div>
	
	<div class="tablenav top">
		<div class="alignleft">
			<a href="?page=<?php echo $this -> sections -> galleries; ?>&amp;method=save&amp;id=<?php echo $gallery -> id; ?>" class="button"><i class="fa fa-pencil"></i> <?php _e('Edit Gallery', $this -> plugin_name); ?></a>
		</div>
		<div class="alignleft">
			<a href="?page=<?php echo $this -> sections -> galleries; ?>&amp;method=hardcode&amp;id=<?php echo $gallery -> id; ?>" class="button"><i class="fa fa-code"></i> <?php _e('Hardcode', $this -> plugin_name); ?></a>
		</div>
		<div class="alignleft">
			<a onclick="if (!confirm('<?php _e('Are you sure you want to delete this gallery?', $this -> plugin_name); ?>')) { return false; }" href="?page=<?php echo $this -> sections -> galleries; ?>&amp;method=delete&amp;id=<?php echo $gallery -> id; ?>" class="button button-highlighted"><i class="fa fa-times"></i> <?php _e('Delete Gallery', $this -> plugin_name); ?></a>
		</div>
	</div>
	
	<?php $this -> render('slides' . DS . 'loop', array('gallery' => $gallery, 'slides' => $slides, 'paginate' => $paginate), true, 'admin'); ?>
</div>