# EasyAdminDashboardBundle

This bundle is an extension for the Easycorp EasyAdminBundle
(the simple Symfony backends administration bundle). It 
allows you to create easily a user-friendly homepage with
some counters, like a dashboard.

![Alt text](/doc/img/dashboard.png?raw=true "Dashboard")

## Requirements

This bundle requires:

    * PHP 8.2 or higher
    * Symfony 6.4 or higher
    * EasyAdmin 4.2x
    
## Installation

Use composer to require the latest stable version.

````bash
$ composer require easyadminfriends/easyadmindashboard-bundle:3.x
````    

Generate dashboard items inside Easyadmin Dashboard Controller
````bash
#App\Controller\Admin\DashboardController
...
use EasyAdminFriends\EasyAdminDashboardBundle\Service\EasyAdminDashboard;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private EasyAdminDashboard $easyAdminDashboard){}

    public function index(): Response
    {
        return $this->render('@EasyAdminDashboard/Default/index.html.twig', [
            'dashboard' => $this->easyAdminDashboard->getDashboard()
        ]);
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
          hierarchy: false
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
          showCount: false
          action: 'detail'
			
````

## Roadmap and Contributions

Contributions are more than welcome. Fork the project, and submit a PR when you're done.

Remaining todos include:

* Tests coverage