<?php

/**
 * @file
 * Contains prize_keys.page.inc.
 *
 * Page callback for Prize keys entities.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for Prize keys templates.
 *
 * Default template: prize_keys.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_prize_keys(array &$variables) {
  // Fetch PrizeKeys Entity Object.
  $prize_keys = $variables['elements']['#prize_keys'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
