<?php

/**
 * TaxService.php
 *
 * @copyright  2022 beikeshop.com - All Rights Reserved
 * @link       https://beikeshop.com
 * @author     Edward Yang <yangjin@guangda.work>
 * @created    2022-07-27 14:24:05
 * @modified   2022-07-27 14:24:05
 */

namespace Beike\Shop\Services\TotalServices;

use Beike\Admin\Repositories\TaxRateRepo;
use Beike\Shop\Services\TotalService;

class TaxService
{
    public static function getTotal(TotalService $totalService): ?array
    {
        $taxEnabled = system_setting('base.tax', false);
        if (!$taxEnabled) {
            return null;
        }

        $taxes = $totalService->taxes;

        $totalItems = [];
        foreach ($taxes as $taxRateId => $value) {
            if ($value <= 0) {
                continue;
            }
            $totalItems[] = array(
                'code' => 'tax',
                'title' => TaxRateRepo::getNameByRateId($taxRateId),
                'amount' => $value,
                'amount_format' => currency_format($value)
            );
            $totalService->amount += $value;
        }

        $totalService->totals = array_merge($totalService->totals, $totalItems);
        return $totalItems;
    }
}
