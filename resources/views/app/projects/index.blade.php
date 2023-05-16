<x-app-layout>
  <x-slot:content>
    <div class="container-fluid">

      <div class="animated fadeIn">
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <x-card title="">
                {{ Breadcrumbs::render('project') }}


              <x-slot:toolbar>
                <a href="{{ route('project.create') }}" class="btn btn-success text-white" target="_blank">งาน/โครงการ</a>
              </x-slot:toolbar>
              <table class="table table-responsive-sm table-striped" id="datatables">
                <thead>
                  <tr>
                    <th>{{ __('ลำดับ') }}</th>
                    <th>{{ __('ปีงบประมาณ') }}</th>
                    <th>{{ __('งาน/โครงการ') }}</th>

                    <th></th>
                  </tr>
                </thead>
              </table>
              {{-- <table class="table">
                <thead>
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($projects as $project)
                    <tr>
                      <td></td>
                      <td>
                        {{ $project->project_name }}<br>
                        <span class="badge bg-info">{{ \Helper::date($project->project_start_date) }}</span> -
                        <span class="badge bg-info">{{ \Helper::date($project->project_end_date) }}</span>
                        @if ($project->task->count() > 0)
                          <span class="badge bg-warning">{{ $project->main_task->count() }} กิจกรรม</span>
                        @endif
                        @if ($project->contract->count() > 0)
                          <span class="badge bg-danger">{{ $project->contract->count() }} สัญญา</span>
                        @endif
                      </td>
                      <td class="text-end">
                        <a href="{{ route('project.show', $project->hashid) }}" class="btn btn-primary text-white"><i class="cil-folder-open "></i></a>
                        <a href="{{ route('project.edit', $project->hashid) }}" class="btn btn-warning text-white"> <i class="cil-cog"></i> </a>
                        <form action="{{ route('project.destroy', $project->hashid) }}" method="POST" style="display:inline">
                          @method('DELETE')
                          @csrf
                          <button class="btn btn-danger text-white"><i class="cil-trash"></i></button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table> --}}
            </x-card>
          </div>
        </div>
      </div>
    </div>
  </x-slot:content>
  <x-slot:css>
    <link href="{{ asset('vendors/DataTables/datatables.css') }}" rel="stylesheet" />
  </x-slot:css>
  <x-slot:javascript>
    <script src="{{ asset('vendors/DataTables/datatables.min.js') }}"></script>
    <script>
      $(document).ready(function() {
        var token = $('meta[name="csrf-token"]').attr('content');
        var modal = $('.modal')
        var form = $('.form')
        var btnAdd = $('.add'),
          btnSave = $('.btn-save'),
          btnUpdate = $('.btn-update');
        var table = $('#datatables').DataTable({
          autoWidth: false,
          processing: true,
          serverSide: true,
          responsive: true,
          ajax: "{{ route('project.index') }}",
          language: {
            processing: "กำลังประมวลผล...",
            search: "ค้นหา:",
            lengthMenu: "แสดง _MENU_ รายการ",
            info: "แสดงรายที่ _START_ ถึง _END_ ทั้งหมด _TOTAL_ รายการ",
            infoEmpty: "แสดงรายที่ 0 ถึง 0 ทั้งหมด 0 รายการ",
            infoFiltered: "(กรองจากทั้งหมด _MAX_ รายการ)",
            infoPostFix: "",
            loadingRecords: "Chargement en cours...",
            zeroRecords: "ไม่พบข้อมูล",
            emptyTable: "ไม่พบข้อมูล",
            paginate: {
              first: "หน้าแรก",
              previous: "ย้อนกลับ",
              next: "ถัดไป",
              last: "หน้าสุดท้าย"
            },
            aria: {
              sortAscending: ": เรียงจากน้อยไปหามาก",
              sortDescending: ": เรียงจากมากไปหาน้อย"
            }
          },
          columns: [{
              data: 'DT_RowIndex',
              name: 'DT_RowIndex',
              orderable: false,
              searchable: false
            },
            {
              data: 'project_fiscal_year'
            },
            {
              data: 'project_name_output',
              name: 'project_name'
            },

            {
              className: "text-end",
              data: 'action',
              orderable: false,
              searchable: false
            }
          ]
        });

        btnUpdate.click(function() {
          if (!confirm("Are you sure?")) return;
          var formData = form.serialize() + '&_method=PUT&_token=' + token
          var updateId = form.find('input[name="id"]').val()
          $.ajax({
            type: "POST",
            url: "/" + updateId,
            data: formData,
            success: function(data) {
              if (data.success) {
                table.draw();
                modal.modal('hide');
              }
            }
          }); //end ajax
        })


        $(document).on('click', '.btn-delete', function() {
          if (!confirm("Are you sure?")) return;

          var rowid = $(this).data('rowid')
          var el = $(this)
          if (!rowid) return;


          $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: "{{ url('project') }}/" + rowid,
            data: {
              _method: 'delete',
              _token: token
            },
            success: function(data) {
              if (data.success) {
                table.row(el.parents('tr'))
                  .remove()
                  .draw();
              }
            }
          }); //end ajax
        })
      });
    </script>
  </x-slot:javascript>
</x-app-layout>
