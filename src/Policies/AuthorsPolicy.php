<?php

declare(strict_types=1);

namespace Arcanesoft\Blog\Policies;

use Arcanesoft\Blog\Models\Author;
use Arcanesoft\Foundation\Authorization\Models\Administrator;

/**
 * Class     AuthorsPolicy
 *
 * @package  Arcanesoft\Blog\Policies
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AuthorsPolicy extends Policy
{
    /* -----------------------------------------------------------------
     |  Getters
     | -----------------------------------------------------------------
     */

    /**
     * Get the ability's prefix.
     *
     * @return string
     */
    protected static function prefix(): string
    {
        return 'admin::blog.authors.';
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the policy's abilities.
     *
     * @return \Arcanedev\LaravelPolicies\Ability[]|iterable
     */
    public function abilities(): iterable
    {
        $this->setMetas([
            'category' => 'Authors',
        ]);

        return [

            // admin::blog.authors.index
            $this->makeAbility('index')->setMetas([
                'name'        => 'List all the authors',
                'description' => 'Ability to list all the authors',
            ]),

            // admin::blog.authors.metrics
            $this->makeAbility('metrics')->setMetas([
                'name'        => "List all the authors' metrics",
                'description' => "Ability to list all the authors' metrics",
            ]),

            // admin::blog.authors.create
            $this->makeAbility('create')->setMetas([
                'name'        => 'Create a new author',
                'description' => 'Ability to create a new author',
            ]),

            // admin::blog.authors.show
            $this->makeAbility('show')->setMetas([
                'name'        => 'Show a author',
                'description' => "Ability to show the author's details",
            ]),

            // admin::blog.authors.update
            $this->makeAbility('update')->setMetas([
                'name'        => 'Update a author',
                'description' => 'Ability to update a author',
            ]),

            // admin::blog.authors.delete
            $this->makeAbility('delete')->setMetas([
                'name'        => 'Delete a author',
                'description' => 'Ability to delete a author',
            ]),

        ];
    }

    /* -----------------------------------------------------------------
     |  Policies
     | -----------------------------------------------------------------
     */

    /**
     * Allow to list all the authors.
     *
     * @param  \Arcanesoft\Foundation\Authorization\Models\Administrator|mixed  $administrator
     *
     * @return \Illuminate\Auth\Access\Response|bool|void
     */
    public function index(Administrator $administrator)
    {
        //
    }

    /**
     * Allow to list all the authors' metrics.
     *
     * @param  \Arcanesoft\Foundation\Authorization\Models\Administrator|mixed  $administrator
     *
     * @return \Illuminate\Auth\Access\Response|bool|void
     */
    public function metrics(Administrator $administrator)
    {
        //
    }

    /**
     * Allow to create a author.
     *
     * @param  \Arcanesoft\Foundation\Authorization\Models\Administrator|mixed  $administrator
     *
     * @return \Illuminate\Auth\Access\Response|bool|void
     */
    public function create(Administrator $administrator)
    {
        //
    }

    /**
     * Allow to show a author details.
     *
     * @param  \Arcanesoft\Foundation\Authorization\Models\Administrator|mixed  $administrator
     * @param  \Arcanesoft\Blog\Models\Author|mixed|null                        $author
     *
     * @return \Illuminate\Auth\Access\Response|bool|void
     */
    public function show(Administrator $administrator, Author $author = null)
    {
        //
    }

    /**
     * Allow to update a author.
     *
     * @param  \Arcanesoft\Foundation\Authorization\Models\Administrator|mixed  $administrator
     * @param  \Arcanesoft\Blog\Models\Author|mixed|null                        $author
     *
     * @return \Illuminate\Auth\Access\Response|bool|void
     */
    public function update(Administrator $administrator, Author $author = null)
    {
        //
    }

    /**
     * Allow to delete a author.
     *
     * @param  \Arcanesoft\Foundation\Authorization\Models\Administrator|mixed  $administrator
     * @param  \Arcanesoft\Blog\Models\Author|mixed|null                        $author
     *
     * @return \Illuminate\Auth\Access\Response|bool|void
     */
    public function delete(Administrator $administrator, Author $author = null)
    {
        if ( ! is_null($author))
            return $author->isDeletable();
    }
}
