<style>

    .submit-button {
        text-align: center;
    }

    .posts {
        min-height: 100px;
        font-size: 14px;
    }

    .postContent p {
        margin-left: 10px;
    }

    .postContent img {
        max-height: 290px;
        max-width: 80%;
    }

    .shape {
        text-align: center;
    }

    .postAvatarImage img {
        border-radius: 50%;
        width: 50px;
    }

    .postAvatarImage p {
        color: dimgrey;
    }

    ul {
        margin: 0;
        padding: 0;
    }

    .errorMessage {
        color: red;
    }

    .userTitle {
        color: inherit;
    }

</style>

<div class="ui vertically divided grid">
    <div class="three column row">
        <div class="column">
        </div>
        <div class="column">
            <div class="ui container segment">
                <?php echo validation_errors(); ?>

                <?php echo form_open(site_url('/SiteController/createTimelinePost')); ?>
                <!--                <form class="create_post_form" action="--><?php //echo site_url('/SiteController/createPost'); ?><!--"-->
                <!--                      method="post">-->

                <div class="ui form">
                    <div class="field">
                        <label>Post Content</label>
                        <textarea spellcheck="false" id="postContent" name="postContent"></textarea>
                    </div>
                    <div class="submit-button">
                        <button class="ui grey button" type="submit">Post</button>
                    </div>

                </div>

                <!--                </form>-->
                <?php echo form_close(); ?>
            </div>
        </div>
        <div class="column"></div>
    </div>
</div>

<?php if ($timelinePosts !== null) { ?>
    <div class="ui vertically divided grid">
        <div class="three column row">
            <div class="column"></div>
            <div class="column">
                <div class="ui container segment load_posts">

                    <ul>
                        <?php foreach ($timelinePosts as $post) { ?>

                            <div class="ui segment posts">
                                <div class="postAvatarImage">
                                    <p>
                                        <a class="userTitle" href="<?php echo site_url('/SiteController/viewUserProfile/' . $post->userId) ?>">
                                        <img align="top" src="<?php echo $post->avatarUrl; ?>">
                                        <?php if ($post->profileName !== NULL) { ?>
                                            <b style="margin-left: 10px;"><?php echo $post->profileName; ?></b><?php echo ' @' . $post->username; ?>
                                        <?php } else { ?>
                                            <b><?php echo '@' . $post->username; ?></b>
                                        <?php } ?>
                                        </a>
                                    <?php if($this->session->userdata('userId') == $post->userId) { ?>
                                    <div class="ui text menu" style="margin-top: -75px;">
                                        <div class="ui right dropdown item">
                                            Options
                                            <i class="dropdown icon"></i>
                                            <div class="menu">
                                                <div class="item"><a href="<?php echo site_url('/SiteController/editPost/' . $post->postId); ?>">Edit Post</a></div>
                                                <div class="item"><a href="<?php echo site_url('/SiteController/deletePost/' . $post->postId); ?>">Delete Post</a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    </p>
                                </div>
                                <br>
                                <p class="postContent"
                                   style="margin-left: 65px;"><?php
                                    $output = $post->postContent;

                                    $regex_images = '~https?://\S+?(?:png|gif|jpe?g)~';
                                    $regex_links = '~(?<!src=\')https?://\S+\b~';

                                    $output = preg_replace($regex_images, "<br> <img src='\\0'> <br>", $output);
                                    $output = preg_replace($regex_links, "<a href='\\0'>\\0</a>", $output);

                                    echo $output
                                    ?></p>
                            </div>

                        <?php } ?>
                    </ul>


                </div>
            </div>
            <div class="column"></div>
        </div>
    </div>

<?php }; ?>
<script language="javascript">
    document.title = "Home";
    $('.ui.dropdown')
        .dropdown()
    ;
</script>