<?php
/**
 * Created by PhpStorm.
 * User: Suwadith
 * Date: 11/17/2019
 * Time: 2:20 AM
 */

class Genre extends CI_Model {

    public $userId;
    public $likedGenres;

    /**
     * Genre constructor.
     * @param $userId
     * @param $likedGenres
     *
     * adding genres to the genre table of a specific user using his user id.
     */
    public function setGenres($userId, $likedGenres) {
        $this->userId = $userId;
        $this->likedGenres = implode(', ', (array) $likedGenres);
    }

    /**
     * @return mixed
     *
     * Return liked genres and returns empty string if genre hasn't been set by the user.
     */
    public function getLikedGenres() {

        if($this->likedGenres !== NULL) {
            return $this->likedGenres;

        }else {
            return '';
        }
    }

    /**
     * @return string
     *
     * Capitalizing the file letter of each favorite genre and returning them to display on user's profile page.
     */
    public function getTransformedLikedGenres() {

        if($this->likedGenres !== NULL) {
            $output = '';
            $genreArray = explode(',', $this->likedGenres);

            foreach ($genreArray as $genre) {
                $output .= ucfirst($genre). ', ';
            }

            return rtrim($output, ", ");

        } else {
            return '';
        }
    }

}