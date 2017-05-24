<?php

namespace BazaarvoiceProductFeed\Elements;

/**
 * Class CategoryElement
 * @package BazaarvoiceProductFeed\Elements
 */
class CategoryElement extends ElementBase implements CategoryElementInterface {

  /**
   * @var string
   */
  protected $page_url;

  /**
   * @var string
   */
  protected $image_url;

  /**
   * @var string
   */
  protected $parent_id;

  /**
   * @var array
   */
  protected $page_urls;

  /**
   * @var array
   */
  protected $image_urls;

  /**
   * CategoryElement constructor.
   *
   * @param string $external_id
   *    The unique ID formatted to meet Bazaarvoice standards.
   *
   * @param string $name
   *   The category name.
   *
   * @param string $page_url
   *   The url of the category page.
   */
  public function __construct($external_id, $name, $page_url) {
    // See: ElementBase::setExternalId().
    $this->setExternalId($external_id);
    // See: ElementBase::setName().
    $this->setName($name);
    $this->setPageUrl($page_url);
    return $this;
  }

  public function setParentId($parent_id) {
    // See: ElementBase::checkValidExternalId().
    if ($this->checkValidExternalId($parent_id)) {
      $this->parent_id = $parent_id;
    }
    return $this;
  }

  public function setPageUrl($url) {
    // See: ElementBase::checkValidUrl().
    if ($this->checkValidUrl($url)) {
      $this->page_url = $url;
    }
    return $this;
  }

  public function setImageUrl($url) {
    // See ElementBase::checkValidUrl().
    if ($this->checkValidUrl($url)) {
      $this->image_url = $url;
    }
    return $this;
  }

  public function addPageUrl($url, $locale) {
    // See ElementBase::checkValidUrl() and ElementBase::checkValidLocale().
    if ($this->checkValidUrl($url) && $this->checkValidLocale($locale)) {
      $this->page_urls[$locale] = $url;
    }
    return $this;
  }

  public function addImageUrl($url, $locale) {
    // See ElementBase::checkValidUrl() and ElementBase::checkValidLocale().
    if ($this->checkValidUrl($url) && $this->checkValidLocale($locale)) {
      $this->image_urls[$locale] = $url;
    }
    return $this;
  }

  public function generateXMLArray() {
    // Get base element array from parent.
    $element = parent::generateXMLArray();
    // Set name property
    $element['#name'] = 'Category';
    // Add child element for PageUrl.
    $element['#children'][] = $this->generateElementXMLArray('CategoryPageUrl', $this->page_url);

    // If have a parent category.
    if ($this->parent_id) {
      // Add child element for ParentExternalId.
      $element['#children'][] = $this->generateElementXMLArray('ParentExternalId', $this->parent_id);
    }

    // If have array of additional page urls.
    if (!empty($this->page_urls)) {
      // Add child element for Locale Page Urls.
      $element['#children'][] = $this->generateLocaleElementsXMLArray('CategoryPageUrls', 'CategoryPageUrl', $this->page_urls);
    }

    // If have an image url
    if ($this->image_url) {
      // Add child element for image url.
      $element['#children'][] = $this->generateElementXMLArray('ImageUrl', $this->image_url);
    }

    // If have array of additional locale images.
    if (!empty($this->image_urls)) {
      // Add child element for locale image urls.
      $element['#children'][] = $this->generateLocaleElementsXMLArray('ImageUrls', 'ImageUrl', $this->image_urls);
    }

    return $element;
  }
}