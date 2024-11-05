<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Requests\Api\V1\StoreUrlRequest;
use App\Http\Requests\Api\V2\UpdateUrlRequest;
use App\Http\Resources\V2\UrlResource;
use App\Models\Url;
use App\Services\V1\UrlService;
use App\Traits\ApiResponses;

class UrlController extends ApiController
{
    use ApiResponses;

    protected $policy = UrlPolicy::class;

    public function index()
    {
        return UrlResource::collection(
            auth()->user()->urls()->latest()->paginate()
        );
    }

    public function store(StoreUrlRequest $request)
    {
        if ($this->isAble('create', new Url())) {
            return new UrlResource((new UrlService())->firstOrCreate($request));
        }
        return $this->unAuthorize('You are not authorized to create url resource.');
    }

    public function show(Url $url)
    {
        if ($this->isAble('view', $url)) {
            return new UrlResource($url);
        }
        return $this->unAuthorize('You are not authorized to see this resource.');
    }

    // TODO: Not Complete Yet.
    // 1. When creating user check customize = 1 and longUrl exist or not in list
    // 2. Bottom Todo
    public function update(UpdateUrlRequest $request, Url $url)
    {
        if ($this->isAble('update', $url)) {
            if ($url->users->pluck('id')->count() > 1) {
                // TODO:
                return "need to Create";
            } else {
                $url->update([
                    'shortUrl' => $request->mappedAttributes()['shortUrl'],
                    'isCustomized' => 1
                ]);
            }
            return new UrlResource($url);
        }
        return $this->unAuthorize('You are not authorized to update the url resource.');
    }


    public function destroy(Url $url)
    {
        if ($this->isAble('delete', $url)) {
            if ($url->users->pluck('id')->count() > 1) {
                $url->users()->detach(auth()->id());
            } else {
                $url->delete();
            }
            return $this->ok('Successfully Deleted the shorten url');
        }
        return $this->unAuthorize('You are not authorized to delete the url resource.');
    }

}
