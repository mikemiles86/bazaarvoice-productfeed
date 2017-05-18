<?php

namespace BazaarvoiceProductFeed\Elements;

class CategoryElement extends ElementBase implements CategoryElementInterface {

  protected $page_url;
  protected $image_url;
  protected $parent_id;

  protected $page_urls;
  protected $image_urls;

  public function __construct($external_id, $name, $page_url) {
    $this->setExternalId($external_id);
    $this->setName($name);
    $this->setPageUrl($page_url);
    return $this;
  }

  public function setParentId($parent_id) {
    if ($this->checkValidExternalId($parent_id)) {
      $this->parent_id = $parent_id;
    }
  }

  public function setPageUrl($url) {
    if ($this->checkValidUrl($url)) {
      $this->page_url = $url;
    }
  }

  public function setImageUrl($url) {
    if ($this->checkValidUrl($url)) {
      $this->image_url = $url;
    }
  }

  public function addPageUrl($url, $locale) {
    if ($this->checkValidUrl($url) && $this->checkValidLocale($locale)) {
      $this->page_urls[$locale] = $url;
    }
  }

  public function addImageUrl($url, $locale) {
    if ($this->checkValidUrl($url) && $this->checkValidLocale($locale)) {
      $this->image_urls[$locale] = $url;
    }
  }

  public function generateXMLElement() {
    // TODO: Implement generateXMLElement() method.
  }
}