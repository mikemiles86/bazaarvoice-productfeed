<?php

namespace BazaarvoiceProductFeed\Elements;

/**
 * Class BrandElement
 * @package BazaarvoiceProductFeed\Elements
 */
class BrandElement extends ElementBase implements BrandElementInterface {

  /**
   * BrandElement constructor.
   * @param string $external_id
   *   The unique ID for the brand. Formatted to meet Bazaarvoice standards.
   *
   * @param string $name
   *   The brand name.
   */
  public function __construct($external_id, $name) {
    // See: ElementBase::setExternalId().
    $this->setExternalId($external_id);
    // See: ElementBase::setName().
    $this->setName($name);
    return $this;
  }

  public function generateXMLArray() {
    // Brand is pretty much the most basic Feed Element you can have.
    // Call parent generation function.
    $element = parent::generateXMLArray();
    // Add name parameter.
    $element['#name'] = 'Brand';
    return $element;
  }

}