<?php
/* Template Name: Learn */
get_header();
the_post();
?>

<div class="container-gray">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6 col-sm-offset-1 col-sm-10 col-xs-12 text-center">
                <div class="row">
                    <div class="col-xs-6 no-padding padding-l">
                        <a class="btn-bg left-border" href="<?php echo home_url('support'); ?>">SUPPORT</a>
                    </div>
                    <div class="col-xs-6 no-padding padding-r">
                        <a class="btn-bg right-border" href="<?php echo home_url('training-videos'); ?>">TRAINING VIDEOS</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mgt40">
            <div class="col-md-offset-3 col-md-6 col-sm-offset-1 col-sm-10 col-xs-12">
                <div class="post-content post-content-text-white text-center">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
        <div class="row mgt40">
            <div class="col-md-7">
                <?php
                $args = array(
                    'posts_per_page' => -1,
                    'post_type' => 'learn_items',
                );
                $support = get_posts($args);
                ?>
                <?php
                foreach ($support as $post) {
                    ?>
                    <div class="feature-item">
                        <div class="media">
                            <div class="pull-left icon">
                                <i class="fa fa-bullseye"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><?php the_title(); ?></h4>
                                <?php echo $post->post_content; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                wp_reset_postdata();
                ?>
            </div>
            <div class="col-md-5 hidden-sm hidden-xs">
                <?php
                $images = rwmb_meta('img-right', 'type=image&size=full'); // Prior to 4.8.0
                if (!empty($images)) {
                    foreach ($images as $image) {
                        echo '<img class="img-responsives" style="padding:5px" src="', esc_url($image['url']), '"  alt="', esc_attr($image['alt']), '">';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>