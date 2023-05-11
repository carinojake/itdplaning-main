<x-app-layout>
    <x-slot:content>
        <div class="mb-3 row container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="card-title fs-5 fw-semibold">ปีงบประมาณ 2566 </div>
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col">
                                        <!--งบประมาณ-->
                                        <div class="card">
                                            <div class="card-body">

                                                <button class="btn " style="width: 12rem;" data-bs-toggle="collapse"
                                                    href="#collapseExample" role="button" aria-expanded="false"
                                                    aria-controls="collapseExample">
                                                    <div class="fs-4 fw-semibold">
                                                        {{ number_format($budgets) }}
                                                    </div>
                                                    <small
                                                        class="text-xl ">
                                                        งบประมาณ
                                                    </small>
                                                </button>
                                            </div>
                                            <div class="collapse" id="collapseExample">
                                                <div class="card-body">

                                                    <button class="btn "  style="width: 12rem;" data-bs-toggle="collapse"
                                                                href="#collapseExample1" role="button"
                                                                aria-expanded="false"
                                                                aria-controls="collapseExample1">
                                                                <div class="fs-4 fw-semibold" >
                                                                    {{ number_format($budgetscentralict) }}
                                                                </div>
                                                                <small
                                                                    class="text-xl">
                                                                    งบกลาง ICT
                                                                </small>
                                                            </button>
                                                </div>
                                                <div class="card-body">

                                                    <button class="btn "  style="width: 12rem;" data-bs-toggle="collapse"
                                                                href="#collapseExample1" role="button"
                                                                aria-expanded="false"
                                                                aria-controls="collapseExample1">
                                                                <div class="fs-4 fw-semibold" >
                                                                    {{ number_format($budgetsinvestment) }}
                                                                </div>
                                                                <small
                                                                    class="text-xl">
                                                                    งบดำเนินงาน
                                                                </small>
                                                            </button>
                                                </div>

                                                <div class="card-body">

                                                    <button class="btn "  style="width: 12rem;" data-bs-toggle="collapse"
                                                                href="#collapseExample1" role="button"
                                                                aria-expanded="false"
                                                                aria-controls="collapseExample1">
                                                                <div class="fs-4 fw-semibold" >
                                                                    {{ number_format($budgetsut) }}
                                                                </div>
                                                                <small
                                                                    class="text-xl">
                                                                    งบสาธารณูปโภค
                                                                </small>
                                                            </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!--จบปี-->














                                    <div class="col">
                                        <!--คงเหลือ-->
                                        <div class="card  ">
                                            <div class="card-body ">
                                                <button class="btn btn-success" style="width: 12rem;" data-bs-toggle="collapse"
                                                    href="#collapseExample5" role="button"
                                                    aria-expanded="false" aria-controls="collapseExample">
                                                    @php
                                                    $tmp_class_bal = $budget['balance'] > 1000000 ? 'success'  :'danger';
                                                  @endphp
                                                <div class="fs-4 fw-semibold ">
                                                    {{ number_format(($budgets- ($ospa + $osa)- ($ispa + $isa)-($utpcs + $utsc) ), 2) }}
                                                    </div>

                                                    <small
                                                        class="text-xl">คงเหลือ</small>
                                                </button>

                                            </div>
                                            <div class="collapse" id="collapseExample5">
                                            <div class="card-body">
                                                <button class="btn " style="width: 12rem;" data-bs-toggle="collapse"
                                                    href="#collapseExample" role="button"
                                                    aria-expanded="false" aria-controls="collapseExample">
                                                    @php
                                                    $tmp_class_bal = $budget['balance'] > 1000000 ? 'success'  :'danger';
                                                  @endphp
                                                <div class="fs-4 fw-semibold text-success">
                                                    {{ number_format(($budgetscentralict- ($ospa + $osa)), 2) }}
                                                    </div>

                                                    <small
                                                        class="text-xl">คงเหลือ</small>
                                                </button>

                                            </div>
                                            <div class="card-body">
                                                <button class="btn " style="width: 12rem;" data-bs-toggle="collapse"
                                                    href="#collapseExample5" role="button"
                                                    aria-expanded="false" aria-controls="collapseExample">
                                                    @php
                                                    $tmp_class_bal = $budget['balance'] > 1000000 ? 'success'  :'danger';
                                                  @endphp
                                                <div class="fs-4 fw-semibold text-success">
                                                    {{ number_format(($budgetsinvestment- ($ispa + $isa) ), 2) }}
                                                    </div>

                                                    <small
                                                        class="text-xl">คงเหลือ</small>
                                                </button>

                                            </div>
                                            <div class="card-body">
                                                <button class="btn " style="width: 12rem;" data-bs-toggle="collapse"
                                                    href="#collapseExample5" role="button"
                                                    aria-expanded="false" aria-controls="collapseExample">
                                                    @php
                                                    $tmp_class_bal = $budget['balance'] > 1000000 ? 'success'  :'danger';
                                                  @endphp
                                                <div class="fs-4 fw-semibold text-success">
                                                    {{ number_format(($budgetsut- ($utpcs + $utsc) ), 2) }}
                                                    </div>

                                                    <small
                                                        class="text-xl">คงเหลือ</small>
                                                </button>

                                            </div>

                                        </div>
                                    </div>
                                    </div>
                                </div>








                            </div><!--งยประมาณ -->
                        </div>
                    </div>



                </div>


                </div>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-sm-6 col-md-6 col-lg-6">

                    <div class="card-body ">
                        <div class="card-title fs-5 fw-semibold">กราฟเบิกจ่ายรวมทั้งหมด</div>

                        <div class="card-body">



                        <div id="c1" class="chartdiv"></div>

                        </div>

                    </div>


            </div>

            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title fs-5 fw-semibold">
                            กราฟเบิกจ่าย งบกลาง ICT</div>

                        <div id="c2" class="chartdiv"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title fs-5 fw-semibold">
                            กราฟเบิกจ่าย งบดำเนินงาน</div>

                        <div id="c3" class="chartdiv"></div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title fs-5 fw-semibold">
                            กราฟเบิกจ่าย งบสาธารณูปโภค</div>

                        <div id="c4" class="chartdiv"></div>
                    </div>
                </div>
            </div>

        </div>








        <div class="mb-3 row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title fs-5 fw-semibold">ค่าใช้จ่ายเดือน ปีงบประมาณ 2566</div>
                        <div id="chart-totalbot2-div" class="chartdiv"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3 row">
            <div class="card">
                <div class="card-body">
                    <div class="card-title fs-5 fw-semibold">งาน/โครงการ</div>
                    <div id="gantt_here" style='width:100%; height:100vh;'></div>
                </div>
            </div>
        </div>

        <!-- Widget Chart yaer -->
        <!--  <div class="mb-3 row">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title fs-5 fw-semibold">งบประมาณ</div>
                        <div id="chart-project-div" class="chartdiv"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title fs-5 fw-semibold">สัญญา แยกตามปีงบประมาณ</div>
                        <div id="chart-contract-div" class="chartdiv"></div>
                    </div>
                </div>
            </div>
        </div> -->
        <!--<div class="col-sm-6 col-md-6 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-title fs-5 fw-semibold">สัญญา เตือน </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($contractsstart as $contractdr)
