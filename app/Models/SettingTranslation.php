<?php

namespace Modules\Isetting\Models;

use Illuminate\Database\Eloquent\Model;

class SettingTranslation extends Model
{
  public $timestamps = false;
  protected $fillable = ['value'];
  protected $table = 'isetting__setting_translations';
  protected $casts = [
    'value' => 'json',
  ];
}
