<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel 9 Sorting Columns</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
    <div class="container">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody id="sortable">
                @foreach($items as $item)
                    <tr data-id="{{ $item->id }}">
                        <td class="order_column">{{ $item->order }}</td>
                        <td>{{ $item->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $("#sortable").sortable({
                items: "tr",
                cursor: "move",
                placeholder: "sortable-placeholder",
                start: function(event, ui) {
                    ui.placeholder.height(ui.helper.outerHeight());
                },
                update: function(event, ui) {
                    let updated_order = [];

                    $("#sortable tr").each(function(index) {
                        const id = $(this).data('id');
                        $(this).find(".order_column").text(index + 1);
                        updated_order.push(id);
                    });
                    $.ajax({
                        url: "{{ route('sortable.updateorder') }}",
    type: 'POST',
    data: {
        _token: '{{ csrf_token() }}',
        items: order_column // แก้ไขจาก updated_order เป็น order_column
    },
    success: function(response) {
        // ตรวจสอบสถานะการตอบกลับ
        if (response.status === 'error') {
            console.log("Error updating order:", response.message);
        } else {
            console.log("Order updated successfully");
            console.log("Updated order:", order_column );
        }
    },
    error: function(xhr, status, error) {
        console.log("Error updating order:", error);
    }
});
                }
            });
            $("#sortable").disableSelection();
        });
    </script>
</body>
</html>
