<div>
    {!! AdminBreadCrumb::Load(['title'=>trans('Dashboard'),'menu'=>[['name'=>trans('Dashboard'),'active'=>true] ],'full-width'=>true]) !!}
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="row g-5 g-xl-8">
                @can('claim::list')
                    <div class="col-xl-3">
                        <!--begin::Statistics Widget 5-->
                        <a href="{{ route('admin::insurance-claim:list') }}" wire:navigate class="card bg-site-light-blue hoverable card-xl-stretch mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body">
                                <i class="ki-duotone ki-chart-simple text-white fs-2x ms-n1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                </i>
                                <div class="text-white fw-bold fs-2 mb-2 mt-5">{{ $rowData['claims'] ??0 }}</div>
                                <div class="fw-semibold text-white">Insurance Claims</div>
                            </div>
                            <!--end::Body-->
                        </a>
                        <!--end::Statistics Widget 5-->
                    </div>
                @endcan
                @can('client::list')
                <div class="col-xl-3">
                    <!--begin::Statistics Widget 5-->
                    <a href="{{ route('admin::customers:list') }}" wire:navigate class="card bg-site-blue hoverable card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <i class="ki-duotone ki-cheque text-gray-100 fs-2x ms-n1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                                <span class="path6"></span>
                                <span class="path7"></span>
                            </i>
                            <div class="text-gray-100 fw-bold fs-2 mb-2 mt-5">{{ $rowData['customers'] ??0 }}</div>
                            <div class="fw-semibold text-gray-100">Clients</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
                @endcan
                @can('claim::list')
                <div class="col-xl-3">
                    <!--begin::Statistics Widget 5-->
                    <a href="{{ route('admin::insurance-claim:list') }}" wire:navigate class="card bg-warning hoverable card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <i class="ki-duotone ki-briefcase text-white fs-2x ms-n1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <div class="text-white fw-bold fs-2 mb-2 mt-5">{{ currency($rowData['total'] ??0) }}</div>
                            <div class="fw-semibold text-white">Total Claim Amount</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
                <div class="col-xl-3">
                    <!--begin::Statistics Widget 5-->
                    <a href="{{ route('admin::insurance-claim:list') }}" wire:navigate class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <i class="ki-duotone ki-chart-pie-simple text-white fs-2x ms-n1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <div class="text-white fw-bold fs-2 mb-2 mt-5">{{ $rowData['completed'] ??0 }}</div>
                            <div class="fw-semibold text-white">Claim Approved</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
                @endcan
            </div>

            @can('charts::access')
                <div class="row g-5 g-xl-8">
                    <div class="col-md-7">
                        <!--begin::Charts Widget 3-->
                        <div class="card card-xl-stretch mb-xl-8">
                            <!--begin::Header-->
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold fs-3 mb-1">Insurance Claims</span>
                                    <span class="text-muted fw-semibold fs-7">Showing the recently created claims</span>
                                </h3>
                                <!--begin::Toolbar-->
                                <div class="card-toolbar d-none" data-kt-buttons="true">
                                    <a class="btn btn-sm btn-color-muted btn-active btn-active-primary active px-4 me-1" id="kt_charts_widget_3_year_btn">Year</a>
                                    <a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1" id="kt_charts_widget_3_month_btn">Month</a>
                                    <a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4" id="kt_charts_widget_3_week_btn">Week</a>
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin::Chart-->
                                <div id="kt_charts_widget_4_chart" style="height: 350px"></div>
                                <!--end::Chart-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Charts Widget 3-->
                    </div>
                    <div class="col-md-5" wire:ignore>
                        <div class="card card-xl-stretch mb-xl-8">
                            <!--begin::Header-->
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold fs-3 mb-1">Claims Amount</span>
                                    <span class="text-muted fw-semibold fs-7">Showing the total amount of closed claims over the years</span>
                                </h3>
                            </div>
                            <!--end::Header-->
                            <div class="card-body">
                                <canvas id="kt_pie_chart_total" style="max-height: 350px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>

@can('charts::access')

@push('scripts')
    <script src="{{ asset('assets/backend/assets/js/custom/apps/chat/chat.js') }}" data-navigate-once></script>
@endpush

@script
    <script >
        let element2 = document.getElementById('kt_charts_widget_4_chart');

        const labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
        const borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
        const baseColor = KTUtil.getCssVariableValue('--bs-info');
        const lightColor = KTUtil.getCssVariableValue('--bs-light-info');

        const height2 = parseInt(KTUtil.css(element2, 'height'));
        const labelColor2 = KTUtil.getCssVariableValue('--bs-gray-500');
        const borderColor2 = KTUtil.getCssVariableValue('--bs-gray-200');
        const baseColor2 = KTUtil.getCssVariableValue('--bs-info');
        const lightColor2 = KTUtil.getCssVariableValue('--bs-light-info');

        const options2 = {
            series: [{
                name: 'Claims',
                data: @json($chartData['data'])
            }],
            chart: {
                fontFamily: 'inherit',
                type: 'area',
                height: height2,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {

            },
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            fill: {
                type: 'solid',
                opacity: 1
            },
            stroke: {
                curve: 'smooth',
                show: true,
                width: 3,
                colors: [baseColor2]
            },
            xaxis: {
                categories: @json($chartData['months']),
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        colors: labelColor2,
                        fontSize: '12px'
                    }
                },
                crosshairs: {
                    position: 'front',
                    stroke: {
                        color: baseColor2,
                        width: 1,
                        dashArray: 3
                    }
                },
                tooltip: {
                    enabled: true,
                    formatter: undefined,
                    offsetY: 0,
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: labelColor2,
                        fontSize: '12px'
                    }
                }
            },
            states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
            tooltip: {
                style: {
                    fontSize: '12px'
                },
                y: {
                    formatter: function (val) {
                        return val
                    }
                }
            },
            colors: [lightColor],
            grid: {
                borderColor: borderColor2,
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            markers: {
                strokeColor: baseColor2,
                strokeWidth: 3
            }
        };

        const chart2 = new ApexCharts(element2, options2);
        chart2.render();
    </script>
@endscript

@script
<script>
    const ctxPie = document.getElementById('kt_pie_chart_total').getContext('2d');

    // Define colors
    const primaryColor = KTUtil.getCssVariableValue('--bs-primary');
    const dangerColor = KTUtil.getCssVariableValue('--bs-danger');
    const successColor = KTUtil.getCssVariableValue('--bs-success');
    const warningColor = KTUtil.getCssVariableValue('--bs-warning');
    const infoColor = KTUtil.getCssVariableValue('--bs-info');

    // Define fonts
    const fontFamily = KTUtil.getCssVariableValue('--bs-font-sans-serif');

    // Chart labels
    const labelsPie = @js($pieCharData['labels']);

    // Chart data
    const dataPie = {
        labels: labelsPie,
        datasets: [{
            data: @js($pieCharData['data']),
            backgroundColor: [primaryColor, dangerColor, successColor, warningColor, infoColor]
        }]
    };

    // Chart config
    const configPie = {
        type: 'pie',
        data: dataPie,
        options: {
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        font: {
                            family: fontFamily
                        }
                    }
                },
                title: {
                    display: false,
                }
            },
            responsive: true,
            defaultFontFamily: fontFamily
        }
    };

    const myPieChart = new Chart(ctxPie, configPie);
</script>

@endscript

@endcan
