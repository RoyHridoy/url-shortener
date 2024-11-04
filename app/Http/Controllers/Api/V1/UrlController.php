<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\StoreUrlRequest;
use App\Http\Resources\V1\UrlResource;
use App\Models\Url;
use App\Policies\V1\UrlPolicy;
use App\Services\UrlService;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

class UrlController extends ApiController
{
    use ApiResponses;

    protected $policy = UrlPolicy::class;

    public function index()
    {
        return UrlResource::collection(
            Url::where('user_id', auth()->id())->paginate()
        );
    }

    /* TODO:
        1. Check Ability to Create a short Url
        2. Refactor Service Class code
        3. Customize an url
        4. Delete an url
        5. Implement Version 2
        6. Limit a user can create maximum 15 url
        7. Handle Exception
        8. Documentation
    */
    public function store(StoreUrlRequest $request)
    {
        return new UrlResource((new UrlService())->firstOrCreate($request));
    }

    public function show(Url $url)
    {
        if ($this->isAble('view', $url)) {
            return new UrlResource($url);
        }
        return $this->unAuthorize('You are not authorize to see this resource.');
    }
}
