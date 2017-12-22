<?php
/* Template Name: Videos */
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
                        <a class="btn-bg right-border" href="<?php echo home_url('learn'); ?>">LEARN</a>
                    </div>
                </div>

            </div>
        </div>
        <div class="row mgt40">
            <div class="col-xs-12">
                <div class="post-content post-content-text-white text-center">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            $args = array(
                'posts_per_page' => -1,
                'post_type' => 'videos',
            );
            $videos = get_posts($args);
            ?>
            <?php
            foreach ($videos as $post) {
                ?>
                <div class="col-md-6 text-center">
                    <div class="btn-block-dashboard">
                        <iframe width="100%" height="315" src="//www.youtube.com/embed/<?php echo rwmb_meta('id_video_url'); ?>" frameborder="0" allowfullscreen></iframe>
                        <div class="title-video">
                            <?php echo $post->post_title; ?>
                        </div>
                    </div>
                </div>
                <?php
            }
            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>


<?php get_footer(); ?>