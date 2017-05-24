<?php

namespace BazaarvoiceProductFeed\Elements;

/**
 * Class ProductElement
 * @package BazaarvoiceProductFeed\Elements
 */
class ProductElement extends ElementBase implements ProductElementInterface {

  /**
   * @var string
   */
  protected $category_id;

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
  protected $description;

  /**
   * @var string
   */
  protected $brand_id;

  /**
   * @var array
   */
  protected $page_urls;

  /**
   * @var array
   */
  protected $image_urls;

  /**
   * @var array
   */
  protected $descriptions;

  /**
   * @var array
   */
  protected $eans;

  /**
   * @var array
   */
  protected $model_numbers;

  /**
   * @var array
   */
  protected $manufacture_part_numbers;

  /**
   * @var array
   */
  protected $upcs;

  /**
   * @var array
   */
  protected $isbns;

  /**
   * @var array
   */
  protected $custom_attributes;


  /**
   * ProductElement constructor.
   *
   * @param string $external_id
   *   Unique Product id string.
   *
   * @param string $name
   *   Product name
   *
   * @param string $category_id
   *   Category ID string
   *
   * @param string $page_url
   *   Product page url.
   *
   * @param string $image_url
   *   Product image string.
   */
  public function __construct($external_id, $name, $category_id, $page_url, $image_url) {
    // See: ElementBase::setExternalId().
    $this->setExternalId($external_id);
    // See: ElementBase::setName().
    $this->setName($name);
    $this->setCategoryId($category_id);
    $this->setPageUrl($page_url);
    $this->setImageUrl($image_url);
    return $this;
  }

  public function setCategoryId($category_id) {
    // See: ElementBase::checkValidExternalId().
    if ($this->checkValidExternalId($category_id)) {
      $this->category_id = $category_id;
    }
    return $this;
  }

  public function setPageUrl($url) {
    // See: ElementBase::CheckValidUrl().
    if ($this->checkValidUrl($url)) {
      $this->page_url = $url;
    }
    return $this;
  }

  public function setDescription($description) {
    if (is_string($description)) {
      $this->description = strip_tags($description);
    }
    else throw new \ErrorException('Description must be a string.');

    return $this;
  }

  public function setBrandId($brand_id) {
    // See: ElementBase::checkValidExternalId().
    if ($this->checkValidExternalId($brand_id)) {
      $this->brand_id = $brand_id;
    }
    return $this;
  }

  public function setImageUrl($url) {
    // See: ElementBase::CheckValidUrl().
    if ($this->checkValidUrl($url)) {
      $this->image_url = $url;
    }
    return $this;
  }

  public function addPageUrl($url, $locale) {
    // See: ElementBase::CheckValidUrl() and ElementBase::checkValidLocale().
    if ($this->checkValidUrl($url) && $this->checkValidLocale($locale)) {
      $this->page_urls[$locale] = $url;
    }
    return $this;
  }

  public function addDescription($description, $locale) {
    // See: ElementBase::checkValidLocale().
    if (is_string($description) && $this->checkValidLocale($locale)) {
      $this->descriptions[$locale] = $description;
    }
    return $this;
  }

  public function addImageUrl($url, $locale) {
    // See: ElementBase::CheckValidUrl() and ElementBase::checkValidLocale().
    if ($this->checkValidUrl($url) && $this->checkValidLocale($locale)) {
      $this->image_urls[$locale] = $url;
    }
    return $this;
  }

  public function addEAN($ean) {
    // Check that $ean is a 8 or 13 digit string.
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
    else throw new \ErrorException('Model Number must be a string.');
    return $this;
  }

  public function addManufacturerPartNumber($part_number) {
    if(is_string($part_number)) {
      $this->manufacture_part_numbers[$part_number] = $part_number;
    }
    else throw new \ErrorException('Manufacturer Part Number must be a string');
    return $this;
  }

  public function addUPC($upc) {
    // Check that UPS is a 6 or 13 digit string.
    if (is_string($upc) && preg_match('/^([0-9]{6}|[0-9]{12})$/', $upc)) {
      $this->upcs[$upc] = $upc;
    }
    else throw new \ErrorException('Invalid UPC. Must be a 6 or 12 digit number.');

    return $this;
  }

