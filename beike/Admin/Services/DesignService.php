<?php
/**
 * DesignService.php
 *
 * @copyright  2022 opencart.cn - All Rights Reserved
 * @link       http://www.guangdawangluo.com
 * @author     Edward Yang <yangjin@opencart.cn>
 * @created    2022-07-14 20:57:37
 * @modified   2022-07-14 20:57:37
 */

namespace Beike\Admin\Services;

use Illuminate\Support\Str;

class DesignService
{
    public static function handleModules($modulesData): array
    {
        $modulesData = $modulesData['modules'];
        if (empty($modulesData)) {
            return [];
        }

        foreach ($modulesData as $index => $moduleData) {
            $moduleId = $moduleData['module_id'] ?? '';
            if (empty($moduleId)) {
                $moduleData['module_id'] = Str::random(16);
            }
            $modulesData[$index] = $moduleData;
        }
        return ['modules' => $modulesData];
    }
}