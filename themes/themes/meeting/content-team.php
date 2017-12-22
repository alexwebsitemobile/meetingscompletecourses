<div class="col-sm-6 mgt30">
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
                    <?php the_title(); ?>
                </h5>
                <p>
                    <?php the_excerpt(); ?>
                </p>
            </div>
        </footer>
    </article>
</div>