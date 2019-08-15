<?php
class Connection_visa {
    /*CREDENCIALES DE PRODUCCION*/
    protected $endpoint = 'https://apiprod.vnforapps.com/api.security/v1/security';
    protected $endpoint_sesion = 'https://apiprod.vnforapps.com/api.ecommerce/v2/ecommerce/token/session/';
    protected $endpoint_genera_autorizacion_transaccion = 'https://apiprod.vnforapps.com/api.authorization/v3/authorization/ecommerce/';
    protected $user = 'carlos.gutierrez@starperu.com';
    protected $pass = '@92e-xCK'; 
    protected $url_post = '/api.security/v1/security';
    protected $host = 'apiprod.vnforapps.com';
    protected $codigo_comercio =  650029979;
    protected $Credentials;
    protected $libreria_checkout = 'https://static-content.vnforapps.com/v2/js/checkout.js';
    //CRENENCIALES SANDBOX 
    // protected $endpoint = 'https://apitestenv.vnforapps.com/api.security/v1/security';
    // protected $endpoint_sesion = 'https://apitestenv.vnforapps.com/api.ecommerce/v2/ecommerce/token/session/';
    // protected $endpoint_genera_autorizacion_transaccion = 'https://apitestenv.vnforapps.com/api.authorization/v3/authorization/ecommerce/';
    // protected $user = 'integraciones.visanet@necomplus.com';
    // protected $pass = 'd5e7nk$M';
    // protected $url_post = '/api.security/v1/security';
    // protected $host = 'apitestenv.vnforapps.com';
    // protected $codigo_comercio = 115015006;
    // protected $Credentials;
    // protected $libreria_checkout = "js/checkout_test.js";

    public function __construct() {
        $this->setCredentials();
//        $this->setCodigo_comercio($codigo_comercio_test);
    }
    
    public function GetLibreriaJSVisa(){
        return $this->libreria_checkout;
    }

    
    public function GenerarSesion($token, $body) {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$this->endpoint_sesion" . $this->codigo_comercio,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "$body",
            CURLOPT_HTTPHEADER => array(
                "Authorization: $token",
                "Content-Type: application/json",
                "Postman-Token: c562e97f-b0af-4b26-8405-6271a1611feb",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public function SolicitarAutorizacionTransaccion($tokenSeguridad, $body) {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$this->endpoint_genera_autorizacion_transaccion" . $this->codigo_comercio,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "$body",
            CURLOPT_HTTPHEADER => array(
                "Authorization: $tokenSeguridad",
                "Content-Type: application/json",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    private function setCredentials() {
        $this->Credentials = $this->user . ':' . $this->pass;
    }

    private function GenerarHttpHeader() {
        $headers = array(
            "POST " . $this->url_post . " HTTP/1.1",
            "Host: " . $this->host,
            "Cache-Control: no-cache",
            "Authorization: Basic " . base64_encode($this->Credentials)
        );
        return $headers;
    }

    public function GenerarBody($TotalPagar, $IP) {
        $request_body = "{ 
                \"amount\": $TotalPagar,
                \"channel\": \"web\",
                \"antifraud\": {
                    \"clientIp\" : \"$IP\",
                    \"merchantDefineData\" : {
                        \"MDD1\" : \"web\",
                        \"MDD2\" : \"Canl\",
                        \"MDD3\" : \"Canl\"
                    }
                }
        }";
        return $request_body;
    }

    public function GenerarBody_AutorizacionTransaccion($documentNumber, $documentType, $amount, $purchaseNumber, $tokenId) {
        $request_body = "{ 
                \"antifraud\": null,
                \"captureType\": \"manual\",
                \"cardHolder\": {
                    \"documentNumber\" : \"$documentNumber\",
                    \"documentType\" : \"$documentType\"
                },
                \"channel\": \"web\",
                \"countable\": \"true\",
                \"order\": {
                    \"amount\" : $amount,
                    \"currency\" : \"USD\",
                    \"productId\" : \" \",
                    \"purchaseNumber\" : $purchaseNumber,
                    \"tokenId\" : \"$tokenId\"
                },
                \"sponsored\": null
        }";
        return $request_body;
    }

    public function Connection() {

        $headers = $this->GenerarHttpHeader();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->endpoint);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $respuesta_visa = curl_exec($ch);

        if (curl_errno($ch)) {
            print "Error: " . curl_error($ch);
        } else {
            curl_close($ch);
            return $respuesta_visa;
        }
    }

    function getCodigo_comercio() {
        return $this->codigo_comercio;
    }

    function setCodigo_comercio($codigo_comercio) {
        $this->codigo_comercio = $codigo_comercio;
    }

}
