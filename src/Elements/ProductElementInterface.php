<?php

namespace BazaarvoiceProductFeed\Elements;

interface ProductElementInterface extends ElementInterface {

  public function setCategoryId($category_id);

  public function setPageUrl($url);

  public function setDescription($description);

  public function setBrandId($brand_id);

  public function setImageUrl($url);

  public function addName($name, $locale);

  public function addPageUrl($url, $locale);

  public function addDescription($description, $locale);

  public function addImageUrl($url, $locale);

  public function addEAN($ean);

  public function addModelNumber($model_number);

  public function addManufacturerPartNumber($part_number);

  public function addUPC($upc);

  public function addISBN($isbn);

  public function addCustomAttribute($attribute_id, $value);

}