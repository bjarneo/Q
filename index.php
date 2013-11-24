<?php
/**
 * Example index.php
 */

// Get Q
require('framework/Q.php');

// Create new instance of Q
$app = new Q(array(
    'mode' => 'developement',
    'view_path' => './app/View/'
));

// Add your route. use($app) if you need to add the object to the anonymous function
$app->route('/test', function () use($app) {
    // Data we append to our view file.
    $data = array(
        'hello' => 'Hello World'
    );

    // render view files
    $app->render('header.php');
    $app->render('content.php', $data);
    $app->render('footer.php');
});

$app->route('/', function () use($app) {
    $data = array(
        'hello' => 'This is front page of your view'
    );
    $app->render('header.php');
    $app->render('content.php', $data);
    $app->render('footer.php');
});

?>