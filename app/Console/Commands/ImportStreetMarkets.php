<?php

namespace Tivit\StreetMarket\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Tivit\StreetMarket\StreetMarket;

class ImportStreetMarkets extends Command
{
    protected $signature = 'import:street-markets {filepath : Caminho do arquivo CSV}';

    protected $description = 'Importa lista de feiras de arquivo CSV';

    protected $file = [];

    protected $data = [];

    public function handle()
    {
        $this->loadFile();
        $this->prepareData();

        $this->info('Importando CSV');

        $this->import();

        $this->info('Concluído.');
    }

    protected function loadFile()
    {
        $file = file($this->argument('filepath'));

        $this->file = array_map('str_getcsv', $file);
    }

    protected function prepareData()
    {
        $keys = array_shift($this->file);

        foreach ($this->file as $values) {
            $this->data[] = array_combine($keys, $values);
        }
    }

    protected function import()
    {
        $total = count($this->data);

        foreach ($this->data as $key => $item) {
            $streetMarket = new StreetMarket();

            $streetMarket->id = $item['ID'];
            $streetMarket->longitude = $item['LONG'];
            $streetMarket->latitude = $item['LAT'];
            $streetMarket->census_tract = $item['SETCENS'];
            $streetMarket->census_tract_group = $item['AREAP'];
            $streetMarket->district_code = $item['CODDIST'];
            $streetMarket->district_name = ucwords(strtolower($item['DISTRITO']));
            $streetMarket->council_code = $item['CODSUBPREF'];
            $streetMarket->council_name = ucwords(strtolower($item['SUBPREFE']));
            $streetMarket->five_area_region = $item['REGIAO5'];
            $streetMarket->eight_area_region = $item['REGIAO8'];
            $streetMarket->street_market_name = ucwords(strtolower($item['NOME_FEIRA']));
            $streetMarket->registration_code = $item['REGISTRO'];
            $streetMarket->street_name = ucwords(strtolower($item['LOGRADOURO']));
            $streetMarket->street_number = $item['NUMERO'];
            $streetMarket->neighborhood = ucwords(strtolower($item['BAIRRO']));
            $streetMarket->landmark = ucwords(strtolower($item['REFERENCIA']));

            if (is_numeric($item['NUMERO'])) {
                $streetMarket->street_number = intval($streetMarket->street_number);
            }

            $streetMarket->save();

            $message = sprintf(
                'Feira %d de %d importada: %s %s',
                $key + 1,
                $total,
                $streetMarket->registration_code,
                $streetMarket->street_market_name
            );

            $this->info($message);
        }
    }
}