<?php
$start_date = \Carbon\Carbon::createFromTimestamp($contractdr->contract_start_date);
$end_date = \Carbon\Carbon::createFromTimestamp($contractdr->contract_end_date);
$duration_p = \Carbon\Carbon::parse($contractdr->contract_end_date)->diffInMonths(\Carbon\Carbon::parse($contractdr->contract_start_date)) - \Carbon\Carbon::parse($contractdr->contract_start_date)->diffInMonths(\Carbon\Carbon::parse());
$color = $duration_p < 3 ? 'red' : 'rgb(5, 255, 5)';
?>
                            <li class="list-group-item">
                                {{ $contractdr->contract_number }}/
                                <span style="color: {{ $color }}">{{ $duration_p }} เดือน</span>
                            </li>
@endforeach
                    </ul>
                    <div class="mt-3">
                        {{ $contractsstart->links() }}
                    </div>
                </div>
            </div>
        </div>  -->







        <style>
            .chartdiv {
                width: 100%;
                height: 250px;
            },
            body {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
}

#chartdiv2 {
  width: 100%;
  height: 500px;
},
#chartdiv3 {
  width: 10%;
  height: 100px;
}
        </style>
    </x-slot:content>

    <x-slot:css>

        <link href="{{ asset('vendors/DataTables/datatables.css') }}" rel="stylesheet" />
        <!--<script src="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.js"></script>-->
        <link href="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.css" rel="stylesheet">
        <script src="https://docs.dhtmlx.com/gantt/codebase/dhtmlxgantt.js?v=7.1.13"></script>
        <script src="//cdn.amcharts.com/lib/4/core.js"></script>
        <script src="//cdn.amcharts.com/lib/4/charts.js"></script>
    </x-slot:css>
    <x-slot:javascript>
        <!-- Resources -->
        <script src="{{ asset('js/jquery-3.6.1.min.') }}"></script>
        <script src="{{ asset('vendors/amcharts5/index.js') }}"></script>
        <script src="{{ asset('vendors/amcharts5/xy.js') }}"></script>
        <script src="{{ asset('vendors/amcharts5/percent.js') }}"></script>
        <script src="{{ asset('vendors/amcharts5/themes/Animated.js') }}"></script>

        <!-- Chart code -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
            crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">


        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
            rel="stylesheet" />
        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />


        <!-- HTML -->

        <script>
           gantt.plugins({
                marker: true,
                fullscreen: true,
                critical_path: true,
                // auto_scheduling: true,
                tooltip: true,
                // undo: true
            });

            //Marker
            var date_to_str = gantt.date.date_to_str(gantt.config.task_date);
            var today = new Date();
            gantt.addMarker({
                start_date: today,
                css: "today",
                text: "Today",
                title: "Today: " + date_to_str(today)
            });

            //Template
            var leftGridColumns = {
                columns: [


                    {
                        name: "text",
                        width: 300,
                        label: "โครงการ/งานประจำ",
                     //   open: false,
                        tree: true,
                        resize: true,
                        template(task) {
                            if (gantt.getState().selected_task == task.id) {
                                return "<b>" + task.text + "</b>";
                            }

                            else {
                                return task.text;
                            };
                        }
                    },
                    //{name:"start_date", label:"Start time", align: "center" },
                    // {name:"owner", width: 200, label:"Owner", template:function(task){
                    //   return task.owner}
                    // }
                ]
            };
            var rightGridColumns = {
                columns: [

                    {
                        name: "budget",
                        width: 120,
                        label: "งบประมาณ",
                        tree: true,
                        template: function(task) {
                            //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));
                            if (task.budget) {
                                return new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget);
                            } else {
                                return '-';
                            }
                        }

                    },

                    {
                        name: "cost_pa",
                        width: 150,
                        label: "PA",
                        tree: true,
                        template: function(task) {
                            //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));
                            if (task.task_type == 1) {
                                return '<span style="color:#560775;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.cost) + '</span>';


                            } else if (task.cost_pa_1 > 0){
                                return '<span style="color:#560775;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.cost_pa_1) + '</span>';
                            } else {
                                return '-';
                            }


                        }
                    },
                    {
                        name: "cost_no_pa",
                        width: 150,
                        label: '<div class="text-d"> ไม่มี PA</div>',

                        tree: true,
                        template: function(task) {
                            //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));
                            if (task.task_type == 2) {
                                return '<span style="color:#560775;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.cost);
                            } else if (task.cost_no_pa_2 > 0){
                                return '<span style="color:#560775;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.cost_no_pa_2) + '</span>';
                            } else {
                                return '-';
                            }





                        }
                    },
                    {
                        name: "pay",
                        width: 100,

                        label: '<div class="text-primary">การเบิกจ่าย</div>',

                        tree: true,

                        template: function(task) {
                            //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));

                            if (task.task_total_pay > 0) {
                                return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.task_total_pay) + '</span>';

                            } else
                            if (task.task_type == 1) {
                                return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.pay) + '</span>';
                            } else if (task.task_type == 2) {
                                return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.pay) + '</span>';

                            } else if (task.total_pay > 0){

                                return '<span style="color:#6010f6;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.total_pay) + '</span>';
                            } else {
                                return '-';
                            }
                        }
                    },

                    {
                        name: "-",
                        width: 100,
                        label: '<div class="text-warning">รอการเบิกจ่าย</div>',
                        tree: true,

                        template: function(task) {

                                 //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));
                                 if (task.total_cost-task.total_pay === 0){
                                    return '-';
                            }


                                 else if (task.total_cost) {
                                return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {

                                    style: 'currency',
                                    currency: 'THB'
                                }).format( task.total_cost-task.total_pay)+ '</span>';
                            }

                            else {
                                return '';
                            }





                        }
                    },
                    {
                        name: "balance",
                        width: 100,



                        label: '<div class="text-success">คงเหลือ</div>',

                        tree: true,

                        template: function(task) {
                            //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));

                            if (task.balance-task.total_pay === 0 ) {
                                return  '-';
                            }



                            else if (task.project_type = "1") {
                                var tmp_class = task.total_pay > 0 ? 'green' : 'green';
                                return '<span style="color:' + tmp_class + ';">'
                                    + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.balance-task.total_pay)
                                   '</span>';
                            }
                            else if (task.project_type = "2" ) {
                                return  '<span style="color:' + tmp_class + ';">'
                                    + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.balance-task.total_pay)
                                '</span>';

                            } else
                            {

                                return '';
                            }
                        }
                    }
                ]
            };

            gantt.templates.tooltip_text = function(start, end, task) {
                var budget_gov = task.budget_gov ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget_gov) : '';
                var budget_it = task.budget_it ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget_it) : '';
                var budget = task.budget ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget) : '';
                var budget_gov_operating = task.budget_gov_operating ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                })

                .format(task.budget_gov_operating) : '';
                var budget_gov_investment = task.budget_gov_investment ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget_gov_investment) : '';
                var budget_gov_utility = task.budget_gov_utility ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget_gov_utility) : '';
                var budget_it_operating = task.budget_it_operating ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget_it_operating) : '';
                var budget_it_investment = task.budget_it_investment ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget_it_investment) : '';
                var cost = task.cost ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.cost) : '';

                var html = '<b>โครงการ/งาน:</b> ' + task.text + '<br/>';
                html += task.owner ? '<b>เจ้าของ:</b> ' + task.owner + '<br/>' : '';

                if (budget) {
                    html += '<table class="table table-sm " style="font-size:9px">';
                    html += '<tr class="text-center align-middle">\
                                                        <td colspan="3">เงินงบประมาณ<br></td>\
                                                        <td colspan="2">งบกลาง IT</td>\
                                                        <td rowspan="2">รวมทั้งหมด<br></td>\
                                                      </tr>';
                    html += '<tr>\
                                                        <td>งบดำเนินงาน<br></td>\
                                                        <td>งบลงทุน IT<br></td>\
                                                        <td>ค่าสาธารณูปโภค</td>\
                                                        <td>งบดำเนินงาน<br></td>\
                                                        <td>งบลงทุน<br></td>\
                                                      </tr>';
                    if (task.type == 'task') {
                        html += '<tr class="text-end">\
                                                        <td>-' +  + '</td>\
                                                        <td>' +  + '</td>\
                                                        <td>-' + budget_gov_utility + '</td>\
                                                        <td>' + budget_it_operating + '</td>\
                                                        <td>' + budget_it_investment + '</td>\
                                                        <td class="text-success">' + budget + '</td>\
                                                      </tr>';
                    } else {
                        html += '<tr class="text-end">\
                                                        <td>' +  + '</td>\
                                                        <td>' +  + '</td>\
                                                        <td>' +  + '</td>\
                                                        <td>' +  + '</td>\
                                                        <td>' +  + '</td>\
                                                        <td class="text-success">' + budget + '</td>\
                                                      </tr>';
                    }
                    html += '</table>';
                }

                if (task.cost) {
                    html += '<b>ค่าใช้จ่าย:</b> <span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                        style: 'currency',
                        currency: 'THB'
                    }).format(task.cost) + '</span><br/>';
                }
                if (task.balance) {
                    var tmp_class = task.balance > 0 ? 'green' : 'red';
                    html += '<b>คงเหลือ:</b> <span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                        style: 'currency',
                        currency: 'THB'
                    }).format(task.balance) + '</span><br/>';
                }

                return html;
            };

            gantt.ext.fullscreen.getFullscreenElement = function() {
                return document.querySelector("#gantt_here");
            };
            //Config
            gantt.config.date_format = "%Y-%m-%d";
            gantt.config.drag_links = false;
            gantt.config.drag_move = false;
            gantt.config.drag_progress = false;
            gantt.config.drag_resize = false;
            gantt.config.grid_resize = true;
            gantt.config.layout = {
                css: "gantt_container",
                rows: [{
                        cols: [{
                                view: "grid",
                                width: 600,
                                scrollX: "scrollHor",
                                scrollY: "scrollVer",
                                config: leftGridColumns
                            },
                            {
                                resizer: true,
                                width: 1
                            },
                            {
                                view: "timeline",
                                scrollX: "scrollHor",
                                scrollY: "scrollVer"
                            },
                            {
                                resizer: true,
                                width: 1
                            },
                            {
                                view: "grid",
                                width: 500,
                                bind: "task",
                                scrollY: "scrollVer",
                                config: rightGridColumns
                            },
                            {
                                view: "scrollbar",
                                id: "scrollVer"
                            }
                        ]

                    },
                    {
                        view: "scrollbar",
                        id: "scrollHor",
                        height: 20
                    }
                ]
            };
            gantt.config.readonly = true;
            gantt.config.scales = [{
                    unit: "year",
                    step: 1,
                    format: function (date) {
      return parseInt(gantt.date.date_to_str("%Y")(date)) + 543;
    },



                },
                {
                    unit: "month",
                    step: 2,
                    format: function(date) {
            //const thaiMonthNames = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
            const thaiMonthNames = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
            const thaiYearNumber = parseInt(gantt.date.date_to_str("%Y")(date)) + 543;
            const thaiMonthName = thaiMonthNames[date.getMonth()];
            return thaiMonthName + " " + thaiYearNumber;
        }
                },
                // {unit: "day", step: 3, format: "%D %M, %Y"},
            ];
            //ganttModules.zoom.setZoom("months");

            gantt.init("gantt_here");
            gantt.parse({
                data: {!! $gantt !!}
            });
        </script>


        <!-- xy2 -->
        <!-- Chart code -->
        <script>
            am5.ready(function() {
                // Create root element
                // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new("chart-totalbot2-div");
                // Set themes
                // https://www.amcharts.com/docs/v5/concepts/themes/
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);
                // Create chart
                // https://www.amcharts.com/docs/v5/charts/xy-chart/
                var chart = root.container.children.push(am5xy.XYChart.new(root, {
                    panX: false,
                    panY: false,
                    wheelX: "panX",
                    wheelY: "zoomX",
                    layout: root.verticalLayout
                }));
                // Add legend
                // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
                var legend = chart.children.push(
                    am5.Legend.new(root, {
                        centerX: am5.p50,
                        x: am5.p50
                    })
                );
                var data = {!! $chart_data_xy !!}

              //  var data1 = {!! $taskcosttotals !!}
              //  var date2 = {!! $taskcosttotals2_json !!}
                //var date3 = {!! $taskconcosttotals !!}
                // Create axes
                // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                var xRenderer = am5xy.AxisRendererX.new(root, {
                    cellStartLocation: 0.1,
                    cellEndLocation: 0.9,
                    minGridDistance: 10
                });
                xRenderer.grid.template.set("location", 0.5);
                xRenderer.labels.template.setAll({
                    location: 0.5,
                    multiLocation: 0.5
                });
                var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                    categoryField: "task_pay_month",

                    renderer: xRenderer,
                    tooltip: am5.Tooltip.new(root, {}),
                }));
                xRenderer.grid.template.setAll({
                    location: 1
                })
                xAxis.data.setAll(data);
                var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                    renderer: am5xy.AxisRendererY.new(root, {
                        strokeOpacity: 0.1,

                    })
                }));

