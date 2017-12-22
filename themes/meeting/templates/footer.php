<?php
$contact = get_page_by_path('contact-us');
$name = get_option('theme_options_name');
$addr = get_option('theme_options_addr');
$city = get_option('theme_options_city');
$state = get_option('theme_options_state');
$zip = get_option('theme_options_zip');
$country = get_option('theme_options_country');
$tel = get_option('theme_options_tel');
$mail = get_option('theme_options_email');
$url = get_option('theme_options_url');
$facebook = get_option('theme_options_facebook');
$instagram = get_option('theme_options_instagram');
$twitter = get_option('theme_options_twitter');
$googleplus = get_option('theme_options_googleplus');
$youtube = get_option('theme_options_youtube');
$linkedin = get_option('theme_options_linkedin');
$pinterest = get_option('theme_options_pinterest');
$tumblr = get_option('theme_options_tumblr');
$rss = get_option('theme_options_rss');
?>

<footer id="#footer-blue" itemscope itemprop="http://schema.org/WPFooter" class="footer text-center-xs">
    <?php if (!is_page('request-demo')) { ?>
        <div class="container-white">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="post-content text-center">
                            <h2>
                                Get Started Now
                            </h2>
                            <a href="<?php echo home_url('request-demo'); ?>" class="btn btn-info btn-lg animated infinite">
                                REQUEST DEMO
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
        <div class="container-blue pdtb20">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="brd-right">
                            <h3>Contact Us</h3>
                            <div itemtype="http://schema.org/LocalBusiness">
                                <p itemprop="name"><?php echo $name; ?></p>
                                <p>
                                    <a href="tel:<?php echo $tel; ?>" class="contact-icon" itemprop="telephone"><?php echo $tel; ?></a>
                                </p>
                                <p>
                                    <a href="mailto:<?php echo $mail; ?>" class="contact-icon" itemprop="email"> <?php echo $mail; ?></a>
                                </p>
                                <div  itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                    <p><span itemprop="streetAddress"><?php echo $addr; ?></span>, </p>
                                    <p>
                                        <span itemprop="addressLocality"><?php echo $city; ?>,</span> -  <span itemprop="addressRegion"><?php echo $state; ?></span> - <span itemprop="postalCode"><?php echo $zip; ?></span>, <span itemprop="addressLocality"><?php echo $country; ?></span> 
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 tg-verticalmiddle">
                        <div class="brd-right">
                            <h3>Useful Links</h3>
                            <?php
                            wp_nav_menu(array(
                                'menu' => 'Useful Links',
                                'theme_location' => 'useful-links'
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-4 tg-verticalmiddle">
                        <div style="margin-bottom: 15px;">
                            <img src="http://52.168.37.34/wp-content/uploads/2017/04/Recurso-1.png" class="img-responsives">
                        </div>
                        <div style="margin-bottom: 15px;">
                            <?php if (!empty($facebook)) { ?>
                                <a target="_blank" href="<?php echo $facebook; ?>">
                                    <i class="fa fa-facebook social-footer" aria-hidden="true"></i>
                                </a>
                            <?php } ?>
                            <?php if (!empty($instagram)) { ?>
                                <a target="_blank" href="<?php echo $instagram; ?>">
                                    <i class="fa fa-instagram social-footer" aria-hidden="true"></i>
                                </a>
                            <?php } ?>
                            <?php if (!empty($twitter)) { ?>
                                <a target="_blank" href="<?php echo $twitter; ?>">
                                    <i class="fa fa-twitter social-footer" aria-hidden="true"></i>
                                </a>
                            <?php } ?>
                            <?php if (!empty($googleplus)) { ?>
                                <a target="_blank" href="<?php echo $googleplus; ?>">
                                    <i class="fa fa-google-plus social-footer" aria-hidden="true"></i>
                                </a>
                            <?php } ?>
                            <?php if (!empty($youtube)) { ?>
                                <a target="_blank" href="<?php echo $youtube; ?>">
                                    <i class="fa fa-youtube-play social-footer" aria-hidden="true"></i>
                                </a>
                            <?php } ?>
                            <?php if (!empty($linkedin)) { ?>
                                <a target="_blank" href="<?php echo $linkedin; ?>">
                                    <i class="fa fa-linkedin social-footer" aria-hidden="true"></i>
                                </a>
                            <?php } ?>
                            <?php if (!empty($pinterest)) { ?>
                                <a target="_blank" href="<?php echo $pinterest; ?>">
                                    <i class="fa fa-pinterest social-footer" aria-hidden="true"></i>
                                </a>
                            <?php } ?>
                            <?php if (!empty($tumblr)) { ?>
                                <a target="_blank" href="<?php echo $tumblr; ?>">
                                    <i class="fa fa-tumblr social-footer" aria-hidden="true"></i>
                                </a>
                            <?php } ?>
                            <?php if (!empty($rss)) { ?>
                                <a target="_blank" href="<?php echo $rss; ?>">
                                    <i class="fa fa-rss social-footer" aria-hidden="true"></i>
                                </a>
                            <?php } ?>
                        </div>
                        <p>
                            Copyright © MAK32, INC.
                        </p>
                        <p>
                            All rights reserved. 2005-<?php the_date('Y'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
</footer>


