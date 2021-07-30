<?php declare(strict_types=1);

namespace Arcanesoft\Blog\Repositories;

use Arcanesoft\Blog\Blog;
use Arcanesoft\Blog\Models\Tag;
use Illuminate\Support\{Collection, Str};

/**
 * Class     TagsRepository
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TagsRepository extends AbstractRepository
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the model FQN class.
     *
     * @return string
     */
    public static function modelClass(): string
    {
        return Blog::model('tag', Tag::class);
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Create a new tag.
     *
     * @param  array  $attributes
     *
     * @return \Arcanesoft\Blog\Models\Tag
     */
    public function createOne(array $attributes)
    {
        $tag = $this->model()->forceFill([
            'uuid' => Str::uuid(), // TODO: Move to Event/Listener
        ])->fill($attributes);

        $tag->save();

        return $tag;
    }

    /**
     * Update the given tag.
     *
     * @param  \Arcanesoft\Blog\Models\Tag  $tag
     * @param  array                        $attributes
     *
     * @return bool
     */
    public function updateOne(Tag $tag, array $attributes): bool
    {
        return $tag->update($attributes);
    }

    /**
     * Delete the given tag.
     *
     * @param  \Arcanesoft\Blog\Models\Tag  $tag
     *
     * @return bool|null
     */
    public function deleteOne(Tag $tag)
    {
        return $tag->delete();
    }

    /**
     * Get the data for select input.
     *
     * @param  bool  $placeholder
     *
     * @return \Illuminate\Support\Collection
     */
    public function getSelectData(bool $placeholder = true): Collection
    {
        return $this
            ->pluck('name', 'uuid')
            ->when($placeholder, function (Collection $tags) {
                return $tags->prepend(__('-- Select a tag --'));
            })
            ->toBase();
    }
}
