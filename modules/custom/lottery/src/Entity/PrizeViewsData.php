<?php

namespace Drupal\lottery\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Prize entities.
 */
class PrizeViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['prize']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Prize'),
      'help' => $this->t('The Prize ID.'),
    );

    return $data;
  }

}
