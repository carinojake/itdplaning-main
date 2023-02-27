<?php
namespace App\Libraries;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class Helper
{

    public static function AppealChannel(string $channel_id = null, $other = null, $department = null)
    {

        $department = $department ? ' (' . self::Department($department) . ')' : '';
        $other      = $other ? ' (' . $other . ')' : '';

        $channel = [
            "department" => "ติดต่อผ่านทางสำนักงาน" . $department,
            "email"      => "อีเมล์",
            "telephone"  => "โทรศัพท์",
            "other"      => "ช่องทางอื่นๆ" . $other,
        ];

        return $channel_id ? $channel[$channel_id] : $channel;
    }

    public static function AppealStatus(Int $status_id = null)
    {

        $status = [
            "1" => "เปิด",
            "2" => "อยู่ระหว่างดำเนินการ",
            "3" => "ปิด",
            "4" => "ส่งต่อหน่วยงานเจ้าของข้อมูล",
            "5" => "ปฏิเสธ",
            "6" => "ส่งต่อ สคส",
            "7" => "Re-Open",
        ];

        return $status_id ? $status[$status_id] : $status;
    }

    public static function AppealType(string $type_id = null, $reason = null)
    {
        $type = [
            "withdraw_consent"                          => "ขอถอนความยินยอม (Right to withdraw consent)",
            "appeal_right_to_access"                    => "ขอเข้าถึงข้อมูล (Right to access)",
            "appeal_right_to_data_portability"          => "ขอถ่ายโอนข้อมูล (Right to data portability)",
            "appeal_right_to_object"                    => "ขอคัดค้านการเก็บรวบรวม ใช้ เปิดเผย ข้อมูลส่วนบุคคล (Right to object)",
            "appeal_right_to_erasure"                   => "ขอให้ลบหรือทำลายข้อมูล (Right to erasure)",
            "appeal_right_to_restriction_of_processing" => "ขอให้ระงับการใช้ข้อมูล (Right to restriction of processing)",
            "appeal_right_to_rectification"             => "ขอให้แก้ไขข้อมูล (Right to rectification)",
            "appeal_right_to_other"                     => "อื่นๆ",
        ];

        $reason = $reason ? " (" . $reason . ")" : "";

        return $type_id ? $type[$type_id] . $reason : $type;
    }

   public static function Date(String $date)
    {
        return date('d/m/Y', $date);
    }
    public static function Date2(string $date)
    {
        $timestamp = strtotime($date);
        return date( $timestamp);
    }

    public static function Date3(String $date)
    {
        return ( $date);
    }


    public static function Attachment(Object $attachment)
    {
        switch ($attachment->file_extension) {
            case 'jpeg':
            case 'jpg':
            case 'png':
                // $output = '<img src="'.Storage::url($attachment->file_path).'" alt="..." height="100px" width="100px" class="rounded img-thumbnail d-block">';
                $output = '<a href="#" class="pop btn btn-app bg-teal"><i class="fas fa-file-image"></i> Image<img src="' . Storage::url($attachment->file_path) . '" class="d-none"></a>';
                break;

            case 'pdf':
                $output = '<a href="' . Storage::url($attachment->file_path) . '" class="btn btn-app bg-teal"><i class="fas fa-file-pdf"></i> PDF<span class="d-none">' . $attachment->file_upload_name . '</span></a>';
                break;

            default:
                $output = '';
                break;
        }

        return $output;
    }

    public static function BuildFiscalYear($start_year = null, $end_year = null)
    {
        $end_year = $end_year ?? date('Y') + 543;
        $years    = [];
        for ($i = $start_year; $i <= $end_year; $i++) {
            $years[] = [
                'id'   => $i,
                'text' => $i,
            ];
        }
        rsort($years);
        return $years;
    }

