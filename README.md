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
$ composer require rogercreasy/chassis-php
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

We follow PSR-2 for coding style, PSR-4 autoloading, and PSR-11 for containers.
We also believe in the use of the Oxford comma (see the above line).  :-)

ChassisPHP is not bound to any particular component. **Whenever possible** component use is written such that it can be replaced with a component of the developer's choosing. i.e. the PHP League Container is default. However, if the developer prefers Pimple, she or he can use it.


## Contributing

1. Fork it!
2. Clone the repo: `git clone [insert link]`
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D
6. ???
7. Profit

## Author

Roger Creasy is the founder of ChassisPHP. [Many community contributors](CONTRIBUTORS.md)

## License
[The MIT License (MIT)](LICENSE)
