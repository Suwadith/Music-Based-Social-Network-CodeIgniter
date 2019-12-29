<style type="text/css">
    body {
        background-color: #DADADA;
    }

    body {
        margin-top: 2%;
        margin-left: 5%;
        margin-right: 5%;
    }

</style>
<div class="ui secondary pointing menu">
    <a class="item" href="<?php echo site_url('/SiteController/timelinePage'); ?>">
        Timeline
    </a>
    <a class="item" href="<?php echo site_url('/SiteController/homePage'); ?>">
        Home
    </a>
    <a class="item" href="<?php echo site_url('/SiteController/searchPage'); ?>">
        Search
    </a>
    <a class="item" href="<?php echo site_url('/SiteController/connections'); ?>">
        Connections
    </a>
    <a class="item" href="<?php echo site_url('/SiteController/contactsList'); ?>">
        Contacts List
    </a>
    <div class="right menu">
        <a class="ui item" href="<?php echo site_url('/UserController/logoutUser'); ?>">
            Logout
        </a>
    </div>
</div>

