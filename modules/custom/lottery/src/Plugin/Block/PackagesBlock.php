<?php

namespace Drupal\lottery\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\HttpFoundation\Session\Session;
use Drupal\develop\Libraries\Converter;

/**
 * Provides a 'PackagesBlock' block.
 *
 * @Block(
 *  id = "packages_block",
 *  admin_label = @Translation("Packages block"),
 * )
 */
class PackagesBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $storage = \Drupal::entityTypeManager()->getStorage('taxonomy_term');

    $ids = $storage->getQuery()
        ->condition('vid','packages')
        ->condition('field_enabled',1)
        ->sort('weight','asc')
        ->execute();

    $result = $storage->loadMultiple($ids);
    $packages = [];

    $storage = \Drupal::entityTypeManager()->getStorage('prize');
    $ids = $storage->getQuery()
        ->sort('gold_value','asc')
        ->execute();

    $prizes = $storage->loadMultiple($ids);
    $converter = new Converter();

    $session = new Session();
    $currrency = $currency = $session->get('currency_code','USD');
    $sign     = $session->get('currency_sign','$');

    foreach($result as $key =>  $pack){
      $packages[$key] = [
        'id' => $pack->id(),
        'name' => $pack->name->value,
        'description' => $pack->description->value,
        'price' =>$converter->convert_item($currrency,$pack->field_price->value),
      ];

      foreach($prizes as $prize){
        if($prize->package_id->entity->id() == $packages[$key]['id']){
          $packages[$key]['prizes'][] = [
            'id' => $prize->id(),
            'name' => $prize->name->value,
            'gold_value' => $prize->gold_value->value,
            'image'     => $prize->image->entity->url(),
          ];
        }
      }
    }


    $build = [];
    $build['packages_block'] = [
        '#cache' => ['max-age' => 0],
    ];
    $build[] = [
        '#theme'    => 'packages_block',
        '#packages' => $packages,
        '#sign'     => $sign
    ];

    return $build;
  }

}
