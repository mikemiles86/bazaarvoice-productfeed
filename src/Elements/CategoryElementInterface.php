<?php

namespace BazaarvoiceProductFeed\Elements;

interface CategoryElementInterface extends ElementInterface {

  public function setPageUrl($url);

  public function setParentId($url);

  public function setImageUrl($url);

  public function addPageUrl($url, $locale);

  public function addImageUrl($url, $locale);
}