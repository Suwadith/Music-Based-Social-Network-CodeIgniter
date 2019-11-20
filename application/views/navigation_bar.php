

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
    <div class="right menu">
        <a class="ui item" href="<?php echo site_url('/SiteController/logoutUser'); ?>">
            Logout
        </a>
    </div>
</div>
<style type="text/css">
    body {
        background-color: #DADADA;
    }
    body {
        margin-top: 2%;
        margin-left: 10%;
        margin-right: 10%;
    }
</style>
<!--<script>-->
<!--    $('.ui .item').on('click', function() {-->
<!--        $('.ui .item').removeClass('active');-->
<!--        $(this).addClass('active');-->
<!--    });-->
<!--</script>-->