<?php namespace Efusionsoft\Mis\Services\Validators;

use Config;

class User extends \Efusionsoft\Mis\Services\Validators\Validator
{
    public function __construct($data = null, $level = null)
    {
        parent::__construct($data, $level);

        static::$rules = Config::get('mis::validator.user');
    }
}
