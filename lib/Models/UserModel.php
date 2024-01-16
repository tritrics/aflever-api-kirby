<?php

namespace Tritrics\AflevereApi\v1\Models;

use Tritrics\AflevereApi\v1\Data\Collection;
use Tritrics\AflevereApi\v1\Data\Model;

/**
 * Model for Kirby's user object 
 *
 * @package   AflevereAPI Models
 * @author    Michael Adams <ma@tritrics.dk>
 * @link      https://aflevereapi.dev
 * @copyright Michael Adams
 * @license   https://opensource.org/license/isc-license-txt/
 */
class UserModel extends Model
{
  /**
   * Marker if this model has child fields.
   * 
   * @var true
   */
  protected $hasChildFields = true;

  /**
   * Get additional field data (besides type and value)
   * Method called by setModelData()
   * 
   * @return Collection 
   */
  protected function getProperties ()
  {
    $meta = new Collection();
    $meta->add('id', md5($this->model->id()));

    $res = new Collection();
    $res->add('meta', $meta);
    return $res;
  }

  /**
   * Get the value of model as it's returned in response.
   * Mandatory method.
   * For security-reasons we don't expose user's build-in values like
   * name, email, role, avatar. We only expose possibly extra-fields.
   * 
   * @return Collection|string|number|bool
   */
  protected function getValue ()
  {
    return $this->fields;
  }
}