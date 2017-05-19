<?php

namespace BazaarvoiceProductFeed\Elements;

class ProductElement extends ElementBase implements ProductElementInterface {

  protected $category_id;
  protected $page_url;
  protected $image_url;
  protected $description;
  protected $brand_id;

  protected $page_urls;
  protected $image_urls;
  protected $descriptions;
  protected $eans;
  protected $model_numbers;
  protected $manufacture_part_numbers;
  protected $upcs;
  protected $isbns;
  protected $custom_attributes;

  public function __construct($external_id, $name, $category_id, $page_url, $image_url) {
    $this->setExternalId($external_id);
    $this->setName($name);
    $this->setCategoryId($category_id);
    $this->setPageUrl($page_url);
    $this->setImageUrl($image_url);
    return $this;
  }

  public function setCategoryId($category_id) {
    if ($this->checkValidExternalId($category_id)) {
      $this->category_id = $category_id;
    }
  }

  public function setPageUrl($url) {
    if ($this->checkValidUrl($url)) {
      $this->page_url = $url;
    }
  }

  public function setDescription($description) {
    if (is_string($description)) {
      $this->description = strip_tags($description);
    }
  }

  public function setBrandId($brand_id) {
    if ($this->checkValidExternalId($brand_id)) {
      $this->brand_id = $brand_id;
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

  public function addDescription($description, $locale) {
    if (is_string($description) && $this->checkValidLocale($locale)) {
      $this->descriptions[$locale] = $description;
    }
  }

  public function addImageUrl($url, $locale) {
    if ($this->checkValidUrl($url) && $this->checkValidLocale($locale)) {
      $this->image_urls[$locale] = $url;
    }
  }

  public function addEAN($ean) {
    if (is_string($ean) && preg_match('/^([0-9]{8}|[0-9]{13})$/', $ean)) {
        $this->eans[$ean] = $ean;
    }
    else throw new \ErrorException('Invalid EAN. Must be a 8 or 13 digit number.');
  }

  public function addModelNumber($model_number) {
    if (is_string($model_number)) {
      $this->model_numbers[$model_number] = $model_number;
    }
  }

  public function addManufacturerPartNumber($part_number) {
    if(is_string($part_number)) {
      $this->manufacture_part_numbers[$part_number] = $part_number;
    }
  }

  public function addUPC($upc) {
    if (is_string($upc) && preg_match('/^([0-9]{6}|[0-9]{12})$/', $upc)) {
      $this->upcs[$upc] = $upc;
    }
    else throw new \ErrorException('Invalid UPC. Must be a 6 or 12 digit number.');
  }

  public function addISBN($isbn) {
    $numeric_length = is_string($isbn) ? strlen(preg_replace('/[^0-9]/', '', $isbn)): 0;
    if (($numeric_length = 10 || $numeric_length = 13) && preg_match('/^[0-9|\-\~]+$/', $isbn)) {
      $this->isbns[$isbn] = $isbn;
    }
    else throw new \ErrorException('Invalid ISBN. Must be a 10 or 13 digit number seperated with hyphens (-) or tildes (~).');
  }

  public function addCustomAttribute($attribute_id, $value) {
    if(is_string($attribute_id)) {
      $this->custom_attributes[$attribute_id][$value] = $value;
    }
  }

  public function generateXMLArray() {
    // TODO: Implement generateXMLElement() method.
  }

}