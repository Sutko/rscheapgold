<?php

namespace Drupal\lottery\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Users email entities.
 */
class UsersEmailViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();
    $data['users_email']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Users email'),
      'help' => $this->t('The Users email ID.'),
    );

    return $data;
  }

  protected function getEntityIds() {
    $query = $this->getStorage()->getQuery()
        ->sort($this->entityType->getKey('id'),'desc');

    // Only add the pager if a limit is specified.
    if ($this->limit) {
      $query->pager($this->limit);
    }
    return $query->execute();
  }

}
