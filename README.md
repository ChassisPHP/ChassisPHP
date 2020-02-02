## ATTENTION!<br>
Beginning with version 0.5.0 There is a separation between the framework and developerland. We have developed a skeleton app which uses the new version. This skeleton is available in the repo ChassisPHP/ChassisPHP-skeleton.<br><br>
# ChassisPHP
[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg)](./LICENSE)
Pronounced Cha-see <br>
Yes, another PHP framework. The goal with ChassisPHP is to be a framework that simplifies the process of creating a brochure-type website.
Be sure to visit our new site [ChassisPHP.com](https://chassisphp.com/) It is very new and needs additional info. We would love your help wita the docs! See the repo at [ChassisPHP-site repo](https://github.com/ChassisPHP/ChassisPHP-Website).
**We are just getting started. This package is in beta. Use in production with caution**
## Getting Started
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.
It's recommended that you use [Composer](https://getcomposer.org/) to install ChassisPHP.
### Prerequisites
* PHP >= 7.1
* Composer
* pdo_sqlite extension
### Installing
* create a directory for your project
* from the directory above the project directory, run
```bash
  composer create-project -s dev rogercreasy/chassis-php [project directory name]
```
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

If you are new to the ChassisPHP project, check out our newbie guide - [Contribution guidelines for this project](CONTRIBUTING_NEWBIE.md). Also be sure to read through our [Code of Conduct](CODE_OF_CONDUCT.md)

We REALLY do want your help. ChassisPHP has grown into a project with real potential! We try to be a helpful, welcoming, and nurturing community. Please look at the code, try it out, and let us know what you want changed. Make a pull request for the change, if you want.
1.  Comment on the issue on which you wish to work (If the issue doesn't exist, create it)
2.  Fork it!
3.  Clone the repo: `git clone https://github.com/RogerCreasy/ChassisPHP.git`
4.  Switch to the current active development branch - currently 0.1.x
5.  Create your feature branch: `git checkout -b my-new-feature`
6.  Commit your changes: `git commit -am 'Add some feature'`
7.  Push to the branch: `git push origin my-new-feature`
8.  Submit a pull request :D
9.  Make any requested changes
10. Profit

## Author

ChassisPHP has a quickly growing community of [contributors](CONTRIBUTORS.md). If you want your name added to that list of contributors, see the "Contributing" section above.<br>
Roger Creasy is the maintainer of the ChassisPHP project, and is its founder.


## License
[The MIT License (MIT)](LICENSE)
