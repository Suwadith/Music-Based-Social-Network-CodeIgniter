<!--<h1>--><?php //echo $this->session->username; ?><!--</h1>-->

<form class="profile_form" action="<?php echo site_url('/SiteController/createProfile'); ?>" method="post">
    <input type="text" id="profileName" name="profileName" placeholder="Profile Name">
    <input type="url" id="avatarUrl" name="avatarUrl" placeholder="https://i.imgur.com/MI8uxnl.jpg">
    <div class="ui fluid multiple search selection dropdown">
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

<script>
    $('.ui.dropdown').dropdown();
</script>
