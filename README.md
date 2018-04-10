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

## Usage
documentation in progress



## Roadmap and Contributions

Contributions are more than welcome. Fork the project, and submit a PR when you're done.

Remaining todos include:

* Tests and test coverage
* Improved documentation
