<?php

// bootstrap.php

use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use UMA\DIC\Container;
use Slim\Views\Twig;
use App\Controller\UserController;
use App\Services\UserService;
use App\Controller\AccueilController;
use App\Controller\GameController;
use App\Services\GameService;
use App\Services\ConditionService;

require_once __DIR__ . '/vendor/autoload.php';

$container = new Container(require __DIR__ . '/settings.php');

$container->set(EntityManager::class, static function (Container $c): EntityManager {
    /** @var array $settings */
    $settings = $c->get('settings');

    // Use the ArrayAdapter or the FilesystemAdapter depending on the value of the 'dev_mode' setting
    // You can substitute the FilesystemAdapter for any other cache you prefer from the symfony/cache library
    $cache = $settings['doctrine']['dev_mode'] ?
        DoctrineProvider::wrap(new ArrayAdapter()) :
        DoctrineProvider::wrap(new FilesystemAdapter(directory: $settings['doctrine']['cache_dir']));

    $config = Setup::createAttributeMetadataConfiguration(
        $settings['doctrine']['metadata_dirs'],
        $settings['doctrine']['dev_mode'],
        null,
        $cache
    );

    return EntityManager::create($settings['doctrine']['connection'], $config);
});


$container->set('view', function () {
    $twig = Twig::create('../templates', ['debug' => true]);
	$twig->addExtension(new \Twig\Extension\DebugExtension());
	return $twig;
});


$container->set(UserService::class, static function (Container $c) {
    return new UserService($c->get(EntityManager::class));
});

$container->set(GameService::class, static function (Container $c) {
    return new GameService($c->get(EntityManager::class));
});

$container->set(ConditionService::class, static function (Container $c) {
    return new ConditioNService($c->get(EntityManager::class));
});

$container->set(UserController::class, static function (ContainerInterface $container) {
    $view = $container->get('view');
    return new UserController($view, $container->get(UserService::class));
});

$container->set(AccueilController::class, static function (ContainerInterface $container) {
    $view = $container->get('view');
    return new AccueilController($view);
});

$container->set(GameController::class, static function (ContainerInterface $container) {
    $view = $container->get('view');
    return new GameController($view,$container->get(GameService::class),$container->get(ConditionService::class),$container->get(EntityManager::class));
});





return $container;