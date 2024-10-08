# Magemontreal PageViewLogger Module

## Description

The **Magemontreal PageViewLogger** module for Magento 2 logs all website page accesses, helping in tracking and analyzing user interactions on your Magento store.

## Features

- Logs all website page accesses.
- Helps in tracking and analyzing user interactions.

## Installation

### Via Composer

To install this module using Composer, follow these steps:

1. **Add the repository to `composer.json`** (if not already added):

    ```sh
   composer config repositories.private-packagist composer https://repo.packagist.com/magemontreal/
   composer config repositories.packagist.org false
   composer config --global --auth http-basic.repo.packagist.com sajidunnar tokenhash (Ask for token)
    ```

2. **Require the module**:

    ```sh
    composer require magemontreal/module-page-view-logger
    ```

3. **Enable the module**:

    ```sh
    bin/magento module:enable Magemontreal_PageViewLogger
    ```

4. **Run setup upgrade**:

    ```sh
    bin/magento setup:upgrade
    ```

5. **Clear the cache**:

    ```sh
    bin/magento cache:clean
    ```

## Configuration

No additional configuration is needed. Once installed and enabled, the module will automatically start logging all page accesses.

## Usage

The module logs all page access information. You can view the logged data in the database or set up custom logging views or reports as needed.

## Support

For support, please contact the author via email sajidunnar@gmail.com


## Author

- **Name**: Sajid Unar
- **Email**: sajidunnar@gmail.com

## Changelog

### 1.0.0
- Initial release of the Magemontreal PageViewLogger module.
