<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/7
 * Time: 10:04
 */
namespace App\Http\Controllers\Admin\Site;

use App\helpers\CommonHelper;
use App\Models\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Controller;
use App\Repositories\Eloquent\SiteRepositoryEloquent;
use Illuminate\Support\Facades\Config;

Class SiteController extends Controller
{
    protected $siteRepositoryEloquent;

    public function __construct(SiteRepositoryEloquent $siteRepositoryEloquent)
    {
        $this->siteRepositoryEloquent = $siteRepositoryEloquent;
    }

    /*
     * 首页
     * */
    public function index(Request $request)
    {
        $set_all = $this->siteRepositoryEloquent->getProduceList($request);
        $params = $request->all();
        if($set_all->toArray()['total'] === 0){
            $url = Config::get('site-config')['api_url'];
            $body = json_decode(CommonHelper::getMethod($url),true);
            foreach ($body['result'] as $item){
                $this->siteRepositoryEloquent->insertSite($item);
            }
        }
        return view('admin.site.site.site_list', compact('set_all','params'));
    }

    /*
     * 更新站点
     */
    public function updateSite(){
        $url = Config::get('site-config')['api_url'];
        $body = json_decode(CommonHelper::getMethod($url),true);
        $res = $this->siteRepositoryEloquent->updateSite($body['result']);
        return response()->json(['code'=>$res?1:0,'msg'=>$res?'更新成功！':'更新失败！']);
    }

    /*
     * 站点在线
     */
    public function getSiteOnlineInfo(Request $request){
        $site_ids = $request->get('site_id',[]);
        $url = Config::get('site-config')['site_online_api_url'];
        $site = Site::whereIn('id',$site_ids)->get();
        $urls = [];
        foreach ($site as $item){
            array_push($urls,$item->site_unique_key.$url);
        }
        $res= CommonHelper::httpPool($urls);
        return response()->json(['code'=>1,'msg'=>'操作成功！','data'=>$res]);
    }

    /*
     * 保存测试
     * */
    public function saveSet($id, Request $request)
    {
        $result = $this->adminSettingRepositoryEloquent->saveSet($id, $request);
        if ($result) {
            $data = [
                'code' => 0,
                'message' => '成功'
            ];
        } else {
            $data = [
                'code' => 1,
                'message' => '修改失败'
            ];
        }
        return response()->json($data);
    }
    
}