    public static function ChartOfAccounts($chart_of_account_id = null)
    {
        $chart_of_accounts = [
            "101060401" => "วัสดุสำนักงาน",
            "101060402" => "วัสดุคอมพิวเตอร์",
            "101080601" => "วัสดุสิ้นเปลือง - สำนักงาน",
            "101080602" => "วัสดุสิ้นเปลือง - คอมพิวเตอร์",
            "101080603" => "วัสดุสิ้นเปลือง - ไฟฟ้าและวิทยุ",
            "101080612" => "วัสดุสิ้นเปลือง - โฆษณาและเผยแพร่",
            "103030101" => "ครุภัณฑ์สำนักงาน",
            "103030102" => "ครุภัณฑ์สำนักงาน ที่ประกอบดัดแปลง ต่อเติมหรือปรับปรุง",
            "103030301" => "ครุภัณฑ์ไฟฟ้าและวิทยุ",
            "103030302" => "ครุภัณฑ์ไฟฟ้าและวิทยุ ที่ประกอบดัดแปลง ต่อเติมหรือปรับปรุง",
            "103030501" => "ครุภัณฑ์โฆษณาและเผยแพร่",
            "103030502" => "ครุภัณฑ์โฆษณาและเผยแพร่ ที่ประกอบดัดแปลง ต่อเติมหรือปรับปรุง",
            "103030503" => "ครุภัณฑ์โฆษณาและเผยแพร่ ที่ได้รับอุดหนุนจากรัฐบาล",
            "103031101" => "ครุภัณฑ์คอมพิวเตอร์",
            "103031102" => "ครุภัณฑ์คอมพิวเตอร์ ที่ประกอบดัดแปลง ต่อเติมหรือปรับปรุง",
            "103031103" => "ครุภัณฑ์คอมพิวเตอร์ ที่ได้รับอุดหนุนจากรัฐบาล",
            "103031104" => "ครุภัณฑ์คอมพิวเตอร์ ในการพัฒนาระบบเทคโนโลยีสารสนเทศ",
            "103060201" => "โปรแกรมคอมพิวเตอร์",
            "103060202" => "โปรแกรมคอมพิวเตอร์ ที่ประกอบดัดแปลง ต่อเติมหรือปรับปรุง",
            "103060203" => "โปรแกรมคอมพิวเตอร์ ที่ได้รับอุดหนุนจากรัฐบาล",
            "103060204" => "โปรแกรมคอมพิวเตอร์ ในการพัฒนาระบบเทคโนโลยีสารสนเทศ",
            "602010000" => "ค่าใช้จ่ายด้านการฝึกอบรมภายในประเทศ",
            "602010100" => "ค่าใช้จ่ายด้านการฝึกอบรมภายในประเทศ",
            "604020300" => "ค่าซ่อมแซมและค่าบำรุงรักษา ครุภัณฑ์",
            "604020400" => "ค่าจ้างเหมาบริการ",
            "604020401" => "ค่าจ้างเหมาบริการ",
            "604020402" => "ค่าจ้างเหมาบริการด้าน IT",
            "604020403" => "ค่าดูแลและบำรุงรักษา (MA) ด้าน Hardware",
            "604020404" => "ค่าดูแลและบำรุงรักษา (MA) ด้าน Software",
            "604020405" => "ค่าดูแลและบำรุงรักษา (MA) ด้าน Network",
            "604020500" => "ค่าใช้จ่ายในการประชุม",
            "604020802" => "ค่าที่ปรึกษาด้าน IT",
            "604021200" => "ค่าใช้จ่ายเพื่อสังคม",
            "604021300" => "ค่าซ่อมแซมและค่าบำรุงรักษา อาคาร",
            "604021600" => "ค่าประชาสัมพันธ์",
            "604023000" => "ค่าจ้างเหมาบริการ ในการพัฒนาระบบเทคโนโลยีสารสนเทศ",
            "604023100" => "ค่าใช้จ่ายอื่นในการพัฒนาระบบเทคโนโลยีสารสนเทศ",
            "604024500" => "ค่าใช้จ่ายอื่นในการเลี้ยงดูบุตร",
            "604024702" => "ค่าเช่าบริการศูนย์ข้อมูล",
            "604024703" => "ค่าเช่าเครื่องและอุปกรณ์คอมพิวเตอร์",
            "604024704" => "ค่าเช่า Software",
            "604030100" => "ค่าวัสดุสำนักงาน",
            "604030200" => "ค่าวัสดุคอมพิวเตอร์",
            "604030300" => "ค่าวัสดุไฟฟ้าและวิทยุ",
            "604031200" => "ค่าวัสดุโฆษณาและเผยแพร่",
            "605050000" => "ค่าบริการทางด้านโทรคมนาคม",
            "606010100" => "ค่าครุภัณฑ์สำนักงาน",
            "606020100" => "ค่าครุภัณฑ์ยานพาหนะและขนส่ง",
            "606020200" => "ค่าครุภัณฑ์ยานพาหนะและขนส่ง ที่ประกอบดัดแปลง ต่อเติมหรือปรับปรุง",
            "606030100" => "ค่าครุภัณฑ์ไฟฟ้าและวิทยุ",
            "606050100" => "ค่าครุภัณฑ์โฆษณาและเผยแพร่",
            "606050200" => "ค่าครุภัณฑ์โฆษณาและเผยแพร่ ที่ประกอบดัดแปลง ต่อเติมหรือปรับปรุง",
            "606050300" => "ค่าครุภัณฑ์โฆษณาและเผยแพร่ ที่ได้รับอุดหนุนจากรัฐบาล",
            "606110100" => "ค่าครุภัณฑ์คอมพิวเตอร์",
            "606110200" => "ค่าครุภัณฑ์คอมพิวเตอร์ ที่ประกอบดัดแปลง ต่อเติมหรือปรับปรุง",
            "606110300" => "ค่าครุภัณฑ์คอมพิวเตอร์ ที่ได้รับอุดหนุนจากรัฐบาล",
            "606110400" => "ค่าครุภัณฑ์คอมพิวเตอร์ ในการพัฒนาระบบเทคโนโลยีสารสนเทศ",
            "606110500" => "ค่าโปรแกรมคอมพิวเตอร์",
            "606110800" => "ค่าโปรแกรมคอมพิวเตอร์ ในการพัฒนาระบบเทคโนโลยีสารสนเทศ",
            "606160100" => "ค่าทรัพย์สินทางปัญญา",
            "609010100" => "เงินสำรองจ่าย",
            "609050400" => "ค่าใช้จ่ายในการดำเนินการหารายได้",
            "611020300" => "ค่าใช้จ่ายสำนักงาน",

        ];

        if ($chart_of_account_id && array_key_exists($chart_of_account_id, $chart_of_accounts)) {
            return $chart_of_accounts[$chart_of_account_id];
        } elseif (!$chart_of_account_id) {
            return $chart_of_accounts;
        } else {
            return 'Unknown';
        }
    }

