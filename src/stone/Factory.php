<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 12/25/17
 * Time: 9:56 AM
 */

namespace diandi\stone;


class Factory
{

    public static function get($class,$type)
    {
        if (method_exists($class,'create'))  //按java的语法应该是找返回值为type类型的方法
        {
            return  function ($arg) use ($class)
            {
                return call_user_func([$class,'create'],$arg);//按java的语法应该是找返回值为type类型的方法
            };
        }
        else{
            return  function ($arg) use ($class)
            {
                return new $class($arg);
            };
        }
    }
}