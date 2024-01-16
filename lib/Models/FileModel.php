<?php

namespace Tritrics\AflevereApi\v1\Models;

use Tritrics\AflevereApi\v1\Data\Collection;
use Tritrics\AflevereApi\v1\Data\Model;
use Tritrics\AflevereApi\v1\Services\LinkService;
use Tritrics\AflevereApi\v1\Services\FileService;

/**
 * Model for Kirby's file object
 *
 * @package   AflevereAPI Models
 * @author    Michael Adams <ma@tritrics.dk>
 * @link      https://aflevereapi.dev
 * @copyright Michael Adams
 * @license   https://opensource.org/license/isc-license-txt/
 */
class FileModel extends Model
{
  /**
   * Marker if this model has child fields.
   * 
   * @var true
   */
  protected $hasChildFields = true;

  /**
   * Get type of this model as it's returned in response.
   * Method called by setModelData()
   * 
   * @return string 
   */
  protected function getType()
  {
    return $this->model->type();
  }

  /**
   * Get additional field data (besides type and value)
   * Method called by setModelData()
   * 
   * @return Collection 
   */
  protected function getProperties ()
  {
    $pathinfo = FileService::getPathinfo($this->model->url());

    $title = $this->fields->node('title', 'value')->get();
    if (!$title) {
      $title = $pathinfo['file'];
    }

    $meta = new Collection();
    $meta->add('dir', $pathinfo['dirname'] . '/');
    $meta->add('file', $pathinfo['file']);
    $meta->add('filename', $pathinfo['filename']);
    $meta->add('ext', $pathinfo['extension']);
    $meta->add('blueprint', $this->model->template());
    $meta->add('title', $title);
    if ($this->model->type() === 'image') {
      $meta->add('width', $this->model->width());
      $meta->add('height', $this->model->height());
    }

    $res = new Collection();
    $res->add('meta', $meta);
    $res->add('link', LinkService::getFile($pathinfo['path']));
    return $res;
  }

  /**
   * Get the value of model as it's returned in response.
   * Mandatory method.
   * 
   * @return Collection
   */
  protected function getValue()
  {
    return $this->fields;
  }
}
