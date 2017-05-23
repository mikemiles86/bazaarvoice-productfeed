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
    return $this;
  }

  public function setPageUrl($url) {
    if ($this->checkValidUrl($url)) {
      $this->page_url = $url;
    }
    return $this;
  }

  public function setDescription($description) {
    if (is_string($description)) {
      $this->description = strip_tags($description);
    }
    return $this;
  }

  public function setBrandId($brand_id) {
    if ($this->checkValidExternalId($brand_id)) {
      $this->brand_id = $brand_id;
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

  public function addDescription($description, $locale) {
    if (is_string($description) && $this->checkValidLocale($locale)) {
      $this->descriptions[$locale] = $description;
    }
    return $this;
  }

  public function addImageUrl($url, $locale) {
    if ($this->checkValidUrl($url) && $this->checkValidLocale($locale)) {
      $this->image_urls[$locale] = $url;
    }
    return $this;
  }

  public function addEAN($ean) {
    if (is_string($ean) && preg_match('/^([0-9]{8}|[0-9]{13})$/', $ean)) {
        $this->eans[$ean] = $ean;
    }
    else throw new \ErrorException('Invalid EAN. Must be a 8 or 13 digit number.');

    return $this;
  }

  public function addModelNumber($model_number) {
    if (is_string($model_number)) {
      $this->model_numbers[$model_number] = $model_number;
    }
    return $this;
  }

  public function addManufacturerPartNumber($part_number) {
    if(is_string($part_number)) {
      $this->manufacture_part_numbers[$part_number] = $part_number;
    }
    return $this;
  }

  public function addUPC($upc) {
    if (is_string($upc) && preg_match('/^([0-9]{6}|[0-9]{12})$/', $upc)) {
      $this->upcs[$upc] = $upc;
    }
    else throw new \ErrorException('Invalid UPC. Must be a 6 or 12 digit number.');

    return $this;
  }

  public function addISBN($isbn) {
    $numeric_length = is_string($isbn) ? strlen(preg_replace('/[^0-9]/', '', $isbn)): 0;
    if (($numeric_length == 10 || $numeric_length == 13) && preg_match('/^[0-9|\-\~]+$/', $isbn)) {
      $this->isbns[$isbn] = $isbn;
    }
    else throw new \ErrorException('Invalid ISBN. Must be a 10 or 13 digit number seperated with hyphens (-) or tildes (~).');

    return $this;
  }

  public function addCustomAttribute($attribute_id, $value) {
    if(is_string($attribute_id)) {
      $this->custom_attributes[$attribute_id][$value] = $value;
    }
    return $this;
  }

  public function generateXMLArray() {
    $element = parent::generateXMLArray();
    $element['#name'] = 'Product';
    $element['#children'][] = $this->generateElementXMLArray('CategoryExternalId', $this->category_id);

    if ($this->description) {
      $element['#children'][] = $this->generateElementXMLArray('Description', $this->description);
    }

    if (!empty($this->descriptions)) {
      $element['#children'][] = $this->generateLocaleElementsXMLArray('Descriptions', 'Description', $this->descriptions);
    }

    if ($this->brand_id) {
      $element['#children'][] = $this->generateElementXMLArray('BrandExternalId', $this->brand_id);
    }

    $element['#children'][] = $this->generateElementXMLArray('ProductPageUrl', $this->page_url);
    if (!empty($this->page_urls)) {
      $element['#children'][] = $this->generateLocaleElementsXMLArray('ProductPageUrls', 'ProductPageUrl', $this->page_urls);
    }

    $element['#children'][] = $this->generateElementXMLArray('ImageUrl', $this->image_url);
    if (!empty($this->image_urls)) {
      $element['#children'][] = $this->generateLocaleElementsXMLArray('ImageUrls', 'ImageUrl', $this->image_urls);
    }

    if (!empty($this->eans)) {
      $element['#children'][] = $this->generateMultipleElementsXMLArray('EANs', 'EAN', $this->eans);
    }

    if (!empty($this->model_numers)) {
      $element['#children'][] = $this->generateMultipleElementsXMLArray('ModelNumbers', 'ModelNumber', $this->model_numbers);
    }

    if (!empty($this->manufacture_part_numbers)) {
      $element['#children'][] = $this->generateMultipleElementsXMLArray('ManufacturePartNumbers', 'ManufacturePartNumber', $this->manufacture_part_numbers);
    }

    if (!empty($this->upcs)) {
      $element['#children'][] = $this->generateMultipleElementsXMLArray('UPCs', 'UPC', $this->upcs);
    }

    if (!empty($this->isbns)) {
      $element['#children'][] = $this->generateMultipleElementsXMLArray('ISBNs', 'ISBN', $this->isbns);
    }

    if (!empty($this->custom_attributes)) {
      $element['#children'][] = $this->generateCustomAttributesXMLArray($this->custom_attributes);
    }

    return $element;
  }

  private function generateCustomAttributesXMLArray(array $custom_attributes = []) {
    $element = false;

    if (!empty($custom_attributes)) {
      $element = $this->generateElementXMLArray('Attributes');

      foreach ($custom_attributes as $attribute_id => $attribute_values) {
        foreach ($attribute_values as $value) {
          $element['#children'][] = $this->generateElementXMLArray('Attribute', $value, ['id' => $attribute_id]);
        }
      }
    }

    return $element;
  }

}