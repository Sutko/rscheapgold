<?php

namespace Drupal\orderlist\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Lottery management entities.
 *
 * @ingroup orderlist
 */
interface LotteryManagerInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Lottery management name.
   *
   * @return string
   *   Name of the Lottery management.
   */
  public function getName();

  /**
   * Sets the Lottery management name.
   *
   * @param string $name
   *   The Lottery management name.
   *
   * @return \Drupal\orderlist\Entity\LotteryManagerInterface
   *   The called Lottery management entity.
   */
  public function setName($name);

  /**
   * Gets the Lottery management creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Lottery management.
   */
  public function getCreatedTime();

  /**
   * Sets the Lottery management creation timestamp.
   *
   * @param int $timestamp
   *   The Lottery management creation timestamp.
   *
   * @return \Drupal\orderlist\Entity\LotteryManagerInterface
   *   The called Lottery management entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Lottery management published status indicator.
   *
   * Unpublished Lottery management are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Lottery management is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Lottery management.
   *
   * @param bool $published
   *   TRUE to set this Lottery management to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\orderlist\Entity\LotteryManagerInterface
   *   The called Lottery management entity.
   */
  public function setPublished($published);

}
