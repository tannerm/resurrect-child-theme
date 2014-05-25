<?php

/* Template Name: Slides */

$postfix = ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ? '' : '.min';
$reveal_url = get_stylesheet_directory_uri() . '/lib/reveal-js/';
$slides = get_option('widget_ctfw-slide'); ?>

<!doctype html>
<html lang="en" class="slides">

<head>
	<meta charset="utf-8">

	<title>Slides</title>

	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<link rel="stylesheet" href="<?php echo $reveal_url; ?>css/reveal.min.css">
<!--	<link rel="stylesheet" href="--><?php //echo $reveal_url; ?><!--css/theme/beige.css" id="theme">-->
<!--	<link rel="stylesheet" href="--><?php //echo get_stylesheet_directory_uri() . "/assets/css/christ_s_community_church_theme{$postfix}.css"; ?><!--">-->

	<!-- For syntax highlighting -->
	<link rel="stylesheet" href="<?php echo $reveal_url; ?>lib/css/zenburn.css">

	<!-- If the query includes 'print-pdf', include the PDF print sheet -->
	<script>
		if( window.location.search.match( /print-pdf/gi ) ) {
			var link = document.createElement( 'link' );
			link.rel = 'stylesheet';
			link.type = 'text/css';
			link.href = 'css/print/pdf.css';
			document.getElementsByTagName( 'head' )[0].appendChild( link );
		}
	</script>

	<!--[if lt IE 9]>
	<script src="<?php echo $reveal_url; ?>lib/js/html5shiv.js"></script>
	<![endif]-->

	<style>

	</style>
	<?php wp_head(); // prints out JavaScript, CSS, etc. as needed by WordPress, theme, plugins, etc. ?>
</head>

<body>

<div class="reveal">

	<div class="slides">

		<?php foreach( $slides as $slide ) : ?>
			<?php if ( ! is_array( $slide ) ) continue; ?>
			<section data-background="<?php echo wp_get_attachment_image_src( $slide['image_id'], 'large' )[0]; ?>">
				<?php if ( $slide['title'] ) : ?>
					<h1 class="flex-title"><?php echo $slide['title']; ?></h1>
				<?php endif; ?>

				<?php if ( $slide['description'] ) : ?>
					<p class="flex-description"><?php echo $slide['description']; ?></p>
				<?php endif; ?>

			</section>
		<?php endforeach; ?>

	</div>

</div>

<script src="<?php echo $reveal_url; ?>lib/js/head.min.js"></script>
<script src="<?php echo $reveal_url; ?>js/reveal.min.js"></script>

<script>

	// Full list of configuration options available here:
	// https://github.com/hakimel/reveal.js#configuration
	Reveal.initialize({
		controls: false,
		progress: false,
		history: false,
		center: false,
		loop: true,
		autoSlide: 10000,
		autoSlideStoppable: false,

		theme: Reveal.getQueryHash().theme, // available themes are in /css/theme
		transition: Reveal.getQueryHash().transition || 'fade', // default/cube/page/concave/zoom/linear/fade/none

		// Parallax scrolling
		// parallaxBackgroundImage: 'https://s3.amazonaws.com/hakim-static/reveal-js/reveal-parallax-1.jpg',
		// parallaxBackgroundSize: '2100px 900px',

		// Optional libraries used to extend on reveal.js
		dependencies: [
			{ src: '<?php echo $reveal_url; ?>lib/js/classList.js', condition: function() { return !document.body.classList; } },
			{ src: '<?php echo $reveal_url; ?>plugin/markdown/marked.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
			{ src: '<?php echo $reveal_url; ?>plugin/markdown/markdown.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
			{ src: '<?php echo $reveal_url; ?>plugin/highlight/highlight.js', async: true, callback: function() { hljs.initHighlightingOnLoad(); } },
			{ src: '<?php echo $reveal_url; ?>plugin/zoom-js/zoom.js', async: true, condition: function() { return !!document.body.classList; } },
			{ src: '<?php echo $reveal_url; ?>plugin/notes/notes.js', async: true, condition: function() { return !!document.body.classList; } }
		]
	});

</script>

</body>
</html>
