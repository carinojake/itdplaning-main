<x-app-layout>
  <x-slot:content>
    <div class="container-fluid">
       <!-- {{ Breadcrumbs::render('contract') }}-->
      <div class="animated fadeIn">
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <x-card title="สัญญา/ใบจ้าง ทั้งหมด">
              <x-slot:toolbar>
               {{--  <a href="{{ route('contract.create') }}" class="btn btn-success text-white">เพิ่มสัญญา</a> --}}


              </x-slot:toolbar>

              <table class="table table-responsive-sm table-striped" id="datatables">
                <thead>
                  <tr>
                    <th>ลำดับ</th>
                    <th>ปีงบประมาณ</th>
                    <th>สัญญา</th>

                    <th></th>
                  </tr>
                </thead>

              </table>
            </x-card>
          </div>
        </div>
      </div>
    </div>
  </x-slot:content>
  <x-slot:css>
    <link href="{{ asset('vendors/DataTables/datatables.css') }}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
          ajax: "{{ route('contract.index') }}",
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
              data: 'contract_fiscal_year_output',
              name: 'contract_fiscal_year'
            },
            {
              data: 'contract_number_output',
              name: 'contract_number'
            },
            {
              data: 'contract_name_output',
              name: 'contract_name'
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
    var rowid = $(this).data('rowid');
    var el = $(this);
    if (!rowid) return;
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
            $.ajax({
                type: "POST",
                dataType: 'JSON',
                url: "{{ url('contract') }}/" + rowid,
                data: {
                    _method: 'delete',
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    if (data.success) {
                        // Check if there is any project inside before delete
                        if (data.project_inside) {
                            Swal.fire("Cannot delete because there is a project inside." + rowid);
                            return;
                        }
                        table.row(el.parents('tr')).remove().draw();
                    }
                    location.reload(); // Reload the page only once after the deletion
                }
            }); //end ajax
        }
    });
});







            });
        </script>
  </x-slot:javascript>
</x-app-layout>
