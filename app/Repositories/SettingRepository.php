<?php

namespace Modules\Isetting\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Mix;
use Imagina\Icore\Repositories\CoreRepository;

interface SettingRepository extends CoreRepository
{
    /**
     * @param string $systemName
     * @param mixed $value
     * @return Model|null
     */
    public function setSetting(string $systemName, mixed $value): ?Model;

    public function getAllSettings($params): mixed;
}
