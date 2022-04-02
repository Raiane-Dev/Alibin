<?php

    namespace App\Http\Controllers;

    use App\Http\Controllers\ServiceController;

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

        public function getClient()
        {
            $this->endpoint = "/vendas";

            $this->chConnect();
            (new ServiceController)->call(
                $this->request,
                "data",
                "payments",
                null,
                false
            );
        }

        public function getParcel()
        {
            $this->endpoint = "/vendas";

            $this->chConnect();
            (new ServiceController)->call(
                $this->request,
                "data",
                ["ref_parcela", "nu_parcela", "vl_parcela"],
                null,
                true
            );
        }

        public function getWithParams(string $params)
        {

            $this->endpoint = "/vendas";

            $params = explode(",", $params);

            $this->chConnect();
            (new ServiceController)->call(
                $this->request,
                "data",
                $params,
                null,
                true
            );

        }

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