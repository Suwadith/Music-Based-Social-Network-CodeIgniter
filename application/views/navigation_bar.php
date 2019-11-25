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
    <a class="item" href="<?php echo base_url('/user/timeline'); ?>">
        Timeline
    </a>
    <a class="item" href="<?php echo base_url('/user/home'); ?>">
        Home
    </a>
    <a class="item" href="<?php echo base_url('/user/search'); ?>">
        Search
    </a>
    <a class="item" href="<?php echo base_url('/user/connections'); ?>">
        Connections
    </a>
    <div class="right menu">
        <a class="ui item" href="<?php echo base_url('/user/logout'); ?>">
            Logout
        </a>
    </div>
</div>

