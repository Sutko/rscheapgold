<?php

namespace Drupal\lottery\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Prize keys entities.
 */
class PrizeKeysViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['prize_keys']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Prize keys'),
      'help' => $this->t('The Prize keys ID.'),
    );

    return $data;
  }

}
