<?php
// print_r(apache_get_modules());
// echo "<pre>"; print_r($_SERVER); die;
// $_SERVER["REQUEST_URI"] = str_replace("/phalt/","/",$_SERVER["REQUEST_URI"]);
// $_GET["_url"] = "/";
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Config;
use Phalcon\Escaper;
use Phalcon\Events\Event;
use App\translate\Locale;
use Phalcon\Events\Manager as EventsManager;

include('../vendor/autoload.php');

$config = new Config([]);

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . "/controllers/",
        APP_PATH . "/models/",
    ]
);
$loader->registerClasses(
    [
        'App\Components\Helperclass' => APP_PATH . '/components/Helperclass.php',
        'App\Listener\NotificationListener' => APP_PATH . '/listener/notification.php',
        'App\Models\Products' => APP_PATH . '/models/Products.php',
        'App\translate\Locale' => APP_PATH . "/translate/Locale.php"
    ]
);

$loader->register();

$container = new FactoryDefault();

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);
$container->set('locale', (new Locale())->getTranslator());

$application = new Application($container);
$eventsManager = new EventsManager();
$eventsManager->attach(
    'notifications',
    new App\Listener\NotificationListener()
);
$eventsManager->attach(
    'application:beforeHandleRequest',
    new App\Listener\NotificationListener()
);
$application->setEventsManager($eventsManager);
$container->set('EventManager', $eventsManager);

// $eventsManager->fire('application:beforeHandleRequest', $application);

$container->set(
    'db',
    function () {
        return new Mysql(
            [
                'host'     => 'mysql-server',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'phalcon',
            ]
        );
    }
);
$container->set('escaper', function () {
    $escaper = new Escaper();
    return $escaper;
});
// $container->set(
//     'session',
//     function () {
//         $session = new Manager();
//         $files = new Phalcon\Session\Adapter\Stream(
//             [
//                 'savePath' => '/tmp',
//             ]
//         );

//         $session
//             ->setAdapter($files)
//             ->start();
//         return $session;
//     }
// );
// $container->set(
//     'mongo',
//     function () {
//         $mongo = new MongoClient();

//         return $mongo->selectDB('phalt');
//     },
//     true
// );

try {
    // Handle the request
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
