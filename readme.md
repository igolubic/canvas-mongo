## Introduction

Canvas with mongoDB by [MVT Solutions](https://www.mvt-solutions.com) 

## TODO
- Load and show posts with tag [ ]
- Load and show posts in topic [ ]

## Installation

> **Note:** Canvas Mongo requires you to have user authentication in place prior to installation. You may run the `make:auth` Artisan command to satisfy this requirement.

Add the following to your composer.json file:

```json
  "repositories": [
    {
      "url": "https://github.com/igolubic/canvas-mongo.git",
      "type": "git"
    }
  ],
```

Require canvas-mongo:

```json
"cnvs/canvas": "dev-master",
```

Publish the assets and primary configuration file using the `canvas:install` Artisan command:

```bash
php artisan canvas:install
```

Create a symbolic link to ensure file uploads are publicly accessible from the web using the `storage:link` Artisan command:

```bash
php artisan storage:link
```

## Configuration

> **Note:** The following steps are optional configurations, you are not required to complete them.

**Want to get started fast?** Just run `php artisan canvas:setup` after installing Canvas mongo. Then, navigate your browser to `http://your-app.test/blog` or any other URL that is assigned to your application. This command scaffolds a default frontend for your entire blog!


If you want to include [Unsplash](https://unsplash.com) images in your post content, set up a new application at [https://unsplash.com/oauth/applications](https://unsplash.com/oauth/applications). Grab your access key and update `config/canvas.php`:

```php
'unsplash' => [
    'access_key' => env('CANVAS_UNSPLASH_ACCESS_KEY'),
],
```

## Updates

You may update your Canvas mongo installation using composer:

```bash
composer update
```

Run any new migrations using the `migrate` Artisan command:

```bash
php artisan migrate
```

Re-publish the assets using the `canvas:publish` Artisan command:

```bash
php artisan canvas:publish
```

## License

Canvas is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Credits

- [The team](https://github.com/orgs/cnvs/people) that continues to support and develop this project
- Thanks to [Mohamed Said](https://themsaid.com/) and his project [Wink](https://github.com/writingink/wink) for inspring much of the design
- Anyone who has [contributed a patch](https://github.com/cnvs/canvas/pulls) or [made a helpful suggestion](https://github.com/cnvs/canvas/issues)
