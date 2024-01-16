<?php

namespace Tritrics\AflevereApi\v1\Models;

use Tritrics\AflevereApi\v1\Data\Collection;
use Tritrics\AflevereApi\v1\Data\Model;
use Tritrics\AflevereApi\v1\Services\LanguagesService;
use Tritrics\AflevereApi\v1\Services\LinkService;

/**
 * Model for Kirby's language object 
 *
 * @package   AflevereAPI Models
 * @author    Michael Adams <ma@tritrics.dk>
 * @link      https://aflevereapi.dev
 * @copyright Michael Adams
 * @license   https://opensource.org/license/isc-license-txt/
 */
class LanguageModel extends Model
{
  protected $add_details;

  /**
   * Constructor with additional property $add_details
   * 
   * @param mixed $model 
   * @param mixed $blueprint 
   * @param mixed $lang 
   * @param bool $add_details 
   * @return void 
   */
  public function __construct($model, $blueprint = null, $lang = null, $add_details = false)
  {
    $this->add_details = $add_details;
    parent::__construct($model);
  }

  /**
   * Get additional field data (besides type and value)
   * Method called by setModelData()
   * 
   * @return Collection 
   */
  protected function getProperties()
  {
    $code = trim(strtolower($this->model->code()));
    $home = kirby()->site()->homePage();

    $res = new Collection();
    $meta = $res->add('meta');
    $meta->add('code', $code);
    $meta->add('default', $this->model->isDefault());
    if ($this->add_details) {
      $meta->add('locale', LanguagesService::getLocale($code));
      $meta->add('direction', $this->model->direction());
    }
    $res->add('link', LinkService::getPage(
      LanguagesService::getUrl($code, $home->uri($code))
    ));
    if ($this->add_details) {
      $res->add('terms', $this->model->translations());
    }
    return $res;
  }

  /**
   * Get the value of model as it's returned in response.
   * Mandatory method.
   * 
   * @return string
   */
  protected function getValue()
  {
    return $this->model->name();
  }
}
