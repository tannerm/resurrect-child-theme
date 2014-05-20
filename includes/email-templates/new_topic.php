<?php
$topic = get_post( $topic_id );
$content = $topic->post_content;
$content = apply_filters('the_content', $content);
$content = str_replace(']]>', ']]&gt;', $content);
$author = get_userdata( $topic->post_author );
?>
<p><?php echo esc_html( $author->display_name );?> just posted a new message in <a href="<?php echo esc_url( get_the_permalink( $topic->ID ) ); ?>"><?php echo esc_html( get_the_title( $forum_id ) ); ?></a></p>

<h1><a href="<?php echo esc_url( get_the_permalink( $topic->ID ) ); ?>"><?php echo esc_html( get_the_title( $topic->ID ) ); ?></a></h1>

<div><?php echo wp_kses_post( $content ); ?></div>

<p><a href="<?php echo esc_url( get_the_permalink( $topic->ID ) ); ?>">Click here to comment or view this topic online.</a></p>