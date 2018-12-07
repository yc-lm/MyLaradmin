<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/7
 * Time: 15:22
 */
namespace App\helpers;

class ModelHelper
{
    static function getModelObject($class){
        $model = new $class();
        return $model;
    }
}