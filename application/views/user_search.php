<style>

    .ui.fluid.inner.search.selection.dropdown {
        max-width: 60%;
    }

    .move {
        padding-left: 30%;
    }

</style>


<div class="ui segment center aligned">
    <form class="search_users" action="<?php echo site_url('/SiteController/searchUser'); ?>" method="post">
        <div class="move">
            <div class="ui fluid inner search selection dropdown">
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
        </div>

        <br><br>
        <button class="ui grey button" type="submit">Search</button>
    </form>
</div>


<?php //if ($usersList["result"] !== null) {
////        print_r($usersList);?>
<!--    <div class="ui segment">-->
<!--        <ul>-->
<!--            --><?php //foreach ($usersList["result"] as $obj): ?>
<!---->
<!--                --><?php
//                $userId = $obj->getUserId();
//                ?>
<!---->
<!--                <li>-->
<!--                    <!--                    --><?php ////echo $obj->getProfileName(), ' ', $obj->getUserId(); ?>
<!--                    <a href="--><?php //echo site_url('/SiteController/viewUserProfile/') . $userId ?><!--">--><?php //echo $obj->getProfileName() ?><!--</a>-->
<!---->
<!---->
<!--                    --><?php //if (in_array($userId, $usersList["relations"])): ?>
<!--                        <a class="unfollow_user"-->
<!--                           href="--><?php //echo site_url('/SiteController/unfollowUser/') . $userId ?><!--">-->
<!--                            <button class="ui red button">Unfollow</button>-->
<!--                        </a>-->
<!--                    --><?php //else: ?>
<!--                        <a class="follow_user" href="--><?php //echo site_url('/SiteController/followUser/') . $userId ?><!--">-->
<!--                            <button class="ui blue button">Follow</button>-->
<!--                        </a>-->
<!--                    --><?php //endif; ?>
<!--                    <!--                    <a class="follow_user" href="-->
<!--                    --><?php ////echo site_url('/SiteController/followUser/') . $obj->getUserId(); ?><!--<!--">Follow</a>-->
<!--                    <!--                    <a class="unfollow_user" href="-->
<!--                    --><?php ////echo site_url('/SiteController/unfollowUser/') . $obj->getUserId(); ?><!--<!--">Unfollow</a>-->
<!--                </li>-->
<!--            --><?php //endforeach; ?>
<!--        </ul>-->
<!--    </div>-->
<?php //}; ?>

<?php if (!empty($usersList[0]) OR !empty($usersList[1])) { ?>
    <div class="ui segment">
        <ul>
            <?php foreach ($usersList[0] as $key => $value) { ?>

                <li>
                    <a href="<?php echo site_url('/SiteController/viewUserProfile/') . $key ?>"><?php echo $value; ?></a>
                    <a class="unfollow_user" href="<?php echo site_url('/SiteController/unfollowUser/') . $key; ?>">
                        <button class="ui red button">Unfollow</button>
                    </a>
                </li>
            <?php } ?>
            <?php foreach ($usersList[1] as $key => $value) { ?>
                <li>
                    <a href="<?php echo site_url('/SiteController/viewUserProfile/') . $key ?>"><?php echo $value; ?></a>
                    <a class="follow_user" href="<?php echo site_url('/SiteController/followUser/') . $key; ?>">
                        <button class="ui blue button">Follow</button>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } elseif (!empty($usersList[2])) { ?>
    <div class="ui segment">
        <ul>
            <?php foreach ($usersList[2] as $obj) { ?>
                <li>
                    <a href="<?php echo site_url('/SiteController/viewUserProfile/') . $obj->getUserId(); ?>"><?php echo $obj->getUsername(); ?></a>
                    <a class="follow_user"
                       href="<?php echo site_url('/SiteController/followUser/') . $obj->getUserId(); ?>">
                        <button class="ui blue button">Follow</button>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>


<script>
    $('.ui.dropdown').dropdown();
</script>
