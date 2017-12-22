<?php
/* Template Name: Solution */
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
            <?php
            $boxes_group = rwmb_meta('boxes_group_solution');
            if (!empty($boxes_group)) {
                foreach ($boxes_group as $group_value) {
                    ?>
                    <div class="mgb20">
                        <?php
                        $option_select = $group_value['order_option'];
                        $invert_mobile = $group_value['invert_option'];
                        if ($option_select == 'img_text') {
                            echo '<div class="col-md-6 tg-verticalmiddle text-center  mgbr20">';
                            $image_ids = isset($group_value['image_box_solution']) ? $group_value['image_box_solution'] : array();
                            foreach ($image_ids as $image_id) {
                                $image = RWMB_Image_Field::file_info($image_id, array('size' == 'full'));
                                echo '<img class="img-responsives" src="' . $image['full_url'] . '">';
                            }
                            echo '</div>';
                            echo '<div class="col-md-6 tg-verticalmiddle"><div class="post-content">';
                            echo '<h2 class="text-center">' . $group_value['title_box_solution'] . '</h2>';
                            $content_src = $group_value['description_box_solution'];
                            $content_box = apply_filters('the_content', $content_src);
                            echo $content_box;
                            echo '</div></div>';
                        } else if ($option_select == 'text_img') {

                            if ($invert_mobile == 'Yes') {
                                echo '<div class="col-md-6 tg-verticalmiddle visible-sm visible-xs mgbr20 text-center">';
                                $image_ids = isset($group_value['image_box_solution']) ? $group_value['image_box_solution'] : array();
                                foreach ($image_ids as $image_id) {
                                    $image = RWMB_Image_Field::file_info($image_id, array('size' == 'full'));
                                    echo '<img class="img-responsives" src="' . $image['full_url'] . '">';
                                }
                                echo '</div>';
                            }

                            echo '<div class="col-md-6 tg-verticalmiddle"><div class="post-content">';
                            echo '<h2 class="text-center">' . $group_value['title_box_solution'] . '</h2>';
                            $content_src = $group_value['description_box_solution'];
                            $content_box = apply_filters('the_content', $content_src);
                            echo $content_box;
                            echo '</div></div>';

                            if ($invert_mobile == 'Yes') {

                                echo '<div class="col-md-6 tg-verticalmiddle text-center hidden-sm hidden-xs">';
                                $image_ids = isset($group_value['image_box_solution']) ? $group_value['image_box_solution'] : array();
                                foreach ($image_ids as $image_id) {
                                    $image = RWMB_Image_Field::file_info($image_id, array('size' == 'full'));
                                    echo '<img class="img-responsives" src="' . $image['full_url'] . '">';
                                }
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>