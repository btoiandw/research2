<?php

namespace Database\Seeders;

use App\Models\TbFaculty;
use App\Models\TbMajor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        /*  $faculty = [
            ['organizational' => 'คณะครุศาสตร์', 'major' => 'โปรแกรมวิชาการศึกษาปฐมวัย'],
            ['organizational' => 'คณะครุศาสตร์', 'major' => 'โปรแกรมวิชาการประถมศึกษา'],
            ['organizational' => 'คณะครุศาสตร์', 'major' => 'โปรแกรมวิชาภาษาอังกฤษ'],
            ['organizational' => 'คณะครุศาสตร์', 'major' => 'โปรแกรมวิชาภาษาไทย'],
            ['organizational' => 'คณะครุศาสตร์', 'major' => 'โปรแกรมวิชาภาษาจีน'],
            ['organizational' => 'คณะครุศาสตร์', 'major' => 'โปรแกรมวิชาคอมพิวเตอร์'],
            ['organizational' => 'คณะครุศาสตร์', 'major' => 'โปรแกรมวิชาคณิศาสตร์'],
            ['organizational' => 'คณะครุศาสตร์', 'major' => 'โปรแกรมวิชาสังคมศึกษา'],
            ['organizational' => 'คณะครุศาสตร์', 'major' => 'โปรแกรมวิชาวิทยาศาสตร์ทั่วไป'],
            ['organizational' => 'คณะครุศาสตร์', 'major' => 'โปรแกรมวิชาพลศึกษา'],
            ['organizational' => 'คณะมนุษยศาสตร์และสังคมศาสตร์', 'major' => 'โปรแกรมวิชารัฐประศาสนศาสตร์'],
            ['organizational' => 'คณะมนุษยศาสตร์และสังคมศาสตร์', 'major' => 'โปรแกรมวิชานิติศาสตร์'],
            ['organizational' => 'คณะมนุษยศาสตร์และสังคมศาสตร์', 'major' => 'โปรแกรมวิชาการพัฒนาสังคม'],
            ['organizational' => 'คณะมนุษยศาสตร์และสังคมศาสตร์', 'major' => 'โปรแกรมวิชาภาษาอังกฤษ'],
            ['organizational' => 'คณะมนุษยศาสตร์และสังคมศาสตร์', 'major' => 'โปรแกรมวิชาวิจิตรศิลป์และประยุกต์ศิลป์'],
            ['organizational' => 'คณะมนุษยศาสตร์และสังคมศาสตร์', 'major' => 'โปรแกรมวิชาภาษาไทย'],
            ['organizational' => 'คณะมนุษยศาสตร์และสังคมศาสตร์', 'major' => 'โปรแกรมวิชาบรรณารักษศาสตร์และสารสนเทศศาสตร์'],
            ['organizational' => 'คณะมนุษยศาสตร์และสังคมศาสตร์', 'major' => 'โปรแกรมวิชาภูมิสารสนเทศ'],
            ['organizational' => 'คณะมนุษยศาสตร์และสังคมศาสตร์', 'major' => 'โปรแกรมวิชาภาษาจีน'],
            ['organizational' => 'คณะมนุษยศาสตร์และสังคมศาสตร์', 'major' => 'โปรแกรมวิชาดนตรีศึกษา'],
            ['organizational' => 'คณะวิทยาการจัดการ', 'major' => 'โปรแกรมวิชาการบัญชี'],
            ['organizational' => 'คณะวิทยาการจัดการ', 'major' => 'โปรแกรมวิชาเอกการจัดการธุรกิจ'],
            ['organizational' => 'คณะวิทยาการจัดการ', 'major' => 'โปรแกรมวิชาเอกการตลาด'],
            ['organizational' => 'คณะวิทยาการจัดการ', 'major' => 'โปรแกรมวิชาเอกการเงิน'],
            ['organizational' => 'คณะวิทยาการจัดการ', 'major' => 'โปรแกรมวิชาเอกเทคโนโลยีธุรกิจดิจิทัล'],
            ['organizational' => 'คณะวิทยาการจัดการ', 'major' => 'โปรแกรมวิชาเอกการเป็นผู้ประกอบการ'],
            ['organizational' => 'คณะวิทยาการจัดการ', 'major' => 'โปรแกรมวิชาท่องเที่ยวและการโรงแรม'],
            ['organizational' => 'คณะวิทยาการจัดการ', 'major' => 'โปรแกรมวิชานิเทศศาสตร์'],
            ['organizational' => 'คณะวิทยาศาสตร์และเทคโนโลยี', 'major' => 'โปรแกรมวิชาวิทยาการคอมพิวเตอร์'],
            ['organizational' => 'คณะวิทยาศาสตร์และเทคโนโลยี', 'major' => 'โปรแกรมวิชาเทคโนโลยีสารสนเทศ'],
            ['organizational' => 'คณะวิทยาศาสตร์และเทคโนโลยี', 'major' => 'โปรแกรมวิชาฟิสิกส์'],
            ['organizational' => 'คณะวิทยาศาสตร์และเทคโนโลยี', 'major' => 'โปรแกรมวิชาชีววิทยา'],
            ['organizational' => 'คณะวิทยาศาสตร์และเทคโนโลยี', 'major' => 'โปรแกรมวิชาคณิตศาสตร์'],
            ['organizational' => 'คณะวิทยาศาสตร์และเทคโนโลยี', 'major' => 'โปรแกรมวิชาสาธารณสุขศาสตร์'],
            ['organizational' => 'คณะวิทยาศาสตร์และเทคโนโลยี', 'major' => 'โปรแกรมวิชานวัตกรรมและธุรกิจอาหาร'],
            ['organizational' => 'คณะวิทยาศาสตร์และเทคโนโลยี', 'major' => 'โปรแกรมวิชาเคมีและวิทยาศาสตร์สิ่งแวดล้อม วิชาเอกเคมี'],
            ['organizational' => 'คณะวิทยาศาสตร์และเทคโนโลยี', 'major' => 'โปรแกรมวิชาเคมีและวิทยาศาสตร์สิ่งแวดล้อม วิชาเอกเคมีอุตสาหกรรม'],
            ['organizational' => 'คณะวิทยาศาสตร์และเทคโนโลยี', 'major' => 'โปรแกรมวิชาเคมีและวิทยาศาสตร์สิ่งแวดล้อม วิชาเอกสิ่งแวดล้อม'],
            ['organizational' => 'คณะเทคโนอุตสาหกรรม', 'major' => 'โปรแกรมวิชาเทคโนโลยีวิศวกรรมไฟฟ้า'],
            ['organizational' => 'คณะเทคโนอุตสาหกรรม', 'major' => 'โปรแกรมวิชาเทคโนโลยีพลังงาน'],
            ['organizational' => 'คณะเทคโนอุตสาหกรรม', 'major' => 'โปรแกรมวิชาเทคโนโลยีวิศวกรรมโยธา'],
            ['organizational' => 'คณะเทคโนอุตสาหกรรม', 'major' => 'โปรแกรมวิชาเทคโนโลยีอุตสาหกรรม'],
            ['organizational' => 'คณะเทคโนอุตสาหกรรม', 'major' => 'โปรแกรมวิชาออกแบบผลิตภัณฑ์และกราฟิก'],
            ['organizational' => 'คณะเทคโนอุตสาหกรรม', 'major' => 'โปรแกรมวิชาเทคโนโลยีคอมพิวเตอร์'],
            ['organizational' => 'คณะเทคโนอุตสาหกรรม', 'major' => 'โปรแกรมวิชาการจัดการโลจิสติกส์'],
            ['organizational' => 'คณะเทคโนอุตสาหกรรม', 'major' => 'โปรแกรมวิชาอุตสาหกรรมศิลป์'],
        ]; */

        $faculty = [
            [
                'organization_id' => '1',
                'organizational_name' => 'คณะครุศาสตร์',
            ],
            [
                'organization_id' => '2',
                'organizational_name' => 'คณะมนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'organization_id' => '3',
                'organizational_name' => 'คณะวิทยาการจัดการ',
            ],
            [
                'organization_id' => '4',
                'organizational_name' => 'คณะวิทยาศาสตร์และเทคโนโลยี',
            ],
            [
                'organization_id' => '5',
                'organizational_name' => 'คณะเทคโนโลยีอุตสาหกรรม',
            ],
            [
                'organization_id' => '6',
                'organizational_name' => 'คณะพยาบาลศาสตร์',
            ]
        ];
        foreach ($faculty as $key => $value) {
            TbFaculty::create($value);
        }

        $major = [
            [
                'major_id' => '1',
                'major_name' => 'โปรแกรมวิชาการศึกษาปฐมวัย',
                'organization_id' => '1',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '2',
                'major_name' => 'โปรแกรมวิชาการประถมศึกษา',
                'organization_id' => '1',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '3',
                'major_name' => 'โปรแกรมวิชาภาษาอังกฤษ',
                'organization_id' => '1',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '4',
                'major_name' => 'โปรแกรมวิชาภาษาไทย',
                'organization_id' => '1',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '5',
                'major_name' => 'โปรแกรมวิชาภาษาจีน',
                'organization_id' => '1',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '6',
                'major_name' => 'โปรแกรมวิชาคอมพิวเตอร์',
                'organization_id' => '1',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '7',
                'major_name' => 'โปรแกรมวิชาคณิศาสตร์',
                'organization_id' => '1',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '8',
                'major_name' => 'โปรแกรมวิชาสังคมศึกษา',
                'organization_id' => '1',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '9',
                'major_name' => 'โปรแกรมวิชาวิทยาศาสตร์ทั่วไป',
                'organization_id' => '1',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '10',
                'major_name' => 'โปรแกรมวิชาพลศึกษา',
                'organization_id' => '1',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '11',
                'major_name' => 'โปรแกรมวิชารัฐประศาสนศาสตร์',
                'organization_id' => '2',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '12',
                'major_name' => 'โปรแกรมวิชาการพัฒนาสังคม',
                'organization_id' => '2',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '13',
                'major_name' => 'โปรแกรมวิชาภาษาอังกฤษ',
                'organization_id' => '2',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '14',
                'major_name' => 'โปรแกรมวิชานิติศาสตร์',
                'organization_id' => '2',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '15',
                'major_name' => 'โปรแกรมวิชาวิจิตรศิลป์และประยุกต์ศิลป์',
                'organization_id' => '2',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '16',
                'major_name' => 'โปรแกรมวิชาภาษาไทย',
                'organization_id' => '2',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '17',
                'major_name' => 'โปรแกรมวิชาบรรณารักษศาสตร์และสารสนเทศศาสตร์',
                'organization_id' => '2',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '18',
                'major_name' => 'โปรแกรมวิชาภูมิสารสนเทศ',
                'organization_id' => '2',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '19',
                'major_name' => 'โปรแกรมวิชาภาษาจีน',
                'organization_id' => '2',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '20',
                'major_name' => 'โปรแกรมวิชาดนตรีศึกษา',
                'organization_id' => '2',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '21',
                'major_name' => 'โปรแกรมวิชาการบัญชี',
                'organization_id' => '3',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '22',
                'major_name' => 'โปรแกรมวิชาเอกการจัดการธุรกิจ',
                'organization_id' => '3',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '23',
                'major_name' => 'โปรแกรมวิชาเอกการตลาด',
                'organization_id' => '3',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '24',
                'major_name' => 'โปรแกรมวิชาเอกการเงิน',
                'organization_id' => '3',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '25',
                'major_name' => 'โปรแกรมวิชาเอกเทคโนโลยีธุรกิจดิจิทัล',
                'organization_id' => '3',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '26',
                'major_name' => 'โปรแกรมวิชาเอกการเป็นผู้ประกอบการ',
                'organization_id' => '3',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '27',
                'major_name' => 'โปรแกรมวิชาท่องเที่ยวและการโรงแรม',
                'organization_id' => '3',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '28',
                'major_name' => 'โปรแกรมวิชานิเทศศาสตร์',
                'organization_id' => '3',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '29',
                'major_name' => 'โปรแกรมวิชาเคมี(วท.บ.)',
                'organization_id' => '4',
                'group_disciplines' => 'กลุ่มสาขาวิทยศาสตร์และเทคโนโลยี',
            ],
            [
                'major_id' => '30',
                'major_name' => 'โปรแกรมวิชาวิทยาการคอมพิวเตอร์',
                'organization_id' => '4',
                'group_disciplines' => 'กลุ่มสาขาวิทยศาสตร์และเทคโนโลยี',
            ],
            [
                'major_id' => '31',
                'major_name' => 'โปรแกรมวิชาเทคโนโลยีสารสนเทศ',
                'organization_id' => '4',
                'group_disciplines' => 'กลุ่มสาขาวิทยศาสตร์และเทคโนโลยี',
            ],
            [
                'major_id' => '32',
                'major_name' => 'โปรแกรมวิชานวัตกรรมและธุรกิจอาหาร',
                'organization_id' => '4',
                'group_disciplines' => 'กลุ่มสาขาวิทยศาสตร์และเทคโนโลยี',
            ],
            [
                'major_id' => '33',
                'major_name' => 'โปรแกรมวิชาสาธารณสุขศาสตร์',
                'organization_id' => '4',
                'group_disciplines' => 'กลุ่มสาขาวิทยศาสตร์และเทคโนโลยี',
            ],
            [
                'major_id' => '34',
                'major_name' => 'โปรแกรมวิชาคณิตศาสตร์',
                'organization_id' => '4',
                'group_disciplines' => 'กลุ่มสาขาวิทยศาสตร์และเทคโนโลยี',
            ],
            [
                'major_id' => '35',
                'major_name' => 'โปรแกรมวิชาเคมี(คบ.)',
                'organization_id' => '4',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '36',
                'major_name' => 'โปรแกรมวิชาฟิสิกส์',
                'organization_id' => '4',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '37',
                'major_name' => 'โปรแกรมวิชาชีววิทยา',
                'organization_id' => '4',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '38',
                'major_name' => 'โปรแกรมวิชาเทคโนโลยีวิศวกรรมไฟฟ้า',
                'organization_id' => '5',
                'group_disciplines' => 'กลุ่มสาขาวิทยศาสตร์และเทคโนโลยี',
            ],
            [
                'major_id' => '39',
                'major_name' => 'โปรแกรมวิชาเทคโนโลยีพลังงาน',
                'organization_id' => '5',
                'group_disciplines' => 'กลุ่มสาขาวิทยศาสตร์และเทคโนโลยี',
            ],
            [
                'major_id' => '40',
                'major_name' => 'โปรแกรมวิชาเทคโนโลยีวิศวกรรมโยธา',
                'organization_id' => '5',
                'group_disciplines' => 'กลุ่มสาขาวิทยศาสตร์และเทคโนโลยี',
            ],
            [
                'major_id' => '41',
                'major_name' => 'โปรแกรมวิชาเทคโนโลยีอุตสาหกรรม',
                'organization_id' => '5',
                'group_disciplines' => 'กลุ่มสาขาวิทยศาสตร์และเทคโนโลยี',
            ],
            [
                'major_id' => '42',
                'major_name' => 'โปรแกรมวิชาเทคโนโลยีคอมพิวเตอร์',
                'organization_id' => '5',
                'group_disciplines' => 'กลุ่มสาขาวิทยศาสตร์และเทคโนโลยี',
            ],
            [
                'major_id' => '43',
                'major_name' => 'โปรแกรมวิชาออกแบบผลิตภัณฑ์และกราฟิก',
                'organization_id' => '5',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '44',
                'major_name' => 'โปรแกรมวิชาการจัดการโลจิสติกส์',
                'organization_id' => '5',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '45',
                'major_name' => 'โปรแกรมวิชาอุตสาหกรรมศิลป์',
                'organization_id' => '5',
                'group_disciplines' => 'กลุ่มสาขามนุษยศาสตร์และสังคมศาสตร์',
            ],
            [
                'major_id' => '46',
                'major_name' => 'โปรแกรมวิชาพยาบาลศาสตร์',
                'organization_id' => '6',
                'group_disciplines' => 'กลุ่มสาขาวิทยาศาสตร์สุขภาพ',
            ],
        ];

        foreach ($major as $key => $item) {
            TbMajor::create($item);
        }
    }
}
