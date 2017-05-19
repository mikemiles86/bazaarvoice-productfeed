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
  }

  public function notRemoved() {
    $this->removed = FALSE;
  }

  public function setExternalId($external_id) {
    if ($this->checkValidExternalId($external_id)) {
      $this->external_id = $external_id;
    }
  }

  public function setName($name) {
    if (is_string($name)) {
      $this->name = $name;
    }
    else throw new \ErrorException('Name must be a string.');
  }

  public function addName($name, $locale) {
    if (is_string($name) && $this->checkValidLocale($locale)) {
      $this->names[$locale] = $name;
    }
  }

  public function generateXMLArray() {
    $element = [];

    if ($this->removed) {
      $element['#attributes']['removed'] = 'true';
    }

    if ($this->external_id) {
      $element[] = $this->generateElementXMLArray('ExternalId', $this->external_id);
    }

    if ($this->name) {
      $element[] = $this->generateNameXMLArray($this->name);
    }

    if ($names = $this->generateNamesXMLArray()) {
      $element[] = $names;
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

  private function generateNameXMLArray($name, array $attributes = []) {
    return $this->generateElementXMLArray('Name', $name, $attributes);
  }

  private function generateNamesXMLArray() {
    $element = false;
    if (count($this->names) > 0) {
      $element = $this->generateElementXMLArray('Names');

      foreach ($this->names as $locale => $name) {
        $element[] = $this->generateNameXMLArray($name, ['locale' => $locale]);
      }
    }
    return $element;
  }

  private function checkValidExternalId($external_id) {
    $valid = FALSE;
    if (is_string($external_id) && preg_match('/^[[:alnum:]|\*|\-|\.|\_]+$/', $external_id)) {
      $valid = TRUE;
    }
    else throw new \ErrorException('Invalid Id. May only contain only alphanumeric characters, asterisk (*), hyphen (-), period (.), or
underscore (_)');

    return $valid;
  }

  private function checkValidUrl($url) {
    $valid = FALSE;

    if (is_string($url) && filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED)) {
      $valid = TRUE;
    }
    else throw new \ErrorException('Invalid URL.')

    return $valid;
  }

  private function checkValidLocale($locale) {
    $valid = FALSE;
    if (is_string($locale) && preg_match('/^[a-z]{2}\_[A-Z]{2}$/', $locale)) {
      $valid = TRUE;
    }
    else throw new \ErrorException('Invalid Locale code. Must match format of "xx_YY"');

    return $valid;
  }
}