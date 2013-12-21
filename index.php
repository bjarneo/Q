<?php
/**
 * Example index.php
 */
// Get Q
require('framework/Q.php');

// Create new instance of Q
$app = new Q(array(
    'mode' => 'development',         // 'production' for no error messages
    'view_path' => './app/View/'    // Set view folder.
));

$app->route('/', function () use($app) {
    $data = array(
        'hello' => 'Welcome to Q PHP framework.',
        'lead' => 'Use this framework as you wish. Need Twitter Bootstrap? Already implemented! <br />
        <a href="https://github.com/bjarneo/Q" target="_blank">Fork Q framework at github!</a>'
    );
    $app->render('header.php');
    $app->render('content.php', $data);
    $app->render('footer.php');
});

// Add your route. use($app) if you need to add the object to the anonymous function
$app->route('/code', function () use($app) {
    // Data we append to our view file.
    $data = array(
        'hello' => 'Code example: ',
        'lead' => '<pre>
                    // This is how you add a new url to your site<br />
                    $app->route("/hello", function () {<br />
                    &nbsp;&nbsp;&nbsp;echo "Hello World";<br />
                    });<br />
                   </pre>'
    );

    // render view files
    $app->render('header.php');
    $app->render('content.php', $data);
    $app->render('footer.php');
});

$app->route('/about', function () use($app) {
    $data = array(
        'hello' => 'About Bjarne Øverli',
        'lead' => 'Coming...meanwhile checkout my <a href="http://www.codephun.com" target="_blank">blog</a> or <a href="//www.twitter.com/bjarneo_" target="_blank">twitter</a>!'
    );

    // render view files
    $app->render('header.php');
    $app->render('content.php', $data);
    $app->render('footer.php');
});

//Ex domain.com/language/1 (function($id) $id == 1)
$app->route('/language', function ($id) {
    $res = array();
    switch($id) {
        case 1:
            $res[] = array('language' => 'PHP');
            break;
        case 2:
            $res[] = array('language' => 'JavaScript');
            break;
        case 3:
            $res[] = array('language' => 'C');
            break;
        default:
            $res[] = array('error' => 'no language found');
    }
    echo json_encode($res);
    header('Content-Type: application/json');
});

// Param test. ex: domain.com/params/test1/test2/test3
$app->route('/params', function ($param, $param2, $param3) {
    printf("Param 1: %s <br />", $param);
    printf("Param 2: %s <br />", $param2);
    printf("Param 3: %s <br />", $param3);
});

$app->run();
?>