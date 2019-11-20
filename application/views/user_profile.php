<style>
    .input {
        min-width: 40%;
    }

    .profile_form {
        text-align: center;
    }

</style>

<div class="ui segment">
    <form class="profile_form" action="<?php echo site_url('/SiteController/createProfile'); ?>" method="post">
        <div class="ui segment ui input focus">
            <input type="text" id="profileName" name="profileName" placeholder="Profile Name" value="<?php echo $userDbProfileData[0]->getProfileName(); ?>">
        </div>
        <div class="ui segment ui input focus">
            <input type="email" id="emailAddress" name="emailAddress" placeholder="Email (suwadith@gmail.com)" value="<?php echo $userDbProfileData[0]->getUserEmail(); ?>">
        </div>
        <div class="ui segment ui input focus">
            <input type="url" id="avatarUrl" name="avatarUrl" placeholder="Image URL (https://i.imgur.com/MI8uxnl.jpg)" value="<?php echo $userDbProfileData[0]->getAvatarUrl(); ?>">
        </div>
        <div class="ui segment ui input focus">
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
        </div>
        <br><br>
        <button class="ui grey button" type="submit">Submit</button>
        <br><br>
    </form>

    <div class="profile_form">
        <a style="text-align: center" href="<?php echo site_url('/SiteController/deleteProfile'); ?>">
            <button class="ui red button">Delete Account</button>
        </a>
    </div>


</div>

<script language="javascript">
    document.title = "Profile";
</script>


<script>
    $('.ui.dropdown').dropdown();

    $('.ui .input').on('click', function () {
        $('.ui .input').removeClass('active');
        $(this).addClass('active');
    });
</script>
