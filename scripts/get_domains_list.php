<?php

require __DIR__ . '/../vendor/autoload.php';


$getter = new \Meklis\UaBlockParser\CipGetter();
$articles = $getter->getArticles();

$domains = [];
foreach ($articles as $article) {
    echo $article['title'] . "\n";
    echo "Знайдено " . count($article['attachments']) . " файлів\n";
    foreach ($article['attachments'] as $attachment) {
        if ($attachment['mimeType'] !== 'text/plain') continue;
        $data = $getter->getAttachment($attachment['id']);
        try {
            $domainsFromArticle = \Meklis\UaBlockParser\CipParser::parseDomainsFromFile($data);
            echo "Отримано ".count($domainsFromArticle)." доменів\n";
            $domains = array_merge($domains, $domainsFromArticle);
        } catch (\Exception $e) {
            echo "Помилка зчитування файлу '{$attachment['originalFileName']}' - {$e->getMessage()}\n";
            continue;
        }
    }
    sleep(0.1);
}

$domains = array_unique($domains);

file_put_contents(__DIR__ . '/../files/domains.txt', join("\n", $domains));
echo "Записано ".count($domains)." доменів\n";
echo "Роботу скрипта завершено!\n";