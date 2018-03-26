<?php

/* Require */
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/* Models */
use Bantenprov\Sktm\Models\Bantenprov\Sktm\Sktm;

class BantenprovSktmSeederSktm extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
	{
        Model::unguard();

        $sktms = (object) [
            (object) [
                'user_id' => '1',
                'master_sktm_id' => '1',
                'nomor_un' => '1',
                'nama_lomba' => 'Lomba 2'              
            ],
            (object) [
                'user_id' => '2',
                'master_sktm_id' => '2',
                'nomor_un' => '2',
                'nama_lomba' => 'Lomba 2'
            ]
        ];

        foreach ($sktms as $sktm) {
            $model = Sktm::updateOrCreate(
                [
                   'user_id' => $sktm->user_id,
                   'master_sktm_id' => $sktm->master_sktm_id,
                   'nomor_un' => $sktm->nomor_un,
                   'nama_lomba' => $sktm->nama_lomba,
                ]
            );
            $model->save();
        }
	}
}


