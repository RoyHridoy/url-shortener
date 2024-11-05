<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\StoreUrlRequest;
use App\Http\Resources\V1\UrlResource;
use App\Models\Url;
use App\Policies\V1\UrlPolicy;
use App\Services\UrlService;
use App\Traits\ApiResponses;

class UrlController extends ApiController
{
    use ApiResponses;

    protected $policy = UrlPolicy::class;

    public function index()
    {
        return UrlResource::collection(
            Url::where('user_id', auth()->id())->latest()->paginate()
        );
    }

    public function store(StoreUrlRequest $request)
    {
        if ($this->isAble('create', new Url())) {
            return new UrlResource((new UrlService())->firstOrCreate($request));
        }
        return $this->unAuthorize('You are not authorize to create url resource.');
    }

    public function show(Url $url)
    {
        if ($this->isAble('view', $url)) {
            return new UrlResource($url);
        }
        return $this->unAuthorize('You are not authorize to see this resource.');
    }

    public function destroy(Url $url)
    {
        if ($this->isAble('delete', $url)) {
            $url->delete();
            return $this->ok('Successfully Deleted the shorten url');
        }
        return $this->unAuthorize('You are not authorize to delete the url resource.');
    }
}
