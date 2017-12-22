<?php
/* Template Name: Find My Meeting */

get_header('meeting');
the_post();
?>
<div class="container-blue">
    <div class="container mgt40">
        <div class="row">
            <div class="col-xs-12">
                <div class="post-content post-content-text-white text-center">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
        <div class="row mgt40">
            <div class="col-sm-offset-4 col-sm-4 col-xs-12">
                <form class="form-signin">
                    <div class="form-group">
                        <input type="text" id="meeting_id" class="form-control" placeholder="MEETING ID" required>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-md btn-info form-control" type="submit">SEND</button>
                    </div>
                </form><!-- /form -->
                <div class="form-group text-center">
                    <a href="#" class="link-white" data-toggle="modal" data-target="#myModal">
                        I Need to Know my Meeting ID
                    </a>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-offset-1 col-sm-5 tg-verticalmiddle text-center">
                        <img class="size-full wp-image-9 aligncenter" src="http://localhost/meeting-wordpress/wp-content/uploads/2017/04/Recurso-1.png" alt="" width="123" height="76" />
                    </div>
                    <div class="col-sm-6 tg-verticalmiddle">
                        <div class="post-content post-content-text-white">
                            <h3>Send Me My Meeting ID</h3>
                        </div>
                        <form class="form-signin">
                            <div class="form-group">
                                <input type="text" id="email" class="form-control" placeholder="EMAIL" required>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-md btn-info form-control" type="submit">SEND</button>
                            </div>
                        </form><!-- /form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').focus()
    })
</script>
<?php get_footer('meeting'); ?>