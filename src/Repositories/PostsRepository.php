<?php declare(strict_types=1);

namespace Arcanesoft\Blog\Repositories;

use Arcanesoft\Blog\Blog;
use Arcanesoft\Blog\Models\Post;
use Illuminate\Support\Str;

/**
 * Class     PostsRepository
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PostsRepository extends AbstractRepository
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
        return Blog::model('post', Post::class);
    }

    /**
     * Create a new post.
     *
     * @param  array  $attributes
     *
     * @return \Arcanesoft\Blog\Models\Post|mixed
     */
    public function createOne(array $attributes): Post
    {
        /** @var  \Arcanesoft\Blog\Models\Post  $post */
        $post = $this->model()->fill($attributes)->forceFill([
            'uuid' => Str::uuid(), // TODO: Move to Event/Listener
        ]);

        $post->save();

        $this->syncTagsByUuid($post, $attributes['tags']);

        return $post;
    }

    /**
     * Update the given post.
     *
     * @param  \Arcanesoft\Blog\Models\Post  $post
     * @param  array                         $attributes
     *
     * @return bool
     */
    public function updateOne(Post $post, array $attributes): bool
    {
        return $post->update($attributes);
    }

    /**
     * Delete a post.
     *
     * @param  \Arcanesoft\Blog\Models\Post  $post
     *
     * @return bool|null
     */
    public function deleteOne(Post $post): ?bool
    {
        return $post->delete();
    }

    /* -----------------------------------------------------------------
     |  Relationship's Methods
     | -----------------------------------------------------------------
     */

    /**
     * @param  \Arcanesoft\Blog\Models\Post  $post
     * @param  array                         $uuids
     *
     * @return array
     */
    public function syncTagsByUuid(Post $post, array $uuids): array
    {
        $ids = $this->getTagsRepository()
            ->whereIn('uuid', $uuids)
            ->pluck('id');

        return $post->tags()->sync($ids);
    }

    /**
     * Get the tags repository.
     *
     * @return \Arcanesoft\Blog\Repositories\TagsRepository
     */
    protected function getTagsRepository(): TagsRepository
    {
        return $this->makeRepository(TagsRepository::class);
    }
}
