Q PHP Framework
=
<a href="http://q.codephun.com/" target="_blank">http://q.codephun.com/</a>

This is not a RESTful framework. This framework is ment for small applications that only needs few pages.
Requires: <a href="http://getcomposer.org">Composer</a>.

###Install
```php
// Clone repository
git clone https://github.com/bjarneo/Q.git

// Open Q directory
composer install
```

### Set up index.php file
```php
// Require composer's autoloader
require 'vendor/autoload.php';

// Create new instance of Q
$app = new \Q\Q(array(
    'mode' => 'development',        // 'production' for no error messages
    'view_path' => './app/View/'    // Set view folder.
));
```

### Append routes (paths)
```php
$app->route('/', function() {
    echo 'Hello Q';
});
```

### Run application
```php
// After last route you've created you must run you application
$app->run()
```

### Render view
```php
$app->route('/404', function() use ($app) {
    $app->render('404.php');
});
```

### Add data to templates
```php
$app->route('/hello', function() use($app) {
    $data = array(
        'greeting' => 'Hello Q!'
    );

    // Now use echo $greeting in template.php
    $app->render('template.php', $data);
});
```

### How to use parameters
```php
// Add params as parameters in function
$app->route('/path', function($name, $age) {
    printf("My name is: %s. I'm %s years old.", $name, $age);
});

// Ex: domain.com/path/bjarneo/26
// Ouput: My name is: bjarneo. I'm 26 years old.
```
