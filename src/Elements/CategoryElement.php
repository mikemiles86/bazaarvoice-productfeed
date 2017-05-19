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

  public function generateXMLArray() {
    $element = parent::generateXMLArray();
    $element['#name'] = 'Category';
    $element[] = $this->generatePageUrlXMLArray($this->page_url);

    if ($this->parent_id) {
      $element[] = $this->generateElementXMLArray('ParentExternalId', $this->parent_id);
    }

    if ($page_urls = $this->generatePageUrlsXMLArray()) {
      $element[] = $page_urls;
    }

    if ($this->image_url) {
      $element[] = $this->generateImageUrlXMLArray($this->image_url);
    }

    if ($image_urls = $this->generateImageUrlsXMLArray()) {
      $elements[] = $image_urls;
    }

    return $element;
  }

  private function generatePageUrlXMLArray($url, array $attributes = []) {
    return $this->generateElementXMLArray('CategoryPageUrl', $url, $attributes);
  }

  private function generatePageUrlsXMLArray() {
    $element = false;

    if (!empty($this->page_urls)) {
      $element = $this->generateElementXMLArray('CategoryPageUrls');

      foreach ($this->page_urls as $locale => $url) {
        $element[] = $this->generatePageUrlXMLArray($url, ['locale' => $locale]);
      }
    }

    return $element;
  }

  private function generateImageUrlXMLArray($url, array $attributes = []) {
    return $this->generateElementXMLArray('ImageUrl', $url, $attributes);
  }

  private function generateImageUrlsXMLArray() {
    $element = false;

    if (!empty($this->image_urls)) {
      $element = $this->generateElementXMLArray('ImageUrls');

      foreach ($this->image_urls as $locale => $url) {
        $element[] = $this->generateImageUrlXMLArray($url, ['locale' => $locale]);
      }
    }

    return $element;
  }

}