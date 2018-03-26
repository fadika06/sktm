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
                'nomor_un' => '12345',
                'kode_sktm' => '1',
                'nama_suket' => 'Suket 1',
                'instansi_suket' => 'Sktm 1',
                'no_suket' => '1',
                'nilai_sktm' => '1',
            ],
            (object) [
                'user_id' => '2',
                'nomor_un' => '123',
                'kode_sktm' => '2',
                'nama_suket' => 'Suket 2',
                'instansi_suket' => 'Sktm 2',
                'no_suket' => '2',
                'nilai_sktm' => '2',
            ]
        ];

        foreach ($sktms as $sktm) {
            $model = Sktm::updateOrCreate(
                [
                    'user_id' => $sktm->user_id,
                    'nomor_un' => $sktm->nomor_un,
                    'kode_sktm' => $sktm->kode_sktm,
                    'nama_suket' => $sktm->nama_suket,
                    'instansi_suket' => $sktm->instansi_suket,
                    'no_suket' => $sktm->no_suket,
                    'nilai_sktm' => $sktm->nilai_sktm,

                ]
            );
            $model->save();
        }
	}
}
