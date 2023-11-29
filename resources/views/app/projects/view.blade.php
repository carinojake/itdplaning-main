<x-app-layout>
    <x-slot:content>
        <div class="container-fluid">

            <div class="animated fadeIn">
                <div class="row">
                    <!-- {!! 'ปีงบประมาณ ' .
                        $project->project_fiscal_year .
                        '<br>' .
                        Helper::projectsType($project->project_type) .
                        $project->project_name !!}-->
                    {{ Breadcrumbs::render('project.show', $project) }}

                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">

                        <x-card title="">

                            <x-slot:toolbar>
                                <a href="{{ route('project.edit', $project->hashid) }}"
                                    class="btn btn-warning text-dark">แก้ไข
                                    {{ Helper::projectsType($project->project_type) }} </a>


                                @if ($budget['budget_total_task_budget_end'] > 0)
                                    <a href="{{ route('project.task.create', $project->hashid) }}"
                                        class="btn btn-info text-white">เพิ่มกิจกรรม</a>

                                    <a href="{{ route('project.task.createcn', $project->hashid) }}"
                                        class="btn btn-success text-white">เพิ่มสัญญา</a>
                                    {{-- <a href="{{ route('project.task.createcn', $project->hashid) }}"
                                        class="btn btn-dark text-white">เพิ่มรายการที่ใช้จ่าย </a> --}}

                                    <a href="{{ route('project.task.createsubno', ['project' => $project->hashid]) }}"
                                        class="btn btn-dark text-white">เพิ่มรายการที่ใช้จ่าย </a>
                                @endif

                                <a href="{{ route('project.index') }}" class="btn btn-secondary">กลับ</a>
                            </x-slot:toolbar>

                            {{--  @include('partials.budgettotaloverview') --}}

                            @include('partials.view')

                            {{--       @include('partials.gantt_ict_here') --}}
                            {{-- เปลี่ยน ict ดำเนิน สา --}}

                            <div id="gantt_here" style='width:100%; height:50vh;'></div>
                            {{--
                          <div id="gantt_ict_here" style='width:100%; height:50vh;'></div>

                          <div id="gantt_in_here" style='width:100%; height:50vh;'></div>

                          <div id="gantt_u_here" style='width:100%; height:50vh;'></div> --}}

                            {{-- เปลี่ยน ict ดำเนิน สา --}}

                            <span style="color:rgb(255, 0, 0);" class="d-inline-block" tabindex="0"
                                data-coreui-toggle="popover" data-coreui-trigger="hover focus"
                                data-coreui-content="Disabled popover">
                                <button class="btn " type="button" disabled>หมายเหตุ</button>
                            </span>
                            <div class="tab-content">
                                <div class="mt-3">
                                    หมายเหตุ: <span style="color:rgb(7, 173, 7);">[ตัวเลขเขียว= งบประมาณคงเหลือ]</span>
                                    <span></span>
                                    <span style="color:blue;">[ตัวเลขน้ำเงิน= งบประมาณ คืน]</span>
                                </div>

                            </div>
                    </div>



                    <div class="callout callout-primary row mt-3">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#activity"
                                    data-bs-toggle="pill">กิจกรรมย่อย</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#subactivity" data-bs-toggle="pill">รายการที่ใช้จ่าย </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#contract" data-bs-toggle="pill">สัญญา</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="activity">
                                <!-- Content for Activity tab -->
                                @include('partials.activity')
                            </div>
                            <div class="tab-pane fade" id="subactivity">
                                <!-- Content for Subactivity tab -->
                                @include ('partials.expenses')
                            </div>
                            <div class="tab-pane fade" id="contract">
                                <!-- Content for Contract tab -->
                                @include('partials.contract')
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        </div>



        </x-card>
    </x-slot:content>
    <script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
    <x-slot:css>

        <link rel="stylesheet" href="{{ asset('/vendors/dhtmlx/dhtmlxgantt.css') }}" type="text/css">


        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">


        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />
        <meta name="viewport" content="width=device-width, initial-scale=1">


    </x-slot:css>
    <x-slot:javascript>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>


        <script src="https://docs.dhtmlx.com/gantt/codebase/dhtmlxgantt.js?v=7.1.13"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="https://unpkg.com/@popperjs/core@2.11.4/dist/umd/popper.min.js"></script>
        <script src="https://unpkg.com/bootstrap@5.7.0/dist/js/bootstrap.bundle.min.js"></script>





        <script>
            // เรียกใช้ Popover
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl, {
                    html: true
                });
            });
        </script>

        <script>
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();

                var rowid = $(this).data('rowid');
                var form = $(this).closest('form');

                Swal.fire({
                    title: 'คุณแน่ใจหรือไม่?',
                    text: "การกระทำนี้ไม่สามารถย้อนกลับได้!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่, ลบเลย!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        </script>



        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const popoverEl = document.querySelectorAll('[data-coreui-toggle="popover"]');
                Array.from(popoverEl).forEach(function(el) {
                    new coreui.Popover(el);
                });
            });
        </script>




        <script>
            gantt.plugins({
                marker: true,
                fullscreen: true,
                critical_path: true,
                auto_scheduling: true,
                tooltip: true,
                undo: true
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
                        width: 150,
                        label: "โครงการ/งานประจำ",
                        tree: true,
                        resize: true,
                        template(task) {
                            var tmp_class = task.task_refund_pa_status == 2 ? 'blue' : 'black';
                            var tmp_class3 = task.task_refund_pa_status == 3 ? 'blue' : 'black'
                            var tmp_class2 = task.task_status == 2 ? 'blue' : 'black';

                            if (task.task_refund_pa_status == 3) {

                                return '<span style="color:' + tmp_class3 + ';">' + "<b>" + task.text + "</b>" +
                                    '</span>';
                            } else if (gantt.getState().selected_task == task.id) {

                                return '<span style="color:' + tmp_class + ';">' + "<b>" + task.text + "</b>" +
                                    '</span>';
                            } else {
                                return '<span style="color:' + tmp_class + ';">' + "<b>" + task.text + "</b>" +
                                    '</span>';
                            };
                        }
                    },
                    //{name:"start_date", label:"Start time", align: "center" },
                    //  else if (task.sumSubroot_task_task_parent_sub_value_plus == 1 && task.task_refund_pa_status == 3  {name:"owner", width: 200, label:"Owner", template:function(task){
                    //   return task.owner}
                    // }
                ]
            };

            var rightGridColumns = {
                columns: [{
                        name: "budget",
                        width: 120,
                        label: "งบประมาณที่ได้รับการจัดสรร",
                        tree: true,
                        resize: true,
                        template: function(task) {
                            let pbalance = task.pbalance;
                            let tmp_class = "someColor"; // You need to define this variable

                            if (pbalance) {
                                return new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(pbalance);
                            } else if (task.task_type === null) {
                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.tbalance) + '</span>';
                            } else if (task.task_refund_pa_status === 4) {
                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.tbalance) + '</span>';
                            } else {
                                return '';
                            }
                        }
                    },


                    /*             if (task.budget) {
                                    return new Intl.NumberFormat('th-TH', {
                                        style: 'currency',
                                        currency: 'THB'
                                    }).format(task.budget_total_mm); */
                    /*
                                                }else if (task.budget_mm <  task.balance) {
                                                    return'<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                                        style: 'currency',
                                                        currency: 'THB'
                                                    }).format(task.budget_total_mm) + '</span>'; */
                    {
                        name: "budget_total_mm",
                        width: 100,
                        label: " MM/PR ",
                        tree: true,
                        resize: true,
                        template: function(task) {
                            var tmp_class = task.balance < 0 ? 'red' : 'dark';
                            if (task.task_type === null) {
                                return '';
                            } else if (task.budget_total_mm) {

                            } else if (task.budget_mm) {
                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget_mm) + '</span>';
                            } else if (task.budget_mm < task.balance) {
                                ''
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        name: "cost_pa",
                        width: 150,
                        label: "มี PA",
                        tree: true,
                        resize: true,
                        template: function(task) {



                            if (task.task_type == 1) {
                                return '<span style="color:#560775;">'  + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.cost);
                            } else
                            if (task.total_Leasttask_cost_1 > 0) {
                                return '<span style="color:#560775;">'  + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.total_Leasttask_cost_1) + '</span>';
                            } else


                            if (task.cost_pa_1 > 0) {
                                return '<span style="color:#560775;">'  + new Intl.NumberFormat('th-TH', {
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
                        label: "ไม่มี PA",
                        tree: true,
                        resize: true,
                        template: function(task) {
                            if (task.task_type == 2) {
                                return '<span style="color:#560775;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.cost);


                            } else if (task.total_Leasttask_cost_2 > 0) {
                                let total_Leasttask_cost_2 = task.total_Leasttask_cost_2;
                                return '<span style="color:#560775;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(total_Leasttask_cost_2) + '</span>';
                            } else if (task.cost_no_pa_2 > 0) {
                                let cost_no_pa_2 = task.cost_no_pa_2;
                                return '<span style="color:#560775;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(cost_no_pa_2) + '</span>';
                            } else {
                                return '-';
                            }
                        }
                    },
                    {
                        name: "wait_pay",
                        width: 100,
                        label: "รอการเบิกจ่าย",
                        tree: true,
                        resize: true,
                        template: function(task) {


                            if (task.total_cost > 0) {

                                if (task.total_cost - (task.total_pay + task.root_total_pay)=== 0) {
                                    return '-';
                                } else {
                                return '<span style="color:red;">'  + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.task_root_total_cost-(task.total_pay) ) + '</span>';
                            }
                        }

                            else if (task.root_rs_id == 1) {
                                if (task.total_cost_op_in_gov - task.total_pay_paycons_cte === 0) {
                                    return '-';
                                } else {
                                    return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                            style: 'currency',
                                            currency: 'THB'
                                        }).format(task.total_cost_op_in_gov - task.total_pay_paycons_cte) +
                                        '</span>';
                                }


                            } else if (task.root_two_rs_id == 2 && task.total_cost_op_in_gov > 0) {
                                if (task.total_cost_op_in_gov - task.total_pay_paycons_cte === 0) {
                                    return '-';
                                } else {
                                    return '<span style="color:red;">'  + new Intl.NumberFormat('th-TH', {
                                            style: 'currency',
                                            currency: 'THB'
                                        }).format(task.total_cost_op_in_gov - task.total_pay_paycons_cte) +
                                        '</span>';
                                }
                            } else if (task.totalLeastPay_Least > 0) {


                                return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format((task.total_cost_op_in_gov - task.total_pay_paycons_cte)) + '</span>';
                            }

                            /*     else if (task.task_parent_sub_cost > 0) {


                                                         return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                                             style: 'currency',
                                                             currency: 'THB'
                                                         }).format(task.task_parent_sub_cost - task.task_parent_sub_pay) + '</span>';
                                                    }
                         */

                            /*        else if (task.total_pay > 0) {
                                                                return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                                                    style: 'currency',
                                                                    currency: 'THB'
                                                                }).format(task.total_cost - task.total_pay) + '</span>';
                                                            }





                                                            else if (task.total_task_cost > 0 ) {
                                                                return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                                                    style: 'currency',
                                                                    currency: 'THB'
                                                                }).format(task.total_task_cost - task.task_total_pay) + '</span>';
                                                            }
                                 */


                            /*     else if (task.total_task_cost > 0) {


                                            return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                                style: 'currency',
                                                currency: 'THB'
                                            }).format(task.total_task_cost - task.pay) + '</span>';
                                            } */
                            else {
                                return '';
                            }
                        }
                    },
                    {
                        name: "pay",
                        width: 100,
                        label: "เบิกจ่ายแล้ว",
                        tree: true,
                        resize: true,
                        template: function(task) {
                          /*   if (task.task_total_pay > 0) {
                                return '<span class="text-warning">' + 1 + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.task_total_pay) + '</span>';
                            } */

                            if (task.root_st_task_pay == 1 ) {
                                if (task.root_st_task_pay === 0) {
                                    return '-';
                                } else {

                                return '<span class="text-warning">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.total_pay_paycons_cte) + '</span>';
                            }
                        }

                        else if (task.root_st_task_pay == 2 && task.total_pay_paycons_cte > 0) {


                                return '<span class="text-warning">'  + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.total_pay_paycons_cte) + '</span>';
                            }

                            else if (task.task_type == 1 && task.pay > 0 && task.p == 1 || task.p == 2 || task
                                .root_total_pay > 0) {
                                return '<span class="text-warning">'  + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format( task.root_total_pay) + '</span>';
                            }

                            else if (task.task_type == 1 && task.pay > 0 && task.p == 1 || task.p == 2 || task
                                .root_total_pay > 0) {
                                return '<span class="text-warning">'  + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.total_pay + task.root_total_pay) + '</span>';
                            }


                            else if (task.task_type == 2 && task.pay > 0 || task.root_total_pay > 0) {
                                return '<span class="text-warning">'  + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.pay) + '</span>';
                            } else if (task.total_pay > 0) {
                                return '<span class="text-warning">' +  new Intl.NumberFormat('th-TH', {
                                    /* style="color:#6010f6;" */
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.total_pay + task.root_total_pay) + '</span>';
                            } else if (task.total_pay_paycons_cte > 0) {
                                return '<span class="text-warning">'  + new Intl.NumberFormat('th-TH', {
                                    /* style="color:#6010f6;" */
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.total_pay_paycons_cte) + '</span>';
                            } else if (task.totalLeastPay_Least > 0 && task.task_total_pay > 0) {


                                return '<span class="text-warning"">'  + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.totalLeastPay_Least) + '</span>';
                            }


                            /*
                                                                                    else if (task.task_parent_sub_cost > 0) {


                                                                                        return '<span class="text-warning"">' +10+ new Intl.NumberFormat('th-TH', {
                                                                                            style: 'currency',
                                                                                            currency: 'THB'
                                                                                        }).format(task.task_parent_sub_pay) + '</span>';
                                                                                    } */
                            else {
                                return '-';
                            }
                        }
                    },
                    {
                        name: "balance_mm_pr",
                        width: 100,
                        label: "งบประมาณคงเหลือที่ไช้ได้",
                        tree: true,
                        resize: true,
                        template: function(task) {


                            /*   if (task.p == 1 && task.budget_total_task_budget_end < 0) {
                                  var tmp_class = task.balance < 0 ? 'red' : 'green';
                                  return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                      style: 'currency',
                                      currency: 'THB'
                                  }).format(0) + '</span>';
                              } */
                            if (task.p == 1 && task.budget_total_task_budget_end < 0) {
                                var tmp_class = task.balance < 0 ? 'red' : 'green';
                                return '1<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget_total_task_budget_end_3) + '</span>';
                            } else if (task.p == 1 && task.budget_total_task_budget_end > 0) {
                                var tmp_class = task.balance < 0 ? 'red' : 'green';
                                var tmp_class = (task.balance+task.total_task_refund_pa_budget_null)-task.total_task_budget_null > task.balance ? 'blue' : 'blue';
                                return '2<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget_total_task_budget_end) + '</span>';
                            }


                            else if (task.p == 1) {
                                var tmp_class = task.balance < 0 ? 'red' : 'green';
                                var tmp_class = (task.balance+task.total_task_refund_pa_budget_null)-task.total_task_budget_null > task.balance ? 'blue' : 'blue';

                                return '3<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget_total_task_budget_end) + '</span>';
                            }


                            else if (task.p == 2 && task.budget_total_task_budget_end < 0) {
                                var tmp_class = task.balance < 0 ? 'red' : 'green';
                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget_total_task_budget_end_3) + '</span>';
                            } else if (task.p == 2 && task.budget_total_task_budget_end > 0) {
                                var tmp_class = task.balance < 0 ? 'red' : 'green';
                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget_total_task_budget_end) + '</span>';
                            } else if (task.p == 2) {
                                var tmp_class = task.balance < 0 ? 'red' : 'green';
                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget_total_task_budget_end) + '</span>';
                            } else if (task.task_parent_sub_refund_pa_status == 4) {
                                var tmp_class = task.balance < 0 ? 'green' : 'green';
                                var tmp_class = task.task_refund_pa_status == 3 ? 'blue' : 'green';

                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format((task.budget - (task.budget_total_task_mm_sum)) + task
                                    .total_task_refund_budget_status + task.task_refund_pa_budget) + '</span>';
                            }




                            else if (task.root_rs_id == 1 && task.sumSubroot_task_task_parent_sub_value_plus ==
                                1) {
                                var tmp_class = task.balance < 0 ? 'blue' : 'blue';
                                var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 2 ? 'blue' :
                                    'green';

                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                        style: 'currency',
                                        currency: 'THB'
                                    }).format(task.budget - task.root_budget_mm + task.root_st_new_balance_re) +
                                    '</span>';
                            } else if (task.sumSubroot_task_task_parent_sub_value_plus == 1 && task
                                .total_cost_op_in_gov > 0 && task.total_refund_starut_b_root < 2) {
                                var tmp_class = task.balance < 0 ? 'blue' : 'blue';
                                var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 2 ? 'blue' :
                                    'green';

                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget - task.total_cost_op_in_gov) + '</span>';
                            } else if (task.sumSubroot_task_task_parent_sub_value_plus == 1 && task
                                .total_cost_op_in_gov > 0) {
                                var tmp_class = task.balance < 0 ? 'blue' : 'blue';
                                var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 2 ? 'blue' :
                                    'green';

                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget - task.total_cost_op_in_gov) + '</span>';
                            } else if (task.sumSubroot_task_task_parent_sub_value_plus == 1) {
                                var tmp_class = task.balance < 0 ? 'blue' : 'blue';
                                var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 2 ? 'blue' :
                                    'green';

                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget) + '</span>';
                            } else if (task.root_two_rs_id == 2 && task
                                .sumSubroot_task_task_parent_sub_value_plus == 2) {
                                var tmp_class = task.balance < 0 ? 'blue' : 'blue';
                                var tmp_class = task.task_refund_pa_status == 2 ? 'blue' :
                                    'green';

                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                        style: 'currency',
                                        currency: 'THB'
                                    }).format(task.budget - task.root_two_budget_mm + task
                                    .root_two_new_balance_re) + '</span>';
                            } else if (task.sumSubroot_task_task_parent_sub_value_plus == 2 && task
                                .total_cost_op_in_gov > 0) {
                                var tmp_class = task.balance < 0 ? 'blue' : 'blue';
                                var tmp_class = task.task_refund_pa_status == 2 && task.task_status == 2 ? 'blue' :
                                    'green';

                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget - task.total_cost_op_in_gov) + '</span>';
                            } else if (task.sumSubroot_task_task_parent_sub_value_plus == 2) {
                                var tmp_class = task.balance < 0 ? 'blue' : 'blue';
                                var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 2 ? 'blue' :
                                    'green';

                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget) + '</span>';
                            } else if (task.sumSubroot_task_task_parent_sub_value_plus == 3 && task
                                .total_cost_op_in_gov > 0) {
                                var tmp_class = task.balance < 0 ? 'blue' : 'blue';
                                var tmp_class = task.task_refund_pa_status == 2 ? 'blue' :
                                    'green';

                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget - task.total_cost_op_in_gov) + '</span>';
                            } else if (task.sumSubroot_task_task_parent_sub_value_plus == 3) {
                                var tmp_class = task.balance < 0 ? 'blue' : 'blue';
                                var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 2 ? 'blue' :
                                    'green';

                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget) + '</span>';
                            }

                            else if (task.sumSubroot_task_task_parent_sub_value_plus == 0) {
                                var tmp_class = task.balance < 0 ? 'blue' : 'blue';
                                var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 2 ? 'blue' :
                                    'green';

                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget - task.total_cost_op_in_gov) + '</span>';
                            }
                            //no
                            /*    else if (task.budget_total_task_mm_sum > 0 && task.total_refund_starut_b > 2) {
                                  var tmp_class = task.balance < 0 ? 'blue' : 'blue';
                                  var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 2 ? 'blue' :
                                      'green';

                                  return '<span style="color:' + tmp_class + ';">' +11 +new Intl.NumberFormat('th-TH', {
                                      style: 'currency',
                                      currency: 'THB'
                                  }).format(task.netSubtotal) + '</span>';
                              }

                              else if (task.budget_total_task_mm_sum > 0 && task.task_root_task_refund_pa_status ==
                                  2) {
                                  var tmp_class = task.balance < 0 ? 'blue' : 'blue';
                                  var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 2 ? 'blue' :
                                      'green';

                                  return '<span style="color:' + tmp_class + ';">' +22+ new Intl.NumberFormat('th-TH', {
                                      style: 'currency',
                                      currency: 'THB'
                                  }).format((task.netSubtotal)) + '</span>';
                              }
                                    else if (task.budget_total_task_mm_sum > 0 && task.total_refund_starut_b < 2) {
                                       var tmp_class = task.balance < 0 ? 'blue' : 'blue';
                                       var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 2 ? 'blue' :
                                           'green';

                                       return '<span style="color:' + tmp_class + ';">' +33+ new Intl.NumberFormat('th-TH', {
                                           style: 'currency',
                                           currency: 'THB'
                                       }).format((task.budget - task.budget_total_task_mm_sum + task
                                           .task_total_sum_task_refund_pa_budget)) + '</span>';
                                   } */
                            //no

                            //up
                            /*   else if (task.task_status == 1 && task.task_parent_sub == 99) {
                                        var tmp_class = task.balance < 0 ? 'green' : 'green';
                                        var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 1 ? 'blue' :
                                            'green';
                                        return '<span style="color:' + tmp_class + ';">' +44+ new Intl.NumberFormat('th-TH', {
                                            style: 'currency',
                                            currency: 'THB'
                                        }).format(task.budget - task.cost) + '</span>';
                                    }

                                    else if (task.task_refund_pa_status == 3 && task.task_parent_sub_refund_pa_status ==
                                        99) {
                                        var tmp_class = task.balance < 0 ? 'green' : 'green';
                                        var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 1 ? 'blue' :
                                            'green';
                                        return '<span style="color:' + tmp_class + ';">' +55+ new Intl.NumberFormat('th-TH', {
                                            style: 'currency',
                                            currency: 'THB'
                                        }).format(task.budget - task.cost) + '</span>';
                                    }


                                    else if (task.sumSubroot_task_task_parent_sub_value_plus == 1 && task.task_refund_pa_status == 3  && task.total_refund_starut_b >! 2 ) {
                                        var tmp_class = task.balance < 0 ? 'green' : 'green';
                                        var tmp_class = task.task_refund_pa_status == 3  ? 'blue' :
                                            'green';
                                        return '<span style="color:' + tmp_class + ';">' +66+ new Intl.NumberFormat('th-TH', {
                                            style: 'currency',
                                            currency: 'THB'
                                        }).format(task.total_sum_budget_op_in_gov-task.total_cost_op_in_gov) + '</span>';
                                    }

                                    else if (task.sumSubroot_task_task_parent_sub_value_plus == 1 && task.task_refund_pa_status == 3 ) {
                                        var tmp_class = task.balance < 0 ? 'green' : 'green';
                                        var tmp_class = task.task_refund_pa_status == 3  ? 'blue' :
                                            'green';
                                        return '<span style="color:' + tmp_class + ';">' +77+ new Intl.NumberFormat('th-TH', {
                                            style: 'currency',
                                            currency: 'THB'
                                        }).format((task.budget - (task.budget_total_task_mm_sum)) + task
                                            .total_task_refund_budget_status) + '</span>';
                                    }


                                    else if (task.sumSubroot_task_task_parent_sub_value_plus == 1
                                    &&  task.budget_total_task_mm_sum > task.budget
                                    && task.task_refund_pa_status == 1 && task.total_refund_starut_b < 2 ) {
                                        var tmp_class = task.balance < 0 ? 'green' : 'green';
                                        var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 1 ? 'blue' :
                                            'green';
                                        return '<span style="color:' + tmp_class + ';">' +88 +new Intl.NumberFormat('th-TH', {
                                            style: 'currency',
                                            currency: 'THB'
                                        }).format(( (task.total_task_refund_budget_status))) + '</span>';
                                    }



                                    else if (task.sumSubroot_task_task_parent_sub_value_plus == 1 && task.budget - task.budget_total_task_mm_sum < 0  && task.task_refund_pa_status == 1 && task.total_refund_starut_b < 2 ) {
                                        var tmp_class = task.balance < 0 ? 'green' : 'green';
                                        var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 1 ? 'blue' :
                                            'green';
                                        return '<span style="color:' + tmp_class + ';">' +99 +new Intl.NumberFormat('th-TH', {
                                            style: 'currency',
                                            currency: 'THB'
                                        }).format((task.budget - task.budget_total_task_mm_sum + (task.task_total_sum_task_refund_pa_budget))) + '</span>';
                                    }
                                      else if (task.sumSubroot_task_task_parent_sub_value_plus == 1
                                    && task.total_task_refund_budget_status >0 && task.total_refund_starut_b < 2 ) {
                                        var tmp_class = task.balance < 0 ? 'green' : 'green';
                                        var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 1 ? 'blue' :
                                            'green';
                                        return '<span style="color:' + tmp_class + ';">' +1010 + new Intl.NumberFormat('th-TH', {
                                            style: 'currency',
                                            currency: 'THB'
                                        }).format((task.budget - task.total_cost_op_in_gov)) + '</span>';
                                    }

                                    else if (task.sumSubroot_task_task_parent_sub_value_plus == 1 && task.task_refund_pa_status == 1 && task.total_refund_starut_b > 2 ) {
                                        var tmp_class = task.balance < 0 ? 'green' : 'green';
                                        var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 1 ? 'blue' :
                                            'green';
                                        return '<span style="color:' + tmp_class + ';">' +1011 + new Intl.NumberFormat('th-TH', {
                                            style: 'currency',
                                            currency: 'THB'
                                        }).format((task.budget - task.budget_total_task_mm_sum + task.task_total_sum_task_refund_pa_budget)) + '</span>';
                                    }

                                    else if (task.sumSubroot_task_task_parent_sub_value_plus == 1 && task.budget - task.budget_total_task_mm_sum < 0  && task.task_refund_pa_status == 1 && task.total_refund_starut_b < 2 ) {
                                        var tmp_class = task.balance < 0 ? 'green' : 'green';
                                        var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 1 ? 'blue' :
                                            'green';
                                        return '<span style="color:' + tmp_class + ';">' +1012 +new Intl.NumberFormat('th-TH', {
                                            style: 'currency',
                                            currency: 'THB'
                                        }).format((task.budget - task.budget_total_task_mm_sum + (task.task_total_sum_task_refund_pa_budget))) + '</span>';
                                    }
         */

                            /*   else if (task.task_root_task_task_parent_sub_value== 2
                             && task.sumSubroot_task_task_parent_sub_value_plus == 1  && task.task_refund_pa_status == 1 && task.total_refund_starut_b < 2 ) {
                                  var tmp_class = task.balance < 0 ? 'green' : 'green';
                                  var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 1 ? 'blue' :
                                      'green';
                                  return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                      style: 'currency',
                                      currency: 'THB'
                                  }).format(444444) + '</span>';
                              } */


                            /*

                                                        else if (task.sumSubroot_task_task_parent_sub_value_plus == 1  && task.task_refund_pa_status == 1 && task.total_refund_starut_b_root > 1.99) {
                                                            var tmp_class = task.balance < 0 ? 'green' : 'green';
                                                            var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 1 ? 'blue' :
                                                                'green';
                                                            return '<span style="color:' + tmp_class + ';">' +111+ new Intl.NumberFormat('th-TH', {
                                                                style: 'currency',
                                                                currency: 'THB'
                                                            }).format(task.netSubtotal) + '</span>';
                                                        }


                                                        else if (task.sumSubroot_task_task_parent_sub_value_plus == 2 && task.task_refund_pa_status == 2) {
                                                            var tmp_class = task.balance < 0 ? 'green' : 'green';
                                                            var tmp_class = task.task_refund_pa_status == 2 && task.task_status == 2 ? 'blue' :
                                                                'green';
                                                            return '<span style="color:' + tmp_class + ';">' +221+ new Intl.NumberFormat('th-TH', {
                                                                style: 'currency',
                                                                currency: 'THB'
                                                            }).format(task.budget-task.total_task_cost) + '</span>';
                                                        }

                                                        else if (task.sumSubroot_task_task_parent_sub_value_plus == 2
                                                        && task.task_refund_pa_status == 1 && task.total_refund_starut_b < 0
                                                        ) {
                                                            var tmp_class = task.balance < 0 ? 'green' : 'green';
                                                            var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 1 ? 'blue' :
                                                                'green';
                                                            return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                                                style: 'currency',
                                                                currency: 'THB'
                                                            }).format((task.budget - task.budget_total_task_mm_sum + task
                                                                .task_total_sum_task_refund_pa_budget)) + '</span>';
                                                        }




                                                        else if (task.budget_total_task_mm_sum > 0 && task.total_refund_starut_b < 2) {
                                                            var tmp_class = task.balance < 0 ? 'blue' : 'blue';
                                                            var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 2 ? 'blue' :
                                                                'green';

                                                            return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                                                style: 'currency',
                                                                currency: 'THB'
                                                            }).format((task.budget - task.budget_total_task_mm_sum + task
                                                                .task_total_sum_task_refund_pa_budget)) + '</span>';
                                                        }

                                                        else if (task.sumSubroot_task_task_parent_sub_value_plus < 1 && task.budget_total_task_mm_sum > 0 && task.total_refund_starut_b > 0) {
                                                            var tmp_class = task.balance < 0 ? 'green' : 'green';
                                                            var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 2 ? 'blue' :
                                                                'green';

                                                            return '<span style="color:' + tmp_class + ';">' +77+ new Intl.NumberFormat('th-TH', {
                                                                style: 'currency',
                                                                currency: 'THB'
                                                            }).format((task.budget - (task.budget_total_task_mm_sum)) + task
                                                                .total_task_refund_budget_status) + '</span>';
                                                        }



                                                 else if (task.budget_total_task_mm_sum > 0 && task.total_refund_starut_b < 2) {
                                                            var tmp_class = task.balance < 0 ? 'blue' : 'blue';
                                                            var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 2 ? 'blue' :
                                                                'green';

                                                            return '<span style="color:' + tmp_class + ';">' +88+ new Intl.NumberFormat('th-TH', {
                                                                style: 'currency',
                                                                currency: 'THB'
                                                            }).format((task.budget - task.budget_total_task_mm_sum+task.task_total_sum_task_refund_pa_budget)) + '</span>';
                                                        }

                                                         else if (task.total_refund_starut_b == 1 && task.cost == 0) {

                                                            var tmp_class = task.task_refund_pa_status == 2 ? 'blue' : 'green';
                                                            return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                                                style: 'currency',
                                                                currency: 'THB'
                                                            }).format(task.budget - task.cost) + '</span>';
                                                        }






                                                        else if (task.task_refund_pa_status == 2) {

                                                            var tmp_class = task.task_refund_pa_status == 2 ? 'blue' : 'green';
                                                            return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                                                style: 'currency',
                                                                currency: 'THB'
                                                            }).format(task.task_refund_pa_budget) + '</span>';
                                                        }
                                                        /*3*/
                            /*   else if (task.cost > 0 && task.task_parent_sub == 99) {
                                 var tmp_class = task.balance < 0 ? 'green' : 'green';
                                 var tmp_class = task.task_refund_pa_status == 3  ? 'blue' :
                                     'green';
                                 return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                     style: 'currency',
                                     currency: 'THB'
                                 }).format(task.budget - task.cost) + '</span>';
                             }
                             else if (task.cost > 0) {
                                 var tmp_class = task.balance < 0 ? 'green' : 'green';
                                 var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 2 ? 'blue' :
                                     'green';
                                 return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                     style: 'currency',
                                     currency: 'THB'
                                 }).format(task.budget - task.cost) + '</span>';
                             }
                             else if (task.sumSubroot_task_task_parent_sub_value_plus == 3) {
                                 var tmp_class = task.balance < 0 ? 'green' : 'green';
                                 var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 2 ? 'blue' :
                                     'green';
                                 return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                     style: 'currency',
                                     currency: 'THB'
                                 }).format(task.budget - task.cost) + '</span>';
                             }
                                 else if (task.task_parent_sub == 2 && task.netSubtotal == 0) {
                                    var tmp_class = task.balance < 0 ? 'green' : 'green';
                                    var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 2 ? 'blue' :
                                        'green';
                                    return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                        style: 'currency',
                                        currency: 'THB'
                                    }).format(task.task_parent_sub_budget) + '</span>';
                                } */
                            /*   else if (task.balance == 0) {
                                  return '';
                              } */
                            else if (task.budget > 0.00) {
                                var tmp_class = task.balance < 0 ? 'red' : 'red';
                                var tmp_class = task.task_refund_pa_status == 3 && task.task_status == 1 ? 'blue' :
                                    'red';
                                return '<span style="color:' + tmp_class + ';">' + 09 + new Intl.NumberFormat(
                                    'th-TH', {
                                        style: 'currency',
                                        currency: 'THB'
                                    }).format(0) + '</span>';
                            }
                            /* 1   else if (task.total_refund_starut_b == 1) {
                                                   var tmp_class = task.task_refund_pa_status == 1 ? 'green' : 'green';
                                                   return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                                       style: 'currency',
                                                       currency: 'THB'
                                                   }).format(task.budget_total_task_budget_end) + '</span>';
                                                   } */

                            /*   else if (task.task_root_task_refund_pa_status == 2 && task.task_root_task_task_parent_sub_value == 2 && task.task_refund_pa_status == 3
                              && task.total_refund_starut_b > 2) {
                                  var tmp_class = task.task_refund_pa_status == 3 ? 'blue' : 'blue';
                                  return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                      style: 'currency',
                                      currency: 'THB'
                                  }).format(task.totalLeastBudget-task.totalLeastCost) + '</span>';


                              } */

                            /*     else if (task.task_root_task_refund_pa_status == 2 && task.task_root_task_task_parent_sub_value == 2) {
                                    var tmp_class = task.balance < 0 ? 'red' : 'green';
                                    return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                        style: 'currency',
                                        currency: 'THB'
                                    }).format(task.task_total_sum_task_refund_pa_budget) + '</span>';
                                }
                                task_root_task_refund_pa_status */

                            /*   else if (task.task_root_task_refund_pa_status == 1 && task.task_root_task_task_parent_sub_value == 2) {
                                  var tmp_class = task.balance < 0 ? 'red' : 'green';
                                  return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                      style: 'currency',
                                      currency: 'THB'
                                  }).format(task.tbalance-task.totalLeastCost) + '</span>';
                              } */


                            /*    else if (task.task_root_task_refund_pa_status == 1 && task.task_root_task_task_parent_sub_value == 2) {
                                   var tmp_class = task.balance < 0 ? 'red' : 'green';
                                   return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                       style: 'currency',
                                       currency: 'THB'
                                   }).format(task.tbalance-task.totalLeastCost) + '</span>';


                               } */
                            /*
                                                        if (task.task_root_task_refund_pa_status == 2 && task.task_root_task_task_parent_sub_value == 2) {
                                                            var tmp_class = task.balance < 0 ? 'red' : 'green';
                                                            return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                                                style: 'currency',
                                                                currency: 'THB'
                                                            }).format(task.task_total_sum_task_refund_pa_budget) + '</span>';


                                                        } */

                            /*   else if (task.p == 2) {
                                  var tmp_class = task.balance < 0 ? 'red' : 'green';
                                  return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                      style: 'currency',
                                      currency: 'THB'
                                  }).format(task.budget_total_task_budget_end_p2) + '</span>';
                              } */

                            // else if (task.task_refund_pa_status == 3 && (task.task_type == 2 || task.task_type ==1)) {
                            //     var tmp_class = task.task_refund_pa_status == 3 ? 'blue' : 'blue';
                            //     var formattedValue = new Intl.NumberFormat('th-TH', {
                            //         style: 'currency',
                            //         currency: 'THB'
                            //     }).format(task.budget - task.budget_mm + task.task_refund_pa_budget);

                            //     return '<span style="color:' + tmp_class + ';">' + formattedValue + '</span>';
                            // }



                            // else if (task.task_refund_pa_status == 3 && (task.task_type == 2 || task.task_type ==1)) {
                            //     var tmp_class = task.task_refund_pa_status == 3 ? 'blue' : 'blue';
                            //     var formattedValue = new Intl.NumberFormat('th-TH', {
                            //         style: 'currency',
                            //         currency: 'THB'
                            //     }).format(task.budget - task.budget_mm + task.task_refund_pa_budget);

                            //     return '<span style="color:' + tmp_class + ';">' + formattedValue + '</span>';
                            // }

                            /*
                                                        else if (task.task_refund_pa_status == 3 && (task.task_status == 1)) {

                                                            var tmp_class = task.task_refund_pa_status == 3 ? 'green' : 'red';
                                                            return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                                                style: 'currency',
                                                                currency: 'THB'
                                                            }).format(task.budget - task.budget_total_task_mm_sum + task
                                                                .total_task_refund_budget_status) + '</span>';

                                                            } */

                            /*

                                                            else if (task.task_refund_pa_status == 1 && task.task_parent_sub_refund_pa_status == 2
                                                            && task.task_parent_sub == null

                                                            ) {
                                                            var tmp_class = task.task_refund_pa_status == 3 ? 'blue' : 'green';
                                                            var formattedValue = new Intl.NumberFormat('th-TH', {
                                                                style: 'currency',
                                                                currency: 'THB'
                                                            }).format(task.task_refund_pa_budget+task.total_task_refund_pa_budget);

                                                            return '<span style="color:' + tmp_class + ';">' + formattedValue + '</span>';
                                                        }
                             */
                            /*     else if (task.task_status == 1 && task.task_refund_pa_status == 1  && task.task_parent_sub_refund_pa_status == 3
                                    && task.task_parent_sub == null

                                    ) {
                                    var tmp_class = task.task_refund_pa_status == 3 ? 'blue' : 'green';
                                    var formattedValue = new Intl.NumberFormat('th-TH', {
                                        style: 'currency',
                                        currency: 'THB'
                                    }).format(task.totalleactdifference);

                                    return '<span style="color:' + tmp_class + ';">' + formattedValue + '</span>';
                                }

                                   else if (task.task_type == null && task.task_refund_pa_status == 1 && task
                                    .task_parent_sub_refund_pa_status == 2) {

                                    var tmp_class = task.task_refund_pa_status == 2 ? 'blue' : 'green';
                                    return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                        style: 'currency',
                                        currency: 'THB'
                                    }).format((task.totalleactdifference)) + '</span>';
                                }


                                else if (task.task_type == null && task.task_refund_pa_status == 2 && task
                                    .task_parent_sub_refund_pa_status == 2) {

                                    var tmp_class = task.task_refund_pa_status == 1 ? 'blue' : 'green';
                                    return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                        style: 'currency',
                                        currency: 'THB'
                                    }).format((task.totalleactdifference)) + '</span>';
                                }

                                else if (task.task_type == null && task.task_refund_pa_status == 3 && task
                                    .task_parent_sub_refund_pa_status == 2) {

                                    var tmp_class = task.task_refund_pa_status == 3 ? 'blue' : 'green';
                                    return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                        style: 'currency',
                                        currency: 'THB'
                                    }).format((task.totalleactdifference)) + '</span>';
                                } */
                            /*
                                                        else if (task.task_parent == null && task.task_type == null && task.task_status == 1
                                                        && task.task_refund_pa_status == 1 && task.task_parent_sub_refund_pa_status == 2) {

                                                            var tmp_class = task.task_refund_pa_status == 2 ? 'blue' : 'green';
                                                            return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                                                style: 'currency',
                                                                currency: 'THB'
                                                            }).format((task.totalLeasttask_refund_pa_budget)) + '</span>';
                                                        }


                                                        else if (task.task_parent == null && task.task_type == null
                                                        && task.task_refund_pa_status == 2 && task.task_parent_sub_refund_pa_status == 2) {

                                                            var tmp_class = task.task_refund_pa_status == 2 ? 'blue' : 'green';
                                                            return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                                                style: 'currency',
                                                                currency: 'THB'
                                                            }).format((task.totalLeasttask_refund_pa_budget)) + '</span>';
                                                        }


                                                         else if (task.task_type == null && task.task_status == 1 && task.task_refund_pa_status == 2 && task
                                                            .task_parent_sub_refund_pa_status == 2) {

                                                            var tmp_class = task.task_refund_pa_status == 3 ? 'blue' : 'green';
                                                            return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                                                style: 'currency',
                                                                currency: 'THB'
                                                            }).format((task.totalleactdifference)) + '</span>';
                                                        }

                             */
                            /*       else if (task.task_root_task_refund_pa_status == 2) {

                                  var tmp_class = task.task_root_task_refund_pa_status == 2 ? 'blue' : 'green';
                                  return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                      style: 'currency',
                                      currency: 'THB'
                                  }).format(task.task_total_sum_task_refund_pa_budget) + '</span>';
                                  } */


                            /*   else if (task.budget_total_task_mm_sum > 0 && task.task_refund_pa_status == "3" &&
                                  task.task_parent_sub_refund_pa_status == "4" && task.type == "task") {
                                  var tmp_class = task.balance < 0 ? 'green' : 'green';
                                  var tmp_class = task.task_refund_pa_status == 3 ? 'blue' : 'green';

                                  return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                      style: 'currency',
                                      currency: 'THB'
                                  }).format((task.budget - (task.budget_total_task_mm_sum)) + task
                                      .total_task_refund_budget_status) + '</span>';
                              }



                              else if (task.budget_total_task_mm_sum > 0 && task.task_parent_sub_refund_pa_status == 3 && task.task_parent_sub_refund_pa_status == 2) {
                                  var tmp_class = task.balance < 0 ? 'green' : 'green';
                                  var tmp_class =task.task_refund_pa_status == 3 && task.task_status == 2 ? 'blue' : 'green';

                                  return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                      style: 'currency',
                                      currency: 'THB'
                                  }).format((task.budget - (task.total_Leasttask_cost_2)) ) + '</span>';
                              } */





                            /*      else if (task.budget > 0) {
                                     var tmp_class = task.balance < 0 ? 'green' : 'green';
                                     return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                         style: 'currency',
                                         currency: 'THB'
                                     }).format(task.budget - task.cost) + '</span>';
                                 } */
                            /*
                                 else if (task.budget_total_task_mm > 0) {
                                     var tmp_class = task.balance < 0 ? 'green' : 'green';

                                     return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                         style: 'currency',
                                         currency: 'THB'
                                     }).format(task.budget - task.budget_total_task_mm) + '</span>';
                                 }
                                  */
                            /*    else if (task.cost_no_pa_2 > 0) {
                                   var tmp_class = task.balance < 0 ? 'green' : 'green';
                                   return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                       style: 'currency',
                                       currency: 'THB'
                                   }).format(task.budget - task.cost_no_pa_2) + '</span>';
                               } */
                            /*
                               else if (task.budget_mm > 0) {
                                   var tmp_class = task.balance < 0 ? 'green' : 'green';
                                   return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                       style: 'currency',
                                       currency: 'THB'
                                   }).format(task.budget - task.budget_mm) + '</span>';
                               }
                                */


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
                }).format(task.budget_gov_operating) : '';
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
                                                                                                                <td colspan="3">เงินงบประมาณ<br>(งบประมาณขอรัฐบาล)</td>\
                                                                                                                <td colspan="2">งบกลาง IT</td>\
                                                                                                                <td rowspan="2">รวมทั้งหมด<br>(เงินงบประมาณ+งบกลาง)</td>\
                                                                                                              </tr>';
                    html += '<tr>\
                                                                                                                <td>งบดำเนินงาน<br>(ค่าใช้สอยต่างๆ)</td>\
                                                                                                                <td>งบลงทุน IT<br>(ครุภัณฑ์ต่างๆ)</td>\
                                                                                                                <td>ค่าสาธารณูปโภค</td>\
                                                                                                                <td>งบดำเนินงาน<br>(ค่าใช้สอยต่างๆ)</td>\
                                                                                                                <td>งบลงทุน<br>(ครุภัณฑ์ต่างๆ)</td>\
                                                                                                              </tr>';
                    if (task.type == 'task') {
                        html += '<tr class="text-end">\
                                                                                                                <td>-' +
                            budget_gov_operating + '</td>\
                                                                                                                <td>' +
                            budget_gov_investment + '</td>\
                                                                                                                <td>' +
                            budget_gov_utility + '</td>\
                                                                                                                <td>' +
                            budget_it_operating + '</td>\
                                                                                                                <td>' +
                            budget_it_investment +
                            '</td>\
                                                                                                                <td class="text-success">' +
                            budget + '</td>\
                                                                                                              </tr>';
                    } else {
                        html += '<tr class="text-end">\
                                                                                                                <td>' +
                            budget_gov_operating + '</td>\
                                                                                                                <td>' +
                            budget_gov_investment + '</td>\
                                                                                                                <td>' +
                            budget_gov_utility + '</td>\
                                                                                                                <td>' +
                            budget_it_operating + '</td>\
                                                                                                                <td>' +
                            budget_it_investment +
                            '</td>\
                                                                                                                <td class="text-success">' +
                            budget + '</td>\
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
                                width: 1,
                                height: 20
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
                    step: 2,
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


            /*
                            else if (task.task_parent_sub == 2) {

                            var tmp_class = task.task_refund_pa_status == 2 ? 'blue' : 'green';
                            return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                            style: 'currency',
                            currency: 'THB'
                            }).format(task.total_task_refund_pa_budget) + '</span>';
                            } */

            /*     else if (total_task_mm_budget_2> 0) {
                    var tmp_class = task.balance < 0 ? 'red' : 'green';
                    return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                        style: 'currency',
                        currency: 'THB'
                    }).format(task.total_task_mm_budget_2-task.total_task_refund_pa_budget_2) + '</span>';
                } */
            /*
                                        else if (task.budget_total_mm_pr2 > 0) {
                                            var tmp_class = task.balance < 0 ? 'red' : 'green';
                                            return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                                style: 'currency',
                                                currency: 'THB'
                                            }).format(task.budget_total_mm_pr2) + '</span>';
                                        } */

            /* else if (task.budget_total_task_mm > 0) {
                var tmp_class = task.balance < 0 ? 'red' : 'green';
                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget-(task.budget_total_task_mm-task.total_task_refund_pa_budget)) + '</span>';
            } */


            /*         else if (task.task_refund_pa_status  == null) {
                        var tmp_class = task.balance < 0 ? 'red' : 'blue';

                        return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                            style: 'currency',
                            currency: 'THB'
                        }).format(task.budget-task.cost) + '</span>';
                    } */
        </script>






    </x-slot:javascript>
</x-app-layout>
