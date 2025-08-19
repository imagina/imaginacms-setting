<?php

namespace Modules\Isetting\Models;

use Astrotomic\Translatable\Translatable;
use Imagina\Icore\Models\CoreModel;
use Imagina\Icore\Relations\EmptyRelation;

class Setting extends CoreModel
{
    use Translatable;

    protected $table = 'isetting__settings';
    public string $transformer = 'Modules\Isetting\Transformers\SettingTransformer';
    public string $repository = 'Modules\Isetting\Repositories\SettingRepository';
    public array $requestValidation = [
        'create' => 'Modules\Isetting\Http\Requests\CreateSettingRequest',
        'update' => 'Modules\Isetting\Http\Requests\UpdateSettingRequest',
    ];
    //Instance external/internal events to dispatch with extraData
    public array $dispatchesEventsWithBindings = [
        'created' => [['path' => 'Modules\Imedia\Events\CreateMedia']],
        'creating' => [],
        'updated' => [['path' => 'Modules\Imedia\Events\UpdateMedia']],
        'updating' => [],
        'deleting' => [['path' => 'Modules\Imedia\Events\DeleteMedia']],
        'deleted' => []
    ];
    public array $translatedAttributes = ['value'];
    protected $fillable = ['system_name', 'plain_value', 'is_translatable'];
    protected $casts = [
        'plain_value' => 'json',
        'is_translatable' => 'boolean',
    ];

    /**
     * Media Fillable
     */
    public array $mediaFillable = [
        'mainimage' => 'single'
    ];

    /**
     * Relation Media
     * Make the Many-To-Many Morph
     */
    public function files()
    {
        if (isModuleEnabled('Imedia')) {
            return app(\Modules\Imedia\Relations\FilesRelation::class)->resolve($this);
        }
        return new EmptyRelation();
    }
}
