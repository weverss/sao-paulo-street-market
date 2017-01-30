<?php

namespace Tivit\StreetMarket\Console\Commands;

use DB;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\JsonFormatter;
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
        $streamHandler = new StreamHandler('php://stdout', Logger::INFO);
        $streamHandler->setFormatter(new JsonFormatter());

        $this->log = new Logger('street_market_importer');
        $this->log->pushHandler($streamHandler);

        $this->loadFile();
        $this->prepareData();
        $this->import();
    }

    protected function loadFile()
    {
        $file = file($this->argument('filepath'));

        $this->file = array_map('str_getcsv', $file);
    }

    protected function prepareData()
    {
        $keys = array_shift($this->file);

        $countKeys = count($keys);

        foreach ($this->file as $values) {
            $countValues = count($values);

            if ($countValues < $countKeys) {
                $extraValues = array_fill(0, $countKeys - $countValues, '');
                $values = array_merge($values, $extraValues);
            }

            $this->data[] = array_combine($keys, $values);
        }
    }

    protected function import()
    {
        DB::table('street_markets')->truncate();

        foreach ($this->data as $key => $item) {
            $streetMarket = new StreetMarket();

            $this->populate($streetMarket, $item);

            $streetMarket->save();

            $this->log->addInfo('street_market_imported', [
                'registration_code' => $streetMarket->registration_code,
                'street_market_name' => $streetMarket->street_market_name,
            ]);
        }
    }

    protected function populate(StreetMarket $streetMarket, array $values)
    {
        $streetMarket->id = $values['ID'];
        $streetMarket->longitude = $values['LONG'];
        $streetMarket->latitude = $values['LAT'];
        $streetMarket->census_tract = $values['SETCENS'];
        $streetMarket->census_tract_group = $values['AREAP'];
        $streetMarket->district_code = $values['CODDIST'];
        $streetMarket->district_name = ucwords(strtolower($values['DISTRITO']));
        $streetMarket->council_code = $values['CODSUBPREF'];
        $streetMarket->council_name = ucwords(strtolower($values['SUBPREFE']));
        $streetMarket->five_area_region = $values['REGIAO5'];
        $streetMarket->eight_area_region = $values['REGIAO8'];
        $streetMarket->street_market_name = ucwords(strtolower($values['NOME_FEIRA']));
        $streetMarket->registration_code = $values['REGISTRO'];
        $streetMarket->street_name = ucwords(strtolower($values['LOGRADOURO']));
        $streetMarket->street_number = $values['NUMERO'];
        $streetMarket->neighborhood = ucwords(strtolower($values['BAIRRO']));
        $streetMarket->landmark = ucwords(strtolower($values['REFERENCIA']));

        if (is_numeric($values['NUMERO'])) {
            $streetMarket->street_number = intval($streetMarket->street_number);
        }
    }
}