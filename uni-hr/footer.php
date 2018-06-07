<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<?php  wp_footer(); ?>

<?php //Debug informtion ?>
<?php get_template_part('/debug/information'); ?>

<footer class="site-footer">
	<div class="container-fluid">
	<div class="col-md-12 text-right">
		<a href="http://www.unimecs.nl" target="_blank" title="Unimecs">
			<img src="<?php bloginfo('template_url')?>/assets/images/unimecs.png" alt="Unimecs" height="25">
		</a>
	</div>
	</div>
</footer>

</body>
</html>
