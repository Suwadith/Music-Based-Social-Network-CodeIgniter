<style>

    .submit-button {
        text-align: center;
    }

    .posts {
        min-height: 100px;
        font-size: 14px;
    }

    img {
        max-height: 290px;
    }

    .shape {
        text-align: center;
    }

    .container {
        min-width: 100%;
    }

</style>
<div class="ui container center aligned">
    <div class="ui segment">
        <div class="ui people shape">
            <div class="sides">
                <div class="active side">
                    <div class="ui card">
                        <div class="image">
                            <img src="<?php echo $profileData[0]->getAvatarUrl(); ?>">
                        </div>
                        <div class="content">
                            <div class="header"><?php echo $profileData[0]->getProfileName(); ?></div>
                            <div class="meta">
                                <a><?php echo $profileData[0]->getUserEmail(); ?></a>
                            </div>
                            <div class="description">
                                <?php echo ($profileData[0]->getLikedGenres()); ?>
                            </div>
                        </div>
                        <div class="extra content">
                            <a>
                                <a href="<?php echo site_url('/SiteController/profile'); ?>"><button class="ui blue button">Edit Profile</button></a>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="ui segment">

        <form class="create_post_form" action="<?php echo site_url('/SiteController/createPost'); ?>" method="post">

            <div class="ui form">
                <div class="field">
                    <label>Post Content</label>
                    <textarea spellcheck="false" id="postContent" name="postContent"></textarea>
                </div>
                <div class="submit-button">
                    <button class="ui grey button" type="submit">Post</button>
                </div>

            </div>

        </form>

    </div>

    <div class="ui segment load_posts">
        <?php if ($posts !== null) { ?>
            <ul>
                <?php foreach ($posts as $obj) { ?>

                    <div class="ui segment posts">
                        <p><?php echo $obj->getPostContent(); ?></p>
                    </div>

                <?php } ?>
            </ul>
        <?php }; ?>

    </div>

    <script language="javascript">
        document.title = "Home";
    </script>