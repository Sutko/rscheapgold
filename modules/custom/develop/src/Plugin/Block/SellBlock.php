<?php

namespace Drupal\develop\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\develop\Libraries\Converter;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Provides a 'SellBlock' block.
 *
 * @Block(
 *  id = "sell_block",
 *  admin_label = @Translation("Sell block"),
 * )
 */
class SellBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    $build['sell_block'] = [
      '#cache' => ['max-age' => 0],
    ];
    $build['sell_block']['#attached']['library'][] = 'develop/selling_js';

    $session = new Session();
    $converter = new Converter();

    $currency = $session->get('currency_code','USD');
    $sign     = $session->get('currency_sign','$');

    $storage = \Drupal::entityTypeManager()->getStorage('node');
    $query = $storage->getQuery();
    $ids = $query
        ->Condition('type','product')
        ->range(0,2)
        ->execute();

    $result = array_values($nodes = $storage->loadMultiple($ids));
    $product1 = [
      'title'      => $result[0]->title->value,
      'price'      => $converter->convert_item($currency,$result[0]->field_sell_price->value),
      'min_amount' => $result[0]->field_min_amount->value
    ];
    $product2 = [
        'title'      => $result[1]->title->value,
        'price'      => $converter->convert_item($currency,$result[1]->field_sell_price->value),
        'min_amount' => $result[1]->field_min_amount->value
    ];

    $build[] = [
        '#theme' => 'sell_block',
        '#product1' => $product1,
        '#product2' => $product2,
        '#sign'     => $sign,
        '#currency' => $currency
    ];

    return $build;
  }

}
