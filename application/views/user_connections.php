<style>

    .userlist {
        min-height: 190px;
        max-height: 190px;
        overflow: auto;
    }

    .errorMessage {
        color: red;
    }


</style>

<div class="ui raised very padded text container segment">
    <h3 class="ui dividing header" style="margin-top: -3%;">
        Following
    </h3>
    <div class="ui middle aligned selection list userlist">
        <?php if ($followingData !== null) {
            foreach ($followingData as $following) { ?>
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
        } else { ?>
            <div class="errorMessage"> You haven't followed anyone. </div><br>
        <?php } ?>
    </div>
</div>

<div class="ui raised very padded text container segment">
    <h3 class="ui dividing header">
        Followers
    </h3>
    <div class="ui middle aligned selection list userlist">
        <?php if ($followerData !== null) {
            foreach ($followerData as $follower) { ?>
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
        } else { ?>
            <div class="errorMessage"> Users haven't followed you yet. </div><br>
        <?php } ?>
    </div>
</div>

<div class="ui raised very padded text container segment">
    <h3 class="ui dividing header">
        Friends
    </h3>
    <div class="ui middle aligned selection list userlist">
        <?php if ($friendsData !== null) {
            foreach ($friendsData as $friends) { ?>
                <div class="item">
                    <img class="ui avatar image" src="<?php echo $friends->getAvatarUrl(); ?>">
                    <div class="content">
                        <div class="header">
                            <a href="<?php echo site_url('/SiteController/viewUserProfile/' . $friends->getUserId()); ?>">
                                <?php echo $friends->getUserName(); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php }
        } else { ?>
            <div class="errorMessage"> You haven't made any friends yet. </div><br>
        <?php } ?>
    </div>
</div>


<script>
    document.title = "Connections";
</script>