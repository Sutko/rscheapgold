<?php

namespace Drupal\orderlist;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Order List entity.
 *
 * @see \Drupal\orderlist\Entity\DefaultEntity.
 */
class DefaultEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\orderlist\Entity\DefaultEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished order list entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published order list entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit order list entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete order list entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add order list entities');
  }

}
