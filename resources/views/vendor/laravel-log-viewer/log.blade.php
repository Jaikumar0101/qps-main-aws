@extends('layouts.admin.app')
@push('head')
    <style>
        body {
            padding: 25px;
        }

        h1 {
            font-size: 1.5em;
            margin-top: 0;
        }

        #table-log {
            font-size: 0.85rem;
        }

        .sidebar {
            font-size: 0.85rem;
            line-height: 1;
        }

        .btn {
            font-size: 0.7rem;
        }

        .stack {
            font-size: 0.85em;
        }

        .date {
            min-width: 75px;
        }

        .text {
            word-break: break-all;
        }

        a.llv-active {
            z-index: 2;
            background-color: #f5f5f5;
            border-color: #777;
        }

        .list-group-item {
            word-break: break-word;
        }

        .folder {
            padding-top: 15px;
        }

        .div-scroll {
            height: 80vh;
            overflow: hidden auto;
        }
        .nowrap {
            white-space: nowrap;
        }
        .list-group {
            padding: 5px;
        }

    </style>
@endpush
@section('content')
    {!! AdminBreadCrumb::Load(['title'=>"Error Logs",'menu'=>[ ['name'=>trans('Server'),'url'=>'#'],['name'=>'Logs','active'=>true] ],'full-width'=>true]) !!}
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="row">
                <div class="col sidebar mb-3">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h1 class="card-title">
                                <i class="fa fa-calendar" aria-hidden="true"></i> &nbsp;&nbsp;Log Viewer
                            </h1>
                        </div>
                        <div class="card-body p-2">
                            <ul class="list-group div-scroll">
                                @foreach($folders as $folder)
                                    <div class="list-group-item">
                                            <?php
                                            \Rap2hpoutre\LaravelLogViewer\LaravelLogViewer::DirectoryTreeStructure( $storage_path, $structure );
                                            ?>
                                    </div>
                                @endforeach
                                @foreach($files as $file)
                                    <a href="?l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}"
                                       class="list-group-item @if ($current_file == $file) active @endif">
                                        {{$file}}
                                    </a>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-10">
                    <div class="card">
                        <div class="card-body table-container">
                            @if ($logs === null)
                                <div class="alert alert-danger">
                                    Log file >50M, please download it.
                                </div>
                            @else
                                <table id="table-log" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" data-ordering-index="{{ $standardFormat ? 2 : 0 }}">
                                    <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                        @if ($standardFormat)
                                            <th>Level</th>
                                            <th>Context</th>
                                            <th>Date</th>
                                        @else
                                            <th>Line number</th>
                                        @endif
                                        <th>Content</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($logs as $key => $log)
                                        <tr data-display="stack{{{$key}}}">
                                            @if ($standardFormat)
                                                <td class="nowrap text-{{{$log['level_class']}}}">
                                                    <span class="fa fa-{{{$log['level_img']}}}" aria-hidden="true"></span>&nbsp;&nbsp;{{$log['level']}}
                                                </td>
                                                <td class="text">{{$log['context']}}</td>
                                            @endif
                                            <td class="date">{{{$log['date']}}}</td>
                                            <td class="text">
                                                @if ($log['stack'])
                                                    <button type="button"
                                                            class="float-end expand btn btn-outline-dark btn-sm btn-icon mb-2 ml-2"
                                                            data-display="stack{{{$key}}}">
                                                        <span class="fa fa-search"></span>
                                                    </button>
                                                @endif
                                                {{{$log['text']}}}
                                                @if (isset($log['in_file']))
                                                    <br/>{{{$log['in_file']}}}
                                                @endif
                                                @if ($log['stack'])
                                                    <div class="stack" id="stack{{{$key}}}"
                                                         style="display: none; white-space: pre-wrap;">{{{ trim($log['stack']) }}}
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                            <div class="p-3">
                                @if($current_file)
                                    <a href="?dl={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                        <span class="fa fa-download"></span> Download file
                                    </a>
                                    -
                                    <a id="clean-log" href="?clean={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                        <span class="fa fa-sync"></span> Clean file
                                    </a>
                                    -
                                    <a id="delete-log" href="?del={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                        <span class="fa fa-trash"></span> Delete file
                                    </a>
                                    @if(count($files) > 1)
                                        -
                                        <a id="delete-all-log" href="?delall=true{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                            <span class="fa fa-trash-alt"></span> Delete all files
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script data-navigate-once>
        document.addEventListener('livewire:navigated', () => {
            const logTable = $('#table-log');
            $(document).ready(function () {
                $('.table-container tr').on('click', function () {
                    $('#' + $(this).data('display')).toggle();
                });
                logTable.DataTable({
                    "language": {
                        "lengthMenu": "Show _MENU_",
                    },
                    "dom":
                        "<'row'" +
                        "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                        "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                        ">" +

                        "<'table-responsive'tr>" +

                        "<'row'" +
                        "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                        "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                        ">"
                    ,
                    "order": [logTable.data('orderingIndex'), 'desc'],
                    "stateSave": true,
                    "stateSaveCallback": function (settings, data) {
                        window.localStorage.setItem("datatable", JSON.stringify(data));
                    },
                    "stateLoadCallback": function (settings) {
                        var data = JSON.parse(window.localStorage.getItem("datatable"));
                        if (data) data.start = 0;
                        return data;
                    }
                });
                $('#delete-log, #clean-log, #delete-all-log').click(function () {
                    return confirm('Are you sure?');
                });
            });
        })
    </script>
@endpush
