<?php
namespace kiczek\infakt;

use kiczek\infakt\Exception\ApiException;
use kiczek\infakt\Exception\UnauthorizedException;

class Infakt {
    protected $endPoint = 'https://api.infakt.pl/v3';
    protected $apiKey;

    const REQUEST_POST = "POST";
    const REQUEST_PUT = "PUT";
    const REQUEST_DELETE = "DELETE";
    const REQUEST_GET = "GET";

    public function __construct( $apiKey ) {
        $this->apiKey = $apiKey;
    }

    public function curl($action, $method = self::REQUEST_GET, $requestParams = [], $queryString = []) {
        $_handle = curl_init();
        $_headers = [];
        $_headers[] = 'X-inFakt-ApiKey: '.$this->apiKey;
        curl_setopt($_handle, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($_handle, CURLOPT_TIMEOUT, 10);
        curl_setopt($_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($_handle, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($_handle, CURLOPT_CUSTOMREQUEST, $method);

        if(!empty($requestParams)) {
            $jsonBody = json_encode($requestParams);
            curl_setopt($_handle, CURLOPT_POSTFIELDS, $jsonBody);
            $_headers[] = 'Content-Type: application/json';
            $_headers[] = 'Content-Length: '.strlen($jsonBody);
        }

        curl_setopt($_handle, CURLOPT_URL, $this->endPoint . $action . '.json?' . http_build_query($queryString));
        curl_setopt($_handle, CURLOPT_HTTPHEADER, $_headers);

        $result = curl_exec($_handle);
        $httpCodeResult = curl_getinfo($_handle, CURLINFO_HTTP_CODE);
        curl_close($_handle);

        $decodedResult = json_decode($result, true);

        if (!in_array($httpCodeResult, [200, 201, 202, 203, 204])) {
            if ($httpCodeResult === 401) {
                throw new UnauthorizedException($decodedResult['error']);
            } elseif($httpCodeResult === 422) {
                throw new ApiException($decodedResult['errors']);
            } else {
                throw new \Exception("Problem with API server (" . $httpCodeResult . "): " . $decodedResult['error'] . ".");
            }
        }

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $result;
        }

        return $decodedResult;
    }
}