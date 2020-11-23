<?php


namespace App\Services\Currencies;


use App\Services\Currencies\Contracts\Currency;
use App\Services\Currencies\Contracts\CurrencyContract;
use App\Services\Currencies\Contracts\CurrencyException;
use Illuminate\Support\Facades\Cache;

class FixerCurrencyService implements CurrencyContract
{
    protected $cacheTime = 120;
    public function __construct()
    {
    }

    public function callApi($endpoint, $params = [])
    {
        $access_key = config("currency.fixer.api_key");
        $base_url = config("currency.fixer.base_url");
        // Initialize CURL:
        $ch = curl_init($base_url . $endpoint . '?access_key=' . $access_key . '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);
        // Decode JSON response:
        return json_decode($json, true);
    }

    /**
     * @inheritDoc
     */
    public function convert(string $from, string $to, float $sum): float
    {
        return $sum;
    }

    /**
     * @inheritDoc
     */
    public function list(): array
    {
        $res = Cache::get("fixer_symbols");
        if (!$res){
            $data = $this->callApi('symbols');
            $res =  $data['symbols'];
            Cache::set("fixer_symbols", $res , $this->cacheTime);
        }

        return $res;
    }
}
