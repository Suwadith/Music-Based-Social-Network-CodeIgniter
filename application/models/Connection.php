<?php
/**
 * Created by PhpStorm.
 * User: Suwadith
 * Date: 11/20/2019
 * Time: 6:55 PM
 */

class Connection {

    public $currentUserId;
    public $followingUserId;

    public function setUserIds($currentUserId, $followingUserId) {
        $this->currentUserId = $currentUserId;
        $this->followingUserId = $followingUserId;
    }

}