<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Ex1</title>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ asset('fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ asset('fonts/THSarabunNewBold.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ asset('fonts/THSarabunNewItalic.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ asset('fonts/THSarabunNewBoldItalic.ttf') }}") format('truetype');
        }

        @page {
            /* margin-top: 10px; */
        }

        body {

font-family: 'THSarabunNew';
}

h1 {
color: red;
font-family: 'THSarabunNew';
text-align: center;
font-size: 16;
}


h2 {
font-family: 'thsarabunnew';
font-weight: bold;
font-size: 30px;
color: orange;
margin: 10px;
text-align: center;
}

table {
border-collapse: collapse;
width: 100%;
}

table td {
border: 1px solid black;
padding: 8x;
}

table th {
border: 1px solid black;
text-align: center;
font-size: 16;
}

    </style>
</head>

<body>
    <h1>{{ $title }}</h1>


    <table class="table table-bordered">
        <thead style="border-top: 1px solid #ddd">
            <tr>
                <th class="text-center">เลขที่สัญญา</th>
                <th class="text-center">ชื่อบริษัทฯ /  ห้างหุ้นส่วนฯ</th>
                <th class="text-center">วิธีการ</th>
                <th class="text-center">รายละเอียดการทำสัญญา</th>
                <th class="text-center">ลำดับแผนงาน<b>โครงการ</th>
                <th class="text-center">  ประเภทงาน</th>
                <th class="text-center">MM บันทึกข้อความ</th>
                <th class="text-center">เลขที่ PR</th>
                <th class="text-center">จำนวนเงิน PR</th>
                <th class="text-center">เลขที่ PA</th>
                <th class="text-center">จำนวนเงิน PA</th>
                <th class="text-center">CN</th>
                <th class="text-center">เริ่ม-สิ้นสุดสัญญา</th>
                <th class="text-center">สถานะ</th>
                <th class="text-center">ลงนามสัญญา</th>
                <th class="text-center">ตรวจรับ(งวด)</th>
                <th class="text-center">ระยะเวลารับประกัน (ปี)</th>
                <th class="text-center">ลำดับที่แผนงานฯ</th>
                <th class="text-center">งวดงาน</th>

            </tr>
        </thead>
        @foreach ($contract as $contract)
            <tr>

                <td>{{ $contract->contract_number }}</td>
                <td>{{ $contract->contract_juristic_id }}</td>
                <td>{{ $contract->contract_type }}</td>
                <td>{{ $contract->contract_description }}</td>
                <td>{{ $contract->contract_type }}</td>
                <td>{{ $contract->contract_type }}</td>
                <td>{{ $contract->contract_mm }}</td>

                <td>{{ $contract->contract_pr }}</td>
                <td>{{ $contract->contract_pr_budget }}</td>
                <td>{{ $contract->contract_pa }}</td>
                <td>{{ $contract->contract_pa_budget }}</td>
                <td>{{ $contract->contract_order_no }}</td>
                <td>{{ \Helper::date($contract->contract_start_date) }}-{{ \Helper::date($contract->contract_end_date) }}</td>
                <td>{{ $contract->contract_sign_date ? \Helper::date($contract->contract_sign_date) : '' }}</td>
                <td>{{ $contract->contract_projectplan }}</td>
            </tr>
        @endforeach
    </table>

        <link rel="stylesheet" href="{{ asset('/vendors/dhtmlx/dhtmlxgantt.css') }}" type="text/css">


    <script type="text/php">
                    if (isset($pdf)) {
                        $text = "หน้า {PAGE_NUM} / {PAGE_COUNT}";
                        $size = 10;
                        $font = $fontMetrics->getFont("THSarabunNew");
                        $width = $fontMetrics->get_text_width($text, $font, $size) / 2;


                        // old footer
                        /*$x = ($pdf->get_width() - $width) / 2;
                        $y = $pdf->get_height() - 35;
                        $pdf->page_text($x, $y, $text, $font, $size);*/

                        // new footer right
                        $x = ($pdf->get_width() - $width) / 1;
                        $y = $pdf->get_height() - 35;
                        $pdf->page_text($x, $y, $text, $font, $size);

                        // header
                        $x2 = $pdf->get_width() - 100;
                        $y2 = 10;
                        $d = date('d/m/Y H:i:s');
                        $pdf->page_text($x2, $y2, "เมื่อ: $d", $font, $size, [0,0,0]);
                    }
                </script>
</body>

</html>
