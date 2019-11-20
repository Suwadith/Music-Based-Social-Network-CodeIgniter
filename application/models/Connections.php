<?php
/**
 * Created by PhpStorm.
 * User: Suwadith
 * Date: 11/20/2019
 * Time: 6:55 PM
 */

class Connections {

    public $currentUserId;
    public $followingId;

    public function setUserIds($currentUserId, $followingId) {
        $this->currentUserId = $currentUserId;
        $this->followingId = $followingId;
    }

}