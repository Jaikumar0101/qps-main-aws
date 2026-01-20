<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h3 class="fs-6 fw-bold">
                    Dashboard
                </h3>
            </div>
        </div>
        <div class="py-2">
            <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6 px-10"
                wire:ignore
            >
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_4">Summary</a>
                </li>
                <li class="nav-item d-none">
                    <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_5">Activity</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="kt_tab_pane_4" role="tabpanel" wire:ignore.self>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card position-relative">
                                <div class="position-absolute" style="top: 15px;left: 20px;">
                                   <span class="fs-6 fw-bold">
                                        All Tasks
                                    </span>
                                </div>
                                <!--begin::Card body-->
                                <div class="px-4">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <!--begin::Chart-->
                                        <div id="kt-chart-op" style="height: 350px;width: 100%" wire:ignore>
                                            <canvas id="kt-chart-op-canvas" style="height: 200px"></canvas>
                                        </div>
                                        <!--end::Chart-->
                                    </div>
                                </div>
                                <!--end::Card body-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="kt_tab_pane_5" role="tabpanel" wire:ignore.self>
                    ...
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script data-navigate-trackn>
    const fontFamily = KTUtil.getCssVariableValue('--bs-font-sans-serif');
    const ctx = document.getElementById('kt-chart-op-canvas').getContext('2d');
    const data = {
        labels: [
            'Late',
            'Started',
            'Today',
            'Upcoming',
            'No date'
        ],
        datasets: [{
            label: ' Tasks',
            data: [10,50, 60, 5, 15],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)',
                'rgb(154, 162, 235)'
            ],
            hoverOffset: 4
        }]
    };

    const config = {
        type: 'doughnut',
        data: data,
        options: {
            plugins: {
                legend: {
                    display: true,
                    position: 'right',
                    labels:{
                        font: {
                            family: fontFamily
                        },
                        generateLabels: function(chart) {
                            const data = chart.data;
                            return data.labels.map(function(label, index) {
                                const value = data.datasets[0].data[index];
                                return {
                                    text: label + '( '+value+')',
                                    fillStyle: data.datasets[0].backgroundColor[index],
                                    strokeStyle: '#fff',
                                    lineWidth: 2
                                };
                            });
                        }
                    }
                },
            },
        },
        responsive: true,
        aspectRatio: 1,
        layout: {
            padding: {
                left: 0,
                right: 0,
                top: 0,
                bottom: 0
            }
        },
        defaultFontFamily: fontFamily
    };

    new Chart(ctx, config);
</script>
@endscript