//eee

                // Add series
                // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                function makeSeries(name, fieldName) {
                    var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                        name: name,
                        xAxis: xAxis,
                        yAxis: yAxis,
                        valueYField: fieldName,
                        categoryXField: "task_pay_month",
                    }));
                    series.columns.template.setAll({
                        tooltipText: "[bold]{name}[/]\n {categoryX}[/]\n:{valueY}",
                        width: am5.percent(100),
                        stacked: true,

                    });

                    let yRenderer = yAxis.get("renderer");
yRenderer.ticks.template.setAll({
  minPosition: 0.0,
  maxPosition: 1.1,
  visible: true
});
yRenderer.labels.template.setAll({
  minPosition: 0.0,
  maxPosition: 1.1
});

                    series.data.setAll(data);
                    // Make stuff animate on load
                    // https://www.amcharts.com/docs/v5/concepts/animations/
                    series.appear();
                    series.bullets.push(function() {
                        return am5.Bullet.new(root, {
                            locationY: 1 ,
                            sprite: am5.Label.new(root, {
                                text: "{valueY}",
                                populateText: true,
                               // fill: root.interfaceColors.get("alternativeText"),
                                centerY: 0,
                                centerX: am5.p50,
                                populateText: true
                            })
                        });
                    });
                    legend.data.push(series);
                };
                //  makeSeries("การใช้จ่ายประมาณ", "total_cost");
              makeSeries("ค่าใช้จ่ายเดือน", "total_cost");

            }); // end am5.ready()
        </script>







