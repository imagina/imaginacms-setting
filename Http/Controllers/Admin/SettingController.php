<?php namespace Modules\Setting\Http\Controllers\Admin;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Laracasts\Flash\Flash;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Setting\Http\Requests\SettingRequest;
use Modules\Setting\Repositories\SettingRepository;

class SettingController extends AdminBaseController
{
    /**
     * @var SettingRepository
     */
    private $setting;

    public function __construct(SettingRepository $setting)
    {
        parent::__construct();

        $this->setting = $setting;
    }

    public function index()
    {
        $settings = $this->setting->all();

        return View::make('setting::admin.settings', compact('settings'));
    }

    public function store(SettingRequest $request)
    {
        $this->setting->createOrUpdate($request->all());

        Flash::success('Settings saved!');
        return Redirect::route('dashboard.setting.index');
    }
}