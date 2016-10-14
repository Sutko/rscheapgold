<?php

namespace Drupal\orderlist;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Order List entities.
 *
 * @ingroup orderlist
 */
class DefaultEntityListBuilder extends EntityListBuilder {

  use LinkGeneratorTrait;

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Order List ID');
    $header['date'] = $this->t('Date');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\orderlist\Entity\DefaultEntity */
    $row['id'] = $entity->id();
    $row['date'] = $entity->date->value;
    $row['name'] = $this->l(
      $entity->label(),
      new Url(
        'entity.default_entity.edit_form', array(
          'default_entity' => $entity->id(),
        )
      )
    );
    return $row + parent::buildRow($entity);
  }

}
