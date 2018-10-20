# ChassisPHP
[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg)](./LICENSE)
Pronounced Cha-see <br>
Yes, another PHP framework. The goal with ChassisPHP is to be a framework that simplifies the process of creating a brouchure-type website.
**We are just getting started. This package is not yet production-ready!**
## Getting Started
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.
It's recommended that you use [Composer](https://getcomposer.org/) to install ChassisPHP.
### Prerequisites
* PHP7.1
* Composer
* pdo_sqlite extension
### Installing
```bash
$ composer require rogercreasy/chassis-php:dev-master
```
then go to folder and install your dependency using composer (*eg. `cd ChassisPHP`*)
```bash
$ composer install
```
and start from there - open it in your browser.
### Configuration
The following steps will help you configure your install of ChassisPHP for the first time.
1. Copy the `.env.example` file to `.env` and ensure that it is readable by the web server process. The .env file is pre-populated with a standard configuration for the PDO SQLite extension (pdo_sqlite.)
2. Ensure that your sqlite database is upgraded by running the Doctrine ORM schema update. This can be handled in the following ways:

Unix: `php vendor/bin/doctrine orm:schema-tool:update`

Windows: `php vendor\doctrine\orm\bin\doctrine orm:schema-tool:update` or `vendor\bin\doctrine.bat orm:schema-tool:update`

3. Attempt to login to the `/backend/login` page with the following credentials:

Username: admin@chassis.123

Password: admin

4. After logging in, navigate to `/backend/users` and select "Add User."
5. Specify your name, email, password, and ensure that you set the user level to `1`. It is **very important** that you create your own unique administrator, so that others cannot circumvent the login protection and login using the default information.
6. Delete the default administrator by navigating back to `/backend/users` and selecting "Delete."

### Testing

To run a test, use:

```bash
$ phpunit
```

*if your environment isn't set up yet, find phpunit at `.\vendor\bin\phpunit`*

## Style, etc.

We follow PSR-2 for coding style, PSR-4 autoloading, PSR-7 for messaging, and PSR-11 for containers.
We also believe in the use of the Oxford comma (see the above line).  :-)

ChassisPHP is not bound to any particular component. **Whenever possible** component use is written such that it can be replaced with a component of the developer's choosing. i.e. the PHP League Container is default. However, if the developer prefers Pimple, she or he can use it.


## Contributing

If you are new to the ChassisPHP project, check out our newbie guide - [Contribution guidelines for this project](CONTRIBUTING_NEWBIE.md)

We REALLY do want your help. ChassisPHP has grown into a project with real potential! We try to be a helpful, welcoming, and nurturing community. Please look at the code, try it out, and let us know what you want changed. Make a pull request for the change, if you want.
1. Comment on the issue on which you wish to work (If the issue doesn't exist, create it)
2. Fork it!
3. Clone the repo: `git clone [insert link]`
4. Create your feature branch: `git checkout -b my-new-feature`
5. Commit your changes: `git commit -am 'Add some feature'`
6. Push to the branch: `git push origin my-new-feature`
7. Submit a pull request :D
8. Make any requested changes
9. Profit

## Author

ChassisPHP has a quickly growing community of [contributors](CONTRIBUTORS.md). If you want your name added to that list of contributors, see the "Contributing" section above.<br>
Roger Creasy is the maintainer of the ChassisPHP project, and is its founder.


## License
[The MIT License (MIT)](LICENSE)
