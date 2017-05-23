<?php

namespace BazaarvoiceProductFeed\Elements;

interface ElementInterface {

  public function getExternalId();

  public function setExternalId($external_id);

  public function setName($name);

  public function setRemoved($removed = TRUE);

  public function generateXMLArray();

  public function generateElementXMLArray($name, $value = FALSE, array $attributes = []);

  public function generateMultipleElementsXMLArray($multiple_name, $single_name, array $elements = []);

  public function generateLocaleElementsXMLArray($multiple_name, $single_name, array $locale_elements = []);
}