<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/7
 * Time: 10:17
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Site extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'site';
    protected $fillable = ['site_unique_key','type', 'site_info'];

}
