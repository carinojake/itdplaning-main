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
            border: 1px solid black;
            font-family: 'THSarabunNew';
        }

        h1 {
            color: red;
            font-family: 'THSarabunNew';
            text-align: center;
        }

        img {
            width: 150px;
            height: 30px;
        }

        .my-text {
            text-align: justify;
            word-spacing: -0.15em;
            line-height: 1;
            text-indent: 24px;
        }

        .page-break {
            page-break-after: always;
        }

        #customer-table {
            border-collapse: collapse;
            width: 100%;
            font-size: 24px;
        }

        #customer-table th,
        #customer-table td {
            border: 1px solid black;
        }

    </style>
</head>

<body>
    <h1>{{ $title }}</h1>


    <table class="table table-bordered">
        <thead style="border-top: 1px solid #ddd">
            <tr>
                <th class="text-center">ที่</th>
                <th class="text-center">ชื่องานประจำ โครงการ</th>
                <th class="text-center">งบประมาณ 2566</th>
                <th class="text-center">การใช้จ่าย งบประมาณ /2566 (รวมกันเหลื่อม)</th>
                <th class="text-center">เปอร์เซ็นการใช้จ่าย</th>
                <th class="text-center">กิจกรรมที่ดำเนินการปี </th>
                <th class="text-center">หมายเหตุ</th>

            </tr>
        </thead>
        @foreach ($project as $projects)
            <tr>
                <td class="text-center">{{ $projects->id }}</td>

                <td>{{ $projects->name }}</td>
                <td>{{ $projects->total_budgot }}</td>



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
