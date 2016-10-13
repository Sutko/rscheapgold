<?php

namespace Drupal\develop\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Feedback entity entities.
 */
class FeedbackEntityViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['feedback_entity']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Feedback entity'),
      'help' => $this->t('The Feedback entity ID.'),
    );

    return $data;
  }

}
