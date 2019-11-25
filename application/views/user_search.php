<style>

    .ui.fluid.inner.search.selection.dropdown {
        max-width: 60%;
    }

    .move {
        padding-left: 30%;
    }

    .errorMessage {
        color: red;
    }

</style>

<div class="ui raised very padded text container segment center aligned">
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

<?php if (!empty($usersList[0]) OR !empty($usersList[1])) { ?>
<div class="ui raised very padded text container segment">
    <div class="ui middle aligned divided list">
        <?php foreach ($usersList[0] as $key => $value) { ?>
            <div class="item">
                <div class="right floated content">
                    <a class="follow_user" href="<?php echo site_url('/SiteController/unfollowUser/') . $key; ?>">
                        <div class="ui button red">Unfollow</div>
                    </a>
                </div>
                <div class="content">
                    <a href="<?php echo site_url('/SiteController/viewUserProfile/') . $key ?>"><?php echo $value; ?></a>
                </div>
            </div>
        <?php } ?>
        <?php foreach ($usersList[1] as $key => $value) { ?>
            <div class="item">
                <div class="right floated content">
                    <a class="follow_user" href="<?php echo site_url('/SiteController/followUser/') . $key; ?>">
                        <div class="ui button blue">Follow</div>
                    </a>
                </div>
                <div class="content">
                    <a href="<?php echo site_url('/SiteController/viewUserProfile/') . $key ?>"><?php echo $value; ?></a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php } elseif (!empty($usersList[2])) { ?>
    <div class="ui raised very padded text container segment">
        <div class="ui middle aligned divided list">
            <?php foreach ($usersList[2] as $obj) { ?>
                <div class="item">
                    <div class="right floated content">
                        <a class="follow_user"
                           href="<?php echo site_url('/SiteController/followUser/') . $obj->getUserId(); ?>">
                            <div class="ui button blue">Follow</div>
                        </a>
                    </div>
                    <div class="content">
                        <a href="<?php echo site_url('/SiteController/viewUserProfile/') . $obj->getUserId(); ?>"><?php echo $obj->getUsername(); ?></a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } elseif($notFound !== '') { ?>
<div class="ui raised very padded text container segment center aligned">
    <div class="errorMessage"> <?php echo $notFound ?> </div><br>
</div>
<?php } ?>
<script>
    document.title = "Search";
    $('.ui.dropdown').dropdown();
</script>
