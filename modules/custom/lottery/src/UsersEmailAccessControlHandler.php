<?php

namespace Drupal\lottery;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Users email entity.
 *
 * @see \Drupal\lottery\Entity\UsersEmail.
 */
class UsersEmailAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\lottery\UsersEmailInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished users email entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published users email entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit users email entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete users email entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add users email entities');
  }

}
