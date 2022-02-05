# About the project

Recreate the [old pokemon project](https://github.com/Benitorax/pokemon-old) with clean architecture (almost respected, [see below](#directory-structure)), new features and a single page application to act like an mobile application but in a browser.

# Directory structure

There are 3 main directories: Domain, Application, Infrastructure.

## Domain

- Domain doesn't depend on Application and Infrastructure.
- Domain is divided in multiple services (Battle, Tournament, Adventure, Shop, Infirmary, etc) to be able to add / remove feature smootly smoothly. It's an hybryd with monolith and micro-services architectures.
- Domain/Main doesn't depend on other Domain/*Service*. But Domain/*Service* can depend on Domain/Main.

## Application
- Code that links Domain and Symfony framework.
- It can depend on Domain.
- It can implement Symfony components if they don't need to be decoupled from the application.

## Infrastructure
Code that implements libraries which need to be decoupled from the application.

# Clean code

- [PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer): PSR1 and PSR12.
- [PHPStan](https://github.com/phpstan/phpstan): level 8.
- [Psalm](https://github.com/vimeo/psalm) It may need symfony plugin later (https://github.com/psalm/psalm-plugin-symfony): level 1.

# Tests
- [PHPUnit](https://github.com/sebastianbergmann/phpunit)

# Front-end
Still in discussions for the tools: 
- Framework like VueJS / ReactJS : 
    - benefit: a lot of tools and big community.
    - inconvenience: migrations are frequent and difficult. Besides there are's always a new trendy framework (Svelte, ViteJS, NuxtJS, NextJS).
- Symfony UX with Stimulus.
    - benefit: migration is easier.
    - inconvenience: fewer tools and small community.

The code might also be in clean architecture to change framework smoothly if necessary.