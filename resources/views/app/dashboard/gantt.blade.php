<x-app-layout>
    <x-slot:content>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <x-card title="ปีงบประมาณ {{ $fiscal_year }} ">
                            <x-slot:toolbar>

                                <form method="POST" action="{{ route('dashboard.gantt') }}" class="mt-3">

                                    @csrf

                                    <div class="input-group mb-3">


                                        <div class="col-sm-6 mt-3" >เลือกปีงบประมาณ &nbsp;</div>
                                    {{--     <select name="fiscal_year" class="form-select">
                                            @for ($i = 2564; $i <= date('Y') + 543 + 3; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $fiscal_year == $i ? 'selected' : '' }}>{{ $i }}
                                                </option>
                                            @endfor
                                            <!-- เพิ่มตัวเลือกเพิ่มเติมตามที่จำเป็น -->
                                        </select> --}}
                                        <select name="fiscal_year" class="form-select">
                                            @foreach($fiscal_years as $year)
                                                <option value="{{ $year }}" {{ ($fiscal_year == $year) ? 'selected' : '' }}>{{ $year }}</option>
                                            @endforeach
                                        </select>


                                        <button class="btn btn-secondary" type="submit">ค้นหา</button>
                                    </div>
                                </form>






                                <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">กลับ</a>

                            </x-slot:toolbar>
                            <div id="gantt_here" style='width:100%; height:100vh;'></div>
                        </x-card>
                    </div>
                </div>
            </div>
        </div>

    </x-slot:content>
    <x-slot:css>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Prompt&display=swap">
        <link rel="stylesheet" href="{{ asset('/vendors/dhtmlx/dhtmlxgantt.css') }}" type="text/css">
    </x-slot:css>
    <x-slot:javascript>
        <script src="https://docs.dhtmlx.com/gantt/codebase/dhtmlxgantt.js?v=7.1.13"></script>


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
                            } else {
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


                            } else if (task.cost_pa_1 > 0) {
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
                            } else if (task.cost_no_pa_2 > 0) {
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
                        name: "-",
                        width: 100,
                        label: '<div class="text-danger">รอการเบิกจ่าย</div>',
                        tree: true,

                        template: function(task) {

                            //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));
                            if (task.total_cost - task.total_pay === 0) {
                                return '-';
                            } else if (task.total_cost) {
                                return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {

                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.total_cost - task.total_pay_paycon) + '</span>';
                            } else {
                                return '';
                            }





                        }
                    },







                    {
                        name: "pay",
                        width: 100,

                        label: '<div class="text-warning">การเบิกจ่าย</div>',

                        tree: true,

                        template: function(task) {
                            //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));

                            if (task.task_total_pay > 0) {
                                return '<span class="text-warning"">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.total_pay_paycon) + '</span>';

                            } else
                            if (task.task_type == 1) {
                                return '<span class="text-warning"">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.pay) + '</span>';
                            } else if (task.task_type == 2) {
                                return '<span class="text-warning"">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.pay) + '</span>';

                            } else if (task.total_pay_paycon > 0) {

                                return '<span class="text-warning"">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.total_pay_paycon) + '</span>';
                            } else {
                                return '-';
                            }
                        }
                    },



                    {
                        name: "balance2",
                        width: 100,



                        label: '<div class="text-primary">ยอดเงินคงเหลือ</div>',

                        tree: true,

                        template: function(task) {

                            var tmp_class = task.total_cost > 0 ? 'green' : 'green';
                            //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));
                            if (task.budget - task.total_cost === 0) {
                                return '-';
                            } else if (task.budget) {
                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {

                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget - task.total_cost) + '</span>';
                            } else {
                                return '';
                            }







                        }
                    },
                    {
    name: "link",
    label: "Link",
    width: 80,
    align: "center",
    template: function(task) {
        // Check if the task has a property named 'hashid'
        if(task.hashid && task.projectViewUrls) {
            // Use the URL from the task object
            return `<a href="${task.projectViewUrls}" class="text-white btn btn-success" target="_blank"><i class="cil-folder-open"></i></a>`;
        } else {
            // If there is no hashid or URL, display a default message or link
            return '-';
        }
    }
}




                   /*  {
                        name: "balance",
                        width: 100,



                        label: '<div class="text-success">-------</div>',

                        tree: true,

                        template: function(task) {
                            //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));

                            if (task.balance - task.total_pay === 0) {
                                return '-';
                            } else if (task.project_type == 1) {
                                var tmp_class = task.total_pay > 0 ? 'green' : 'green';
                                return '<span style="color:' + tmp_class + ';">' +
                                    new Intl.NumberFormat('th-TH', {
                                        style: 'currency',
                                        currency: 'THB'
                                    }).format(task.balance - task.total_pay)
                                '</span>';
                            } else if (task.project_type == 2) {
                                return '<span style="color:' + tmp_class + ';">' +
                                    new Intl.NumberFormat('th-TH', {
                                        style: 'currency',
                                        currency: 'THB'
                                    }).format(task.balance - task.total_pay)
                                '</span>';

                            } else {

                                return '';
                            }
                        }
                    } */
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
                    }).format(task.budget - task.total_cost) + '</span><br/>';
                }


         // Assuming `task.hashid` and `task.task_id.hashid` are variables already set in JavaScript
//var taskShowUrl = `/project/${task.hashid}/task/${task.task_id.hashid}`;
//var html = `<a href="${taskShowUrl}" class="btn btn-primary text-white"><i class="cil-folder-open"></i></a>`;


                return html;
            };

            gantt.ext.fullscreen.getFullscreenElement = function() {
                return document.querySelector("#gantt_here");
            };
            //Config

            gantt.config.date_format = "%Y-%m-%d";
           // gantt.config.link_attribute = "data-link-id"
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
                                width: 200,
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
                                width: 1200,
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
                    format: function(date) {
                        return parseInt(gantt.date.date_to_str("%Y")(date)) + 543;
                    },



                },
                {
                    unit: "month",
                    step: 1,
                    format: function(date) {
                        //const thaiMonthNames = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
                        const thaiMonthNames = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.",
                            "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
                        ];
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
    </x-slot:javascript>
</x-app-layout>
