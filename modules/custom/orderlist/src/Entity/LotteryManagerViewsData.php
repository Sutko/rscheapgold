<?php

namespace Drupal\orderlist\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Lottery management entities.
 */
class LotteryManagerViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['lottery_manager']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Lottery management'),
      'help' => $this->t('The Lottery management ID.'),
    );

    return $data;
  }

}
