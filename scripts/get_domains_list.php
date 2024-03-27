<?php

require __DIR__ . '/../vendor/autoload.php';


$getter = new \Meklis\UaBlockParser\CipGetter();
$articles = $getter->getArticles();

$domainsForBlock = [];
$domainsForUnblock = [];
foreach ($articles as $article) {
    echo $article['title'] . "\n";
    echo "Знайдено " . count($article['attachments']) . " файлів\n";
    foreach ($article['attachments'] as $attachment) {
        if ($attachment['mimeType'] !== 'text/plain') continue;
        $data = $getter->getAttachment($attachment['id']);
        try {
            $domainsFromArticle = \Meklis\UaBlockParser\CipParser::parseDomainsFromFile($data);
            echo "Отримано " . count($domainsFromArticle) . " доменів\n";
            $domainsForBlock = array_merge($domainsForBlock, $domainsFromArticle);

            if (strpos(strtolower($article['title']), 'розблокування') !== false) {
                echo "Знайдено домен під розблокування\n";
                $domainsForUnblock = array_merge($domainsForUnblock, $domainsFromArticle);
            }

        } catch (\Exception $e) {
            echo "Помилка зчитування файлу '{$attachment['originalFileName']}' - {$e->getMessage()}\n";
            continue;
        }
    }
    sleep(0.1);
}


$domainsForBlock = array_unique($domainsForBlock);
foreach ($domainsForBlock as $num => $domain) {
    if (in_array($domain, $domainsForUnblock)) {
        echo "Домен {$domain} розблоковано, видалення зі списку\n";
        unset($domainsForBlock[$num]);
    }
}
sort($domainsForBlock);

file_put_contents(__DIR__ . '/../files/domains.txt', join("\n", $domainsForBlock));
echo "Записано " . count($domainsForBlock) . " доменів\n";
echo "Роботу скрипта завершено!\n";