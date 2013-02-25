# Pandora
## Just another MVC framework
===========

The goal: to create a lightweight framework that allows web entities to be rendered and served back to an HTTP client.

The result: Pandora, a small package that simplifies creation of dynamic web pages by assuming things about where your site's assets live.

### Set-up

Take a composer dependency on pandora-mvc:

    {
        "require": {
            "zutto/pandora-mvc": "dev-master"
        }
    }

### Configure
  
Provide Pandora with the runtime configuration it needs in your index.php:

    PageDispatcher::registerLoader( $your_autoloader_for_controllers );
    PageDispatcher::registerLoader( $your_autoloader_for_models );

    EnvironmentFactory::setConfigFile(dirname(__FILE__)."/conf/environment.json");

    FrontController::render(DEFAULT_PAGE, DEFAULT_ACTION);
  
The 3 parts:

1. A classloader for your controllers (and models)
1. A path to your JSON configuration directives that will provide runtime config
1. A call to FrontController::render

### Serve

Your controllers will simply be generic classes where each method is mapped to a page. 

When a page is requested, the lifecycle looks like this:

1. The appropriate controller is loaded according to the autoloader you've configured
1. An instance of it is created and injected with a Request and Model objects
1. An appropriate view is loaded according to the Accept-Type of the request
1. The page method is called and its return value is exposed to the view
1. Viola!

### Example

Here's an example of a controller for an operation that gives a formatted date:

    class TimeController {
        protected $request;
    
        public function __construct( Request $request ) {
            $this->request = $request;
        }
    
        public function format() {
            $fmt = $this->request->get('format', 'You must specify a date format');
        
            return array (
                'timestamp' => date($fmt)
            );
        }
    }
    
If you've set up a configuration like the one in the section above, TimeController::format() will be called whenever someone sends a request to:

    index.php?page=time&action=format
    
By accessing that URL, Pandora will execute the format method and try to load a view file in views/time/method.html.php--or method.json.php if the request specified application/json as the Accept-type.
