<?php

namespace Modules\Isetting\Transformers;

use Imagina\Icore\Transformers\CoreResource;

class SettingTransformer extends CoreResource
{
    /**
     * Attribute to exclude relations from transformed data
     * @var array
     */
    protected array $excludeRelations = [];

    /**
     * Method to merge values with response
     *
     * @return array
     */
    public function modelAttributes($request): array
    {

        //Implementation with Media
        return [
            'files' => $this->whenLoaded('files', fn() => $this->files->byZones($this->mediaFillable, $this)),
        ];
    }
}
