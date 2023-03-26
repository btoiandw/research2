<?php

namespace Database\Seeders;

use App\Models\TbResearchSource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResearchSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $source = [
            [

                'research_source_name' => 'งบแผ่นดินโครงการยุทธศาสตร์',
                'full_name_source' => 'งบแผ่นดินโครงการยุทธศาสตร์',
                'Year_source' => '2565',
                'type_research_source' => 'ภายใน',
                'ex_research' => ''
            ],
            [

                'research_source_name' => 'งบรายได้(บ.กศ.)',
                'full_name_source' => 'งบรายได้(บ.กศ.).',
                'Year_source' => '2565',
                'type_research_source' => 'ภายใน',
                'ex_research' => ''
            ],
            [

                'research_source_name' => 'วช.',
                'full_name_source' => 'สำนักงานการวิจัยแห่งชาติ (วช.)',
                'Year_source' => '2565',
                'type_research_source' => 'ภายนอก',
                'ex_research' => ''
            ],
            [

                'research_source_name' => 'สก.สว.',
                'full_name_source' => 'สำนักงานคณะกรรมการส่งเสริมวิทยาศาสตร์ วิจัยและนวัตกรรม (สก.สว.)',
                'Year_source' => '2565',
                'type_research_source' => 'ภายนอก',
                'ex_research' => ''
            ],
            [

                'research_source_name' => 'PMU',
                'full_name_source'=>'Program Management Unit (PMU)',
                'Year_source' => '2565',
                'type_research_source' => 'ภายนอก',
                'ex_research' => ''
            ]
        ];
        foreach ($source as $key => $value) {
            TbResearchSource::create($value);
        }
    }
}
