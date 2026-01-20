<div>
    {!! AdminBreadCrumb::Load([
            'title'=>$customer->fullName(true),
            'menu'=>[ ['name'=>trans('Claim'),'url'=>route('admin::insurance-claim:list')],['name'=>'View','active'=>true] ],
            'actions'=>[ ['name'=>'Back To List','url'=>$backUrl] ],
            'full-width'=>true
         ])
    !!}

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header pt-7">
                            <!--begin::Title-->
                            <h3 class="card-title align-items-start flex-column pb-3">
                                <span class="card-label fw-bold text-gray-800">Client Information</span>
                                <span class="text-gray-400 mt-1 fw-semibold fs-6">Showing client details</span>
                            </h3>
                            <!--end::Title-->
                        </div>
                        <div class="card-body">
                            <p>
                                <b>Name:</b> {{ $customer->fullName() }}<br>
                                <b>Email:</b> {{ $customer->email ??'' }}<br>
                                <b>Dental Office:</b> {{ $customer->last_name ??'' }}<br>
                                <b>Phone:</b> {{ $customer->email ??'' }}<br>
                                <b>Address:</b> {{ $customer->address ??'' }}<br>
                            </p>
                        </div>
                    </div>
                    <div class="card card-flush mb-3 min-h-200px">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Currency-->
                                    <span class="fs-4 fw-semibold text-gray-400 me-1 align-self-start">$</span>
                                    <!--end::Currency-->
                                    <!--begin::Amount-->
                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">
                                        {{ round($rowData['total_amount'] ??0,2) }}
                                    </span>
                                    <!--end::Amount-->
                                    <!--begin::Badge-->
                                    <span class="badge badge-light-success fs-base">
{{--															<i class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">--}}
{{--																<span class="path1"></span>--}}
{{--																<span class="path2"></span>--}}
{{--															</i>--}}
                                        Total</span>
                                    <!--end::Badge-->
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 pb-0 d-flex flex-wrap align-items-center">

                            <!--begin::Labels-->
                            <div class="d-flex flex-column content-justify-center flex-row-fluid">
                                <!--begin::Label-->
                                <div class="d-flex fw-semibold align-items-center">
                                    <!--begin::Bullet-->
                                    <div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>
                                    <!--end::Bullet-->
                                    <!--begin::Label-->
                                    <div class="text-gray-500 flex-grow-1 me-4">Total Claims</div>
                                    <!--end::Label-->
                                    <!--begin::Stats-->
                                    <div class="fw-bolder text-gray-700 text-xxl-end">
                                        {{ $rowData['total_claims'] ??0 }}
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Label-->
                                <!--begin::Label-->
                                <div class="d-flex fw-semibold align-items-center my-3">
                                    <!--begin::Bullet-->
                                    <div class="bullet w-8px h-3px rounded-2 bg-primary me-3"></div>
                                    <!--end::Bullet-->
                                    <!--begin::Label-->
                                    <div class="text-gray-500 flex-grow-1 me-4">Closed Claims</div>
                                    <!--end::Label-->
                                    <!--begin::Stats-->
                                    <div class="fw-bolder text-gray-700 text-xxl-end">
                                        {{ $rowData['closed_claims'] ??0 }}
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Label-->
{{--                                <!--begin::Label-->--}}
{{--                                <div class="d-flex fw-semibold align-items-center">--}}
{{--                                    <!--begin::Bullet-->--}}
{{--                                    <div class="bullet w-8px h-3px rounded-2 me-3" style="background-color: #E4E6EF"></div>--}}
{{--                                    <!--end::Bullet-->--}}
{{--                                    <!--begin::Label-->--}}
{{--                                    <div class="text-gray-500 flex-grow-1 me-4">Others</div>--}}
{{--                                    <!--end::Label-->--}}
{{--                                    <!--begin::Stats-->--}}
{{--                                    <div class="fw-bolder text-gray-700 text-xxl-end">$45,257</div>--}}
{{--                                    <!--end::Stats-->--}}
{{--                                </div>--}}
{{--                                <!--end::Label-->--}}
                            </div>
                            <!--end::Labels-->
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header pt-7">
                            <!--begin::Title-->
                            <h3 class="card-title align-items-start flex-column pb-3">
                                <span class="card-label fw-bold text-gray-800">Claims Overview</span>
                                <span class="text-gray-400 mt-1 fw-semibold fs-6">Showing past claims history of client over last months</span>
                            </h3>
                            <!--end::Title-->
                        </div>
                        <div class="card-body" wire:ignore>
                            <div id="kt_charts_widget_4_chart" style="height: 350px"></div>
                        </div>
                    </div>
                </div>
            </div>
            <livewire:admin.customers.customer-claim-table :customer="$customer" />
        </div>
    </div>
</div>



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

