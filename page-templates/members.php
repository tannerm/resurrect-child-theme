<?php

/* Template Name: Members */

// No direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$template = 'dashboard';

if ( isset( $_GET['action'] ) && 'registered' === $_GET['action'] ) {
	$template = 'verify_registration';
}

if ( ! current_user_can( 'edit_posts' ) ) {
	$template = 'apply_for_membership';
}

if ( ! is_user_logged_in() ) {
	$template = 'login';
}

get_header(); // header.php ?>

	<div id="resurrect-content" class="<?php echo resurrect_sidebar_enabled() ? 'resurrect-has-sidebar' : 'resurrect-no-sidebar'; ?>">

		<div id="resurrect-content-inner">

			<?php resurrect_breadcrumbs( 'content' ); ?>

			<div class="resurrect-content-block resurrect-content-block-close resurrect-clearfix">
				<h1>Members</h1>
				<?php while( have_posts() ) : the_post(); ?>
					<?php get_template_part( CCC_Setup::$template_parts_path . $template ); ?>
				<?php endwhile; ?>

			</div>

		</div>

	</div>

<?php get_sidebar(); // load sidebar.php to show appropriate sidebar ?>

<?php get_footer(); // footer.php ?>