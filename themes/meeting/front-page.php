<?php
get_header();
the_post();
?>
<div class="container-white" data-animation="fadeIn" data-animation-delay="100">
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
$content_box_gray_src = rwmb_meta('content_box_gray');
?>
<div class="container-gray">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="post-content">
                    <?php
                    $content_box_gray = apply_filters('the_content', $content_box_gray_src);
                    echo $content_box_gray;
                    ?>
                </div>
            </div>
        </div>
        <div class="row mgt40">
            <?php
            $time = 100;
            $boxes_group = rwmb_meta('boxes_group');
            if (!empty($boxes_group)) {
                foreach ($boxes_group as $group_value) {
                    echo '<div class="col-sm-4 text-center" data-animation="fadeInUp" data-animation-delay="' . $time . '">';
                    $image_ids = isset($group_value['image_box']) ? $group_value['image_box'] : array();
                    foreach ($image_ids as $image_id) {
                        $image = RWMB_Image_Field::file_info($image_id, array('size' == 'thumbnail'));
                        echo '<img src="' . $image['url'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '">';
                    }
                    echo '<h2 class="title-box">' . $group_value['title_box'] . '</h2>';
                    echo '<a class="btn btn-primary btn-md mgt20" href="' . $group_value['url_box'] . '">LEARN MORE</a>';
                    echo '</div>';
                    $time = $time + 100;
                }
            }
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>