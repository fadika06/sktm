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
                'nama' => 'Budi',
                'nilai' => '1',              
                'instansi' => 'Satu'                           
            ],
            (object) [
                
                'user_id' => '2',
                'nama' => 'Badu',
                'nilai' => '2',              
                'instansi' => 'Dua'                          
            ]
        ];

        foreach ($master_sktms as $master_sktm) {
            $model = MasterSktm::updateOrCreate(
                [
                   'user_id' => $master_sktm->user_id,
                   'nama' => $master_sktm->nama,
                   'nilai' => $master_sktm->nilai,
                   'instansi' => $master_sktm->nilai,

                ]
            );
            $model->save();
        }
	}
}


