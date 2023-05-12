# EasyAdminDashboardBundle

This bundle is an extension for the Easycorp EasyAdminBundle
(the simple Symfony backends administration bundle). It 
allows you to create easily a user-friendly homepage with
some counters, like a dashboard.

![Alt text](/doc/img/dashboard.png?raw=true "Dashboard")

## Requirements

This bundle requires, in addition to prerequisites of each PHPOffice library:

    * PHP 8.0 or higher
    * Symfony 5.3 or higher
    * EasyAdmin 3 or 4
    
## Installation

Use composer to require the latest stable version.

````bash
$ composer require easyadminfriends/easyadmindashboard-bundle:2.x
````

Enable the bundle in your `config/bundles.php` file.

````php
return [
    [...]
    EasyAdminFriends\EasyAdminDashboardBundle\EasyAdminDashboardBundle::class => ['all' => true],
];
````

Add Dashboard service :
````bash
#config/services.yaml
services:

    EasyAdminFriends\EasyAdminDashboardBundle\Controller\DefaultController:
        public: true
        tags: ['doctrine']
````          

Generate dashboard items inside Easyadmin Dashboard Controller
````bash
#App\Controller\Admin\DashboardController
...
use EasyAdminFriends\EasyAdminDashboardBundle\Controller\DefaultController as EasyAdminDashboard;

class DashboardController extends AbstractDashboardController
{
    private $easyAdminDashboard;

    public function __construct(EasyAdminDashboard $easyAdminDashboard)
    {
        $this->easyAdminDashboard = $easyAdminDashboard;
    }

    public function index(): Response
    {
        return $this->render('@EasyAdminDashboard/Default/index.html.twig', array(
            'dashboard' => $this->easyAdminDashboard->generateDashboardValues(),
            'layout_template_path' => $this->easyAdminDashboard->getLayoutTemplate()
        ));
    }

    public function configureCrud(): Crud
    {
		...
    }
...
````   

## Usage
documentation in progress
full example:
````bash
#config/packages/easy_admin_dashboard.yaml

parameters:
  easy_admin_dashboard:
    title: "Welcome to backend"
    blocks:
      Bloc1:
        label: Products
        size: 12
        css_class: primary
        permissions: ['ROLE_USER']
        items:
          Product:
            label: "Active products in catalog"
            size: 3
            css_class: success text-dark
	    class: App\Entity\Product
            controller: App\Controller\Admin\ProductCrudController
            icon:  shopping-cart
            link_label: "Product list"
            permissions: ['ROLE_ADMIN']
	    query: MyCustomQuery
          ProductCategory:
            label: "Categories"
            size: 3
            css_class: green
            class: App\Entity\Category
            controller: App\Controller\Admin\ProductCategoryCrudController
            icon:  list-ul
            link_label: "Category list"
	    permissions: ['ROLE_ADMIN']
	    dql_filter: "entity.is_active = 1"
			
````

## Roadmap and Contributions

Contributions are more than welcome. Fork the project, and submit a PR when you're done.

Remaining todos include:

* Tests coverage
* Improved documentation
