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
        <div class="row">
            <div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12">
                <section id="cd-timeline" class="cd-container">
                    <?php
                    $timeline = rwmb_meta('boxes_timeline');
                    if (!empty($timeline)) {
                        foreach ($timeline as $timeline_value) {
                            ?>
                            <div class="cd-timeline-block">
                                <div class="cd-timeline-img cd-picture">
                                    <img src="http://52.168.37.34/wp-content/uploads/2017/05/cd-icon-picture.png" alt="Bullet">
                                </div>
                                <div class="cd-timeline-content">
                                    <h2><?php echo $timeline_value['title_timeline']; ?></h2>
                                    <span class="cd-date"><?php echo $timeline_value['description_timeline']; ?></span>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </section> <!-- cd-timeline -->
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
        <div class="container">
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
</div>

<script>
    jQuery(document).ready(function ($) {
        var timelineBlocks = $('.cd-timeline-block'),
                offset = 0.8;

        //hide timeline blocks which are outside the viewport
        hideBlocks(timelineBlocks, offset);

        //on scolling, show/animate timeline blocks when enter the viewport
        $(window).on('scroll', function () {
            (!window.requestAnimationFrame)
                    ? setTimeout(function () {
                        showBlocks(timelineBlocks, offset);
                    }, 100)
                    : window.requestAnimationFrame(function () {
                        showBlocks(timelineBlocks, offset);
                    });
        });

        function hideBlocks(blocks, offset) {
            blocks.each(function () {
                ($(this).offset().top > $(window).scrollTop() + $(window).height() * offset) && $(this).find('.cd-timeline-img, .cd-timeline-content').addClass('is-hidden');
            });
        }

        function showBlocks(blocks, offset) {
            blocks.each(function () {
                ($(this).offset().top <= $(window).scrollTop() + $(window).height() * offset && $(this).find('.cd-timeline-img').hasClass('is-hidden')) && $(this).find('.cd-timeline-img, .cd-timeline-content').removeClass('is-hidden').addClass('bounce-in');
            });
        }
    });
</script>
<?php get_footer(); ?>