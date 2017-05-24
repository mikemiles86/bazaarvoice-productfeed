<?php

namespace BazaarvoiceProductFeed\Elements;

/**
 * Interface CategoryElementInterface
 * @package BazaarvoiceProductFeed\Elements
 */
interface CategoryElementInterface extends ElementInterface {

  /**
   * Sets the url string for the category page.
   *
   * @param string $url
   *   Properly formatted url string.
   *
   * @return \BazaarvoiceProductFeed\Elements\CategoryElementInterface
   *  Expected to return the object instance.
   */
  public function setPageUrl($url);

  /**
   * Sets the unique ID of category parent. Must meet Bazaarvoice standards.
   *
   * @param string $parent_id
   *   Unique id of category parent.
   *
   * @return \BazaarvoiceProductFeed\Elements\CategoryElementInterface
   *  Expected to return the object instance.
   */
  public function setParentId($parent_id);

  /**
   * Sets the url of the image for the category.
   *
   * @param string $url
   *   Properly formatted URL string.
   *
   * @return \BazaarvoiceProductFeed\Elements\CategoryElementInterface
   *  expected to return the object instance.
   */
  public function setImageUrl($url);

  /**
   * Add a locale specific page url variant.
   *
   * @param string $url
   *   Properly formatted URL string.
   *
   * @param string $locale
   *   Properly formatted Locale code (xx_YY)
   *
   * @return \BazaarvoiceProductFeed\Elements\CategoryElementInterface
   *  expected to return the object instance.
   */
  public function addPageUrl($url, $locale);

  /**
   * Add a locale specific image url variant.
   *
   * @param string $url
   *   Properly formatted URL string.
   *
   * @param string $locale
   *   Properly formatted Locale code (xx_YY)
   *
   * @return \BazaarvoiceProductFeed\Elements\CategoryElementInterface
   *  expected to return the object instance.
   */
  public function addImageUrl($url, $locale);
}