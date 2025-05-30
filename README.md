# Reporter API

[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.1-blue.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-GPL--2.0%2B-green.svg)](LICENSE)

A modern PHP library providing a reporting API for web applications. Designed as PSR-7/PSR-15 middleware that collects and reports application status information including installed packages, repositories, and application metadata.

## Features

- 🚀 **Modern PHP 8.1+** with native enums, constructor property promotion, and strict types
- 📊 **Application Status Reporting** with package information and metadata
- 🔌 **PSR-7/PSR-15 Compatible** middleware for easy integration
- 🎯 **Null Object Pattern** for robust error handling
- 📋 **OpenAPI 3.0 Specification** with complete API documentation
- 🧪 **100% Test Coverage** with PHPUnit 11
- 🔐 **JWT Authentication** support

## Requirements

- **PHP 8.1+** (required for native enum support)
- **Composer** for dependency management
- **PHPUnit 10.5+ or 11.0+** for testing (dev dependency)

## Installation

Install via Composer:

```bash
composer require dwenzel/reporter-api
```

## Quick Start

### Basic Usage as PSR-15 Middleware

```php
<?php

use DWenzel\ReporterApi\Api;
use Psr\Http\Message\ServerRequestInterface;

// Create the API middleware
$reporterApi = new Api();

// Check if the API can handle the request
if ($reporterApi->canHandle($request)) {
    // Process the request and get response
    $response = $reporterApi->process($request, $handler);
}
```

### Using the Report Endpoint Directly

```php
<?php

use DWenzel\ReporterApi\Api;

$api = new Api();
$reportEndpoint = $api->getReportEndpoint();

// Handle a server request
$response = $reportEndpoint->handle($serverRequest);
```

### Working with Application Status

```php
<?php

use DWenzel\ReporterApi\Schema\ApplicationStatus;
use DWenzel\ReporterApi\Schema\Report;

// Create a new report
$report = new Report();

// Set application status using modern PHP enum
$report->setStatus(ApplicationStatus::OK);
$report->setName('My Application');
$report->setApplicationId(12345);

// Get status information
$status = $report->getStatus(); // Returns ApplicationStatus enum
$statusValue = $status->getValue(); // Returns 'ok'
```

## API Endpoints

### GET /api/reporter/v1/application/report

Returns a comprehensive JSON report containing:

- Application metadata (name, ID, status)
- Installed package information with versions
- Repository details
- Status indicators

**Example Response:**

```json
{
  "applicationId": 12345,
  "name": "my-application",
  "status": "ok",
  "packages": [
    {
      "name": "vendor/package",
      "version": "1.0.0",
      "sourceReference": "abc123"
    }
  ],
  "repositories": [
    {
      "type": "git",
      "url": "https://github.com/vendor/package.git"
    }
  ]
}
```

## Architecture

### Core Components

- **`Api`**: Main PSR-15 middleware class with endpoint routing
- **`Endpoint\Report`**: Primary reporting endpoint implementation
- **`Schema\*`**: Data models representing API response structure
- **`Http\*`**: PSR-7 HTTP message implementations

### Design Patterns

- **Endpoint Routing**: Path-based routing with lazy loading
- **Schema Serialization**: JSON serialization via traits
- **Null Object Pattern**: Robust error handling
- **Dependency Integration**: Leverages `cpsit/auditor` for package discovery

## Testing

Run the test suite:

```bash
# Using composer script
composer test

# Using PHPUnit directly
./vendor/bin/phpunit -c tests/Build/UnitTests.xml

# With DDEV (if using Docker development environment)
ddev exec "cd /var/www/html/app/vendor/dwenzel/reporter-api && .build/bin/phpunit -c tests/Build/UnitTests.xml"
```

### Test Coverage

The library maintains 100% test coverage with comprehensive unit tests for all components.

## Configuration

### Custom Endpoint Registration

```php
<?php

use DWenzel\ReporterApi\Api;

$api = new Api();

// The default endpoint map can be extended
// Default: ['/api/reporter/v1/application/report' => Report::class]
```

### JWT Authentication

The API supports JWT token authentication as defined in the OpenAPI specification. Include the `api_key` header in your requests:

```http
GET /api/reporter/v1/application/report
Authorization: Bearer your-jwt-token
```

## Development

### Project Structure

```
src/
├── Api.php                 # Main middleware class
├── Endpoint/              # HTTP endpoint handlers
│   ├── EndpointInterface.php
│   ├── Report.php         # Main reporting endpoint
│   └── NullEndpoint.php   # Null object for unhandled routes
├── Schema/                # Data models
│   ├── ApplicationStatus.php  # PHP 8.1 enum
│   ├── Report.php
│   ├── Package.php
│   └── ...
├── Http/                  # PSR-7 implementations
│   ├── JsonResponse.php
│   ├── AbstractMessage.php
│   └── ...
└── Traits/                # Reusable functionality
    ├── JsonSerialize.php
    └── ToArray.php
```

### Modern PHP Features

This library showcases modern PHP development practices:

- **Native Enums** (PHP 8.1): `ApplicationStatus` enum with string backing
- **Constructor Property Promotion** (PHP 8.0): Clean, concise constructors
- **Typed Properties** (PHP 7.4): All properties are strictly typed
- **Strict Types**: Enabled across the entire codebase
- **Union Types**: Used where appropriate for flexibility

### Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Make your changes with proper tests
4. Ensure all tests pass (`composer test`)
5. Commit your changes (`git commit -m 'Add amazing feature'`)
6. Push to the branch (`git push origin feature/amazing-feature`)
7. Open a Pull Request

### Code Standards

- PHP 8.1+ with strict types
- PSR-4 autoloading
- PSR-7/PSR-15 compliance
- 100% test coverage
- Modern PHP conventions

## API Documentation

Complete API documentation is available in the OpenAPI 3.0 specification:

- **OpenAPI Spec**: [`reporterApi.yaml`](reporterApi.yaml)
- **Interactive Documentation**: Use tools like Swagger UI to explore the API

## License

This project is licensed under the GPL-2.0+ License - see the [LICENSE](docs/MIT-LICENSE) file for details.

## Authors

- **Dirk Wenzel** - *Initial work and maintenance*

## Dependencies

### Runtime Dependencies

- **PHP 8.1+**: Core language requirement
- **cpsit/auditor**: Package information gathering
- **web-token/jwt-framework**: JWT token handling

### Development Dependencies

- **PHPUnit 10.5+/11.0+**: Testing framework
- **roave/security-advisories**: Security vulnerability monitoring

## Changelog

See [ChangeLog](ChangeLog) for a detailed history of changes and improvements.

---

**Need help?** Open an issue on GitHub or check the OpenAPI specification for detailed API documentation.