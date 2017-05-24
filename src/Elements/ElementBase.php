<?php

namespace BazaarvoiceProductFeed\Elements;

/**
 * Class ElementBase
 * @package BazaarvoiceProductFeed\Elements
 */
abstract class ElementBase implements ElementInterface {

  /**
   * @var string
   */
  protected $external_id;

  /**
   * @var string
   */
  protected $name;

  /**
   * @var array
   */
  protected $names;

  /**
   * @var bool
   */
  protected $removed;

  public function getExternalId() {
    return $this->external_id;
  }

  public function setRemoved($removed = TRUE) {
    $this->removed = ($removed === TRUE ? TRUE:FALSE);
    return $this;
  }

  public function setExternalId($external_id) {
    if ($this->checkValidExternalId($external_id)) {
      $this->external_id = $external_id;
    }
    return $this;
  }

  public function setName($name) {
    // Confirm that name is a string value.
    if (is_string($name)) {
      $this->name = $name;
    }
    else throw new \ErrorException('Name must be a string.');

    return $this;
  }

  public function addName($name, $locale) {
    if ($this->checkValidLocale($locale)) {
      // Add name to array keyed off of Locale to prevent duplicate locales.
      $this->names[$locale] = $name;
    }
    return $this;
  }

  public function generateXMLArray() {
    $element = [];

    // If marked as a removed element, set removed property.
    if ($this->removed) {
      $element['#attributes']['removed'] = 'true';
    }

    // If external id has been set.
    if ($this->external_id) {
      // Add child element for ExternalId.
      $element['#children'][] = $this->generateElementXMLArray('ExternalId', $this->external_id);
    }

    // If name has been set.
    if ($this->name) {
      // Add child element for Name
      $element['#children'][] = $this->generateElementXMLArray('Name', $this->name);
    }

    // If locale variants of Name have been added.
    if (!empty($this->names)) {
      // Add children elements for each locale name.
      $element['#children'][] = $this->generateLocaleElementsXMLArray('Names', 'Name', $this->names);
    }

    return $element;
  }

  public function generateElementXMLArray($name, $value = false, array $attributes = []) {
    $element = [
      '#name' => $name,
    ];

    // Value being passed? set value attribute.
    if ($value !== false) {
      $element['#value'] = $value;
    }

    // Additional XML attributes being passed? set attributes.
    if (!empty($attributes)) {
      $element['#attributes'] = $attributes;
    }

    return $element;
  }

  public function generateMultipleElementsXMLArray($multiple_name, $single_name, array $elements) {
    $element = false;

    if (!empty($elements)) {
      // Generate basic element array with just name of multiple.
      $element = $this->generateElementXMLArray($multiple_name);

      // Add each passed element to multiple element as a child.
      foreach ($elements as $value) {
        $element['#children'][] = $this->generateElementXMLArray($single_name, $value);
      }
    }

    return $element;
  }

  public function generateLocaleElementsXMLArray($multiple_name, $single_name, array $locale_elements) {
    $element = false;

    if (!empty($locale_elements)) {
      // Generate basic element array with just name of multiple.
      $element = $this->generateElementXMLArray($multiple_name);

      // Add each passed element to multiple element as a child, passing locale attribute.
      foreach ($locale_elements as $locale => $value) {
        $element['#children'][] = $this->generateElementXMLArray($single_name, $element, ['locale' => $locale]);
      }
    }

    return $element;
  }

  /**
   * Boolean check if Id is formatted correctly.
   *
   * @param string $external_id
   *   The external id string to evaluate.
   *
   * @return bool
   *   Boolean TRUE or FALSE if properly formatted string.
   *
   * @throws \ErrorException
   */
  public function checkValidExternalId($external_id) {
    // ID should be a string, and can only contain alphanumeric, asterisk(*), hyphens)-) and unserscores (_).
    if (is_string($external_id) && preg_match('/^[[:alnum:]|\*|\-|\.|\_]+$/', $external_id)) {
      return TRUE;
    }
    // Invalid Id so throw error.
    else throw new \ErrorException('Invalid Id. May only contain only alphanumeric characters, asterisk (*), hyphen (-), period (.), or
underscore (_)');
  }

  /**
   * Boolean check if string is a valid url.
   *
   * @param string $url
   *   The url string to evaluate.
   *
   * @return bool
   *   Boolean TRUE or FALSE if valid or not.
   *
   * @throws \ErrorException
   */
  public function checkValidUrl($url) {
    // Use php filter_var with validate url flag, and must be absolute.
    if (is_string($url) && filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED)) {
      return TRUE;
    }
    // Invalid url so throw an exception.
    else throw new \ErrorException('Invalid URL.');
  }

  /**
   * Boolean check if string is a valid locale code.
   *
   * @param string $locale
   *   Locale string to check.
   *
   * @return bool
   *   Boolean TRUE or FALSE if valid or note.
   *
   * @throws \ErrorException
   */
  public function checkValidLocale($locale) {
    // Must be a string and must match the format of xx_YY.
    if (is_string($locale) && preg_match('/^[a-z]{2}\_[A-Z]{2}$/', $locale)) {
      return TRUE;
    }
    // Invalid locale string so throw error.
    else throw new \ErrorException('Invalid Locale code. Must match format of "xx_YY"');
  }
}