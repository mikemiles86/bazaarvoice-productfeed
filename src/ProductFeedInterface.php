<?php
namespace BazaarVoice;

use BazaarVoice\Elements\BrandElementInterface;
use BazaarVoice\Elements\CategoryElementInterface;
use BazaarVoice\Elements\FeedElementInterface;
use BazaarVoice\Elements\ProductElementInterface;

interface ProductFeedInterface
{
    public function newFeed(string $name, bool $incremental = false): FeedElementInterface;

    public function newProduct(string $externalId, string $name, string $categoryId, string $pageUrl, string $imageUrl): ProductElementInterface;

    public function newBrand(string $externalId, string $name): BrandElementInterface;

    public function newCategory(string $externalId, string $name, string $pageUrl): CategoryElementInterface;

    public function printFeed(FeedElementInterface $feed): string;

    public function saveFeed(FeedElementInterface $feed, string $fileLocation, string $fileName);

    public function sendFeed(string $filePath, string $sftpUsername, string $sftpPassword, string $sftpDirectory = '/import-box', string $sftpPort = '22'): bool;
}
