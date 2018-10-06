# ChassisPHP
[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg)](./LICENSE)
Pronounced Cha-see <br>
Yes, another PHP framework. The goal with ChassisPHP is to be a framework that simplifies the process of creating a brouchure-type website.
**We are just getting started. This package is not yet production-ready!**
## Getting Started
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.
It's recommended that you use [Composer](https://getcomposer.org/) to install ChassisPHP.
### Prerequisites
* PHP7
* Composer
* Nodejs/ NPM (Node Package Manager)
### Installing
```bash
$ composer require rogercreasy/chassis-php:dev-master
```
then go to folder and install your dependency using composer (*eg. `cd ChassisPHP`*)
```bash
$ composer install
```
```bash
$ npm install
```
and start from there - open it in your browser.

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
