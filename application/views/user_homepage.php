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

    .userlist {
        min-height: 160px;
        max-height: 160px;
        overflow: auto;
    }

    .friendslist{
        min-height: 400px;
        max-height: 400px;
        overflow: auto;
    }

</style>

<div class="ui vertically divided grid">
    <div class="three column row">
        <div class="column">
            <div class="ui segment ">
                <h3 class="ui dividing header">
                    Following
                </h3>
                <div class="ui middle aligned selection list userlist">
                    <?php if($followingData !== null) {
                        foreach ($followingData as $following) {?>
                    <div class="item">
                        <img class="ui avatar image" src="<?php echo $following->getAvatarUrl(); ?>">
                        <div class="content">
                            <div class="header">
                                <a href="<?php echo site_url('/SiteController/viewUserProfile/' . $following->getUserId()); ?>">
                                    <?php echo $following->getUserName(); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php }
                    } ?>
                </div>
            </div>
            <div class="ui segment">
                <h3 class="ui dividing header">
                    Followers
                </h3>
                <div class="ui middle aligned selection list userlist">
                    <?php if($followerData !== null) {
                        foreach ($followerData as $follower) {?>
                            <div class="item">
                                <img class="ui avatar image" src="<?php echo $follower->getAvatarUrl(); ?>">
                                <div class="content">
                                    <div class="header">
                                        <a href="<?php echo site_url('/SiteController/viewUserProfile/' . $follower->getUserId()); ?>">
                                            <?php echo $follower->getUserName(); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="ui segment center aligned">
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
                                        <?php echo $genreData[0]->getLikedGenres(); ?>
                                    </div>
                                </div>
                                <div class="extra content">
                                    <a>
                                        <a href="<?php echo site_url('/SiteController/profile'); ?>">
                                            <button class="ui blue button">Edit Profile</button>
                                        </a>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="ui segment ">
                <h3 class="ui dividing header">
                    Friends
                </h3>
                <div class="ui middle aligned selection list friendslist">
                    <?php if($friendsData !== null) {
                        foreach ($friendsData as $friend) {?>
                            <div class="item">
                                <img class="ui avatar image" src="<?php echo $friend->getAvatarUrl(); ?>">
                                <div class="content">
                                    <div class="header">
                                        <a href="<?php echo site_url('/SiteController/viewUserProfile/' . $friend->getUserId()); ?>">
                                            <?php echo $friend->getUserName(); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ui vertically divided grid">
    <div class="three column row">
        <div class="column">
        </div>
        <div class="column">
            <div class="ui container segment">
                <?php echo validation_errors(); ?>

                <?php echo form_open(site_url('/SiteController/createHomePost')); ?>
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

    <?php if ($posts !== null) { ?>
    <div class="ui vertically divided grid">
        <div class="three column row">
            <div class="column"></div>
            <div class="column">
                <div class="ui container segment load_posts">

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
                                    <div class="ui text menu" style="margin-top: -75px;">
                                        <div class="ui right dropdown item">
                                            Options
                                            <i class="dropdown icon"></i>
                                            <div class="menu">
                                                <div class="item"><a href="<?php echo site_url('/SiteController/editPost/' . $obj->getPostId()); ?>">Edit Post</a></div>
                                                <div class="item"><a href="<?php echo site_url('/SiteController/deletePost/' . $obj->getPostId()); ?>">Delete Post</a></div>
                                            </div>
                                        </div>
                                    </div>
                                    </p>
                                </div>
                                <br>
                                <p class="postContent"
                                   style="margin-left: 65px;"><?php echo $obj->getPostContent(); ?></p>
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