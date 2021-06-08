<?php

declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Transformers;

use Arcanesoft\Foundation\Datatable\Contracts\Transformer;
use Illuminate\Http\Request;

/**
 * Class     AuthorTransformer
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AuthorTransformer implements Transformer
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Transform the resource.
     *
     * @param  \Arcanesoft\Blog\Models\Author|mixed  $resource
     * @param  \Illuminate\Http\Request              $request
     *
     * @return array
     */
    public function transform($resource, Request $request): array
    {
        return [
            'full_name'  => $resource->full_name,
            'username'   => $resource->username,
            'posts'      => $resource->posts_count,
            'created_at' => $resource->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
