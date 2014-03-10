<?php
/**
 * Page content for: BP Groups
 * 
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'resurrect-entry-full' ); ?>>

	<?php if ( ctfw_has_title() && ! resurrect_hide_page_title() ) : // do not repeat title if already shown via header-banner.php ?>
		<h1 class="resurrect-entry-title resurrect-main-title"><?php resurrect_title_paged(); // show with (Page #) if multipage ?></h1>
	<?php endif; ?>

	<div class="resurrect-entry-content resurrect-clearfix">

		<?php the_content(); ?>

		<?php do_action( 'resurrect_after_content' ); ?>

	</div>

	<?php get_template_part( 'content-footer-full' ); // multipage nav, taxonomy terms, "Edit" button, etc. ?>

</article>