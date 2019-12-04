<?php

namespace App\Traits;

use Exception;
use GuzzleHttp\Client;
use  App\Dtech\DtechException;
use Auth;
use  App\Dtech\Helper;

trait ConsumesExternalService
{
    /**
     * Send a request to any service
     * @return string
     */
    public function performRequest($method, $requestUrl, $formParams = [], $headers = [])
    {

        try {
            $client = new Client([
                'base_uri' => $this->baseUri,
            ]);
            if (isset($this->secret)) {
                $headers['Authorization'] = $this->secret;
            }
            $response = $client->request($method, $requestUrl,
                ['form_params' => $formParams, 'headers' =>$headers]);

            return  json_decode((string)$response->getBody()->getContents(),true);
        }
        catch (GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            throw new DtechException($responseBodyAsString);
        }
        catch(\Exception $ex){

            throw new DtechException($ex->getMessage());
        }
    }

    /**
     * send sms request to any service
     * @param $method
     * @param $requestUrl
     * @param array $formParams
     * @param array $headers
     * @return mixed
     * @throws DtechException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function performSmsRequest($method, $requestUrl, $formParams = [])
    {
        try {
            $client = new Client();
            $response = $client->request($method, $requestUrl. $formParams);

            return json_decode((string)$response->getBody()->getContents(), true);
        } catch (GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            throw new DtechException($responseBodyAsString);
        } catch (Exception $ex) {

            throw new DtechException($ex->getMessage());
        }
    }

}
