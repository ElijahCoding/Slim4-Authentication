<?php

$container->addServiceProvider(
    new \App\Providers\ViewServiceProvider(
        $app->getRouteCollector()->getRouteParser()
    )
);

$container->addServiceProvider(
    new \App\Providers\FlashServiceProvider(

    )
);