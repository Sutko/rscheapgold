<?php

namespace Drupal\develop\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'BlogBlock' block.
 *
 * @Block(
 *  id = "blog_block",
 *  admin_label = @Translation("Blog block"),
 * )
 */
class BlogBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $storage = \Drupal::entityTypeManager()->getStorage('node');

    $ids = $storage->getQuery()
        ->condition('type','article')
        ->sort('created','desc')
        ->range(0,12)
        ->execute();

    $result = $storage->loadMultiple($ids);
    foreach($result as $a){
      $articles[] = [
        'body' => $a->body->value,
        'image' => $a->field_image->entity->url()
      ];
    }
    $build = [];
    $build['blog_block'] = [
        '#cache' => ['max-age' => 0],
    ];
    $build[] = [
        '#theme'    => 'blog_block',
        '#articles' => $articles,
    ];

    return $build;
  }

}
