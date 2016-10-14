<?php

/**
 * @file
 * Contains users_email.page.inc.
 *
 * Page callback for Users email entities.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for Users email templates.
 *
 * Default template: users_email.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_users_email(array &$variables) {
  // Fetch UsersEmail Entity Object.
  $users_email = $variables['elements']['#users_email'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
