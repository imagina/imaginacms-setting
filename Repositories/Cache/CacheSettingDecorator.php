<?php

namespace Modules\Setting\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Setting\Repositories\SettingRepository;

class CacheSettingDecorator extends BaseCacheDecorator implements SettingRepository
{
    public function __construct(SettingRepository $setting)
    {
        parent::__construct();
        $this->entityName = 'setting.settings';
        $this->repository = $setting;
    }

    /**
     * Create or update the settings
     *
     * @return mixed
     */
    public function createOrUpdate($settings)
    {
        $this->clearCache();

        return $this->repository->createOrUpdate($settings);
    }

    /**
     * Find a setting by its name
     *
     * @return mixed
     */
    public function findByName($settingName, $central = false, $organizationId = null)
    {
        $settingValue = $this->remember(function () use ($settingName) {
            return $this->repository->findByName($settingName) ?? $settingName.'___NULL';
        });

        if ($settingValue === $settingName.'___NULL') {
            $settingValue = null;
        }

        return $settingValue;
    }

    /**
     * Return all modules that have settings
     * with its settings
     *
     * @param  array|string  $modules
     */
    public function moduleSettings($modules)
    {
        // return $this->remember(function () use ($modules) {
        return $this->repository->moduleSettings($modules);
        //});
    }

    /**
     * Return the saved module settings
     *
     * @return mixed
     */
    public function savedModuleSettings($module)
    {
        return $this->remember(function () use ($module) {
            return $this->repository->savedModuleSettings($module);
        });
    }

    /**
     * Find settings by module name
     *
     * @return mixed
     */
    public function findByModule($module)
    {
        return $this->remember(function () use ($module) {
            return $this->repository->findByModule($module);
        });
    }

    /**
     * Find the given setting name for the given module
     *
     * @return mixed
     */
    public function get($settingName)
    {
        return $this->remember(function () use ($settingName) {
            return $this->repository->get($settingName);
        });
    }

    /**
     * Return the translatable module settings
     */
    public function translatableModuleSettings($module)
    {
        return $this->remember(function () use ($module) {
            return $this->repository->translatableModuleSettings($module);
        });
    }

    /**
     * Return the non translatable module settings
     */
    public function plainModuleSettings($module)
    {
        return $this->remember(function () use ($module) {
            return $this->repository->plainModuleSettings($module);
        });
    }
}
