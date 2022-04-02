<?php

    namespace App\Http\Controllers;

    use App\Http\Controllers\ServiceController;
use Exception;

    class Answerable
    {
        protected readonly string $uri;
        protected string $endpoint;
        protected array $find_data;
        protected array $request;

        public function __construct()
        {
            $this->uri = "https://api-sandbox.fpay.me";
        }

        /**
         * Função que pega dados do cliente.
         * O primeiro parâmetro são os valores da api, passados como uma "referência"
         * pois a função que antecede essa é a chConnect() que atribui o valor para essa referência.
         * Na api, recebemos 3 arrays, um contém como valor uma string indicando o status da requisição,
         * mas a que nos interessa seria o array de "data", que contém os dados que precisamos.
         * O terceiro parâmetro "payments" é o nome da tabela do banco de dados, a função call() que é executada
         * varre todos os nomes das colunas da tabela do banco de dados, associa as chaves da api e retorna
         * tais valores. E o quarto parâmetro serve para caso as colunas possuem o nome diferente das chaves
         * da api, ele pegará e substituira essa tal chave.
         * Caso esse array "data" possua um array dentro de sí, ou seja um array multidimencional, a função
         * irá pegar os dados da api recursivamente e trazendo para o array "pai".
         */
        public function getClient()
        {
            $this->endpoint = "/vendas";

            $this->chConnect();
            try{
                (new ServiceController)->call(
                    $this->request,
                    "data",
                    "payments",
                    null,
                    false
                );
            } catch (Exception $e){
                echo json_encode(["error" => "Ops, houve um erro"]);
            }
        }


        /**
         * O mesmo esquema que a função acima, mas essa retorna apenas as parcelas.
         * E como não temos uma tabela no banco de dados, e queremos apenas pegar
         * alguns parâmetros dessa api, passamos dentro de um array tais valores que queremos.
         */
        public function getParcel()
        {
            $this->endpoint = "/vendas";

            $this->chConnect();
            try{
                (new ServiceController)->call(
                    $this->request,
                    "data",
                    ["ref_parcela", "nu_parcela", "vl_parcela"],
                    null,
                    true
                );
            } catch (Exception $e) {
                echo json_encode(["error" => "Ops, houve um erro"]);
            }
        }

        /**
         * Essa função filtra os elementos do array com os parãmetros passados
         * no endpoint.
         */
        public function getWithParams(string $params)
        {

            $this->endpoint = "/vendas";

            $params = explode(",", $params);
            var_dump($params);

            $this->chConnect();
            try{
                (new ServiceController)->call(
                    $this->request,
                    "data",
                    $params,
                    null,
                    true
                );
            } catch (Exception $e) {
                echo json_encode(["error" => "Ops, houve um erro"]);
            }

        }

        /**
         * Requisição para a api.
         * Concateno a url base com o endpoint pois a url base é sempre a mesma,
         * mas o endpoint pode variar muitas vezes.
         */
        public function chConnect(): array
        {
            $ch = curl_init($this->uri.$this->endpoint);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER     => ["Content-Type: application/json"]
            ]);
            $this->request = json_decode(curl_exec($ch), true);
            curl_close($ch);

            return $this->request;
        }
    }

?>