<script>
  /**
 * ---------------------------------------
 * This demo was created using amCharts 5.
 *
 * For more information visit:
 * https://www.amcharts.com/
 *
 * Documentation is available at:
 * https://www.amcharts.com/docs/v5/
 * ---------------------------------------
 */

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("");

  // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root.setThemes([
        am5themes_Animated.new(root)
    ]);

    // Create chart
    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
    var chart = root.container.children.push(am5percent.PieChart.new(root, {

    }));

    // Create series
    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
    var series = chart.series.push(am5percent.PieSeries.new(root, {


        valueField: "value"
    }));





    // Set up adapters for variable slice radius
    // https://www.amcharts.com/docs/v5/concepts/settings/adapters/

    // Set data
    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
    series.data.setAll([{
    value: {{ $budgets-($otpsa1 + $otpsa2+$itpsa1 + $itpsa2+$utsc_pay_pa+$utsc_pay) }},
    category: "คงเหลือ:" + {{ number_format(($budgets-($otpsa1 + $otpsa2+$itpsa1 + $itpsa2+$utsc_pay_pa+$utsc_pay) ) / $budgets * 100, 4) }} + "%"
},
{
    value: {{($otpsa1 + $otpsa2+$itpsa1 + $itpsa2+$utsc_pay_pa+$utsc_pay) }},
    category: "เบิกจ่ายทั้งหมด :" + {{ number_format(($otpsa1 + $otpsa2+$itpsa1 + $itpsa2+$utsc_pay_pa+$utsc_pay) / $budgets * 100, 4) }} + "%" + "\nงบกลาง ICT :" + {{ number_format(($otpsa1 + $otpsa2) / $budgets * 100, 4) }} + "%" + "\nงบดำเนินงาน :" + {{ number_format(($itpsa1 + $itpsa2) / $budgets * 100, 4) }} + "%" + "\nงบสาธารณูปโภค :" + {{ number_format(($utsc_pay_pa+$utsc_pay) / $budgets * 100, 4) }} + "%"
}]);

