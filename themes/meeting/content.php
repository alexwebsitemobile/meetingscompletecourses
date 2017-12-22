<div class="col-md-4 col-sm-6 mgt30">
    <article>
        <header class="img-entry">
            <a href="<?php the_permalink(); ?>">
                <?php
                if (has_post_thumbnail()) {
                    the_post_thumbnail('img_news', array('class' => 'img-responsive'));
                } else {
                    echo '<img class="img-responsive" src="' . get_bloginfo('stylesheet_directory')
                    . '/images/news_not.png" />';
                }
                ?>
            </a>
        </header>
        <footer>
            <div class="align-cards-home color-cards-home bottom-cards-home card-home">
                <h5>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h5>
                <p>
                    <?php echo substr(get_the_excerpt(), 0, 60) . ' [...]'; ?>
                </p>
            </div>
            <div class="link-card-home align-cards-home color-cards-home view-more">
                <a href="#">VIEW MORE</a>
            </div>
        </footer>
    </article>
</div>