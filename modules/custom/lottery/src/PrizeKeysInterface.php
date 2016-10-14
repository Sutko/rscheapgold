<?php

namespace Drupal\lottery;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Prize keys entities.
 *
 * @ingroup lottery
 */
interface PrizeKeysInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Prize keys name.
   *
   * @return string
   *   Name of the Prize keys.
   */
  public function getName();

  /**
   * Sets the Prize keys name.
   *
   * @param string $name
   *   The Prize keys name.
   *
   * @return \Drupal\lottery\PrizeKeysInterface
   *   The called Prize keys entity.
   */
  public function setName($name);

  /**
   * Gets the Prize keys creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Prize keys.
   */
  public function getCreatedTime();

  /**
   * Sets the Prize keys creation timestamp.
   *
   * @param int $timestamp
   *   The Prize keys creation timestamp.
   *
   * @return \Drupal\lottery\PrizeKeysInterface
   *   The called Prize keys entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Prize keys published status indicator.
   *
   * Unpublished Prize keys are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Prize keys is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Prize keys.
   *
   * @param bool $published
   *   TRUE to set this Prize keys to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\lottery\PrizeKeysInterface
   *   The called Prize keys entity.
   */
  public function setPublished($published);

}
