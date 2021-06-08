<?php

declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Transformers;

use Arcanesoft\Foundation\Datatable\Contracts\Transformer;
use Illuminate\Http\Request;

/**
 * Class     PostTransformer
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PostTransformer implements Transformer
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Transform the resource.
     *
     * @param  \Arcanesoft\Blog\Models\Post|mixed  $resource
     * @param  \Illuminate\Http\Request            $request
     *
     * @return array
     */
    public function transform($resource, Request $request): array
    {
        return [
            'title'      => $resource->title,
            'created_at' => $resource->created_at->format('Y-m-d H:i:s'),
            'published'  => with($resource->isPublished(), function ($isPublished) {
                return [
                    'active' => $isPublished,
                    'label'  => __($isPublished ? 'Published' : 'Unpublished'),
                    'icon'   => true,
                ];
            }),
        ];
    }
}
