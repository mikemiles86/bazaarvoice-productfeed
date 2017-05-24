<?php

namespace BazaarvoiceProductFeed\Elements;

/**
 * Interface ProductElementInterface
 * @package BazaarvoiceProductFeed\Elements
 */
interface ProductElementInterface extends ElementInterface {

  /**
   * Set Product Category Id.
   *
   * @param string $category_id
   *  Unique id string.
   *
   * @return \BazaarvoiceProductFeed\Elements\ProductElementInterface
   *   this instance of object.
   */
  public function setCategoryId($category_id);

  /**
   * Set the product page url.
   *
   * @param string $url
   *   Url string.
   *
   * @return \BazaarvoiceProductFeed\Elements\ProductElementInterface
   *   this instance of object.
   */
  public function setPageUrl($url);

  /**
   * Set the product description.
   *
   * @param string $description
   *   Description string.
   *
   * @return \BazaarvoiceProductFeed\Elements\ProductElementInterface
   *   this instance of object.
   */
  public function setDescription($description);

  /**
   * Set the product brand Id.
   *
   * @param string $brand_id
   *   Brand id string.
   *
   * @return \BazaarvoiceProductFeed\Elements\ProductElementInterface
   *   this instance of object.
   */
  public function setBrandId($brand_id);

  /**
   * Set the product image url.
   *
   * @param string $url
   *   url string.
   *
   * @return \BazaarvoiceProductFeed\Elements\ProductElementInterface
   *   this instance of object.
   */
  public function setImageUrl($url);

  /**
   * Add a locale variant product name.
   *
   * @param string $name
   *  Product name.
   *
   * @param string $locale
   *   Locale string, in the format of xx_YY
   *
   * @return \BazaarvoiceProductFeed\Elements\ProductElementInterface
   *   this instance of object.
   */
  public function addName($name, $locale);

  /**
   * Add a locale variant product url.
   *
   * @param string $url
   *  Url string
   *
   * @param string $locale
   *   Locale string, in the format of xx_YY
   *
   * @return \BazaarvoiceProductFeed\Elements\ProductElementInterface
   *   this instance of object.
   */
  public function addPageUrl($url, $locale);

  /**
   * Add a locale variant product description
   *
   * @param string $description
   *  Product name.
   *
   * @param string $locale
   *   Locale string, in the format of xx_YY
   *
   * @return \BazaarvoiceProductFeed\Elements\ProductElementInterface
   *   this instance of object.
   */
  public function addDescription($description, $locale);

  /**
   * Add a locale variant product image url.
   *
   * @param string $url
   *  Product image url.
   *
   * @param string $locale
   *   Locale string, in the format of xx_YY
   *
   * @return \BazaarvoiceProductFeed\Elements\ProductElementInterface
   *   this instance of object.
   */
  public function addImageUrl($url, $locale);

  /**
   * Add a product EAN value.
   *
   * @param string $ean
   *   EAN string.
   *
   * @return \BazaarvoiceProductFeed\Elements\ProductElementInterface
   *   this instance of object.
   */
  public function addEAN($ean);

  /**
   * Add a Product Module Number.
   *
   * @param string $model_number
   *  Model number string.
   *
   * @return \BazaarvoiceProductFeed\Elements\ProductElementInterface
   *   this instance of object.
   */
  public function addModelNumber($model_number);

  /**
   * Add a ManufacturerPartNumber.
   *
   * @param string $part_number
   *   Part Number string.
   *
   * @return \BazaarvoiceProductFeed\Elements\ProductElementInterface
   *   this instance of object.
   */
  public function addManufacturerPartNumber($part_number);

  /**
   * Add a Product UPC code.
   *
   * @param string $upc
   *   UPC string.
   *
   * @return \BazaarvoiceProductFeed\Elements\ProductElementInterface
   *   this instance of object.
   */
  public function addUPC($upc);

  /**
   * Add a Product ISBN number.
   *
   * @param string $isbn
   *   ISBN String.
   *
   * @return \BazaarvoiceProductFeed\Elements\ProductElementInterface
   *   this instance of object.
   */
  public function addISBN($isbn);

  /**
   * Add a custom Product attribute.
   *
   * @param string $attribute_id
   *   Attribute id string.
   *
   * @param mixed $value
   *   Attribute value.
   *
   * @return \BazaarvoiceProductFeed\Elements\ProductElementInterface
   *   this instance of object.
   */
  public function addCustomAttribute($attribute_id, $value);

}