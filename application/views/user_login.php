<form class="login_form" action="<?php echo site_url('/SiteController/loginUser'); ?>" method="post">
    <input type="text" name="username" id="username" placeholder="username" required>
    <input type="password" name="password" id="password" placeholder="password" required>
    <input type="submit">
    <a href="<?php echo site_url('/SiteController/registration'); ?>">Register</a>
</form>