    public static function Department($department_id = null)
    {
        $departments = [
            "02"  => "โรงพยาบาลจุฬาลงกรณ์",
            "03"  => "โรงพยาบาลสมเด็จพระบรมราชเทวี ณ ศรีราชา",
            "04"  => "สถานเสาวภา",
            "05"  => "สำนักงานยุวกาชาด",
            "06"  => "สำนักงานอาสากาชาด",
            "07"  => "ศูนย์บริการโลหิตแห่งชาติ",
            "08"  => "สำนักงานบรรเทาทุกข์และประชานามัยพิทักษ์",
            "09"  => "สำนักงานจัดหารายได้",
            "10"  => "สถาบันการพยาบาลศรีสวรินทิรา สภากาชาดไทย",
            "11"  => "ศูนย์เวชศาสตร์ฟื้นฟู",
            "12"  => "สำนักงานการคลัง",
            "13"  => "ศูนย์ดวงตา",
            "14"  => "ศูนย์วิจัยโรคเอดส์",
            "15"  => "มูลนิธิสงเคราะห์เด็กของสภากาชาดไทย",
            "16"  => "สำนักงานบริหารทรัพยากรบุคคล",
            "17"  => "สำนักงานบริหารกลาง",
            "171" => "สำนักวิเทศสัมพันธ์",
            "172" => "สำนักสารนิเทศและสื่อสารองค์กร",
            "18"  => "สำนักงานโภชนาการสวนจิตรลดา",
            "19"  => "ศูนย์รับบริจาคอวัยวะ",
            "20"  => "สำนักงานจัดการทรัพย์สิน",
            "21"  => "สำนักงานเทคโนโลยีสารสนเทศและดิจิทัล",
            "22"  => "ศูนย์ฝึกอบรมปฐมพยาบาลและสุขภาพอนามัย",
            "23"  => "สำนักงานตรวจสอบ",
            "24"  => "สำนักงานบริหารระบบกายภาพ",
            "25"  => "สำนักงานบริหารกิจการเหล่ากาชาด",
            "26"  => "กลุ่มงานกลยุทธ์องค์กร",
            "261" => "สำนักนโยบายยุทธศาสตร์และงบประมาณ",
            "262" => "สำนักบริหารความเสี่ยงและควบคุมภายใน",
            "263" => "สำนักขับเคลื่อนการพัฒนา",
            "27"  => "สำนักกฎหมาย",
        ];

        if ($department_id && array_key_exists($department_id, $departments)) {
            return $departments[$department_id];
        } elseif (!$department_id) {
            return $departments;
        } else {
            return 'Unknown';
        }
    }

