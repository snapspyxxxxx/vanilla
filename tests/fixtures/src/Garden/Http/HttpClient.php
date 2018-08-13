<?php

namespace VanillaTests\Fixtures\Garden\Http;

/**
 * @inheritdoc
 */
class HttpClient extends \Garden\Http\HttpClient {
    /**
     * @inheritdoc
     */
    public function createRequest(string $method, string $uri, $body, array $headers = [], array $options = []) {
        $originalRequest = parent::createRequest($method, $uri, $body, $headers, $options);
        $request = new HttpRequest(
            $originalRequest->getMethod(),
            $originalRequest->getUrl(),
            $originalRequest->getBody(),
            $originalRequest->getHeaders(),
            $originalRequest->getOptions()
        );
        return $request;
    }
}
