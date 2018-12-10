<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/7
 * Time: 10:11
 */
namespace App\Repositories\Eloquent;


use App\helpers\ModelHelper;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\SiteRepository;
use App\Models\Role;
use App\Models\Site;
/**
 * Class SiteRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class SiteRepositoryEloquent extends BaseRepository implements SiteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Site::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /*
     * 获取站点
     * */
    public function getAll()
    {
        return $this->all();
    }

    public function getProduceList($request){
        $length = intval($request->get('length', 10));
        $site_name = trim($request->get('site_name',''));

        $collects = ModelHelper::getModelObject($this->model())
            ->when($site_name,function($query)use($site_name){
                return $query->where('site_info->sitename','like','%'.$site_name.'%');
            })
            ->where('type','produce')
            ->orderBy('updated_at','desc')
            ->paginate($length);
        $params = $request->all();
        $collects->appends($params);
        return $collects;
    }

    public function insertSite($data){
        
        return $this->model->insert(
            [
                'site_unique_key'=>$data['site_url'],
                'type'=>$data['env'],
                'site_info'=>json_encode($data),
                'created_at'=>date('Y-m-d H:i:s',time()),
                'updated_at'=>date('Y-m-d H:i:s',time())
            ]
        );
    }


    public function updateSite($data){
        if(empty($data)) return false;
        foreach ($data as $item){
            $find = ModelHelper::getModelObject($this->model())->where('site_unique_key',$item['site_url'])->first();
            if($find){
                $find->site_info = json_encode($item);
                $find->type = $item['env'];
                $find->updated_at = date('Y-m-d H:i:s',time());
                $find->save();
            }else{
                $this->insertSite($item);
            }
        }
        return true;
    }
    /**
     * 清除原有用户组，加入新的用户组
     * @param $user_id int 用户ID
     * @param $role_id int 权限组ID
     * @return bool
     * */
    public function editUserRole($user_id, $role_id)
    {
        $user = $this->find($user_id);
        foreach($user->roles as $role) {
            $roles[] = $role->id;
        }
        $old_role = Role::findOrfail($roles[0]);
        $new_role = Role::findOrfail($role_id);
        // 删除原用户组
        $user->detachRole($old_role);
        $user->attachRole($new_role);
        if ($user->hasRole($new_role->name)) {
            return true;
        } else {
            return false;
        }
    }
}
