<?php

namespace Modules\Setting\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Setting\Repositories\SettingRepository;

class SettingDatabaseSeeder extends Seeder
{
    /**
     * @var SettingRepository
     */
    private $setting;

    public function __construct(SettingRepository $setting)
    {
        $this->setting = $setting;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        $this->call(SettingModuleTableSeeder::class);
        $settingsToCreate = [
            'core::template' => 'ImaginaTheme',
            'core::locales' => ['es'],
        ];

        foreach ($settingsToCreate as $key => $settingToCreate) {
          $setting = $this->setting->findByName($key);
          if (! isset($setting->id)) {
            $this->setting->createOrUpdate([$key => $settingToCreate]);
          }
        }
    }
}
