@extends('layouts.admin.app')

@section('content')
    {!! AdminBreadCrumb::Load(['title'=>"Server Details",'menu'=>[ ['name'=>trans('Server'),'url'=>'#'],['name'=>'Information','active'=>true] ]]) !!}
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-body">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                            <tr>
                                <th colspan="3" class="fw-bold">Software</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="w-25px">
                                    <i class="bi bi-display"></i>
                                </td>
                                <td class="w-100px">OS</td>
                                <td>{{ Arr::get($data,'server.software.os') ??''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25px">
                                    <i class="bi bi-info-circle"></i>
                                </td>
                                <td class="w-100px">Version</td>
                                <td>{{ Arr::get($data,'server.software.distro') ??''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25px">
                                    <i class="bi bi-cpu"></i>
                                </td>
                                <td class="w-100px">Kernel</td>
                                <td>{{ Arr::get($data,'server.software.kernel') ??''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25px">
                                    <i class="bi bi-collection"></i>
                                </td>
                                <td class="w-100px">Architecture</td>
                                <td>{{ Arr::get($data,'server.software.arc') ??''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25px">
                                    <i class="bi bi-hdd-network"></i>
                                </td>
                                <td class="w-100px">Web Server</td>
                                <td>{{ Arr::get($data,'server.software.webserver') ??''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25px">
                                    <i class="bi bi-info"></i>
                                </td>
                                <td class="w-100px">Version</td>
                                <td>{{ Arr::get($data,'server.software.php') ??''}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-body">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                            <tr>
                                <th colspan="3" class="fw-bold">Hardware</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="w-25px">
                                    <i class="bi bi-cpu-fill"></i>
                                </td>
                                <td class="w-100px">CPU</td>
                                <td>{{ Arr::get($data,'server.hardware.cpu') ??''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25px">
                                    <i class="bi bi-kanban"></i>
                                </td>
                                <td class="w-100px">Threads</td>
                                <td>{{ Arr::get($data,'server.hardware.cpu_count') ??''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25px">
                                    <i class="bi bi-info-circle"></i>
                                </td>
                                <td class="w-100px">Model</td>
                                <td>{{ Arr::get($data,'server.hardware.model') ??''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25px">
                                    <i class="bi bi-badge-vr-fill"></i>
                                </td>
                                <td class="w-100px">Virtualization</td>
                                <td>{{ Arr::get($data,'server.hardware.virtualization') ??''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25px">
                                    <i class="bi bi-clock"></i>
                                </td>
                                <td class="w-100px">Up Time</td>
                                <td>{{ Arr::get($data,'server.uptime.uptime') ??''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25px">
                                    <i class="bi bi-calendar-check"></i>
                                </td>
                                <td class="w-100px">Booted At</td>
                                <td>{{ Arr::get($data,'server.uptime.booted_at') ??''}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-body">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                            <tr>
                                <th colspan="3" class="fw-bold">Database & Space</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="w-25px">
                                    <i class="bi bi-server"></i>
                                </td>
                                <td class="w-100px">Driver</td>
                                <td>{{ Arr::get($data,'database.driver') ??''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25px">
                                    <i class="bi bi-info-circle"></i>
                                </td>
                                <td class="w-100px">Version</td>
                                <td>{{ Arr::get($data,'database.version') ??''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25px">
                                    <i class="bi bi-hdd-fill"></i>
                                </td>
                                <td class="w-100px">Disk Total</td>
                                <td>{{ Arr::get($data,'server.hardware.disk.human_total') ??''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25px">
                                    <i class="bi bi-hdd"></i>
                                </td>
                                <td class="w-100px">Disk Free</td>
                                <td>{{ Arr::get($data,'server.hardware.disk.human_free') ??''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25px">
                                    <i class="bi bi-hdd-stack-fill"></i>
                                </td>
                                <td class="w-100px">Ram Total</td>
                                <td>{{ Arr::get($data,'server.hardware.ram.human_total') ??''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25px">
                                    <i class="bi bi-hdd-stack"></i>
                                </td>
                                <td class="w-100px">Ram Free</td>
                                <td>{{ Arr::get($data,'server.hardware.ram.human_free') ??''}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

