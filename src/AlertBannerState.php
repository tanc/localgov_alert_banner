<?php

/**
* @file
* Contains \Drupal\bhcc_alert_banners\AlertBannerState.
*
* Common service for generating and setting a token for unique emergency banner.
* @note not entity ID as same entity should get a new token when put
*       live or message refreshed.
*/

namespace Drupal\bhcc_alert_banners;

use Drupal\Core\State\State;

/**
 * Class AlertBannerState
 *
 * @package Drupal\bhcc_alert_banners
 */
class AlertBannerState {

  /**
   * @var \Drupal\Core\State\State
   */
  protected $state;

  /**
   * @var array
   */
  protected $token;

  /**
   * AlertBannerState constructor.
   * @param Drupal\Core\State\State $state
   */
  public function __construct(State $state) {
    $this->state = $state;
    $this->token = $state->get('bhcc_alert_banners.alert_banner_token');
  }

  /**
   * @param  \Drupal\Core\Entity\ContentEntityBase $entity
   * @return $this
   */
  public function generateToken(\Drupal\Core\Entity\ContentEntityBase $entity) {
    $prefix = 'alert-'.$entity->id();
    $hash = sha1(uniqid('', true));
    $this->token = $prefix.'-'.$hash;

    return $this;
  }

  /**
   * @return string
   */
  public function getToken() {
    return $this->token ?? null;
  }

  /**
   * @return mixed
   */
  public function save() {
    return $this->state->set('bhcc_alert_banners.alert_banner_token', $this->token);
  }

}
