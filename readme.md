# São Paulo Street Market API


##Docker

Será necessário a instalação do Docker para resolução e dependências. Mais informações em: [https://docs.docker.com/engine/installation/](https://docs.docker.com/engine/installation/)

Após a instalação completa do Docker, baixe o Docker Compose: [https://docs.docker.com/compose/install/](https://docs.docker.com/compose/install/)

## Clone o repositório e acesse a raiz do projeto:
```shell
git clone git@github.com:weverss/sao-paulo-street-market.git
cd sao-paulo-street-market
```

Crie a máquina para executar a aplicação:
```shell
docker-compose up -d
```

Instale o framework e dependências:
```shell
docker run --rm -v $(pwd):/app composer/composer install
```

Crie as tabelas no banco de dados
```shell
docker exec -it street-market-api /bin/bash -c "php artisan migrate"
```

Agora baixe o arquivo CSV com locais de feiras do site da prefeitura de São Paulo:
```shell
wget http://www.prefeitura.sp.gov.br/cidade/secretarias/upload/chamadas/feiras_livres_1429113213.zip
```

Extraia o arquivo "DEINFO_AB_FEIRASLIVRES_2014.csv" para raiz do projeto e execute o importador:
```shell
docker exec -it street-market-api /bin/bash -c "php artisan import:street-markets DEINFO_AB_FEIRASLIVRES_2014.csv"
```

## Testes e Relatórios de Cobertura

Para execução dos testes unitários, execute:
```shell
docker exec -it street-market-api /bin/bash -c "vendor/bin/phpunit --coverage-text"
```

Para informações de cobertura de testes mais detalhadas, rode o commando acima substituindo "--coverage-text" por "--coverage-html {diretório}" para geração em html. Ex.:

```shell
docker exec -it street-market-api /bin/bash -c "vendor/bin/phpunit --coverage-html coverage"
```

## Executando a aplicação
```shell
docker exec -it street-market-api /bin/bash -c "php artisan serve --host 0.0.0.0"
```

## Lista de feiras

```
GET http://localhost:8000/api/street-markets
```

## Para acessar informações da feira com código de registro 4041-0:
```
GET http://localhost:8000/api/street-markets/4041-0
```

Resposta:

```json
HTTP code: 200
Content-Type: application/json

{
  "id": 1,
  "registration_code": "4041-0",
  "street_market_name": "Vila Formosa",
  "street_name": "Rua Maragojipe",
  "street_number": "S/N",
  "neighborhood": "Vl Formosa",
  "landmark": "Tv Rua Pretoria",
  "latitude": -23558733,
  "longitude": -46550164,
  "district_code": 87,
  "district_name": "Vila Formosa",
  "council_code": 26,
  "council_name": "Aricanduva-formosa-carrao",
  "five_area_region": "Leste",
  "eight_area_region": "Leste 1",
  "census_tract": 355030885000091,
  "census_tract_group": 3550308005040,
  "created_at": "2017-01-30 21:35:17",
  "updated_at": "2017-01-30 21:35:17"
}
```


## Para criar uma nova feira

```
POST http://localhost:8000/api/street-markets
```

Conteúdo da requisição:

```json
Content-Type: application/json

{
  "registration_code": "9999-9",
  "street_market_name": "Vila Formosa",
  "street_name": "Rua Maragojipe",
  "street_number": "S/N",
  "neighborhood": "Vl Formosa",
  "landmark": "Tv Rua Pretoria",
  "latitude": -23558733,
  "longitude": -46550164,
  "district_code": 87,
  "district_name": "Vila Formosa",
  "council_code": 26,
  "council_name": "Aricanduva-formosa-carrao",
  "five_area_region": "Leste",
  "eight_area_region": "Leste 1",
  "census_tract": 355030885000091,
  "census_tract_group": 3550308005040,
  "created_at": "2017-01-30 21:35:17",
  "updated_at": "2017-01-30 21:35:17"
}
```

Resposta

```
HTTP status: 201 Created
Header: "Location: http://localhost:8000/api/street-markets/9999-9"
```

## Para atualizar uma feira pelo código de registro

```
PUT http://localhost:8000/api/street-markets/9999-9
```

Conteúdo da requisição:

```json
Content-Type: application/json

{
  "registration_code": "9999-9",
  "street_market_name": "Vila Formosa",
  "street_name": "Rua Maragojipe",
  "street_number": "S/N",
  "neighborhood": "Vl Formosa",
  "landmark": "Tv Rua Pretoria",
  "latitude": -23558733,
  "longitude": -46550164,
  "district_code": 87,
  "district_name": "Vila Formosa",
  "council_code": 26,
  "council_name": "Aricanduva-formosa-carrao",
  "five_area_region": "Leste",
  "eight_area_region": "Leste 1",
  "census_tract": 355030885000091,
  "census_tract_group": 3550308005040,
  "created_at": "2017-01-30 21:35:17",
  "updated_at": "2017-01-30 21:35:17"
}
```

Resposta

```
HTTP status: 204 No content
Header: "Location: http://localhost:8000/api/street-markets/9999-9"
```

## Para remover o registro de uma feira

```
DELETE http://localhost:8000/api/street-markets/9999-9
```

Resposta

```
HTTP status: 204 No content
```

## Logs

```
storage/logs/requests.log
```
