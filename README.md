# Pandora
## Just another MVC framework
===========

The goal: to create a lightweight framework that allows web entities to be rendered and served back to an HTTP client.

The result: Pandora, a small package that simplifies the creation of dynamic web pages by having opinions about where your business logic, data models, and UI assets should live.

First off, take a composer dependency on pandora-mvc:

  {
    "require": {
      "zutto/pandora-mvc": "dev-master"
    }
  }
  
Then, provide Pandora with the runtime configuration it needs in your index.php:

  PageDispatcher::registerLoader( $your_autoloader_for_controllers );
  PageDispatcher::registerLoader( $your_autoloader_for_models );

  EnvironmentFactory::setConfigFile(dirname(__FILE__)."/conf/environment.json");

  FrontController::render(DEFAULT_PAGE, DEFAULT_ACTION);
  
The 3 parts:

1. A classloader for your controllers (and models)
1. A path to your JSON configuration directives that will provide runtime config
1. A call to FrontController::render
