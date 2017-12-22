<div class="col-sm-4 mgt30">
    <article>
        <header class="img-entry text-center">
            <?php
            if (has_post_thumbnail()) {
                the_post_thumbnail('img_news', array('class' => 'img-responsives'));
            }
            ?>
        </header>
        <footer>
            <div class="text-center">
                <h5 class="title-member">
                    <?php the_title(); ?>
                </h5>
                <p><?php echo rwmb_meta('title_position'); ?></p>
                <div class="post-content">
                    <?php the_excerpt(); ?>
                </div>
            </div>
        </footer>
    </article>
</div>