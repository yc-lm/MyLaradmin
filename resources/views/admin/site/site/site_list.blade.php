@extends('admin.layouts.main')

{{--顶部前端资源--}}
@section('styles')

@endsection

{{--页面内容--}}
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

                    <div class="btn-group" style="padding-left:10px;">
                        <button class="btn green btn-outline">
                            全国站点在线<i class="fa"></i>
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
                                        <td title="{{$site_info['site_url']}}">{{ $site_info['site_url']}}</td>
                                        <td>{{$set->updated_at}}</td>
                                        <td>
                                            <a href="javascript:void(0)" data-url="{{$site_info['site_url']}}" style="color: #337AB7;padding-right: 5px;" class="jump_to_site">跳转</a>
                                            <a href="javascript:void(0)" data-id="{{$set->id}}" style="color: #337AB7;" class="site_online_info">站点在线</a>
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
    <div class="online_box  dis_none">
        <div class="box_content" style="width: 360px;height: 500px;">

        </div>
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
    <script type="text/javascript" src="{{asset('js/layer/layer.js')}}"></script>
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

        //跳转
        $(".jump_to_site").unbind('click').bind('click',function(){
            var url = $(this).attr('data-url');
            let a = $("<a href='"+url+"/index.php?r=admin/index/index' target='_blank'>admin</a>").get(0);
            let e = document.createEvent('MouseEvents');
            e.initEvent( 'click', true, true );
            a.dispatchEvent(e);
        });

        //统计站点在线
        $(".site_online_info").unbind('click').bind('click',function(){
            var site_id = parseInt($(this).attr('data-id'));
            var arr = new Array();
            arr.push(site_id);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"post",
                data:{site_id:arr},
                url:"{{ url('admin/site/get_site_online_info') }}",
                dataType:"json",
                success:function(data){
                    console.log(data);
                    //自定页
                    console.log($('.del_confirm')[0])
                    layer.open({
                        type: 1,
                        skin: '', //样式类名
                        closeBtn: 1, //不显示关闭按钮
                        anim: 2,
                        shadeClose: true, //开启遮罩关闭
                        content: $('.online_box')
                    });


                },
                error: function (data) {
                    alert('操作失败');
                }
            });
        });
    </script>
@endsection

