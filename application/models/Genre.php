<?php
/**
 * Created by PhpStorm.
 * User: Suwadith
 * Date: 11/17/2019
 * Time: 2:20 AM
 */

class Genre
{

    public $userId;
    public $likedGenres;

    /**
     * Genre constructor.
     * @param $userId
     * @param $likedGenres
     */
    public function setGenres($userId, $likedGenres) {
        $this->userId = $userId;
        $this->likedGenres = implode(', ', (array) $likedGenres);
    }

    /**
     * @return mixed
     */
    public function getLikedGenres() {

        if($this->likedGenres !== NULL) {
            return $this->likedGenres;

        }else {
            return '';
        }
    }


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