<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php

			/* Start the Loop */

			/*
				Modificação
			*/

			// query_posts('posts_per_page=10&order=ASC');
			// query_posts('post_status=draft');
			// query_posts('tag_id=2');
			// query_posts('cat=3,4');
			// echo "Nome do Blog: ".bloginfo();

			/* Primeiro loop */
				/*
				global $wpdb;

				$sql = "Select * FROM $wpdb->posts WHERE post_status = 'publish'";

				$listaDados = $wpdb->get_results($sql);

				foreach($listaDados as $value){
					echo '<h3>'.$value->post_title.'</h3>';
					echo $value->post_content;
				} */
			/* Fim do Primeiro Loop */

			/* EXEMPLO 2 LOOP */
				/* $myPosts = new WP_Query('posts_per_page=2&orderby=rand');

				while ($myPosts->have_posts()) :
					$myPosts->the_post();
					echo '<h3>'.the_title().'</h3>';
					echo the_content();
				endwhile; */
			/* FIM EXEMPLO 2 LOOP */

			while ( have_posts() ) :
				the_post();
				
				// O autor deve estar dentro do loop. Senão não funciona. 
				//echo "<br>Autor: ".the_author();

				get_template_part( 'template-parts/content/content', 'single' );

				if ( is_singular( 'attachment' ) ) {
					// Parent post navigation.
					the_post_navigation(
						array(
							/* translators: %s: parent post link */
							'prev_text' => sprintf( __( '<span class="meta-nav">Published in</span><span class="post-title">%s</span>', 'twentynineteen' ), '%title' ),
						)
					);
				} elseif ( is_singular( 'post' ) ) {
					// Previous/next post navigation.
					the_post_navigation(
						array(
							'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next Post', 'twentynineteen' ) . '</span> ' .
								'<span class="screen-reader-text">' . __( 'Next post:', 'twentynineteen' ) . '</span> <br/>' .
								'<span class="post-title">%title</span>',
							'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous Post', 'twentynineteen' ) . '</span> ' .
								'<span class="screen-reader-text">' . __( 'Previous post:', 'twentynineteen' ) . '</span> <br/>' .
								'<span class="post-title">%title</span>',
						)
					);
				}

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

			endwhile; // End of the loop.
			?>

			<?php 
				//Mostra os campos personalizados
				echo the_meta();
			?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