  public function addISBN($isbn) {
    $numeric_length = is_string($isbn) ? strlen(preg_replace('/[^0-9]/', '', $isbn)): 0;
    // Check that ISBN is a string of 10 or 13 digits, seperated by hyphens (-) or tildes (~).
    if (($numeric_length == 10 || $numeric_length == 13) && preg_match('/^[0-9|\-\~]+$/', $isbn)) {
      $this->isbns[$isbn] = $isbn;
    }
    else throw new \ErrorException('Invalid ISBN. Must be a 10 or 13 digit number separated with hyphens (-) or tildes (~).');

    return $this;
  }

  public function addCustomAttribute($attribute_id, $value) {
    // Confirm that attribute id is a string.
    if(is_string($attribute_id)) {
      $this->custom_attributes[$attribute_id][$value] = $value;
    }
    else throw new \ErrorException('Custom Attribute Id must be a string.');
    return $this;
  }

  public function generateXMLArray() {
    // Get base element.
    $element = parent::generateXMLArray();
    // Set name attribute.
    $element['#name'] = 'Product';
    // Category id.
    $element['#children'][] = $this->generateElementXMLArray('CategoryExternalId', $this->category_id);

    // If have description, add it.
    if ($this->description) {
      $element['#children'][] = $this->generateElementXMLArray('Description', $this->description);
    }

    // If have description locale variants, add them.
    if (!empty($this->descriptions)) {
      $element['#children'][] = $this->generateLocaleElementsXMLArray('Descriptions', 'Description', $this->descriptions);
    }

    // If have brand id, add it.
    if ($this->brand_id) {
      $element['#children'][] = $this->generateElementXMLArray('BrandExternalId', $this->brand_id);
    }

    // Add pageurl element.
    $element['#children'][] = $this->generateElementXMLArray('ProductPageUrl', $this->page_url);
    // If have pageUrl locale variants add them.
    if (!empty($this->page_urls)) {
      $element['#children'][] = $this->generateLocaleElementsXMLArray('ProductPageUrls', 'ProductPageUrl', $this->page_urls);
    }

    // Add imageurl element.
    $element['#children'][] = $this->generateElementXMLArray('ImageUrl', $this->image_url);
    // If have imageurl locale variants add them.
    if (!empty($this->image_urls)) {
      $element['#children'][] = $this->generateLocaleElementsXMLArray('ImageUrls', 'ImageUrl', $this->image_urls);
    }

    // If have eans, add them.
    if (!empty($this->eans)) {
      $element['#children'][] = $this->generateMultipleElementsXMLArray('EANs', 'EAN', $this->eans);
    }

    // If have model numbers, add them.
    if (!empty($this->model_numers)) {
      $element['#children'][] = $this->generateMultipleElementsXMLArray('ModelNumbers', 'ModelNumber', $this->model_numbers);
    }

    // If have part numbers, add them.
    if (!empty($this->manufacture_part_numbers)) {
      $element['#children'][] = $this->generateMultipleElementsXMLArray('ManufacturePartNumbers', 'ManufacturePartNumber', $this->manufacture_part_numbers);
    }

    // If have upc, add them.
    if (!empty($this->upcs)) {
      $element['#children'][] = $this->generateMultipleElementsXMLArray('UPCs', 'UPC', $this->upcs);
    }

    // If have isbns, add them.
    if (!empty($this->isbns)) {
      $element['#children'][] = $this->generateMultipleElementsXMLArray('ISBNs', 'ISBN', $this->isbns);
    }

    // If have custom attributes add them.
    if (!empty($this->custom_attributes)) {
      $element['#children'][] = $this->generateCustomAttributesXMLArray($this->custom_attributes);
    }

    return $element;
  }

  /**
   * Create XML array for any custom attributes.
   *
   * @param array $custom_attributes
   *   Array of custom attributes.
   *
   * @return array|bool
   *   structured array for generating XML element or boolean false.
   */
  private function generateCustomAttributesXMLArray(array $custom_attributes) {
    $element = false;
    // Have custom attributes?
    if (!empty($custom_attributes)) {
      // Generate attributes element.
      $element = $this->generateElementXMLArray('Attributes');

      // loop through all custom attributes.
      foreach ($custom_attributes as $attribute_id => $attribute_values) {
        // Loop through all values for this attribute.
        foreach ($attribute_values as $value) {
          // Add basic element with value and id attribute.
          $element['#children'][] = $this->generateElementXMLArray('Attribute', $value, ['id' => $attribute_id]);
        }
      }
    }

    return $element;
  }

}