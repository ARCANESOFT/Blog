<?php declare(strict_types=1);

namespace Arcanesoft\Blog\Repositories;

use Arcanesoft\Blog\Blog;
use Arcanesoft\Blog\Models\Author;
use Arcanesoft\Foundation\Authorization\Repositories\AdministratorsRepository;
use Illuminate\Support\Str;

/**
 * Class     AuthorsRepository
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AuthorsRepository extends AbstractRepository
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
        return Blog::model('author', Author::class);
    }

    /**
     * Create a new author.
     *
     * @param  array  $attributes
     *
     * @return \Arcanesoft\Blog\Models\Author|mixed
     */
    public function createOne(array $attributes): Author
    {
        /** @var  \Arcanesoft\Blog\Models\Author  $author */
        $author = $this->model()->fill($attributes)->forceFill([
            'uuid' => Str::uuid(), // TODO: Move to Event/Listener
        ]);

        $this->addCreator($author, $attributes);

        $author->save();

        return $author;
    }

    /**
     * Update the given author.
     *
     * @param  \Arcanesoft\Blog\Models\Author  $author
     * @param  array                           $attributes
     *
     * @return bool
     */
    public function updateOne(Author $author, array $attributes): bool
    {
        // Filter/Remove nullable attributes like password
        $attributes = array_filter($attributes);

        $updated = $author->update($attributes);

        $this->updateCreator($author, $attributes);

        return $updated;
    }

    /**
     * Delete the given author.
     *
     * @param  \Arcanesoft\Blog\Models\Author  $author
     *
     * @return bool|null
     */
    public function deleteOne(Author $author): ?bool
    {
        return $author->delete();
    }

    /* -----------------------------------------------------------------
     |  Relationship's Methods
     | -----------------------------------------------------------------
     */

    /**
     * Create a new `creator/authenticatable` user associated to the author.
     *
     * @param  \Arcanesoft\Blog\Models\Author  $author
     * @param  array                           $attributes
     *
     * @return \Illuminate\Database\Eloquent\Model|mixed
     */
    protected function addCreator(Author $author, array $attributes)
    {
        $repo    = static::getAdminRepository();
        $creator = $repo->createOne($attributes);
        $repo->syncRolesByKeys($creator, ['blog-author']);

        return $author->creator()->associate($creator);
    }

    /**
     * Update the associated creator.
     *
     * @param  \Arcanesoft\Blog\Models\Author  $author
     * @param  array                           $attributes
     *
     * @return bool
     */
    protected function updateCreator(Author $author, array $attributes): bool
    {
        return static::getAdminRepository()
            ->updateOne($author->creator, $attributes);
    }

    /**
     * Get the `administrator` repository.
     *
     * @return \Arcanesoft\Foundation\Authorization\Repositories\AdministratorsRepository|mixed
     */
    protected static function getAdminRepository(): AdministratorsRepository
    {
        return static::makeRepository(AdministratorsRepository::class);
    }
}
