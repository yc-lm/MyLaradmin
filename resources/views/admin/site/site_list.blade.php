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
                    <div class="actions">
                        <div class="btn-group">
                            <a href="" class="btn green btn-outline">
                                <i class="fa fa-edit"></i>
                                更新站点
                            </a>
                        </div>
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
                                        <td>{{$site_info['sitename']}}</td>
                                        <td>{{$site_info['site_url']}}</td>
                                        <td>{{$set->updated_at}}</td>
                                        <td></td>
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

@endsection

