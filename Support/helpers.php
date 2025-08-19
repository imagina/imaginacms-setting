<?php

if (!function_exists('setting')) {
    function setting(string $systemName, mixed $default = null, ?string $locale = null): mixed
    {
        $settingService = app('Modules\Isetting\Services\SettingsService');
        return $settingService->get($systemName, $default, $locale);
    }
}
