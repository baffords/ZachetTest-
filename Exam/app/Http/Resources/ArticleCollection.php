<?php

namespace App\Http\Resources;
use App\Models\Article;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'links' => [
            'self' => 'link-value',
            ],
        ];
    }
}
