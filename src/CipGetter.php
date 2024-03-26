<?php

namespace Meklis\UaBlockParser;

use GuzzleHttp\Client;

class CipGetter
{
    const ARTICLES_URL = 'https://cip.gov.ua/services/cm/api/articles?page=0&size=1000&tagId=60751';

    const ATTACHMENT_URL = 'https://cip.gov.ua/services/cm/api/attachment/download';

    /**
     * @var Client|null
     */
    protected $client = null;

    function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'Accept-Encoding' => 'gzip, deflate, br',
                'Accept-Language' => 'uk',
                'User-Agent' => 'cip.gov.ua parser/0.0.1 (Reading articles and blocked domains - meklis/ua-blocking-parser)'
            ],
        ]);
    }

    function getArticles()
    {
        $res = $this->client->get(self::ARTICLES_URL, ['debug' => false,]);
        return json_decode($res->getBody()->getContents(), true);
    }

    function getAttachment($id)
    {
        $res = $this->client->get(self::ATTACHMENT_URL . "?id={$id}", ['debug' => false,]);
        return $res->getBody()->getContents();
    }

}