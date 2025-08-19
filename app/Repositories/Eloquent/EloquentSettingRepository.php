<?php

namespace Modules\Isetting\Repositories\Eloquent;

use Modules\Isetting\Repositories\SettingRepository;
use Imagina\Icore\Repositories\Eloquent\EloquentCoreRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EloquentSettingRepository extends EloquentCoreRepository implements SettingRepository
{
    /**
     * Filter names to replace
     * @var array
     */
    protected array $replaceFilters = [];

    /**
     * Relation names to replace
     * @var array
     */
    protected array $replaceSyncModelRelations = [];

    /**
     * Attribute to define default relations
     * all apply to index and show
     * index apply in the getItemsBy
     * show apply in the getItem
     * @var array
     */
    protected array $with = [/*all => [] ,index => [],show => []*/];

    /**
     * @param Builder $query
     * @param object $filter
     * @param object $params
     * @return Builder
     */
    public function filterQuery(Builder $query, object $filter, object $params): Builder
    {

        /**
         * Note: Add filter name to replaceFilters attribute before replace it
         *
         * Example filter Query
         * if (isset($filter->status)) $query->where('status', $filter->status);
         *
         */

        //Response
        return $query;
    }

    /**
     * @param Model $model
     * @param array $data
     * @return Model
     */
    public function syncModelRelations(Model $model, array $data): Model
    {
        //Get model relations data from model attributes
        //$modelRelationsData = ($model->modelRelations ?? []);

        /**
         * Note: Add relation name to replaceSyncModelRelations attribute before replace it
         *
         * Example to sync relations
         * if (array_key_exists(<relationName>, $data)){
         *    $model->setRelation(<relationName>, $model-><relationName>()->sync($data[<relationName>]));
         * }
         *
         */

        //Response
        return $model;
    }

    /**
     * @param string $systemName
     * @param mixed $value
     * @return Model|null
     */
    public function setSetting(string $systemName, mixed $value): ?Model
    {
        [$module, $key] = explode('::', $systemName, 2);
        $settingConfig = config("$module.settings.$key");
        if (!$settingConfig) return null;

        $isTranslatable = $settingConfig['isTranslatable'] ?? false;
        $isMedia = $settingConfig['isMedia'] ?? false;

        return $this->updateOrCreate(['system_name' => $systemName], [
            'is_translatable' => $isTranslatable,
            'plain_value' => !$isTranslatable ? $value : null,
            ...(!$isTranslatable ? [] : array_map(function ($value) {
                return ['value' => $value];
            }, $value)),
            ...($isMedia ? $value : [])
        ]);
    }



    /**
     * Get all Setting Formated from Config and DB
     */
    public function getAllSettings($params): mixed
    {
        //Get Module with settings
        $modulesWithSettings = iconfig('settings', true);

        //Pass to first level
        $configSettings = [];
        foreach ($modulesWithSettings as $module => $settings) {
            foreach ($settings as $key => $config) {
                //Validation valid array
                if (is_array($config)) {
                    $configSettings[] = array_merge($config, [
                        'name' => "{$module}::{$key}",
                    ]);
                }
            }
        }

        //Get All Settings from DB
        $dbSettings = $this->getItemsBy($params);

        //Get All Settings Formatted
        $settings = app('Modules\Isetting\Services\SettingsService')->getFormatedSettings($configSettings, $dbSettings);

        return $settings;
    }
}
