<style>

    .submit-button {
        text-align: center;
    }

    .posts {
        min-height: 150px;
        max-height: 400px;
        font-size: 14px;
        overflow: auto;
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

    .userlist {
        min-height: 160px;
        max-height: 160px;
        overflow: auto;
    }

    .friendslist {
        min-height: 400px;
        max-height: 400px;
        overflow: auto;
    }

</style>

<div class="ui raised very padded text container segment center aligned">
    <div class="ui people shape">
        <div class="sides">
            <div class="active side">
                <div class="ui card">
                    <div class="image">
                        <img src="<?php echo $profileData[0]->getAvatarUrl(); ?>">
                    </div>
                    <div class="content">
                        <?php if ($profileData[0]->getProfileName() !== NULL) { ?>
                            <div class="header"><?php echo $profileData[0]->getProfileName(); ?></div>
                            <div class="meta">
                                <a><?php echo '@' . $profileData[0]->getUserName(); ?></a>
                            </div>
                        <?php } else { ?>
                            <div class="header"><?php echo '@' . $profileData[0]->getUsername(); ?></div>
                            <div class="meta">
                                <a><?php echo $profileData[0]->getUserEmail(); ?></a>
                            </div>
                        <?php } ?>
                        <div class="description">
                            <?php if($genreData[0]->getTransformedLikedGenres() !== '') {?>
                                Genres: <?php echo $genreData[0]->getTransformedLikedGenres(); ?>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if ($this->session->userdata('userId') != $profileData[0]->getUserId()) { ?>
                        <div class="extra content">

                            <?php if ($isFollowing) { ?>
                                <a href="<?php echo site_url('/SiteController/unfollowUser/' . $profileData[0]->getUserId()); ?>">
                                    <button class="ui blue button">Unfollow</button>
                                </a>
                            <?php } else { ?>
                                <a href="<?php echo site_url('/SiteController/followUser/' . $profileData[0]->getUserId()); ?>">
                                    <button class="ui blue button">Follow</button>
                                </a>
                            <?php } ?>

                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($posts !== null) { ?>
<div class="ui raised very padded text container segment">
    <ul>
        <?php foreach ($posts as $obj) { ?>

            <div class="ui segment posts">
                <div class="postAvatarImage">
                    <p><img align="top" src="<?php echo $profileData[0]->getAvatarUrl(); ?>">
                        <?php if ($profileData[0]->getProfileName() !== NULL) { ?>
                            <b style="margin-left: 10px;"><?php echo $profileData[0]->getProfileName(); ?></b><?php echo ' @' . $profileData[0]->getUsername(); ?>
                        <?php } else { ?>
                            <b><?php echo '@' . $profileData[0]->getUsername(); ?></b>
                        <?php } ?>
                    </p>
                </div>
                <br>
                <p class="postContent"
                   style="margin-left: 65px;"><?php echo $obj->getPostContent(); ?></p>
            </div>

        <?php } ?>
    </ul>
</div>
<?php } ?>

<script>
    document.title = "Profile";
</script>