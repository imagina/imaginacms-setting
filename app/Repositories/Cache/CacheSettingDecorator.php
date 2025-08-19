<?php

namespace Modules\Isetting\Repositories\Cache;

use Illuminate\Database\Eloquent\Model;
use Modules\Isetting\Repositories\SettingRepository;
use Imagina\Icore\Repositories\Cache\CoreCacheDecorator;

class CacheSettingDecorator extends CoreCacheDecorator implements SettingRepository
{
    public function __construct(SettingRepository $setting)
    {
        parent::__construct();
        $this->entityName = 'isetting.settings';
        $this->repository = $setting;
    }

    /**
     * @param string $systemName
     * @param mixed $value
     * @return Model|null
     */
    public function setSetting(string $systemName, mixed $value): ?Model
    {
        $this->clearCache();
        return $this->repository->setSetting($systemName, $value);
    }

    public function getAllSettings($params): mixed
    {
        return $this->remember(function () use ($params) {
            return $this->repository->getAllSettings($params);
        });
    }
}
