<x-app-layout>
    <x-slot name="content">
        <!-- ... -->
        <div class="py-12">
            <!-- ... -->
            <div class="p-6 bg-white border-b border-gray-200">
                <table class="table table-responsive-sm table-striped" id="datatables">
                    <thead>
                        <tr>
                            <th>{{ __('project_id') }}</th>
                            <th>{{ __('ปีงบประมาณ') }}</th>
                            <th>{{ __('งาน/โครงการ') }}</th>
                            <th>{{ __('no') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="sortable">
                        @foreach($items as $item)
                        <tr data-id="{{ $item->order_column }}">
                            <td>{{  $item->id }}</td>
                                <td>{{ $item->project_id }}</td>

                                <td>{{ $item->project_fiscal_year }}</td>
                                <td>{{ $item->project_name }}</td>
                                <td class="order_column">{{ $item->order_column }}</td>
                                <!-- Add other data rows as needed -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-slot>

    <style>

    </style>
    <x-slot name="scripts">
        <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery UI -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

        <x-slot:javascript>


        <script>

              $("#sortable").sortable({
                items: "tr",
                cursor: "move",
                placeholder: "sortable-placeholder",
                start: function(event, ui) {
                  ui.placeholder.height(ui.helper.outerHeight());
                },
                update: function(event, ui) {
                  let order_column = [];

                  $("#sortable tr").each(function(index) {
                    const id = $(this).data('id');
                    console.log("Item ID:", id); // Log the item ID
                    $(this).find(".order_column").text(index + 1);
                    order_column.push(id);
                  });
                  console.log("Sending update order:", order_column); // Add this line

                  $.ajax({

    url: "{{ route('sortable.updateorder') }}",

    type: 'POST',
    data: {
        _token: '{{ csrf_token() }}',
        items: $("#sortable").sortable("toArray")
    },
    success: function(response) {
        // ตรวจสอบสถานะการตอบกลับ
        if (response.status === 'error') {
            console.log("Error updating order:", response.message);
        } else {
            console.log("Order updated successfully");
            console.log("Updated order:", order_column);
        }
    },
    error: function(xhr, status, error) {
        console.log("Error updating order:", error);
    }
});

                }
              });
              $("#sortable").disableSelection();

          </script>
    </x-slot>
</x-slot:javascript>
</x-app-layout>

