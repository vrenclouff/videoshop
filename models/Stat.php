<?php

class Stat
{
        private static $arr = array();

        public static function push($val){
//            array_push(self::$arr, $val);
            self::$arr[$val] = $val;
            print_r(self::$arr);
        }

        public static function getArr(){
            return serlf::$arr;
        }
}

?>