series.labels.template.setAll({
  text: "{category}",
  textType: "circular",
  inside: true,
  radius: 10
});

    // Create legend
    // https://www.amcharts.com/docs/v5/charts/percent-charts/legend-percent-series/



    legend.data.setAll(series.dataItems);

    // Play initial series animation
    // https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
    series.appear(1000, 100);

 // end am5.ready()

</script>


<script>
   /**
 * ---------------------------------------
 * This demo was created using amCharts 5.
 *
 * For more information visit:
 * https://www.amcharts.com/
 *
 * Documentation is available at:
 * https://www.amcharts.com/docs/v5/
 * ---------------------------------------
 */

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("");

// Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root.setThemes([
        am5themes_Animated.new(root)
    ]);

    // Create chart
    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
    var chart = root.container.children.push(am5percent.PieChart.new(root, {
        layout: root.verticalLayout
    }));

    // Create series
    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
    var series = chart.series.push(am5percent.PieSeries.new(root, {


        valueField: "value",
        categoryField: "category"
    }));





    // Set up adapters for variable slice radius
    // https://www.amcharts.com/docs/v5/concepts/settings/adapters/

    // Set data
    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
    series.data.setAll([{
value: {{ $budgetscentralict-($otpsa1 + $otpsa2) }},
category: "คงเหลือ"
}, {
value: {{($otpsa1 + $otpsa2) }},
category: "เบิกจ่ายทั้งหมด"
}
]);
series.slices.template.setAll({
  fillOpacity: 0.5,
  fill: am5.color(0xf60b0b),
  strokeWidth: 2
});
    // Create legend
    // https://www.amcharts.com/docs/v5/charts/percent-charts/legend-percent-series/
    var legend = chart.children.push(am5.Legend.new(root, {
        centerX: am5.p50,
        x: am5.p50,
        marginTop: 15,
        marginBottom: 15
    }));

    legend.data.setAll(series.dataItems);

    // Play initial series animation
    // https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
    series.appear(1000, 100);

 // end am5.ready()

