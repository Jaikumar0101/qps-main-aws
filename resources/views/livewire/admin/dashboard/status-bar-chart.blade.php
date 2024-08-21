<div>

    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <div class="col-xl-12">
            <!--begin::Charts Widget 3-->
            <div class="card card-xl-stretch mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Status Chart</span>
                        <span class="text-muted fw-semibold fs-7">Showing the insurance claims status analytics</span>
                    </h3>
                    <!--begin::Toolbar-->
                    <div class="card-toolbar">
                        <a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1 {{ $filter == "all"?'active':'' }}"
                           wire:click.prevent="changeFilter('all')"
                           wire:loading.attr="disabled"
                        >All</a>
                        <a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1 {{ $filter == "ST30"?'active':'' }}"
                           wire:click.prevent="changeFilter('ST30')"
                           wire:loading.attr="disabled"
                        >0-30</a>
                        <a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1 {{ $filter == "ST60"?'active':'' }}"
                           wire:click.prevent="changeFilter('ST60')"
                           wire:loading.attr="disabled"
                        >30-60</a>
                        <a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1 {{ $filter == "ST90"?'active':'' }}"
                           wire:click.prevent="changeFilter('ST90')"
                           wire:loading.attr="disabled"
                        >60-90</a>
                        <a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1 {{ $filter == "ST120"?'active':'' }}"
                           wire:click.prevent="changeFilter('ST120')"
                           wire:loading.attr="disabled"
                        >90-120</a>
                        <a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1 {{ $filter == "ST120+"?'active':'' }}"
                           wire:click.prevent="changeFilter('ST120+')"
                           wire:loading.attr="disabled"
                        >120+</a>
                        <div class="ms-2">
                            <select class="form-select form-select-sm" wire:model.live="type">
                                <option value="count">Claims</option>
                                <option value="total">Amount</option>
                            </select>
                        </div>
                        <div class="ms-2">
                            <button class="btn btn-sm btn-success"
                                    wire:click.prevent="ExportData"
                                    wire:loading.attr="disabled"
                            >
                                        <span wire:loading  wire:target="ExportData">
                                            <span class="spinner-border spinner-border-sm"></span>
                                        </span>
                                <span wire:loading.remove wire:target="ExportData">Export Claims</span>
                            </button>
                        </div>
                        <div class="ms-2">
                            <button class="btn btn-sm btn-primary"
                                    wire:click.prevent="Export"
                                    wire:loading.attr="disabled"
                            >
                                        <span wire:loading  wire:target="Export">
                                            <span class="spinner-border spinner-border-sm"></span>
                                        </span>
                                <span wire:loading.remove wire:target="Export">Export</span>
                            </button>
                        </div>
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body p-3" wire:ignore>
                    <!--begin::Chart-->
                    <div id="kt_bar_chart" class="min-h-450px"></div>
                    <!--end::Chart-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Charts Widget 3-->
        </div>
    </div>
    <!--end::Row-->

    @include('admin.modals.export_modal')

</div>


@script
<script>
    const element2 = document.getElementById('kt_bar_chart');

    var bar_height = parseInt(KTUtil.css(element2, 'bar_height'));
    var bar_labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
    var bar_borderColor = KTUtil.getCssVariableValue('--bs-gray-700');
    var bar_baseColor = KTUtil.getCssVariableValue('--bs-info');
    var bar_secondaryColor = KTUtil.getCssVariableValue('--bs-gray-300');


    if (!element2) {
        return;
    }

    var options2 = {
        series: [{
            name: 'Claims',
            data: @js($chartData)
        },{
            name: 'Claims',
            data: @js($chartData)
        }],
        chart: {
            fontFamily: 'inherit',
            type: 'bar',
            bar_height: bar_height,
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                horizontal: true,
                columnWidth: ['30%'],
                endingShape: 'rounded'
            },
        },
        legend: {
            show: false
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: @js($chartLabels),
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false
            },
            labels: {
                style: {
                    colors: bar_labelColor,
                    fontSize: '12px'
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: bar_labelColor,
                    fontSize: '12px'
                }
            }
        },
        fill: {
            opacity: 1
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
                    return val ??''
                },
            }
        },
        colors: [bar_baseColor, bar_secondaryColor],
        grid: {
            bar_borderColor: bar_borderColor,
            strokeDashArray: 4,
            yaxis: {
                lines: {
                    show: true
                }
            }
        }
    };

    const chart_1 = new ApexCharts(element2, options2);
    chart_1.render();

    window.addEventListener('updateBarChart',({detail:{type,data,total}})=>{

        if(type === "total")
        {
            chart_1.updateOptions({
                series: [{
                    name: 'Total',
                    data: total
                }],
                tooltip: {
                    style: {
                        fontSize: '12px'
                    },
                    y: {
                        formatter: function (val) {
                            return '$' + val
                        },
                    }
                },
            });
        }
        else
        {
            chart_1.updateOptions({
                series: [{
                    name: 'Claims',
                    data: data
                }],
                tooltip: {
                    style: {
                        fontSize: '12px'
                    },
                    y: {
                        formatter: function (val) {
                            return val ??''
                        },
                    }
                },
            });
        }
    })
</script>
@endscript
