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
    <?php if(isset($usersList)) { ?>
        <ul>
            <?php foreach ($usersList as $obj) { ?>
                <li>
                    <?php echo $obj->getProfileName(); ?>
                </li>
            <?php } ?>
        </ul>
    <?php }; ?>
</div>

<script>
    $('.ui.dropdown').dropdown();
</script>
