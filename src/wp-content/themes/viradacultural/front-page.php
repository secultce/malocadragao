<?php get_header(); ?>
<div class="container-fluid">
	<div class="row">
		<section id="main-section" class="col-md-8 col-md-offset-2">
		<?php $homefeatures = new WP_Query( 'posts_per_page=-1&meta_key=_home&meta_value=1&ignore_sticky_posts=1' ); ?>

			<div id="front-page-carousel" class="carousel slide" data-ride="carousel">
				<?php if ($homefeatures->have_posts()) : ?>
					<!-- Indicators -->
					<ol class="carousel-indicators">
						<?php for ($i=0; $i < $homefeatures->found_posts; $i++) { ?>
							<li data-target="#front-page-carousel" data-slide-to="<?php echo $i; ?>"></li>
						<?php } ?>
					</ol>

					<!-- Wrapper for slides -->
					<div class="carousel-inner">
						<?php while ($homefeatures->have_posts()) : $homefeatures->the_post(); ?>
							<div class="item">
								<?php if ( has_post_thumbnail() ) : ?> 
									<?php the_post_thumbnail('large', 'true'); ?>				 
								<?php endif; ?>
								<div class="carousel-caption">
									<h1><a href="<?php the_permalink();?>" title="<?php the_title_attribute();?>"><?php the_title();?></a></h1>
								</div>
							</div>
						<?php endwhile; ?>
					</div>

					<!-- Controls -->
					<a class="left carousel-control" href="#front-page-carousel" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
					</a>
					<a class="right carousel-control" href="#front-page-carousel" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span>
					</a>
				<?php else :?>
                    <p>Nenhum destaque encontrado.</p>
				<?php endif; ?> 
			</div>
			<?php wp_reset_postdata(); ?>
			<div class="row">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php html::part('loop'); ?>
                <?php endwhile; ?>
                <?php if ($wp_query->max_num_pages > 1) : ?>
                    <nav id="posts-nav" class="clearfix">
                        <div class="alignleft"><?php next_posts_link(__('&laquo; Previous posts', 'viradacultural')); ?></div>
                        <div class="alignright"><?php previous_posts_link(__('Next posts &raquo;', 'viradacultural')); ?></div>
                    </nav>
                    <!-- #posts-nav -->
                <?php endif; ?>					
            <?php else : ?>
                <p><?php _e('No results found.', 'viradacultural'); ?></p>              
            <?php endif; ?>
           	</div>			
		</section>
		<!-- #main-section -->
		<?php get_footer(); ?>
	</div>
	<!-- .row -->
	</div>
<!-- .container-fluid -->
<?php html::part('countdown'); ?>
