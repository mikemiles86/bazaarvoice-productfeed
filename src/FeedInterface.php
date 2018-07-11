<?php
namespace BazaarVoice;

use BazaarVoice\Elements\FeedElementInterface;

interface FeedInterface
{
    public function newFeed(string $name, bool $incremental = false): FeedElementInterface;

    public function printFeed(FeedElementInterface $feed): string;

    public function saveFeed(FeedElementInterface $feed, string $fileLocation, string $fileName);

    public function sendFeed(string $filePath, string $sftpUsername, string $sftpPassword, string $sftpDirectory = '/import-box', string $sftpPort = '22'): bool;
}
