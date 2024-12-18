<?php
class Middleware {
    private $webServiceUrl = "http://localhost/WSInventaris/Server.php";

    /**
     * Handle the incoming request from the client.
     *
     * @param array $clientRequest Request in JSON format.
     * @return string Response to the client in JSON format.
     */
    public function handleRequest($clientRequest) {
        // Convert JSON request to SOAP XML
        $soapRequest = $this->jsonToSoap($clientRequest);

        // Send SOAP request to the web service
        $soapResponse = $this->sendSoapRequest($soapRequest);

        // Convert SOAP XML response back to JSON
        $jsonResponse = $this->soapToJson($soapResponse);

        return $jsonResponse;
    }

    /**
     * Convert JSON to SOAP XML.
     *
     * @param array $data JSON data from client.
     * @return string SOAP XML string.
     */
    private function jsonToSoap($data) {
        $productId = $data['product_id'];
        $newStock = $data['new_stock'];

        return <<<XML
        <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
            <SOAP-ENV:Body>
                <notifikasiRestock>
                    <productId>{$productId}</productId>
                    <newStock>{$newStock}</newStock>
                </notifikasiRestock>
            </SOAP-ENV:Body>
        </SOAP-ENV:Envelope>
        XML;
    }

    /**
     * Send SOAP request to the web service.
     *
     * @param string $soapRequest SOAP XML request.
     * @return string SOAP XML response from web service.
     */
    private function sendSoapRequest($soapRequest) {
        $ch = curl_init($this->webServiceUrl);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $soapRequest);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: text/xml; charset=utf-8",
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    /**
     * Convert SOAP XML response to JSON.
     *
     * @param string $soapResponse SOAP XML response.
     * @return string JSON string response for the client.
     */
    private function soapToJson($soapResponse) {
        $xml = simplexml_load_string($soapResponse);
        $json = json_encode($xml);
        return $json;
    }
}

// Simulating client request
$middleware = new Middleware();
$clientRequest = [
    'product_id' => 101,
    'new_stock' => 150
];

$response = $middleware->handleRequest($clientRequest);
echo $response;
