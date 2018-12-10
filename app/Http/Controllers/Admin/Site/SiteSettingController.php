<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/10
 * Time: 11:00
 */
namespace App\Http\Controllers\Admin\Site;
use App\Http\Controllers\Admin\Controller;

class SiteSettingController extends Controller
{
    public function index(){
        return view('admin.site.site_setting.index');
    }
}