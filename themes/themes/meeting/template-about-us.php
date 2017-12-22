<?php
/* Template Name: About Us */

get_header();
the_post();
?>
<div class="container-gray">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="post-content">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$args = array(
    'posts_per_page' => -1,
    'post_type' => 'team',
);
$team = get_posts($args);
?>

<div class="container-white">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="post-content">
                    <h2 class="text-center">
                        OUR TEAM
                    </h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            foreach ($team as $post) : setup_postdata($post);
                get_template_part('content-team');
            endforeach;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>