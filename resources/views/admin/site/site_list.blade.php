@extends('admin.layouts.main')

{{--顶部前端资源--}}
@section('styles')

@endsection

{{--页面内容--}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE TABLE PORTLET-->
            <div class="portlet light portlet-fit portlet-datatable bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-red"></i>
                        <span class="caption-subject font-red sbold uppercase">站点管理</span>
                    </div>
                    {{-- <div class="actions">
                         <div class="btn-group">
                             <a href="{{ route('user.create') }}" class="btn green btn-outline">
                                 <i class="fa fa-edit"></i>
                                 添加权限
                             </a>
                         </div>
                     </div>--}}

                    <div class="btn-group update_site" style="padding-left:10px;">
                        <button class="btn green btn-outline">
                            更新站点<i class="fa fa-edit"></i>
                        </button>
                    </div>
                    <div class="actions search_btn">
                        <input type="text" name="site_name" placeholder="请输入站点名称" value="{{ isset($params['site_name'])?$params['site_name']:"" }}">
                        <button>搜索</button>
                    </div>
                <div class="portlet-body">
                    <div class="table-container">
                        <table class="table table-striped table-bordered table-hover" id="datatable_ajax">
                            <thead>
                            <tr role="row" class="heading">
                                <th > ID </th>
                                <th > 站点名称 </th>
                                <th > 站点url </th>
                                <th > 更新时间 </th>
                                <th > 操作 </th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($set_all as $set)
                                    <?php $site_info = json_decode($set->site_info,true); ?>
                                    <tr>
                                        <td>{{$set->id}}</td>
                                        <td title="{{$site_info['sitename']}}">{{ str_limit($site_info['sitename'],20,'...')}}</td>
                                        <td title="{{$site_info['site_url']}}">{{ str_limit($site_info['site_url'],20,'...')}}</td>
                                        <td>{{$set->updated_at}}</td>
                                        <td>
                                            <a href="">打开站点</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $set_all->links() }}
                    </div>

                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection

{{--尾部前端资源--}}
@section('script')

    <script src="{{asset('assets/admin/layouts/scripts/datatable.js')}}" type="text/javascript"></script>
    <script src="{{asset('vendor/datatables/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('vendor/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
    {{--ajax使用--}}
    <script src="{{asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
    {{--sweetalert弹窗--}}
    <script src="{{asset('assets/admin/layouts/scripts/sweetalert/sweetalert-ajax-delete.js')}}" type="text/javascript"></script>
    <script>
        //更新站点
        $(".update_site button").on('click',function(e){
            $.ajax({
                type:"get",
                url:"{{ url('admin/site/update_site') }}",
                dataType:"json",
                success:function(data){
                    alert(data.msg);
                }
            });
        });

        //搜索
        $(".search_btn button").unbind('click').bind('click',function(){
            var site_name = $("input[name='site_name']").val();
            window.location.href = "{{ url('admin/site') }}"+"?site_name="+site_name;
        });

    </script>
@endsection

