<style>

    .submit-button {
        text-align: center;
    }

    .posts {
        min-height: 100px;
        font-size: 14px;
    }

    img {
        max-height: 200px;
    }

    .shape {
        text-align: center;
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
                                Steve Jobes is a fictional character designed to resemble someone familiar to readers.
                            </div>
                        </div>
                        <div class="extra content">
          <span class="right floated">
            Joined in 2014
          </span>
                            <span>
            <i class="user icon"></i>
            151 Friends
          </span>
                        </div>
                    </div>
                </div>
                <div class="side">
                    <div class="ui card">
                        <div class="image">
                            <img src="/images/avatar/large/stevie.jpg">
                        </div>
                        <div class="content">
                            <a class="header">Stevie Feliciano</a>
                            <div class="meta">
                                <span class="date">Joined in 2014</span>
                            </div>
                            <div class="description">
                                Stevie Feliciano is a library scientist living in New York City. She likes to spend her
                                time reading, running, and writing.
                            </div>
                        </div>
                        <div class="extra content">
                            <a>
                                <i class="user icon"></i>
                                22 Friends
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