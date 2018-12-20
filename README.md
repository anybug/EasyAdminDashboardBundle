# EasyAdminDashboardBundle

This bundle is an extension for the Easycorp EasyAdminBundle
(the simple Symfony backends administration bundle). It 
allows you to create easily a user-friendly homepage with
some counters, like a dashboard.

## Requirements

This bundle requires, in addition to prerequisites of each PHPOffice library:

    * PHP 5.6 or higher
    * Symfony 2.7, 3.0
    
## Installation

Use composer to require the latest stable version.

````bash
$ composer require easyadminfriends/easyadmindashboard-bundle
````

Then enable the bundle in your `AppKernel.php` file.

````php
$bundles = array(
    [...]
    new EasyAdminFriends\EasyAdminDashboardBundle\EasyAdminDashboardBundle(),
);
````
Then add easy_admin_dashboard route. This example includes /backend prefix but you can change it to fit your application route:
````bash
#app/config/routing.yml

easy_admin_dashboard:
    resource: "@EasyAdminDashboardBundle/Resources/config/routing.yml"
    prefix:   /backend/dashboard
````

## Usage
documentation in progress
full example:
````bash
#app/config/config.yml

easy_admin_dashboard:
    title: "Welcome to backend"
    template: '@Backend/Default/layout.html.twig'
    blocks:
      Bloc1:
        label: Products
        size: 12
        css_class: primary
        items:
          Item1:
            label: "Active products in catalog"
            size: 3
            css_class: aqua
            class: BackendBundle\Entity\Product
            dql_filter: "entity.is_active = 1"
            icon:  shopping-cart
            link_label: "Product list"
          Item2:
            label: "Categories"
            size: 3
            css_class: green
            class: BackendBundle\Entity\Category
            entity: Category
            icon:  list-ul
            link_label: "Category list"
````

## Roadmap and Contributions

Contributions are more than welcome. Fork the project, and submit a PR when you're done.

Remaining todos include:

* Tests coverage
* Improved documentation
