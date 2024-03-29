<x-app-layout>
  <x-slot:content>
    <div class="container-fluid">
       <!-- {{ Breadcrumbs::render('contract') }}-->
      <div class="animated fadeIn">
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <x-card title="Office">
              <x-slot:toolbar>
                <a href="{{ route('expenses.create') }}" class="btn btn-success text-white">เพื่ม Office exp</a>


              </x-slot:toolbar>

              <table class="table table-responsive-sm table-striped" id="datatables">
                <thead>
                  <tr>
                    <th>ลำดับ</th>
                    <th>ปีงบประมาณ</th>
                    <th>จ่ายสำนักงาน</th>

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
          ajax: "{{ route('expenses.index') }}",
          language: {
            processing: "กำลังประมวลผล...",
            search: "ค้นหา:"  ,
            lengthMenu: "แสดง _MENU_ รายการ",
            info: "แสดงรายที่ _START_ ถึง _END_ ทั้งหมด _TOTAL_ รายการ",
            infoEmpty: "แสดงรายที่ 0 ถึง 0 ทั้งหมด 0 รายการ",
            infoFiltered: "(กรองจากทั้งหมด _MAX_ รายการ)",
            infoPostFix: "", // ส่วนท้ายของข้อความ (ใช้แท็ก <span> เพื่อให้ปรากฏในรูปแบบ HTML)
             loadingRecords: "กำลังโหลดข้อมูล...",
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
              data: 'contract_fiscal_year'
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
          if (!confirm("Are you sure?")) return;

          var rowid = $(this).data('rowid')
          var el = $(this)
          if (!rowid) return;


          $.ajax({
  type: "POST",
  dataType: 'JSON',
  url: "{{ url('expenses') }}/" + rowid,
  data: {
    _method: 'delete',
    _token: token
  },
  success: function(data) {
    if (data.success) {
      table.row(el.parents('tr')).remove().draw();
    }
  },
  beforeSend: function(xhr) {
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Accept-Language', 'en');
    xhr.setRequestHeader('Accept', 'application/json');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    xhr.setRequestHeader('X-CSRF-TOKEN', token);
    xhr.setRequestHeader('Search', 'OE');
  }
});

        })
      });
    </script>
  </x-slot:javascript>
</x-app-layout>
