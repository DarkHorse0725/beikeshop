<?php
/**
 * MarketingService.php
 *
 * @copyright  2022 beikeshop.com - All Rights Reserved
 * @link       https://beikeshop.com
 * @author     Edward Yang <yangjin@guangda.work>
 * @created    2022-09-26 11:50:34
 * @modified   2022-09-26 11:50:34
 */

namespace Beike\Admin\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use ZanySoft\Zip\Zip;

class MarketingService
{
    private PendingRequest $httpClient;

    public function __construct()
    {
        $this->httpClient = Http::withOptions([
            'verify' => false,
        ])->withHeaders([
            'developer-token' => system_setting('base.developer_token'),
        ]);
    }

    public static function getInstance()
    {
        return new self;
    }

    /**
     * 获取可插件市场插件列表
     *
     * @param array $filters
     * @return mixed
     */
    public function getList(array $filters = []): mixed
    {
        $url = config('beike.api_url') . '/api/plugins';
        if (! empty($filters)) {
            $url .= '?' . http_build_query($filters);
        }

        return $this->httpClient->get($url)->json();
    }

    /**
     * 获取插件市场单个插件信息
     *
     * @param $pluginCode
     * @return mixed
     */
    public function getPlugin($pluginCode): mixed
    {
        $url    = config('beike.api_url') . "/api/plugins/{$pluginCode}?version=" . config('beike.version');
        $plugin = $this->httpClient->get($url)->json();
        if (empty($plugin)) {
            throw new NotFoundHttpException('该插件不存在或已下架');
        }

        return $plugin;
    }

    /**
     * 购买插件市场单个插件
     *
     * @throws \Exception
     */
    public function buy($pluginCode, $postData)
    {
        $url = config('beike.api_url') . "/api/plugins/{$pluginCode}/buy";

        $content = $this->httpClient->withBody($postData, 'application/json')
            ->post($url)
            ->json();

        $status = $content['status'] ?? '';
        if ($status == 'success') {
            return $content['data'];
        }

            throw new \Exception($content['message'] ?? '');
    }

    /**
     * 下载插件到网站
     *
     * @param $pluginCode
     * @throws \Exception
     */
    public function download($pluginCode)
    {
        $datetime = date('Y-m-d');
        $url      = config('beike.api_url') . "/api/plugins/{$pluginCode}/download";

        $content = $this->httpClient->get($url)->body();

        $pluginPath = "plugins/{$pluginCode}-{$datetime}.zip";
        Storage::disk('local')->put($pluginPath, $content);

        $pluginZip = storage_path('app/' . $pluginPath);
        $zipFile   = (new Zip)->open($pluginZip);
        $zipFile->extract(base_path('plugins'));
    }
}
