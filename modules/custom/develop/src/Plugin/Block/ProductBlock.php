<?php

namespace Drupal\develop\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\develop\Libraries\Converter;
use Symfony\Component\HttpFoundation\Session\Session;
/**
 * Provides a 'ProductBlock' block.
 *
 * @Block(
 *  id = "product_block",
 *  admin_label = @Translation("Product block"),
 * )
 */
class ProductBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $storage = \Drupal::entityTypeManager()->getStorage('node');
    $ids = $storage->getQuery()
        ->condition('type','product')
        ->range(0,2)
        ->execute();

    $result = $storage->loadMultiple($ids);
    $products = [];

    $session = new Session();
    $currency = $session->get('currency_code','USD');
    $sign     = $session->get('currency_sign','$');

    /* get quick prices taxonomy */

    $storage = \Drupal::entityTypeManager()->getStorage('taxonomy_term');

    $ids = $storage->getQuery()
        ->condition('vid','quick_prices')
        ->sort('weight','asc')
        ->execute();

    $prices = $storage->loadMultiple($ids);

    $converter = new Converter();
    foreach($result as $item){
      $products[]   = [
        'nid'       => $item->nid->value,
        'title'     => $item->title->value,
        'amount'    => $item->field_stock_amount->value,
        'min_amount'=> $item->field_min_amount->value,
        'price'     => $converter->convert_item($currency,$item->field_price->value),
        'image'     => $item->field_image->entity->url(),
        'image_alt' => $item->field_image[0]->alt
      ];
    }

    $build = [];
    $build['product_block'] = [
        '#cache' => ['max-age' => 0],
    ];
    $build[] = [
        '#theme'    => 'product_block',
        '#products' => $products,
        '#sign'     => $sign,
        '#currency' => $currency,
        '#prices'   => $prices
    ];

    $build['sell_block']['#attached']['library'][] = 'develop/product_js';

    return $build;
  }

}