    public static function contractAcquisition($acquisition_id = null)
    {
        $acquisition = [
            "1" => "วิธีตกลงราคา",
            "2" => "วิธีสอบราคา",
            "3" => "วิธีประกวดราคา",
            "4" => "วิธีพิเศษ",
            "5" => "วิธีกรณีพิเศษ",
            "6" => "วิธีประมูลด้วยระบบอิเล็กทรอนิกส์",
        ];

        if ($acquisition_id && array_key_exists($acquisition_id, $acquisition)) {
            return $acquisition[$acquisition_id];
        } elseif (!$acquisition_id) {
            return $acquisition;
        } else {
            return 'Unknown';
        }
    }

    public static function contractType($type_id = null)
    {
        $type = [
            "B" => "การซื้อ",
            "H" => "การจ้าง",
            "L" => "การเช่า",
        ];

        if ($type_id && array_key_exists($type_id, $type)) {
            return $type[$type_id];
        } elseif (!$type_id) {
            return $type;
        } else {
            return 'Unknown';
        }
    }

    public static function JuristicType($juristic_type_id = null)
    {
        $juristic_types = [
            "1" => "บุคคลธรรมดา",
            "2" => "นิติบุคคล",
        ];

        if ($juristic_type_id && array_key_exists($juristic_type_id, $juristic_types)) {
            return $juristic_types[$juristic_type_id];
        } elseif (!$juristic_type_id) {
            return $juristic_types;
        } else {
            return 'Unknown';
        }
    }

    public static function DataSubjectCid($cid)
    {
        return $cid ?? "-";
    }

    public static function DataSubjectName(Object $data_subject)
    {
        $_text = $data_subject->data_subject_title . $data_subject->data_subject_firstname . " " . $data_subject->data_subject_lastname;
        return $_text != " " ? $_text : "-";
    }

    public static function DataSubjectTelephone($telephone)
    {
        return $telephone ?? "-";
    }

    public static function DataSubjectEmail($email)
    {
        return $email ?? "-";
    }

    public static function NameLogo($user)
    {
        $first = $user->firstname ? substr($user->firstname, 0, 1) : '';
        $last  = $user->lastname ? substr($user->lastname, 0, 1) : '';
        return strtoupper($first . $last);
    }

    public static function Username($user_id)
    {
        $user = User::find($user_id);
        return $user->firstname ?? "-";
    }

    public static function JsonDecode($json, $key1 = null, $key2 = null)
    {
        $array = json_decode($json, JSON_OBJECT_AS_ARRAY);
        if (array_key_exists($key1, $array)) {
            return $array[$key1][$key2];
        }
        return null;
    }

    /**
     * แสดงผลตัวเลขจำนวนเงิน
     */
    public static function millionFormat($number)
    {
        if ($number < 1000000) {
            // Anything less than a million
            $format = number_format($number);
        } else if ($number < 1000000000) {
            // Anything less than a billion
            $format = (number_format ($number / 1000000, 2)) . 'M';
        } else {
            // At least a billion
            $format = (number_format($number / 1000000000, 2)) . 'B';
        }
        return $format;
    }

}
