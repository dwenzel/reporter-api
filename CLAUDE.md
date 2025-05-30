# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a PHP library providing a reporting API for web applications. It's designed as PSR-7/PSR-15 middleware that collects and reports application status information including installed packages, repositories, and application metadata.

The library integrates with the `cpsit/auditor` package to gather package information and uses JWT tokens for authentication.

## Development Commands

### Testing

```bash
# Run all unit tests
composer test

# Run tests with PHPUnit configuration
ddev exec "cd /var/www/html/app/vendor/dwenzel/reporter-api && .build/bin/phpunit -c tests/Build/UnitTests.xml"

# Run tests with coverage (requires PHPUnit configuration)
phpunit -c tests/Build/UnitTests.xml
```

### Dependencies

```bash
# Install dependencies
composer install

# Dependencies are installed to custom paths:
# - Vendor: .build/vendor
# - Binaries: .build/bin
```

### Requirements

- **PHP 8.1+**: Required for native enum support and modern PHP features
- **PHPUnit 10.5+ or 11.0+**: For modern unit testing

## Architecture

### Core Components

- **Api.php**: Main middleware class implementing PSR-15 MiddlewareInterface
- **Endpoint/**: HTTP endpoint handlers
  - `Report.php`: Main reporting endpoint at `/api/reporter/v1/application/report`
  - `EndpointInterface.php`: Contract for endpoint implementations
  - `NullEndpoint.php`: Null object pattern for unhandled routes

### Data Layer

- **Schema/**: Data models representing the API response structure
  - `Report.php`: Main report aggregate containing application metadata
  - `Package.php`: Represents installed packages with version and source info
  - `Repository.php`, `Category.php`, `Tag.php`: Supporting entities

### HTTP Layer

- **Http/**: PSR-7 message implementations
  - `JsonResponse.php`: JSON response implementation
  - `AbstractMessage.php`, `Response.php`: Base HTTP message classes
  - `Stream.php`: PSR-7 stream implementation

### Key Patterns

- **Endpoint Routing**: Path-based routing in `Api::$endpointMap` with lazy loading
- **Schema Serialization**: All schema classes use `JsonSerialize` and `ToArray` traits
- **Null Object Pattern**: Used extensively (NullEndpoint, NullPackage, NullPackageSource)
- **Dependency Integration**: Leverages `CPSIT\Auditor` for package discovery
- **Modern PHP**: Uses PHP 8.1+ features including native enums, constructor property promotion, and strict types

### API Specification

The API follows OpenAPI 3.0 specification defined in `reporterApi.yaml`. The main endpoint returns JSON reports containing:
- Application metadata (name, ID, status)
- Installed package information
- Repository details
- Tags and categories

Authentication is handled via API key in headers as defined in the OpenAPI spec.