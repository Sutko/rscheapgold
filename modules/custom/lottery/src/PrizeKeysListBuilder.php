<?php

namespace Drupal\lottery;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Prize keys entities.
 *
 * @ingroup lottery
 */
class PrizeKeysListBuilder extends EntityListBuilder {

  use LinkGeneratorTrait;

  public function getEntityIds() {
    $query = $this->getStorage()->getQuery()
        ->sort($this->entityType->getKey('id'),'desc');

    // Only add the pager if a limit is specified.
    if ($this->limit) {
      $query->pager($this->limit);
    }
    return $query->execute();
  }
  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Prize keys ID');
    $header['key'] = $this->t('Key');
    $header['status'] = $this->t('Status');
    $header['package'] = $this->t('Package');
    $header['nickname'] = $this->t('Nickname');
    $header['name'] = $this->t('Name');
    $header['email'] = $this->t('Email');
    $header['prize'] = $this->t('Prize');
    $header['ip_address'] = $this->t('IP-address');
    $header['transaction_id'] = $this->t('Transaction ID');
    $header['delivered'] = $this->t('Delivered (yes/no)');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\lottery\Entity\PrizeKeys */
   //dump($entity);
    $row['id'] = $entity->id();
    $row['key'] = "E";
    $row['status'] = $entity->status->value ? 'Used' : 'Active';
    $row['package'] = $entity->get('package_id')->entity ? $entity->get('package_id')->entity->name->value : ' ';
    $row['nickname'] = "E";
    $row['name'] = $entity->get('email_id')->entity ? $entity->get('email_id')->entity->name->value : ' ';
    $row['email'] = "E";
    $row['prize'] = $entity->get('prize_id')->entity ? $entity->get('prize_id')->entity->name->value.' ('.$entity->get('prize_id')->entity->gold_value->value.'M)' : '';
    $row['ip_address'] = "E";
    $row['transaction_id'] = "E";
    $row['delivered'] = "E";
    $row['operations']['data'] = $this->buildOperations($entity);

    return $row;
    /* active/used */
  }

  public function getDefaultOperations(EntityInterface $entity) {
    $operations = array();

    if ($entity->access('view') && $entity->hasLinkTemplate('canonical')) {
      $operations['canonical'] = array(
          'title' => $this->t('View'),
          'weight' => 10,
          'url' => $entity->urlInfo('canonical'),
      );
    }
    if ($entity->access('delete') && $entity->hasLinkTemplate('delete-form')) {
      $operations['delete'] = array(
          'title' => $this->t('Delete'),
          'weight' => 100,
          'url' => $entity->urlInfo('delete-form'),
      );
    }

    return $operations;
  }

}
