<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
</head>

<body>
    <header>
        Laravel API
    </header>
    <main>
        <pre>
            You can use this API for your web application.
            It has no front-end except API documentation for improve performance.
            
            <a href="https://github.com/abolraj/grill-go-vue-laravel">Github : grill-go-vue-laravel</a>
            Thank you to support !
        </pre>
    </main>
    <footer>
        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
    </footer>
</body>

</html>