</script>

<script>
    // Create root element
    var root = am5.Root.new("");

   // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root.setThemes([
        am5themes_Animated.new(root)
    ]);

    // Create chart
    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
    var chart = root.container.children.push(am5percent.PieChart.new(root, {
        layout: root.verticalLayout
    }));

    // Create series
    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
    var series = chart.series.push(am5percent.PieSeries.new(root, {


        valueField: "value",
        categoryField: "category"
    }));





    // Set up adapters for variable slice radius
    // https://www.amcharts.com/docs/v5/concepts/settings/adapters/

    // Set data
    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
    series.data.setAll([{
value: {{ $budgetsinvestment-($itpsa1 + $itpsa2) }},
category: "คงเหลือ"
}, {
value: {{($itpsa1 + $itpsa2) }},
category: "เบิกจ่ายทั้งหมด"
}
]);



    // Create legend
    // https://www.amcharts.com/docs/v5/charts/percent-charts/legend-percent-series/
    var legend = chart.children.push(am5.Legend.new(root, {
        centerX: am5.p50,
        x: am5.p50,
        marginTop: 15,
        marginBottom: 15,

    }));

    legend.data.setAll(series.dataItems);

    // Play initial series animation
    // https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
    series.appear(1000, 100);

 // end am5.ready()
