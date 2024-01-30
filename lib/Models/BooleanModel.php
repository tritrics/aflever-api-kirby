<?php

namespace Tritrics\AflevereApi\v1\Models;

use Tritrics\AflevereApi\v1\Data\Model;

/**
 * Model for Kirby's fields: toggle
 */
class BooleanModel extends Model
{
  /**
   * Get the value of model as it's returned in response.
   * Mandatory method.
   */
  protected function getValue (): int
  {
    return (float) $this->model->isTrue(); // return 0 or 1 as number
  }
}