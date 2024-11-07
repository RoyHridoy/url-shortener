<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UrlResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'url',
            'id' => $this->id,
            'attributes' => [
                'longUrl' => $this->longUrl,
                'shortUrl' => url($this->shortUrl),
                /** @var integer */
                'totalVisit' => $this->visitorCount ?? 0,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'relationships' => [
                'users' => [
                    'data' => [
                        'type' => 'user',
                        /** @var array */
                        'id' => $this->users->pluck('id')
                    ]
                ]
            ],
            'links' => [
                'self' => [
                    route('urls.show', ['url' => $this->id])
                ]
            ]
        ];
    }
}
