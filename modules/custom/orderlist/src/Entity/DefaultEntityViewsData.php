<?php

namespace Drupal\orderlist\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Order List entities.
 */
class DefaultEntityViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['default_entity']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Order List'),
      'help' => $this->t('The Order List ID.'),
    );

    return $data;
  }

}
