<?php
get_header('top-bar');
the_post();
?>
<div class="container-blue">
    <div class="container-fluid no-padding" style="overflow: hidden">
        <div class="row">
            <div class="col-md-6 col-sm-12 tg-verticalmiddle col-xs-12">
                <?php the_post_thumbnail('full', array('class' => 'img-responsive')); ?>
            </div>
            <div class="col-md-6 col-sm-12 tg-verticalmiddle col-xs-12">
                <div class="post-content post-content-text-white text-center pdr30">
                    <h3>Log in to MeetingComplete</h3>
                    <div class="login-box">
                        <form class="form-signin">
                            <div class="form-group">
                                <input type="text" id="email" class="form-control" placeholder="EMAIL" required>
                            </div>
                            <div class="form-group">
                                <input type="password" id="password" class="form-control" placeholder="PASSWORD" required>
                            </div>
                            <button class="btn btn-md btn-info form-control" type="submit">Login</button>
                        </form><!-- /form -->
                    </div>
                    <div class="form-group">
                        <a href="#" class="link-white">
                            Lost My Password?
                        </a>
                        <br>
                        <a href="http://54.85.209.254:9005/find-my-meeting/" class="link-white">
                            I'm looking for my meeting
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>