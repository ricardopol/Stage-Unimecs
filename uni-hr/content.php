<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<?php
/**
* Filename: content.php
 * Description:
 * Company: Unimecs
 * URL: www.unimecs.com
 * Copyright: Unimecs, 2018
 * Version:
 * Last changed:
 */
?>
<?php if(have_posts()): while(have_posts()): the_post(); ?>
	<h1><?php the_title(); ?></h1>
	<?php the_content(); ?>
<?php endwhile; endif; ?>
