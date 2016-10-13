<?php

namespace Drupal\lottery\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\lottery\PrizeKeysInterface;
use Drupal\user\UserInterface;
use Drupal\lottery\Libraries\SARandom;

/**
 * Defines the Prize keys entity.
 *
 * @ingroup lottery
 *
 * @ContentEntityType(
 *   id = "prize_keys",
 *   label = @Translation("Prize keys"),
 *   handlers = {
 *     "view_builder" = "Drupal\lottery\PrizeKeysViewBuilder",
 *     "list_builder" = "Drupal\lottery\PrizeKeysListBuilder",
 *     "views_data" = "Drupal\lottery\Entity\PrizeKeysViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\lottery\Form\PrizeKeysForm",
 *       "add" = "Drupal\lottery\Form\PrizeKeysForm",
 *       "edit" = "Drupal\lottery\Form\PrizeKeysForm",
 *       "delete" = "Drupal\lottery\Form\PrizeKeysDeleteForm",
 *     },
 *     "access" = "Drupal\lottery\PrizeKeysAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\lottery\PrizeKeysHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "prize_keys",
 *   admin_permission = "administer prize keys entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/prize_keys/{prize_keys}",
 *     "add-form" = "/admin/structure/prize_keys/add",
 *     "edit-form" = "/admin/structure/prize_keys/{prize_keys}/edit",
 *     "delete-form" = "/admin/structure/prize_keys/{prize_keys}/delete",
 *     "collection" = "/admin/structure/prize_keys",
 *   },
 *   field_ui_base_route = "prize_keys.settings"
 * )
 */
class PrizeKeys extends ContentEntityBase implements PrizeKeysInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);

    $random = new SARandom();
    $code = $random->generate_code(5);

    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
    );
    $values += array(
        'code' => $code
    );
  }



  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? NODE_PUBLISHED : NODE_NOT_PUBLISHED);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Prize keys entity.'))
      ->setReadOnly(TRUE);
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Prize keys entity.'))
      ->setReadOnly(TRUE);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Prize keys entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDefaultValueCallback('Drupal\node\Entity\Node::getCurrentUserId')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Prize keys entity.'))
      ->setSettings(array(
        'max_length' => 50,
        'text_processing' => 0,
      ))
      ->setDefaultValue('');

    $fields['code'] = BaseFieldDefinition::create('string')
        ->setLabel(t('Code'))
        ->setSettings(array(
            'max_length' => 50,
            'text_processing' => 0,
        ))
        ->setDefaultValue('');

    $fields['package_id'] = BaseFieldDefinition::create('entity_reference')
        ->setLabel(t('Package'))
        ->setDescription(t('select package'))
        ->setSetting('target_type', 'taxonomy_term')
        ->setSetting('handler_settings', ['target_bundles' => ['taxonomy_term' => 'packages']])
        ->setDisplayOptions('view', array(
            'label' => 'above',
            'type' => 'taxonomy_term',
            'weight' => -4,
        ))
        ->setRequired(TRUE)
        ->setDisplayOptions('form', array(
            'weight' => -4,
            'type' => 'taxonomy_term',
            'settings' => array(
                'match_operator' => 'CONTAINS',
                'autocomplete_type' => 'tags',
            ),
        ))
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE);

    $fields['email_id'] = BaseFieldDefinition::create('entity_reference')
        ->setLabel(t('User'))
        ->setDescription(t('select user'))
        ->setSetting('target_type', 'users_email')
        ->setDisplayOptions('view', array(
            'label' => 'above',
            'type' => 'taxonomy_term',
            'weight' => -4,
        ))
        ->setRequired(TRUE)
        ->setDisplayOptions('form', array(
            'weight' => -4,
            'type' => 'taxonomy_term',
            'settings' => array(
                'match_operator' => 'CONTAINS',
                'autocomplete_type' => 'tags',
            ),
        ))
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE);

    $fields['prize_id'] = BaseFieldDefinition::create('entity_reference')
        ->setLabel(t('Prize'))
        ->setSetting('target_type', 'prize')
        ->setDefaultValue(0)
        ->setDisplayOptions('view', array(
            'label' => 'above',
            'type' => 'taxonomy_term',
            'weight' => -4,
        ))
        ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
        ->setLabel(t('Publishing status'))
        ->setDescription(t('A boolean indicating whether the Prize keys is published.'))
        ->setDefaultValue(FALSE);

    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language code'))
      ->setDescription(t('The language code for the Prize keys entity.'))
      ->setDisplayOptions('form', array(
        'type' => 'language_select',
        'weight' => 10,
      ))
      ->setDisplayConfigurable('form', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