</script>



<script>
/**
 * ---------------------------------------
 * This demo was created using amCharts 5.
 *
 * For more information visit:
 * https://www.amcharts.com/
 *
 * Documentation is available at:
 * https://www.amcharts.com/docs/v5/
 * ---------------------------------------
 */

// Create root and chart
var root = am5.Root.new("");
pieSeries.slices.template.fill = am5core.color("green");
// Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root.setThemes([
        am5themes_Animated.new(root)
    ]);

    // Create chart
    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
    var chart = root.container.children.push(am5percent.PieChart.new(root, {
        layout: root.verticalLayout
    }));

    // Create series
    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
    var series = chart.series.push(am5percent.PieSeries.new(root, {


        valueField: "value",
        categoryField: "category"
    }));





    // Set up adapters for variable slice radius
    // https://www.amcharts.com/docs/v5/concepts/settings/adapters/

    // Set data
    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
    series.data.setAll([{
value: {{ $budgetsut-($utsc_pay_pa+$utsc_pay) }},
category: "คงเหลือ",
color: am5core.color("green")
}, {
value: {{($utsc_pay_pa+$utsc_pay) }},
category: "เบิกจ่ายทั้งหมด"
}
]);

    // Create legend
    // https://www.amcharts.com/docs/v5/charts/percent-charts/legend-percent-series/
    var legend = chart.children.push(am5.Legend.new(root, {
        centerX: am5.p50,
        x: am5.p50,
        marginTop: 15,
        marginBottom: 15
    }));

    legend.data.setAll(series.dataItems);

    // Play initial series animation
    // https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
    series.appear(1000, 100);

 // end am5.ready()



</script>

<script>

    /**
     * ---------------------------------------
     * This demo was created using amCharts 4.
     *
     * For more information visit:
     * https://www.amcharts.com/
     *
     * Documentation is available at:
     * https://www.amcharts.com/docs/v4/
     * ---------------------------------------
     */

    // Create chart instance
    var chart = am4core.create("c1", am4charts.PieChart);

    // Add data
    chart.data = [{
      "country": "คงเหลือ",
      "litres":  {{ $budgets-($otpsa1 + $otpsa2+$itpsa1 + $itpsa2+$utsc_pay_pa+$utsc_pay)}},
      "color": am4core.color("#198754")
    }, {
      "country": " :เบิกจ่ายทั้งหมด"  + "\n"+{{ number_format(($otpsa1 + $otpsa2) / $budgets * 100, 4) }} + "%"+" :งบกลาง ICT :"  + "\n" + {{ number_format(($itpsa1 + $itpsa2) / $budgets * 100, 4) }} + "%" + " :งบดำเนินงาน" + "\n" + {{ number_format(($utsc_pay_pa+$utsc_pay) / $budgets * 100, 4) }} + "%" +"  :งบสาธารณูปโภค",



      "litres":  {{($otpsa1 + $otpsa2+$itpsa1 + $itpsa2+$utsc_pay_pa+$utsc_pay) }},
      "color": am4core.color("#0d6efd")
    }, ];

    // Add and configure Series
    var pieSeries = chart.series.push(new am4charts.PieSeries());
    pieSeries.dataFields.value = "litres";
    pieSeries.dataFields.category = "country";
    pieSeries.slices.template.propertyFields.fill = "color";

    pieSeries.labels.template.text = "{value.percent.formatNumber('#.00')}% {category}";
    </script>




