<?php
/* Template Name: Request Demo */
session_destroy();
get_header('top-bar');
the_post();
?>
<div class="container-gray">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="post-content mgt40">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
        <div class="row mgb40">
            <div class="col-sm-offset-2 col-sm-8 col-xs-12">
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>