<?php

    namespace App\Http\Controllers;

    final class Answerable
    {
        protected readonly string $uri;
        protected string $endpoint;
        protected array | string $params;
        protected array $request;

        public function __construct(): mixed
        {
            $this->uri = "https://api-sandbox.fpay.me";
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