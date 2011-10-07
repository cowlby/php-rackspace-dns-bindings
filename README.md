PHP Rackspace Cloud DNS Bindings
================================

This library contains PHP bindings for the Rackspace Cloud DNS API

Please visit the [](http://www.rackspace.com/cloud/cloud_hosting_products/dns/)
homepage for more information about the Rackspace Cloud DNS system.


Requirements
--------------------------------

- PHP 5.3+
- One of the following 3rd party libraries for the Http\Client component:
    * [Zend Framework 2.0+](https://github.com/zendframework/zf2)
- One of the following 3rd party components for the Storage component:
    * [Memcached Extension](http://us.php.net/memcached)
    * [Memcache Extension](http://us.php.net/memcache)
    * [Symfony HttpFoundation 2.0+](https://github.com/symfony/HttpFoundation)


Install
--------------------------------

### Installing from Git ###

It is possible to download and install the Bindings directly from GitHub.
Just go to the [repository home page](http://github.com/pradador/php-rackspace-dns-bindings)
and click the "Download" button.

#### Cloning the Repository ####

The repository can be cloned from [](https://github.com/pradador/php-rackspace-dns-bindings.git).

You will need to have `git` installed before you can use the `git clone`
command or use your favorite Git GUI.

    git clone https://github.com/pradador/php-rackspace-dns-bindings.git
    cd php-rackspace-dns-bindings
    git submodule init
    git submodule update

### Including the Library ###

#### Using the Symfony ClassLoader submodule. ####

Copy the `autoload.php.dist` file to `autoload.php` and configure it according
to your environmentand. Include it in your scripts as 
 
    require_once '/path/to/autoload.php'
    
#### Using Other Autoloaders ####

The library follows the standards described in the [PSR-0 Proposal](https://gist.github.com/1234504/).
Any class autoloader that follows these conventions will be able to load the
library by pointing the `Prado` namespace to the `src` folder.


Usage
--------------------------------

API interaction is managed through the Cloud DNS Service Container. Entity
managers are created via this service which in turn give you access to the
API resources.

    require_once '/path/to/autoload.php'
    
    use Prado\Rackspace\DNS\ServiceContainer;
    
    $service = new ServiceContainer('your-username', 'your-apiKey');
    
    // Find an entity
    $em = $service->createDomainManager();
    $domain = $em->find('domainId');

    // Getting list of entities
    $em = $service->createAsynchResponseManager();
    $list = $em->createList();

The resources returned are modeled by the Entity classes. These are simple
light-weight containers the represent the resources and allow easy creation
and modification.

    // Creating a Domain entity
    $domain = new Domain();
    $domain->setName('example.com');
    $domain->setEmailAddress('admin@example.com');
    $domain->setTtl(3600);
    
Persisting and updating these objects to the Cloud DNS service is done via the
entity managers.

    // Persisting an Entity
    $em = $service->createDomainManager();
    $asynchResponse = $em->create($domain);
    
    // $asynchResponse is an AsynchResponse entity
    $asynchResopnse->getJobId();       // e63886c9-acf0-4e5d-8023-09a0fae37446
    $asynchResponse->getStatus();      // RUNNING, COMPLETED, etc.
    $asynchResponse->getCallbackUrl(); // https://dns.api.rackspacecloud.com/v1.0/1234/status/e63886c9-acf0-4e5d-8023-09a0fae37446
    
    // Updating an Entity
    $em = $service->createDomainManager();
    $domain = $em->find('domainId');
    
    $domain->setTtl(14400);
    $domain->setEmailAddress('helpdesk@example.com');
    
    $asynchResponse = $em->update($domain);
