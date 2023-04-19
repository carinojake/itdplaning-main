<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{{ asset('bootstrap3/css/custom-bootstrap.min.css') }}" />
    <title>Ex3</title>
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
                <th class="text-center">ที่</th>
                <th class="text-center">ชื่องานประจำ โครงการ</th>
                <th class="text-center">งบประมาณ 2566</th>
                <th class="text-center">การใช้จ่าย<b>งบประมาณ<b>2566 (รวมกันเหลื่อม)</th>
                <th class="text-center">เปอร์เซ็น<b>การใช้จ่าย</th>
                <th class="text-center">กิจกรรมที่ดำเนินการปี </th>
                <th class="text-center">หมายเหตุ</th>
            </tr>
        </thead>
        @php
$combined = array_combine($project->pluck('project_id')->toArray(), $taskcosttotals->pluck('total_pay')->toArray());
        @endphp
        @foreach ($project as $p)
            <tr>
                <td class="text-center">{{ $p->project_id }}</td>
                <td class="text-center">{{ $p->text }}</td>
                <td class="text-center">{{ number_format($p->total_budgot, 2, '.', ',') }}</td>
                <td class="text-center">{{ number_format($p->total_budgot, 2, '.', ',') }}</td>
                <td class="text-center">{{ number_format($p->total_budgot, 2, '.', ',') }}</td>
                <td class="text-center">{{ $p->year }}</td>
                <td class="text-center"></td>
            </tr>
        @endforeach
    </table>
</body>


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
