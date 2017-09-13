<?php

use Arcanesoft\Auth\Models\User;
use Arcanesoft\Blog\Models\Category;
use Arcanesoft\Blog\Models\Post;
use Arcanesoft\Blog\Models\Tag;
use Faker\Generator as Faker;

/** @var  Illuminate\Database\Eloquent\Factory  $factory */

$factory->define(Post::class, function (Faker $faker) {
    return [
        'author_id'    => factory(User::class)->lazy(),
        'category_id'  => factory(Category::class)->lazy(),
        'locale'       => 'fr',
        'title'        => $faker->sentence,
        'slug'         => $faker->sentence,
        'excerpt'      => $faker->paragraph,
        'thumbnail'    => 'http://example.com/img/thumbnail.jpg',
        'content'      => '# This is a **markdown** `content`',
        'is_draft'     => $faker->boolean,
        'published_at' => \Carbon\Carbon::now(),
    ];
});

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->unique()->name,
        'slug' => \Illuminate\Support\Str::slug($name),
    ];
});

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->unique()->name,
        'slug' => \Illuminate\Support\Str::slug($name),
    ];
});

$factory->define(User::class, function (Faker $faker) {
    static $password;

    return [
        'username'       => $faker->userName,
        'first_name'     => $faker->firstName,
        'last_name'      => $faker->lastName,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'is_admin'       => true,
        'is_active'      => true,
    ];
});
