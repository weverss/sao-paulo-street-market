<?php

namespace Tests\Unit;

use DB;
use Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ImportStreetMarketsTest extends TestCase
{
    public function testHandle()
    {
        Artisan::call('import:street-markets', ['filepath' => base_path('tests/TestFile.csv')]);

    $expected = <<<EOT
Importando CSV
Feira 1 de 10 importada: 4041-0 Vila Formosa
Feira 2 de 10 importada: 4045-2 Praca Santa Helena
Feira 3 de 10 importada: 4003-7 Concordia
Feira 4 de 10 importada: 3048-1 Vila Nova Granada
Feira 5 de 10 importada: 7210-9 Parque Savoy City
Feira 6 de 10 importada: 1087-1 Mar Paulista
Feira 7 de 10 importada: 1040-5 Cruz Das Almas
Feira 8 de 10 importada: 7222-2 Lajeado
Feira 9 de 10 importada: 3008-2 Alto Das Perdizes
Feira 10 de 10 importada: 4038-0 Maria Carlota
Concluído.

EOT;

        $actual = Artisan::output();

        $this->assertEquals($expected, $actual);
    }
}