<script>

/**
 * ---------------------------------------
 * This demo was created using amCharts 4.
 *
 * For more information visit:
 * https://www.amcharts.com/
 *
 * Documentation is available at:
 * https://www.amcharts.com/docs/v4/
 * ---------------------------------------
 */

// Create chart instance
var chart = am4core.create("c2", am4charts.PieChart);

// Add data
chart.data = [{
  "country": "คงเหลือ",
  "litres":  {{ $budgetscentralict-($otpsa1 + $otpsa2) }},
  "color": am4core.color("#198754")
}, {
  "country": "เบิกจ่ายทั้งหมด",
  "litres":  {{($otpsa1 + $otpsa2) }},
  "color": am4core.color("#0d6efd")
}, ];

// Add and configure Series
var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "litres";
pieSeries.dataFields.category = "country";
pieSeries.slices.template.propertyFields.fill = "color";
pieSeries.labels.template.text = "{value.percent.formatNumber('#.00')}% {category}";
//chart.legend = new am4charts.Legend();
</script>

<script>

    /**
     * ---------------------------------------
     * This demo was created using amCharts 4.
     *
     * For more information visit:
     * https://www.amcharts.com/
     *
     * Documentation is available at:
     * https://www.amcharts.com/docs/v4/
     * ---------------------------------------
     */

    // Create chart instance
    var chart = am4core.create("c3", am4charts.PieChart);

    // Add data
    chart.data = [{
      "country": "คงเหลือ",
      "litres":  {{ $budgetsinvestment-($itpsa1 + $itpsa2) }},
      "color": am4core.color("#198754")
    }, {
      "country": "เบิกจ่ายทั้งหมด",
      "litres":  {{($itpsa1 + $itpsa2) }},
      "color": am4core.color("#0d6efd")
    }, ];

    // Add and configure Series
    var pieSeries = chart.series.push(new am4charts.PieSeries());
    pieSeries.dataFields.value = "litres";
    pieSeries.dataFields.category = "country";
    pieSeries.slices.template.propertyFields.fill = "color";
    pieSeries.labels.template.text = "{value.percent.formatNumber('#.00')}% {category}";
  //  chart.legend = new am4charts.Legend();
    </script>


<script>

    /**
     * ---------------------------------------
     * This demo was created using amCharts 4.
     *
     * For more information visit:
     * https://www.amcharts.com/
     *
     * Documentation is available at:
     * https://www.amcharts.com/docs/v4/
     * ---------------------------------------
     */

    // Create chart instance
    var chart = am4core.create("c4", am4charts.PieChart);

    // Add data
    chart.data = [{
      "country": "คงเหลือ",
      "litres":  {{ $budgetsut-($utsc_pay_pa+$utsc_pay) }},

      "color": am4core.color("#198754")
    }, {
      "country": "เบิกจ่ายทั้งหมด",
      "litres":  {{($utsc_pay_pa+$utsc_pay) }},
      "color": am4core.color("#0d6efd")
    }, ];

    // Add and configure Series
    var pieSeries = chart.series.push(new am4charts.PieSeries());
    pieSeries.dataFields.value = "litres";
    pieSeries.dataFields.category = "country";
    pieSeries.slices.template.propertyFields.fill = "color";
    pieSeries.labels.template.text = "{value.percent.formatNumber('#.00')}% {category}";
   // chart.legend = new am4charts.Legend();
    </script>
    </x-slot:javascript>


</x-app-layout>




WHEN 'ม.ค. $fiscal_year' THEN 4 WHEN 'ก.พ. $fiscal_year' THEN 5 WHEN 'มี.ค. $fiscal_year'
 THEN 6 WHEN 'เม.ย. $fiscal_year' THEN 7 WHEN 'พ.ค. $fiscal_year' THEN 8 WHEN 'มิ.ย. $fiscal_year' THEN 9 WHEN
 'ก.ค. $fiscal_year' THEN 10 WHEN 'ส.ค. $fiscal_year' THEN 11 WHEN 'ก.ย. $fiscal_year' THEN 12 END")
