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

</style>

<div class="ui container center aligned">
    <div class="ui people shape" style="text-align: center">
        <div class="sides">
            <div class="active side">
                <div class="ui centered card">
                    <div class="image">
                        <img src="<?php echo $profileData[0]->getAvatarUrl(); ?>">
                    </div>
                    <div class="content">
                        <div class="header"><?php echo '@' . $profileData[0]->getUsername(); ?></div>
                        <div class="meta">
                            <a><?php echo $profileData[0]->getUserEmail(); ?></a>
                        </div>
                        <div class="description">
                            <?php echo $genreData[0]->getLikedGenres(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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