<?php

namespace Modules\Isetting\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Imagina\Icore\Http\Controllers\CoreApiController;

//Model
use Modules\Isetting\Models\Setting;
use Modules\Isetting\Repositories\SettingRepository;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Modules\Isetting\Transformers\SettingTransformer;

class SettingApiController extends CoreApiController
{
    public function __construct(Setting $model, SettingRepository $modelRepository)
    {
        parent::__construct($model, $modelRepository);
    }

    public function set(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            //Get model data
            $modelData = $request->input('attributes') ?? [];

            //Set settings
            foreach ($modelData as $systemName => $value) {
                $this->modelRepository->setSetting($systemName, $value);
            }

            //Response
            $response = ['message' => Response::$statusTexts[Response::HTTP_OK]];
            DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            DB::rollback(); //Rollback to Data Base
            [$status, $response] = $this->getErrorResponse($e);
        }
        //Return response
        return response()->json($response, $status ?? Response::HTTP_OK);
    }


    /**
     * Controller To request all model data
     *
     * @return mixed
     */
    public function getAll(Request $request): JsonResponse
    {
        try {
            //Get Parameters from request
            $params = $this->getParamsRequest($request);

            $settings = $this->modelRepository->getAllSettings($params);

            //Response
            $response = ['data' => SettingTransformer::collection($settings)];
        } catch (Exception $e) {
            [$status, $response] = $this->getErrorResponse($e);
        }

        //Return response
        return response()->json($response, $status ?? Response::HTTP_OK);
    }
}
