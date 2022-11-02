<?php

namespace SimpleGQLient;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class Client
{
    public ?string $defaultEndpoint = null;
    public array   $defaultHeaders  = [];

    public function __construct(?string $endpoint = null, array $headers = [])
    {
        $this->defaultEndpoint = $endpoint;
        $this->defaultHeaders  = $headers;
    }

    /**
     * Submit JSON to provided endpoint
     *
     * @param string $endpoint
     * @param array  $data
     * @param array  $headers
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function postJson(string $endpoint, array $data, array $headers): ResponseInterface
    {
        return (new HttpClient())->post($endpoint, [
            RequestOptions::JSON    => $data,
            RequestOptions::HEADERS => $headers,
        ]);
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function postGraphQL(array $data, array $headers = []): ResponseInterface
    {
        return $this->postJson($this->defaultEndpoint, $data, $headers);
    }

    /**
     * @param string $query
     * @param array  $variables
     * @param array  $extraParams
     * @param array  $headers
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function graphQL(
        string $query,
        array  $variables = [],
        array  $extraParams = [],
        array  $headers = []
    ): ResponseInterface {
        // Prepend headers
        $headers = array_merge($this->defaultHeaders, $headers);

        // Prepare parameters
        $params = ['query' => $query];
        if ([] !== $variables) {
            $params += ['variables' => $variables];
        }
        $params += $extraParams;

        // Submit GQL request
        return $this->postGraphQL($params, $headers);
    }
}
