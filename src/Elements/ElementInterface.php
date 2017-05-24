<?php

namespace BazaarvoiceProductFeed\Elements;

/**
 * Interface ElementInterface
 * @package BazaarvoiceProductFeed\Elements
 */
interface ElementInterface {

  /**
   * Return the external ID string for element.
   *
   * @return string
   */
  public function getExternalId();

  /**
   * Sets the external ID string for element.
   *
   * @param string $external_id
   *   string to be used as external id.
   *
   * @return \BazaarvoiceProductFeed\Elements\ElementInterface
   *  Expected to return this current instance of element.
   */
  public function setExternalId($external_id);

  /**
   * Set the name value of an element.
   *
   * @param string $name
   *   String to be used as the name.
   *
   * @return \BazaarvoiceProductFeed\Elements\ElementInterface
   *  Expected to return this current instance of element.
   */
  public function setName($name);

  /**
   * Set the removed status of the element.
   *
   * @param bool $removed
   *   Boolean TRUE or FALSE is element is to be remvoed or not.
   *
   * @return \BazaarvoiceProductFeed\Elements\ElementInterface
   *  Expected to return this current instance of element.
   */
  public function setRemoved($removed = TRUE);

  /**
   * Creates an array for the element that can be used to build an XML document.
   *
   * @return array
   *  Key/value array to represent element for XML generation.
   *  known keys (all optional):
   *   - #name : the name of the element.
   *   - #value : element value.
   *   - #attributes : key/value array of XML attributes for element.
   *   - #children : array of child element arrays.
   */
  public function generateXMLArray();

  /**
   * Builds array for specific XML element.
   *
   * @param string $name
   *   Element name.
   *
   * @param bool|mixed $value
   *   (optional) element value.
   *
   * @param array $attributes
   *   (optional) Array of XML attributes.
   *
   * @return array
   *  Key/value array to represent element for XML generation.
   *  known keys (all optional):
   *   - #name : the name of the element.
   *   - #value : element value.
   *   - #attributes : key/value array of XML attributes for element.
   *   - #children : array of child element arrays.
   */
  public function generateElementXMLArray($name, $value = FALSE, array $attributes = []);

  /**
   * Builds array for an XML element that represents multiple values.
   *
   * @param string $multiple_name
   *   Name of plural element.
   *
   * @param string $single_name
   *   Name of single element.
   *
   * @param array $elements
   *   array of values to add as single elements to multiple element.
   *
   *  Key/value array to represent element for XML generation.
   *  known keys (all optional):
   *   - #name : the name of the multiple element.
   *   - #children : array of child elements containing
   *        - #name :  single element name
   *        - #value : element value.
   */
  public function generateMultipleElementsXMLArray($multiple_name, $single_name, array $elements);

  /**
   * Builds array for an XML element that represents locale varaints of an element.
   *
   * @param string $multiple_name
   *   Name of plural element.
   *
   * @param string $single_name
   *   Name of single element.
   *
   * @param array $locale_elements
   *   Key/value array of elements to create.
   *    - locale_code => value.
   *
   *  Key/value array to represent element for XML generation.
   *  known keys (all optional):
   *   - #name : the name of the multiple element.
   *   - #children : array of child elements containing
   *        - #name :  single element name
   *        - #value : element value.
   *        - #attributes : array with locale key
   *            - locale => (locale_string)
   */
  public function generateLocaleElementsXMLArray($multiple_name, $single_name, array $locale_elements);
}