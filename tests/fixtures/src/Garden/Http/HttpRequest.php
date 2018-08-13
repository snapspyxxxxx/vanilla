<?php

namespace VanillaTests\Fixtures\Garden\Http;

/**
 * @inheritdoc
 */
class HttpRequest extends \Garden\Http\HttpRequest {
    /**
     * @inheritdoc
     */
    protected function createCurl() {
        $curl = parent::createCurl();
        curl_setopt($curl, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS | CURLPROTO_FILE);
        return $curl;
    }
}
