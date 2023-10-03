<?php

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command(
    'make:slug {--model=} {--key=}',
    function ($model, $key) {
        $className = "App\\Models\\$model";
        $model = new $className();
        $classes = $model::whereNull('slug')->get();
        if ($classes) {
            foreach ($classes as $class) {
                $slug = makeSlug(
                    $class->class_name,
                    $model,
                    $key
                );
                $class->slug = $slug;
                $class->save();
            }
            $this->info($classes->count(). " Slug generated.");
            return;
        }
        $this->info("No slug generated");
    }
)->describe('Add slug into classes');
