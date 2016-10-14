<?php

/**
 * @file
 * Contains prize.page.inc.
 *
 * Page callback for Prize entities.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for Prize templates.
 *
 * Default template: prize.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_prize(array &$variables) {
  // Fetch Prize Entity Object.
  $prize = $variables['elements']['#prize'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
