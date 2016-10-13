<?php

namespace Drupal\lottery;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Prize keys entity.
 *
 * @see \Drupal\lottery\Entity\PrizeKeys.
 */
class PrizeKeysAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\lottery\PrizeKeysInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished prize keys entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published prize keys entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit prize keys entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete prize keys entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add prize keys entities');
  }

}
