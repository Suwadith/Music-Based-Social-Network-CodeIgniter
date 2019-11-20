<!--<form class="login_form" action="--><?php //echo site_url('/SiteController/loginUser'); ?><!--" method="post">-->
<!--    <input type="text" name="username" id="username" placeholder="username" required>-->
<!--    <input type="password" name="password" id="password" placeholder="password" required>-->
<!--    <input type="submit">-->
<!--    <a href="--><?php //echo site_url('/SiteController/registration'); ?><!--">Register</a>-->
<!--</form>-->

<style type="text/css">
    body {
        background-color: #DADADA;
    }
    body > .grid {
        height: 100%;
    }
    .image {
        margin-top: -100px;
    }
    .column {
        max-width: 450px;
    }
</style>

<div class="ui middle aligned center aligned grid" >
    <div class="column">
        <h2 class="ui teal image header">
            <div class="content">
                Log-in to your account
            </div>
        </h2>
        <form class="ui large form" action="<?php echo site_url('/SiteController/loginUser'); ?>" method="post" id="login_form">
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="text" name="username" id="username" placeholder="Username">
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="password" placeholder="Password">
                    </div>
                </div>
<!--                <div class="ui fluid large teal submit button">-->
                <button class="ui fluid large teal submit button" type="submit" form="login_form" value="Submit">Submit</button>
<!--            </div>-->
            </div>

            <div class="ui error message"></div>

        </form>

        <div class="ui message">
            New to us? <a href="<?php echo site_url('/SiteController/registration'); ?>">Sign Up</a>
        </div>
    </div>
</div>