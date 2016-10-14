<?php

namespace Drupal\lottery\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\lottery\PrizeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Prize entity.
 *
 * @ingroup lottery
 *
 * @ContentEntityType(
 *   id = "prize",
 *   label = @Translation("Prize"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\lottery\PrizeListBuilder",
 *     "views_data" = "Drupal\lottery\Entity\PrizeViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\lottery\Form\PrizeForm",
 *       "add" = "Drupal\lottery\Form\PrizeForm",
 *       "edit" = "Drupal\lottery\Form\PrizeForm",
 *       "delete" = "Drupal\lottery\Form\PrizeDeleteForm",
 *     },
 *     "access" = "Drupal\lottery\PrizeAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\lottery\PrizeHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "prize",
 *   admin_permission = "administer prize entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/prize/{prize}",
 *     "add-form" = "/admin/structure/prize/add",
 *     "edit-form" = "/admin/structure/prize/{prize}/edit",
 *     "delete-form" = "/admin/structure/prize/{prize}/delete",
 *     "collection" = "/admin/structure/prize",
 *   },
 *   field_ui_base_route = "prize.settings"
 * )
 */
class Prize extends ContentEntityBase implements PrizeInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
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
      ->setDescription(t('The ID of the Prize entity.'))
      ->setReadOnly(TRUE);
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Prize entity.'))
      ->setReadOnly(TRUE);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Prize entity.'))
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
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Prize entity.'))
      ->setSettings(array(
        'max_length' => 50,
        'text_processing' => 0,
      ))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['gold_value'] = BaseFieldDefinition::create('decimal')
        ->setLabel(t('Gold Value'))
        ->setDescription(t('The value of the prize in gold (game millions)'))
        ->setSettings(array(
            'max_length' => 50,
        ))
        ->setRequired(TRUE)
        ->setDisplayOptions('view', array(
            'label' => 'above',
            'type' => 'number_integer',
            'weight' => -4,
        ))
        ->setDisplayOptions('form', array(
            'type' => 'number',
            'weight' => -4,
        ))
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE);

    $fields['win_amount'] = BaseFieldDefinition::create('integer')
        ->setLabel(t('Win Amount'))
        ->setSettings(array(
            'max_length' => 50,
        ))
        ->setDefaultValue(0);

    $fields['image'] = BaseFieldDefinition::create('image')
        ->setLabel(t('Prize Picture'))
        ->setDisplayOptions('view', array(
            'label' => 'above',
            'type' => 'image_image',
            'weight' => -4,
        ))
        ->setDisplayOptions('form', array(
            'type' => 'image',
            'weight' => -4,
        ))
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE);

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

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Prize is published.'))
      ->setDefaultValue(TRUE);

    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language code'))
      ->setDescription(t('The language code for the Prize entity.'))
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
