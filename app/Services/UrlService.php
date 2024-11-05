<?php

namespace App\Services;

use App\Http\Requests\Api\V1\StoreUrlRequest;
use App\Models\Url;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UrlService
{
    public function firstOrCreate(StoreUrlRequest $request)
    {
        $requestedData = $request->mappedAttributes();
        $url = $this->isUrlExists($requestedData['longUrl'], 'longUrl');

        if ($url) {
            return $url;
        }

        return Url::create(array_merge(
            $requestedData,
            ['shortUrl' => $this->generateShortUrl()]
        ));
    }

    private function generateShortUrl()
    {
        $urlLength = random_int(4, 8);
        $shortUrl = str()->random($urlLength);

        if ($this->isUrlExists($shortUrl, 'shortUrl')) {
            return $this->generateShortUrl();
        }
        return $shortUrl;
    }

    private function isUrlExists(string $url, string $urlType): bool|Model
    {
        try {
            $url = Url::when($urlType === 'longUrl', function ($query) {
                return $query->where('user_id', auth()->id());
            })->where($urlType, $url)->firstOrFail();

            return $url;
        } catch (ModelNotFoundException $exception) {
            return false;
        }
    }
}
