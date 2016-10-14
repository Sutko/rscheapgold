<?php

namespace Drupal\lottery;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Prize entities.
 *
 * @ingroup lottery
 */
interface PrizeInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Prize name.
   *
   * @return string
   *   Name of the Prize.
   */
  public function getName();

  /**
   * Sets the Prize name.
   *
   * @param string $name
   *   The Prize name.
   *
   * @return \Drupal\lottery\PrizeInterface
   *   The called Prize entity.
   */
  public function setName($name);

  /**
   * Gets the Prize creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Prize.
   */
  public function getCreatedTime();

  /**
   * Sets the Prize creation timestamp.
   *
   * @param int $timestamp
   *   The Prize creation timestamp.
   *
   * @return \Drupal\lottery\PrizeInterface
   *   The called Prize entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Prize published status indicator.
   *
   * Unpublished Prize are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Prize is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Prize.
   *
   * @param bool $published
   *   TRUE to set this Prize to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\lottery\PrizeInterface
   *   The called Prize entity.
   */
  public function setPublished($published);

}
