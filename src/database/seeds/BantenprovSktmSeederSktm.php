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
                'label' => 'Sktm 1',
                'description' => 'Sktm 1',
            ],
            (object) [
                'label' => 'Sktm 2',
                'description' => 'Sktm 2',
            ]
        ];

        foreach ($sktms as $sktm) {
            $model = Sktm::updateOrCreate(
                [
                    'label' => $sktm->label,
                ],
                [
                    'description' => $sktm->description,
                ]
            );
            $model->save();
        }
	}
}
