<?php

/**
 * @file
 * Contains lottery_manager.page.inc.
 *
 * Page callback for Lottery management entities.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for Lottery management templates.
 *
 * Default template: lottery_manager.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_lottery_manager(array &$variables) {
  // Fetch LotteryManager Entity Object.
  $lottery_manager = $variables['elements']['#lottery_manager'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
