<?php

namespace Meklis\UaBlockParser;

class CipParser
{
    static function parseDomainsFromFile(string $fileData)
    {
        $domains = [];
        foreach (explode("\n", $fileData) as $line) {
            $line = trim($line);
            if(!$line) continue;
            if(!preg_match('/^(http|https):\/\/.*/', $line)) {
                $line = "http://" . $line;
            }
            $url = parse_url($line);
            if(!$url) throw new \Exception("Error parse url - {$line}");

            if(!isset($url['host'])) {
                print_r($url);
                throw new \Exception("Host not found in URL - {$line}");
            }
            $domains[] = $url['host'];
        }
        return array_values(array_unique($domains));
    }

}