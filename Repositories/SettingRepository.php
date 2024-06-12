<?php

namespace Modules\Setting\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface SettingRepository extends BaseRepository
{
    /**
     * Create or update the settings
     *
     * @return mixed
     */
    public function createOrUpdate($settings);

    /**
     * Find a setting by its name
     *
     * @return mixed
     */
    public function findByName($settingName, $central = false, $organizationId = null);

    /**
     * Return all modules that have settings
     * with its settings
     *
     * @param  array|string  $modules
     * @return array
     */
    public function moduleSettings($modules);

    /**
     * Return the saved module settings
     *
     * @return mixed
     */
    public function savedModuleSettings($module);

    /**
     * Find settings by module name
     *
     * @param  string  $module
     * @return mixed
     */
    public function findByModule($module);

    /**
     * Find the given setting name for the given module
     *
     * @param  string  $settingName
     * @return mixed
     */
    public function get($settingName);

    /**
     * Return the translatable module settings
     *
     * @return array
     */
    public function translatableModuleSettings($module);

    /**
     * Return the non translatable module settings
     *
     * @return array
     */
    public function plainModuleSettings($module);
}
