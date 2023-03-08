<x-app-layout>
  <x-slot:content>
    <div class="container-fluid">
      <div class="animated fadeIn">
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <x-card title="{{ $contract->contract_name }}">
              <x-slot:toolbar>
                <a href="{{ route('contract.edit', $contract->hashid) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('contract.task.create', $contract->hashid) }}" class="text-white btn btn-success">Add Task</a>

                <a href="{{ route('contract.index') }}" class="btn btn-secondary">Back</a>
              </x-slot:toolbar>
              <table class="table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Task Name</th>

                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($contract->task as $task)
                    <tr>
                      <td></td>
                      <td>
                        {{ $task['task_name'] }}<br>
                        <span class="badge bg-primary">{{ \Helper::date($task->task_start_date) }}</span>
                        <span class="badge bg-primary">{{ \Helper::date($task->task_end_date) }}</span>
                      </td>
                      <td class="text-end">
                        <a href="{{ route('project.show', ['project' => $task->project_hashid]) }}" class="text-white btn btn-success"><i class="cil-folder-open "></i> Project</a>
                        <a href="{{ route('project.task.show', ['project' => $task->project_hashid, 'task' => $task->hashid]) }}" class="text-white btn btn-primary"><i class="cil-folder-open "></i> Task</a>
                        {{-- <a href="{{ route('contract.task.edit', ['contract' => $contract->hashid, 'task' => $task->hashid]) }}" class="text-white btn btn-warning"> <i class="cil-cog"></i> </a>
                        <form action="{{ route('contract.task.destroy', ['contract' => $contract->hashid, 'task' => $task->hashid]) }}" method="POST" style="display:inline">
                          @method('DELETE')
                          @csrf
                          <button class="text-white btn btn-danger"><i class="cil-trash"></i></button>
                        </form> --}}
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>


         <div class="container">
              <div class="row">
                <div class="col-sm">
                    <div class="row">
                        <div class="col-3">{{ __('สถานะสัญญา') }}</div>
                        <div class="col-9">
                            <?php
                            echo isset($contract) && $contract->contract_status == 2
                                ? '<span style="color:red;">ดำเนินการแล้วเสร็จ</span>'
                                : '<span style="color:green;">อยู่ในระหว่างดำเนินการ</span>';
                            ?>
                        </div>
                      </div>
                    <div class="row">
                <div class="col-3">{{ __('เลขที่สัญญา') }}</div>
                <div class="col-9">{{ $contract->contract_number }} </div>
                    </div>
              <div class="row">
                <div class="col-3">{{ __('คู่ค้า') }}</div>
                <div class="col-9">{{ $contract->contract_juristic_id }}</div>
              </div>
              <div class="row">
                <div class="col-3">{{ __('เลขที่สั่งซื้อ') }}</div>
                <div class="col-9">{{ $contract->contract_order_no }}</div>
              </div>
              <div class="row">
                <div class="col-3">{{ __('ประเภท') }}</div>
                <div class="col-9">{{ $contract->contract_type }}</div>
              </div>
              <div class="row">
                <div class="col-3">{{ __('วิธีการได้มา') }}</div>
                <div class="col-9">{{ $contract->contract_acquisition }}</div>
              </div>
              <div class="row">
                <div class="col-3">{{ __('วันที่เริ่มสัญญา') }}</div>
                <div class="col-9">{{ \Helper::date($contract->contract_start_date) }}</div>
              </div>

              <div class="row">
                <div class="col-3">{{ __('วันที่สิ้นสุดสัญญา') }}</div>
                <div class="col-9">{{ \Helper::date($contract->contract_end_date) }}</div>
              </div>
              <div class="row">
                <div class="col-3">{{ __('จำนวนเดือน') }}</div>
                <div class="col-3">{{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInMonths(\Carbon\Carbon::parse($contract->contract_end_date)) }} เดือน</div>
                <div class="col-3">{{ __('จำนวนวัน') }}</div>
                <div class="col-3">{{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInDays(\Carbon\Carbon::parse($contract->contract_end_date)) }} วัน</div>
              </div>
              <div class="row">
                <div class="col-3">{{ __('ดำเนินการมาแล้ว') }}</div>
                <div class="col-3">{{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInMonths(\Carbon\Carbon::parse()) }} เดือน</div>
                <div class="col-3">{{ __('ดำเนินการมาแล้ว') }}</div>
                <div class="col-3">{{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInDays(\Carbon\Carbon::parse()) }} วัน</div>
              </div>

              <div class="row">
                <div class="col-3">{{ __('เตือน เหลือเวลา') }}</div>
                <div class="col-9" >
                    <?php
                    echo isset($duration_p) && $duration_p < 3
                    ? '<span style="color:red;">'.$duration_p.'</span>'
              : '<span style="color:rgb(5, 255, 5);">'.$duration_p.'</span>';
                    ?> เดือน


            </div>
              </div>


            </div>
              <div class="col-sm">
              <div class="row">
                <div class="col-3">{{ __('บันทึกข้อความ') }}</div>
                <div class="col-9">{{ $contract->contract_projectplan }}</div>
              </div>
              <div class="row">
                <div class="col-3">{{ __('เลขที่ PR') }}</div>
                <div class="col-9">{{ $contract->contract_pr }}</div>
              </div>
              <div class="row">
                <div class="col-3">{{ __('จำนวนเงิน PR') }}</div>
                <div class="col-9">{{ $contract->contract_pr_budget }}</div>
              </div>
              <div class="row">
                <div class="col-3">{{ __('เลขที่ PA') }}</div>
                <div class="col-9">{{ $contract->contract_pa }}</div>
              </div>
              <div class="row">
                <div class="col-3">{{ __('จำนวนเงิน PA') }}</div>
                <div class="col-9">{{ $contract->contract_pa_budget }}</div>
              </div>
              <div class="row">
                <div class="col-4">{{ __('เจ้าหน้าที่ผู้รับผิดชอบ') }}</div>
                <div class="col-9">{{ $contract->contract_owner }}</div>
              </div>
            </div>
         </div>
              <table class="table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Task Name</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($contract->taskcon as $taskcon)
                    <tr>
                      <td></td>
                      <td>
                        {{ $taskcon['taskcon_name'] }}<br>
                        <span class="badge bg-primary">{{ \Helper::date($taskcon->taskcon_start_date) }}</span>
                        <span class="badge bg-primary">{{ \Helper::date($taskcon->taskcon_end_date) }}</span>
                      </td>
                      <td class="text-end">
                        <a href="{{ route('contract.task.show', ['contract' => $contract->hashid, 'taskcon' => $taskcon->hashid]) }}" class="text-white btn btn-primary"><i class="cil-folder-open "></i> ข้อมูล</a>
                        <a href="{{ route('contract.task.edit', ['contract' => $contract->hashid, 'taskcon' => $taskcon->hashid]) }}" class="text-white btn btn-primary"><i class="cil-folder-open "></i> Taske</a>
                        <a href="{{ route('project.show', ['project' => $task->project_hashid]) }}" class="text-white btn btn-success"><i class="cil-folder-open "></i> Project</a>
                        <a href="{{ route('project.task.show', ['project' => $task->project_hashid, 'task' => $task->hashid]) }}" class="text-white btn btn-primary"><i class="cil-folder-open "></i> Task</a>
                        {{-- <a href="{{ route('contract.task.edit', ['contract' => $contract->hashid, 'task' => $task->hashid]) }}" class="text-white btn btn-warning"> <i class="cil-cog"></i> </a>
                        <form action="{{ route('contract.task.destroy', ['contract' => $contract->hashid, 'task' => $task->hashid]) }}" method="POST" style="display:inline">
                          @method('DELETE')
                          @csrf
                          <button class="text-white btn btn-danger"><i class="cil-trash"></i></button>
                        </form> --}}
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <div class="mb-3 row">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title fs-5 fw-semibold">Project</div>
                        <div id="gantt_here" style='width:100%; height:100vh;'></div>
                    </div>
                </div>
            </div>


            </x-card>
          </div>
        </div>
      </div>
    </div>
  </x-slot:content>

  <x-slot:css>
    <link rel="stylesheet" href="{{ asset('/vendors/dhtmlx/dhtmlxgantt.css') }}" type="text/css">
  </x-slot:css>
  <x-slot:javascript>
    <script src="{{ asset('/vendors/dhtmlx/dhtmlxgantt.js') }}"></script>
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
        columns: [{
            name: "",
            width: 60,
            resize: false,
            template: function(task) {
              return "<span class='gantt_grid_wbs'>" + gantt.getWBSCode(task) + "</span>"
            }
          },
          {
            name: "text",
            width: 400,
            label: "โครงการ/งานประจำ",
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
        columns: [{
            name: "budget",
            width: 100,
            label: "งบประมาณ",
            template: function(task) {
              //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));
              if (task.budget) {
                return new Intl.NumberFormat('th-TH', {
                  style: 'currency',
                  currency: 'THB'
                }).format(task.budget);
              } else {
                return '';
              }
            }
          },
          {
            name: "cost",
            width: 100,
            label: "ใช้จ่ายแล้ว",
            template: function(task) {
              //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));
              if (task.cost) {
                return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                  style: 'currency',
                  currency: 'THB'
                }).format(task.cost) + '</span>';
              } else {
                return '';
              }
            }
          },
          {
            name: "balance",
            width: 100,
            label: "คงเหลือ",
            template: function(task) {
              //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));
              if (task.balance) {
                var tmp_class = task.balance > 0 ? 'green' : 'red';
                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                  style: 'currency',
                  currency: 'THB'
                }).format(task.balance) + '</span>';
              } else {
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
          html += '<tr class="text-end">\
                                                                                                                                                                                        <td>' + budget_gov_operating + '</td>\
                                                                                                                                                                                        <td>' + budget_gov_investment + '</td>\
                                                                                                                                                                                        <td>' + budget_gov_utility + '</td>\
                                                                                                                                                                                        <td>' + budget_it_operating + '</td>\
                                                                                                                                                                                        <td>' + budget_it_investment + '</td>\
                                                                                                                                                                                        <td class="text-success">' + budget + '</td>\
                                                                                                                                                                                      </tr>';
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
                width: 500,
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
                width: 300,
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
          format: "%Y"
        },
        {
          unit: "month",
          step: 2,
          format: "%M, %Y"
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
