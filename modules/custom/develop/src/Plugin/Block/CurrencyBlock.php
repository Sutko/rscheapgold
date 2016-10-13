<?php

namespace Drupal\develop\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\develop\Libraries\Converter;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Provides a 'CurrencyBlock' block.
 *
 * @Block(
 *  id = "currency_block",
 *  admin_label = @Translation("Currency block"),
 * )
 */
class CurrencyBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $converter = new Converter();
    $currency = $converter->get_available_currency_menu();

    $session = new Session();
    $selected = $session->get('currency_code','USD');
    $build = [];
    $build['currency_block'] = [
        '#cache' => ['max-age' => 0],
    ];
    $build['currency_block']['#attached']['library'][] = 'develop/currency_js';

    $build[] = [
        '#theme' => 'currency_block',
        '#selected' => $selected,
        '#currency' => $currency
    ];

    return $build;
  }

}
