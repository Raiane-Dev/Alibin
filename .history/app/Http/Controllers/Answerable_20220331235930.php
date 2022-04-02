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
            $this->endpoint = "/";


            $this->chConnect();
            (new ServiceController)->call(
                $this->request,
                "payments",
                null,
                false
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