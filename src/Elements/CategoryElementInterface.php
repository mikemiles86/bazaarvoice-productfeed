<?php
namespace BazaarVoice\Elements;

interface CategoryElementInterface extends ElementInterface
{
    public function setPageUrl(string $url): CategoryElementInterface;

    public function setParentId(string $parentId): CategoryElementInterface;

    public function setImageUrl(string $url): CategoryElementInterface;

    public function addPageUrl(string $url, string $locale): CategoryElementInterface;

    public function addImageUrl(string $url, string $locale): CategoryElementInterface;
}
