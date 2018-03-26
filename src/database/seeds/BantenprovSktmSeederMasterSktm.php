<?php

/* Require */
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/* Models */
use Bantenprov\Sktm\Models\Bantenprov\Sktm\MasterSktm;

class BantenprovSktmSeederMasterSktm extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
	{
        Model::unguard();

        $master_sktms = (object) [
            (object) [
                'user_id' => '1',
                'juara' => '1',
                'tingkat' => '1',
                'nilai' => '10',              
                'bobot' => '1'                           
            ],
            (object) [
                'user_id' => '1',
                'juara' => '2',
                'tingkat' => '2',
                'nilai' => '20', 
                'bobot' => '2'                          
            ]
        ];

        foreach ($master_sktms as $master_sktm) {
            $model = MasterSktm::updateOrCreate(
                [
                   'user_id' => $master_sktm->user_id,
                   'juara' => $master_sktm->juara,
                   'tingkat' => $master_sktm->tingkat,
                   'nilai' => $master_sktm->nilai,
                   'bobot' => $master_sktm->bobot,

                ]
            );
            $model->save();
        }
	}
}


