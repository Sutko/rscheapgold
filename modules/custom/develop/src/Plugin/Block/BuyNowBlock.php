<?php

namespace Drupal\develop\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'BuyNowBlock' block.
 *
 * @Block(
 *  id = "buy_now_block",
 *  admin_label = @Translation("Buy now block"),
 * )
 */
class BuyNowBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['buy_now_block']['#markup'] = '';
    $build['buy_now_block'] = [
        '#cache' => ['max-age' => 0],
    ];

    $build[] = [
        '#theme' => 'buy_now_block',
    ];

    return $build;
  }

}
