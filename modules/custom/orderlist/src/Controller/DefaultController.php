<?php

namespace Drupal\orderlist\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\lottery\Entity\PrizeKeys;
use Drupal\orderlist\Entity\DefaultEntity;

/**
 * Class DefaultController.
 *
 * @package Drupal\orderlist\Controller
 */
class DefaultController extends ControllerBase {

  /**
   * Order_data.
   *
   * @return string
   *   Return Hello string.
   */
  public function order_data() {
    
    DefaultEntity::create([
                      'name' => "test",
                      'date' => "test",
                  ])->save();

    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: order_data')
    ];
  }

}
