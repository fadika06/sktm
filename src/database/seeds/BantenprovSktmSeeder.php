<?php

use Illuminate\Database\Seeder;

class BantenprovSktmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BantenprovSktmSeederMasterSktm::class);
        $this->call(BantenprovSktmSeederSktm::class);
    }
}
