<form class="create_post_form" action="<?php echo site_url('/SiteController/createPost'); ?>" method="post">
    <input type="text" id="postContent" name="postContent">
    <input type="submit">
</form>

<div class="load_posts">
    <?php if($posts !== null) { ?>
    <ul>
        <?php foreach ($posts as $obj) { ?>
            <li>
                <?php echo $obj->getPostContent(); ?>
            </li>
        <?php } ?>
    </ul>
    <?php }; ?>
</div>