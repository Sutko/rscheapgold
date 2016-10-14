<?php

namespace Drupal\lottery\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'PackageOpenerBlock' block.
 *
 * @Block(
 *  id = "package_opener_block",
 *  admin_label = @Translation("Package opener block"),
 * )
 */
class PackageOpenerBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $build = [];
    $build['package_opener_block'] = [
        '#cache' => ['max-age' => 0],
    ];
    $build[] = [
        '#theme'    => 'packages_opener_block',
    ];

    $build['package_opener_block']['#attached']['library'][] = 'lottery/package_opener_js';

    return $build;
  }

}
