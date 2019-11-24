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

    .errorMessage {
        color: red;
    }

</style>

<div class="ui middle aligned center aligned grid">
    <div class="column">
        <h2 class="ui teal image header">
            <div class="content">
                Registration
            </div>
        </h2>

        <?php echo validation_errors(); ?>

        <?php echo form_open(site_url('/UserController/registerUser')); ?>
        <div class="ui large form">
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="text" name="username" id="username" placeholder="Username" required>
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="email" name="emailAddress" id="emailAddress" placeholder="Email Address" required>
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" id="confirmPassword" name="confirmPassword"
                               placeholder="Confirm Password" required>
                    </div>
                </div>
                <button class="ui fluid large teal submit button" type="submit" value="Submit">
                    Submit
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>

        <div class="ui message">
            Already have an account? <a href="<?php echo site_url('/UserController/login'); ?>">Login</a>
        </div>
    </div>
</div>

<script>
    document.title = "Registration";
</script>