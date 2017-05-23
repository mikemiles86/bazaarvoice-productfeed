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
    return $this;
  }

  public function setPageUrl($url) {
    if ($this->checkValidUrl($url)) {
      $this->page_url = $url;
    }
    return $this;
  }

  public function setImageUrl($url) {
    if ($this->checkValidUrl($url)) {
      $this->image_url = $url;
    }
    return $this;
  }

  public function addPageUrl($url, $locale) {
    if ($this->checkValidUrl($url) && $this->checkValidLocale($locale)) {
      $this->page_urls[$locale] = $url;
    }
    return $this;
  }

  public function addImageUrl($url, $locale) {
    if ($this->checkValidUrl($url) && $this->checkValidLocale($locale)) {
      $this->image_urls[$locale] = $url;
    }
    return $this;
  }

  public function generateXMLArray() {
    $element = parent::generateXMLArray();
    $element['#name'] = 'Category';
    $element['#children'][] = $this->generateElementXMLArray('CategoryPageUrl', $this->page_url);

    if ($this->parent_id) {
      $element['#children'][] = $this->generateElementXMLArray('ParentExternalId', $this->parent_id);
    }

    if (!empty($this->page_urls)) {
      $element['#children'][] = $this->generateLocaleElementsXMLArray('CategoryPageUrls', 'CategoryPageUrl', $this->page_urls);
    }

    if ($this->image_url) {
      $element['#children'][] = $this->generateElementXMLArray('ImageUrl', $this->image_url);
    }

    if (!empty($this->image_urls)) {
      $element['#children'][] = $this->generateLocaleElementsXMLArray('ImageUrls', 'ImageUrl', $this->image_urls);
    }

    return $element;
  }
}