<?php
	
if (!defined('ABSPATH')) exit; // Exit if accessed directly	
	
?>

<div style="text-align:center;">
	<h4><a href="https://wordpress.org/plugins/newsletters-lite/" target="_blank">WordPress Newsletter plugin</a></h4>
	<p>
		<a href="https://wordpress.org/plugins/newsletters-lite/" target="_blank"><img style="width:200px; height:auto;" width="200" src="<?php echo $this -> url(); ?>/images/plugins/newsletters.png" alt="newsletters" /></a>
	</p>
	<p>
		Get the WordPress Newsletter plugin today. It is a FREE plugin which can be installed by clicking the button below.
	</p>
	<p>
		<a class="thickbox button button-primary button-large" href="<?php echo wp_nonce_url(admin_url('plugin-install.php?tab=plugin-information&plugin=newsletters-lite&TB_iframe=true&width=640&height=591')); ?>"><i class="fa fa-check fa-fw"></i> <?php _e('Install Now', $this -> plugin_name); ?></a>
		<a class="button button-secondary button-large" href="https://wordpress.org/plugins/newsletters-lite/" target="_blank"><i class="fa fa-info-circle"></i> <?php _e('More Info', $this -> plugin_name); ?></a>
	</p>
</div>