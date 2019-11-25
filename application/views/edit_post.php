<style>

    .submit-button {
        text-align: center;
    }

    .posts {
        min-height: 100px;
        font-size: 14px;
    }

    .postAvatarImage img {
        border-radius: 50%;
        width: 50px;
    }

    .postAvatarImage p {
        color: dimgrey;
    }

    ul {
        margin: 0;
        padding: 0;
    }

    .errorMessage {
        color: red;
    }

</style>

<div class="ui vertically divided grid">
    <div class="three column row">
        <div class="column"></div>
        <div class="column">
            <div class="ui container segment">
                <?php echo validation_errors(); ?>

                <?php echo form_open(site_url('/SiteController/updatePost/' . $posts[0]->getPostId())); ?>

                    <div class="ui form">
                        <div class="field">
                            <label>Post Content</label>
                            <textarea spellcheck="false" id="postContent" name="postContent" required><?php echo $posts[0]->getRawPostContent(); ?></textarea>
                        </div>
                        <div class="submit-button">
                            <button class="ui grey button" type="submit">Post</button>
                        </div>

                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
        <div class="column"></div>
    </div>
</div>

<script>
    document.title = "Edit Post";
</script>