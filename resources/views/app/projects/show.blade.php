<x-app-layout>
  <x-slot:content>
    <div class="container-fluid">
      <div class="animated fadeIn">
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <x-card title="{{ $project->project_name }}">
              <x-slot:toolbar>
                <a href="{{ route('project.edit', $project->hashid) }}" class="btn btn-warning text-white">Edit</a>
                <a href="{{ route('project.task.create', $project->hashid) }}" class="btn btn-success text-white">Add Task</a>
                <a href="{{ route('project.index') }}" class="btn btn-secondary">Back</a>
              </x-slot:toolbar>
              <div class="row mb-3">
                <div class="col-sm-6 col-md-3 col-lg-4">
                  <div class="card">
                    <div class="card-body">
                      <div class="text-medium-emphasis text-end mb-4">
                        <i class="cil-money icon icon-xxl"></i>
                      </div>
                      <div class="fs-4 fw-semibold">{{ number_format($budget['total']) }}</div><small class="text-medium-emphasis text-uppercase fw-semibold">งบประมาณ</small>
                      <div class="progress progress-thin mt-3 mb-0">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-4">
                  <div class="card">
                    <div class="card-body">
                      <div class="text-medium-emphasis text-end mb-4">
                        <i class="cil-money icon icon-xxl"></i>
                      </div>
                      <div class="fs-4 fw-semibold">{{ number_format($budget['cost']) }}</div><small class="text-medium-emphasis text-uppercase fw-semibold">ค่าใช้จ่าย</small>
                      <div class="progress progress-thin mt-3 mb-0">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-4">
                  <div class="card">
                    <div class="card-body">
                      <div class="text-medium-emphasis text-end mb-4">
                        <i class="cil-money icon icon-xxl"></i>
                      </div>
                      <div class="fs-4 fw-semibold">{{ number_format($budget['balance']) }}</div><small class="text-medium-emphasis text-uppercase fw-semibold">คงเหลือ</small>
                      <div class="progress progress-thin mt-3 mb-0">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <table class="table">
                <thead>
                  <tr>
                    <th width="50">No</th>
                    <th>Task Name</th>
                    <th>Date</th>
                    <th width="200"></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($project->main_task as $task)
                    <tr>
                      <td></td>
                      <td>
                        {{ $task->task_name }} {!! $task->task_status == 2 ? '<span class="badge bg-info">ดำเนินการแล้วเสร็จ</span>' : '' !!}
                        @if ($task->contract->count() > 0)
                          {{-- <span class="badge bg-warning">{{ $task->contract->count() }} สัญญา</span> --}}
                          @foreach ($task->contract as $contract)
                            <a href="{{ route('contract.show', ['contract' => $contract->hashid]) }}"><span class="badge bg-warning">{{ $contract->contract_number }}</span></a>
                          @endforeach
                        @endif
                        @if ($task->subtask->count() > 0)
                          <h6>Sub task</h6>
                          <ul>
                            @foreach ($task->subtask as $subtask)
                              <li>
                                {{ $subtask->task_name }}
                                <span class="badge bg-primary">{{ \Helper::date($subtask->task_start_date) }}</span>
                                <span class="badge bg-primary">{{ \Helper::date($subtask->task_end_date) }}</span>
                                @if ($subtask->contract->count() > 0)
                                  {{-- <span class="badge bg-warning">{{ $subtask->contract->count() }} สัญญา</span> --}}
                                  @foreach ($subtask->contract as $contract)
                                    <a href="{{ route('contract.show', ['contract' => $contract->hashid]) }}"><span class="badge bg-warning">{{ $contract->contract_number }}</span></a>
                                  @endforeach
                                @endif
                                <a href="{{ route('project.task.show', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}" class="btn-sm btn btn-primary text-white"><i class="cil-folder-open "></i></a>
                                <a href="{{ route('project.task.edit', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}" class="btn-sm btn btn-warning text-white"> <i class="cil-cog"></i> </a>
                                <form action="{{ route('project.task.destroy', ['project' => $project->hashid, 'task' => $subtask->hashid]) }}" method="POST" style="display:inline">
                                  @method('DELETE')
                                  @csrf
                                  <button class="btn-sm btn btn-danger text-white"><i class="cil-trash"></i></button>
                                </form>
                              </li>
                            @endforeach
                          </ul>
                        @endif
                      </td>
                      <td>
                        <span class="badge bg-primary">{{ \Helper::date($task->task_start_date) }}</span> -
                        <span class="badge bg-primary">{{ \Helper::date($task->task_end_date) }}</span>
                      </td>
                      <td class="text-end">
                        <a href="{{ route('project.task.show', ['project' => $project->hashid, 'task' => $task->hashid]) }}" class="btn btn-primary text-white"><i class="cil-folder-open "></i></a>
                        <a href="{{ route('project.task.edit', ['project' => $project->hashid, 'task' => $task->hashid]) }}" class="btn btn-warning text-white"> <i class="cil-cog"></i> </a>
                        <form action="{{ route('project.task.destroy', ['project' => $project->hashid, 'task' => $task->hashid]) }}" method="POST" style="display:inline">
                          @method('DELETE')
                          @csrf
                          <button class="btn btn-danger text-white"><i class="cil-trash"></i></button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

              <div id="gantt_here" style='width:100%; height:100vh;'></div>
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
          if (task.type == 'task') {
            html += '<tr class="text-end">\
                        <td>-' + budget_gov_operating + '</td>\
                        <td>' + budget_gov_investment + '</td>\
                        <td>' + budget_gov_utility + '</td>\
                        <td>' + budget_it_operating + '</td>\
                        <td>' + budget_it_investment + '</td>\
                        <td class="text-success">' + budget + '</td>\
                      </tr>';
          } else {
            html += '<tr class="text-end">\
                        <td>' + budget_gov_operating + '</td>\
                        <td>' + budget_gov_investment + '</td>\
                        <td>' + budget_gov_utility + '</td>\
                        <td>' + budget_it_operating + '</td>\
                        <td>' + budget_it_investment + '</td>\
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
