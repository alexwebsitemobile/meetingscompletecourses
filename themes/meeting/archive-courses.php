<?php get_header(); ?>
<?php
$args = array(
    'posts_per_page' => 10,
    'post_type' => 'post',
);
$posts = get_posts($args);
?>

<div class="container-gray">
    <div class="container">
        <div class="row">
            <?php
            foreach ($posts as $post) : setup_postdata($post);
                ?>
                <div class="col-md-4 col-sm-6 mgt30 text-center">
                    <article>
                        <header class="img-entry">
                            <a href="<?php the_permalink(); ?>">
                                <?php
                                if (has_post_thumbnail()) {
                                    the_post_thumbnail('img_news', array('class' => 'img-responsive'));
                                }
                                ?>
                            </a>
                        </header>
                        <footer>
                            <div class="align-cards-home color-cards-home bottom-cards-home card-home">
                                <h5>
                                    <a href="<?php the_permalink(); ?>" class="title-member">
                                        <?php the_title(); ?>
                                    </a>
                                </h5>
                                <?php the_excerpt(); ?>
                            </div>
                            <div class="text-center">
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary">VIEW MORE</a>
                            </div>
                        </footer>
                    </article>
                </div>
                <?php
            endforeach;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>