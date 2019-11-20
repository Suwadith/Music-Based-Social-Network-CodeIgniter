<form class="search_users" action="<?php echo site_url('/SiteController/searchUser'); ?>" method="post">
    <div class="ui fluid search selection dropdown">
        <input type="hidden" name="genres" id="genres">
        <i class="dropdown icon"></i>
        <div class="default text">Select Genres</div>
        <div class="menu">
            <div class="item" data-value="rock">Rock</div>
            <div class="item" data-value="jazz">Jazz</div>
            <div class="item" data-value="dubstep">Dubstep</div>
            <div class="item" data-value="techno">Techno</div>
            <div class="item" data-value="country">Country</div>
            <div class="item" data-value="electro">Electro</div>
            <div class="item" data-value="pop">Pop</div>
        </div>
    </div>
    <input type="submit">
</form>

<div class="load_users">
    <?php if($usersList["result"] !== null) {
//        print_r($usersList);?>
        <ul>
            <?php foreach ($usersList["result"] as $obj): ?>

                <?php
                $userId = $obj->getUserId();
                ?>

                <li>
                    <!--                    --><?php //echo $obj->getProfileName(), ' ', $obj->getUserId(); ?>
                    <a href="<?php echo site_url('/SiteController/viewUserProfile/') . $userId ?>"><?php echo $obj->getProfileName() ?></a>


                    <?php if (in_array($userId, $usersList["relations"])): ?>
                        <a class="unfollow_user" href="<?php echo site_url('/SiteController/unfollowUser/') . $userId ?>">Unfollow</a>
                    <?php else: ?>
                        <a class="follow_user" href="<?php echo site_url('/SiteController/followUser/') . $userId ?>">Follow</a>
                    <?php endif; ?>
                    <!--                    <a class="follow_user" href="--><?php //echo site_url('/SiteController/followUser/') . $obj->getUserId(); ?><!--">Follow</a>-->
                    <!--                    <a class="unfollow_user" href="--><?php //echo site_url('/SiteController/unfollowUser/') . $obj->getUserId(); ?><!--">Unfollow</a>-->
                </li>
            <?php endforeach; ?>
        </ul>
    <?php }; ?>
</div>

<script>
    $('.ui.dropdown').dropdown();
</script>
