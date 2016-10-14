<?php

namespace Drupal\lottery;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Users email entities.
 *
 * @ingroup lottery
 */
class UsersEmailListBuilder extends EntityListBuilder {

  use LinkGeneratorTrait;

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id']     = $this->t('Users email ID');
    $header['name']   = $this->t('Name');
    $header['email']  = $this->t('Email');
    $header['amount'] = $this->t('Amount');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\lottery\Entity\UsersEmail */
    $row['id']     = $entity->id();
    $row['name']   =  $entity->label();
    $row['email']  = $entity->email->value;
    $row['amount'] = $entity->sum->value.' $';
    return $row + parent::buildRow($entity);
  }

}
