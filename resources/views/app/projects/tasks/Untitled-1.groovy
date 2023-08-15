{
                        name: "balance_mm_pr",
                        width: 100,
                        label: "งบประมาณคงเหลือที่ไช้ได้",
                        tree: true,
                        resize: true,
                        template: function(task) {

                            if (task.budget_total_mm_pr2 > 0) {
                                var tmp_class = task.balance < 0 ? 'red' : 'green';
                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget_total_task_budget_end) + '</span>';
                            }










                      else if (task.task_parent_sub == 2 && task.budget_total_task_mm_sum > 1) {

                            var tmp_class = task.task_refund_pa_status == 2 ? 'magenta' : 'magenta';
                            return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                style: 'currency',
                                currency: 'THB'
                            }).format((task.tbalance_sub - task.budget_total_task_mm_sum )+task.total_task_refund_budget_status )+ '</span>';
                            }




                            else if (task.task_parent_sub == 2) {

                            var tmp_class = task.task_refund_pa_status == 2 ? 'blue' : 'green';
                            return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                style: 'currency',
                                currency: 'THB'
                            }).format(task.tbalance_sub) + '</span>';
                            }

/*
                            else if (task.task_parent_sub == 2) {

                            var tmp_class = task.task_refund_pa_status == 2 ? 'blue' : 'green';
                            return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                            style: 'currency',
                            currency: 'THB'
                            }).format(task.total_task_refund_pa_budget) + '</span>';
                            } */





                            else if (task.task_refund_pa_status == 2) {

                                var tmp_class = task.task_refund_pa_status == 2 ? 'blue' : 'green';
                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.task_refund_pa_budget) + '</span>';
                            }





                            else if (task.task_refund_pa_status == 3 && (task.task_type == 2 || task.task_type == 1)) {
                                var tmp_class = task.task_refund_pa_status == 3 ? 'blue' : 'blue';
                                var formattedValue = new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget - task.budget_mm + task.task_refund_pa_budget);

                                return '<span style="color:' + tmp_class + ';">' + formattedValue + '</span>';
                            }


                            else if (task.task_refund_pa_status == 3  && (task.task_status == 1)) {

                            var tmp_class = task.task_refund_pa_status == 3 ? 'green' : 'red';
                            return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                style: 'currency',
                                currency: 'THB'
                            }).format(task.budget-task.budget_total_task_mm_sum+task.total_task_refund_budget_status) + '</span>';
                            }



                                else if (task.task_refund_pa_status == 3  && (task.task_status == 2)) {

                                var tmp_class = task.task_refund_pa_status == 3 ? 'blue' : 'green';
                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget-task.budget_total_task_mm_sum+task.total_task_refund_budget_status) + '</span>';
                                }


                                else if (task.task_refund_pa_status == 4 && (task.task_status == 2)&& (task.task_type == null)  ) {

                            var tmp_class = task.task_refund_pa_status == 4 ? 'blue' : 'blue';
                            return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                style: 'currency',
                                currency: 'THB'
                            }).format(task.total_task_refund_pa_budget) + '</span>';
                            }


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


                             else if (task.budget_total_task_mm_sum > 0) {
                                var tmp_class = task.balance < 0 ? 'green' : 'green';
                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget-(task.budget_total_task_mm_sum)) + '</span>';
                            }

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

                            else if (task.cost > 0) {
                                var tmp_class = task.balance < 0 ? 'green' : 'green';

                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget-task.cost) + '</span>';
                            }

                            else if (task.budget > 0) {
                                var tmp_class = task.balance < 0 ? 'green' : 'green';
                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget-task.cost) + '</span>';
                            }

                            else if (task.budget_total_task_mm > 0) {
                                var tmp_class = task.balance < 0 ? 'green' : 'green';

                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget-task.budget_total_task_mm) + '</span>';
                            }
                            else if (task.cost_no_pa_2 > 0) {
                                var tmp_class = task.balance < 0 ? 'green' : 'green';
                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget-task.cost_no_pa_2) + '</span>';
                            }









                            else if (task.budget_mm > 0) {
                                var tmp_class = task.balance < 0 ? 'green' : 'green';
                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget-task.budget_mm) + '</span>';
                            }





                            else if (task.balance == 0) {
                                return '';
                            }



                            else {
                                return '';
                            }
                        }
                    }
                ]
            };
