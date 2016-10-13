<?php

namespace Drupal\lottery\Libraries;

class SARandom {

    public function generate_code($length = 16){
        $code = '';
        while(true){
            $code = $this->str_random($length);

            $storage = \Drupal::entityTypeManager()->getStorage('prize_keys');
            $ids = $storage->getQuery()
                ->condition('status',0)
                ->condition('code',$code)
                ->execute();

            if(!count($ids)){
                break;
            }
        }

        return $code;
    }


    public function str_random($length = 16){
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            $bytes = random_bytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }

}