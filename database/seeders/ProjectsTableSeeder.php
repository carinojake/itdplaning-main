<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('projects')->delete();
        
        \DB::table('projects')->insert(array (
            0 => 
            array (
                'project_id' => 1,
                'project_name' => 'งานให้คำปรึกษาและผลักดันเพื่อพัฒนาระบบเทคโนโลยีสารสนเทศของหน่วยงานตามภารกิจของสภากาชาดไทย',
                'project_description' => NULL,
                'project_type' => NULL,
                'start_date' => '2022-10-01 00:00:00',
                'end_date' => '2023-09-30 00:00:00',
                'budget_gov_operating' => 0,
                'budget_gov_investment' => NULL,
                'budget_gov_utility' => NULL,
                'budget_it_operating' => NULL,
                'budget_it_investment' => NULL,
                'project_cost' => NULL,
                'project_owner' => 0,
                'craeted_at' => '2022-10-28 14:32:06',
                'updated_at' => '2022-10-28 14:32:06',
            ),
            1 => 
            array (
                'project_id' => 2,
                'project_name' => 'งานพัฒนา ดูแล บำรุงรักษา และให้บริการระบบอินทราเน็ตและเว็บไซต์ของสภากาชาดไทย',
                'project_description' => NULL,
                'project_type' => NULL,
                'start_date' => '2022-10-01 00:00:00',
                'end_date' => '2023-09-30 00:00:00',
                'budget_gov_operating' => 8170000,
                'budget_gov_investment' => NULL,
                'budget_gov_utility' => NULL,
                'budget_it_operating' => NULL,
                'budget_it_investment' => NULL,
                'project_cost' => NULL,
                'project_owner' => 0,
                'craeted_at' => '2022-10-28 14:32:06',
                'updated_at' => '2022-10-28 14:32:06',
            ),
            2 => 
            array (
                'project_id' => 3,
            'project_name' => 'งานบริการ สนับสนุนซอฟต์แวร์ (Software) เพื่อสนับสนุนการดำเนินงานตามภารกิจของสภากาชาดไทย ',
                'project_description' => NULL,
                'project_type' => NULL,
                'start_date' => '2022-10-01 00:00:00',
                'end_date' => '2023-09-30 00:00:00',
                'budget_gov_operating' => 27085828,
                'budget_gov_investment' => NULL,
                'budget_gov_utility' => NULL,
                'budget_it_operating' => NULL,
                'budget_it_investment' => NULL,
                'project_cost' => NULL,
                'project_owner' => 0,
                'craeted_at' => '2022-10-28 14:32:06',
                'updated_at' => '2022-10-28 14:32:06',
            ),
            3 => 
            array (
                'project_id' => 4,
            'project_name' => 'งานบริการ สนับสนุนอุปกรณ์ระบบคอมพิวเตอร์ (Hardware) เพื่อสนับสนุนการดำเนินงานตามภารกิจของสภากาชาดไทย',
                'project_description' => NULL,
                'project_type' => NULL,
                'start_date' => '2022-10-01 00:00:00',
                'end_date' => '2023-09-30 00:00:00',
                'budget_gov_operating' => 0,
                'budget_gov_investment' => NULL,
                'budget_gov_utility' => NULL,
                'budget_it_operating' => NULL,
                'budget_it_investment' => NULL,
                'project_cost' => NULL,
                'project_owner' => 0,
                'craeted_at' => '2022-10-28 14:32:06',
                'updated_at' => '2022-10-28 14:32:06',
            ),
            4 => 
            array (
                'project_id' => 5,
                'project_name' => 'งานพัฒนา ดูแล บำรุงรักษา ศูนย์ข้อมูลคอมพิวเตอร์และคอมพิวเตอร์แม่ข่าย',
                'project_description' => NULL,
                'project_type' => NULL,
                'start_date' => '2022-10-01 00:00:00',
                'end_date' => '2023-09-30 00:00:00',
                'budget_gov_operating' => 26500000,
                'budget_gov_investment' => NULL,
                'budget_gov_utility' => NULL,
                'budget_it_operating' => NULL,
                'budget_it_investment' => NULL,
                'project_cost' => NULL,
                'project_owner' => 0,
                'craeted_at' => '2022-10-28 14:32:06',
                'updated_at' => '2022-10-28 14:32:06',
            ),
            5 => 
            array (
                'project_id' => 6,
                'project_name' => 'งานพัฒนา ดูแล บำรุงรักษาและให้บริการระบบเครือข่าย',
                'project_description' => NULL,
                'project_type' => NULL,
                'start_date' => '2022-10-01 00:00:00',
                'end_date' => '2023-09-30 00:00:00',
                'budget_gov_operating' => 26500000,
                'budget_gov_investment' => NULL,
                'budget_gov_utility' => NULL,
                'budget_it_operating' => NULL,
                'budget_it_investment' => NULL,
                'project_cost' => NULL,
                'project_owner' => 0,
                'craeted_at' => '2022-10-28 14:32:06',
                'updated_at' => '2022-10-28 14:32:06',
            ),
            6 => 
            array (
                'project_id' => 7,
                'project_name' => 'งานบริการการใช้งานอินเทอร์เน็ตและระบบเครือข่ายเชื่อมโยงส่วนกลางและส่วนภูมิภาค',
                'project_description' => NULL,
                'project_type' => NULL,
                'start_date' => '2022-10-01 00:00:00',
                'end_date' => '2023-09-30 00:00:00',
                'budget_gov_operating' => 10500000,
                'budget_gov_investment' => NULL,
                'budget_gov_utility' => NULL,
                'budget_it_operating' => NULL,
                'budget_it_investment' => NULL,
                'project_cost' => NULL,
                'project_owner' => 0,
                'craeted_at' => '2022-10-28 14:32:06',
                'updated_at' => '2022-10-28 14:32:06',
            ),
            7 => 
            array (
                'project_id' => 8,
                'project_name' => 'งานบริการ และให้คำปรึกษาด้าน ICT กับหน่วยงานในสภากาชาดไทย (รวม IT Helpdesk)',
                'project_description' => NULL,
                'project_type' => NULL,
                'start_date' => '2022-10-01 00:00:00',
                'end_date' => '2023-09-30 00:00:00',
                'budget_gov_operating' => 0,
                'budget_gov_investment' => NULL,
                'budget_gov_utility' => NULL,
                'budget_it_operating' => NULL,
                'budget_it_investment' => NULL,
                'project_cost' => NULL,
                'project_owner' => 0,
                'craeted_at' => '2022-10-28 14:32:06',
                'updated_at' => '2022-10-28 14:32:06',
            ),
            8 => 
            array (
                'project_id' => 9,
                'project_name' => 'งานพัฒนาบุคลากรของสภากาชาดไทยด้าน ICT',
                'project_description' => NULL,
                'project_type' => NULL,
                'start_date' => '2022-10-01 00:00:00',
                'end_date' => '2023-09-30 00:00:00',
                'budget_gov_operating' => 400000,
                'budget_gov_investment' => NULL,
                'budget_gov_utility' => NULL,
                'budget_it_operating' => NULL,
                'budget_it_investment' => NULL,
                'project_cost' => NULL,
                'project_owner' => 0,
                'craeted_at' => '2022-10-28 14:32:06',
                'updated_at' => '2022-10-28 14:32:06',
            ),
            9 => 
            array (
                'project_id' => 10,
            'project_name' => 'งานพัฒนาบุคลากร (พัฒนาบุคลากรของศูนย์ IT)',
                'project_description' => NULL,
                'project_type' => NULL,
                'start_date' => '2022-10-01 00:00:00',
                'end_date' => '2023-09-30 00:00:00',
                'budget_gov_operating' => 400000,
                'budget_gov_investment' => NULL,
                'budget_gov_utility' => NULL,
                'budget_it_operating' => NULL,
                'budget_it_investment' => NULL,
                'project_cost' => NULL,
                'project_owner' => 0,
                'craeted_at' => '2022-10-28 14:32:06',
                'updated_at' => '2022-10-28 14:32:06',
            ),
            10 => 
            array (
                'project_id' => 11,
                'project_name' => 'งานบริหารองค์กร',
                'project_description' => NULL,
                'project_type' => NULL,
                'start_date' => '2022-10-01 00:00:00',
                'end_date' => '2023-09-30 00:00:00',
                'budget_gov_operating' => 10757000,
                'budget_gov_investment' => NULL,
                'budget_gov_utility' => NULL,
                'budget_it_operating' => NULL,
                'budget_it_investment' => NULL,
                'project_cost' => NULL,
                'project_owner' => 0,
                'craeted_at' => '2022-10-28 14:32:06',
                'updated_at' => '2022-10-28 14:32:06',
            ),
        ));
        
        
    }
}