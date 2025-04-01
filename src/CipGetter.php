<?php

namespace Meklis\UaBlockParser;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

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
            'base_uri' => 'https://cip.gov.ua',
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:137.0) Gecko/20100101 Firefox/137.0',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language' => 'uk,ru;q=0.5',
                'Accept-Encoding' => 'gzip, deflate, br, zstd',
                'DNT' => '1',
                'Sec-GPC' => '1',
                'Connection' => 'keep-alive',
                'Upgrade-Insecure-Requests' => '1',
                'Sec-Fetch-Dest' => 'document',
                'Sec-Fetch-Mode' => 'navigate',
                'Sec-Fetch-Site' => 'none',
                'Sec-Fetch-User' => '?1',
                'Priority' => 'u=0, i',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'no-cache',
            ],
            'cookies' => CookieJar::fromArray([
                'NG_TRANSLATE_LANG_KEY' => '%22ua%22',
                'bm_sv' => 'AD6E5B6E5E4A06C5A8D92EEFA4CFFE35~YAAQVBdlX7c3irKVAQAAQ/kC8RvoJcPCNfsc9z5L43QF4+Wz80BnwTAUZ9qKfG6b0ATjwIaKkBeb/y5QVbPSvU4HtKZ45Vvl8EClTmAW/LCT3iPXKLqkfai4P66lX0SqxcCgSN8A1AYGKgTu7VYZTUzRBrNodt9J5qn7FQg4OTOPjrUQmGe3KiT4JPkTEkZKMeqq9kRMI6kGjBsm4ojA3L1r8+fDMZ3Oi0c9g5V+8TtSghCHT0WZRBJCHPf5/n2X~1',
            ], 'cip.gov.ua'),
            'http_errors' => false,
            'allow_redirects' => true,
            'decode_content' => true,
            'verify' => false,
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
