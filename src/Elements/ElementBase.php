<?php

namespace BazaarvoiceProductFeed\Elements;

abstract class ElementBase implements ElementInterface {

  protected $external_id;
  protected $name;
  protected $names;
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
    if (is_string($name)) {
      $this->name = $name;
    }
    else throw new \ErrorException('Name must be a string.');

    return $this;
  }

  public function addName($name, $locale) {
    if (is_string($name) && $this->checkValidLocale($locale)) {
      $this->names[$locale] = $name;
    }
    return $this;
  }

  public function generateXMLArray() {
    $element = [];

    if ($this->removed) {
      $element['#attributes']['removed'] = 'true';
    }

    if ($this->external_id) {
      $element['#children'][] = $this->generateElementXMLArray('ExternalId', $this->external_id);
    }

    if ($this->name) {
      $element['#children'][] = $this->generateElementXMLArray('Name', $this->name);
    }

    if (!empty($this->names)) {
      $lement['#children'][] = $this->generateLocaleElementsXMLArray('Names', 'Name', $this->names);
    }

    return $element;
  }

  public function generateElementXMLArray($name, $value = false, array $attributes = []) {
    $element = [
      '#name' => $name,
    ];
    if ($value !== false) {
      $element['#value'] = $value;
    }

    if (!empty($attributes)) {
      $element['#attributes'] = $attributes;
    }

    return $element;
  }

  public function generateMultipleElementsXMLArray($multiple_name, $single_name, array $elements = []) {
    $element = false;

    if (!empty($elements)) {
      $element = $this->generateElementXMLArray($multiple_name);

      foreach ($elements as $value) {
        $element['#children'][] = $this->generateElementXMLArray($single_name, $value);
      }
    }

    return $element;
  }

  public function generateLocaleElementsXMLArray($multiple_name, $single_name, array $locale_elements = []) {
    $element = false;

    if (!empty($locale_elements)) {
      $element = $this->generateElementXMLArray($multiple_name);

      foreach ($locale_elements as $locale => $value) {
        $element['#children'][] = $this->generateElementXMLArray($single_name, $element, ['locale' => $locale]);
      }
    }

    return $element;
  }

  public function checkValidExternalId($external_id) {
    $valid = FALSE;
    if (is_string($external_id) && preg_match('/^[[:alnum:]|\*|\-|\.|\_]+$/', $external_id)) {
      $valid = TRUE;
    }
    else throw new \ErrorException('Invalid Id. May only contain only alphanumeric characters, asterisk (*), hyphen (-), period (.), or
underscore (_)');

    return $valid;
  }

  public function checkValidUrl($url) {
    $valid = FALSE;

    if (is_string($url) && filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED)) {
      $valid = TRUE;
    }
    else throw new \ErrorException('Invalid URL.');

    return $valid;
  }

  public function checkValidLocale($locale) {
    $valid = FALSE;
    if (is_string($locale) && preg_match('/^[a-z]{2}\_[A-Z]{2}$/', $locale)) {
      $valid = TRUE;
    }
    else throw new \ErrorException('Invalid Locale code. Must match format of "xx_YY"');

    return $valid;
  }
}