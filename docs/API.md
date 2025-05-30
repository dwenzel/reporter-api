# API Documentation

This document provides comprehensive documentation for the Reporter API classes and methods.

## Table of Contents

- [Core Classes](#core-classes)
  - [Api](#api)
  - [Endpoint Classes](#endpoint-classes)
  - [Schema Classes](#schema-classes)
  - [HTTP Classes](#http-classes)
- [Traits](#traits)
- [Enums](#enums)
- [Usage Examples](#usage-examples)

## Core Classes

### Api

The main PSR-15 middleware class that handles request routing and endpoint management.

**Namespace:** `DWenzel\ReporterApi\Api`

#### Properties

| Property | Type | Description |
|----------|------|-------------|
| `$endpointMap` | `array` | Maps route paths to endpoint classes |
| `$endpointCache` | `array` | Cached endpoint instances for performance |

#### Methods

##### `__construct()`

Creates a new Api instance with default endpoint mapping.

```php
public function __construct()
```

##### `canHandle(RequestInterface $request): bool`

Determines if the API can handle the given request.

```php
public function canHandle(RequestInterface $request): bool
```

**Parameters:**
- `$request` - PSR-7 request interface

**Returns:** `bool` - True if the request can be handled

##### `getReportEndpoint(): EndpointInterface`

Gets the report endpoint instance.

```php
public function getReportEndpoint(): EndpointInterface
```

**Returns:** `EndpointInterface` - The report endpoint

**Throws:** `InvalidClass` - If endpoint class is invalid

##### `process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface`

Processes an incoming server request (PSR-15 middleware interface).

```php
public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
```

**Parameters:**
- `$request` - PSR-7 server request
- `$handler` - Request handler

**Returns:** `ResponseInterface` - HTTP response

---

## Endpoint Classes

### EndpointInterface

Interface defining the contract for all endpoint implementations.

**Namespace:** `DWenzel\ReporterApi\Endpoint\EndpointInterface`

#### Methods

##### `handle(ServerRequestInterface $request): ResponseInterface`

Handles a request and produces a response.

```php
public function handle(ServerRequestInterface $request): ResponseInterface
```

### Report

Main reporting endpoint that generates application status reports.

**Namespace:** `DWenzel\ReporterApi\Endpoint\Report`

#### Methods

##### `handle(ServerRequestInterface $request): ResponseInterface`

Generates and returns a comprehensive application report.

```php
public function handle(ServerRequestInterface $request): ResponseInterface
```

**Returns:** `JsonResponse` containing:
- Application metadata
- Installed packages with versions
- Repository information
- Application status

##### `getPackages(): array`

Retrieves all installed packages.

```php
protected function getPackages(): array
```

**Returns:** `Package[]` - Array of Package objects

### NullEndpoint

Null object implementation for unhandled routes.

**Namespace:** `DWenzel\ReporterApi\Endpoint\NullEndpoint`

---

## Schema Classes

### ApplicationStatus

PHP 8.1 enum representing application status values.

**Namespace:** `DWenzel\ReporterApi\Schema\ApplicationStatus`

#### Cases

| Case | Value | Description |
|------|-------|-------------|
| `UNKNOWN` | `'unknown'` | Status is unknown |
| `OK` | `'ok'` | Application is running normally |
| `ERROR` | `'error'` | Application has errors |
| `WARNING` | `'warning'` | Application has warnings |

#### Methods

##### `getValue(): string`

Gets the string value of the enum case.

```php
public function getValue(): string
```

##### `default(): self`

Returns the default status (UNKNOWN).

```php
public static function default(): self
```

### Report

Main report data model containing application information.

**Namespace:** `DWenzel\ReporterApi\Schema\Report`

#### Properties

| Property | Type | Description |
|----------|------|-------------|
| `$applicationId` | `int` | Application identifier |
| `$name` | `string` | Application name |
| `$status` | `ApplicationStatus` | Current application status |
| `$packages` | `array` | Installed packages |
| `$repositories` | `array` | Repository information |
| `$tags` | `array` | Application tags |

#### Methods

##### Constructor

```php
public function __construct()
```

Creates a new Report with default status (UNKNOWN).

##### Getters and Setters

```php
public function getApplicationId(): int
public function setApplicationId(int $applicationId): Report

public function getName(): string
public function setName(string $name): Report

public function getStatus(): ApplicationStatus
public function setStatus(ApplicationStatus $status): Report

public function getPackages(): array
public function setPackages(array $packages): Report

public function getRepositories(): array
public function setRepositories(array $repositories): Report
```

### Package

Represents an installed package with version and source information.

**Namespace:** `DWenzel\ReporterApi\Schema\Package`

#### Constructor Property Promotion

```php
public function __construct(
    protected string $name = '',
    protected string $version = '',
    protected string $sourceReference = '',
    protected PackageSource $source = new NullPackageSource()
)
```

#### Properties

| Property | Type | Description |
|----------|------|-------------|
| `$name` | `string` | Package name |
| `$version` | `string` | Package version |
| `$type` | `string` | Package type |
| `$sourceReference` | `string` | Source reference (commit hash, etc.) |
| `$source` | `PackageSource` | Package source information |

#### Methods

```php
public function getName(): string
public function setName(string $name): void

public function getVersion(): string
public function setVersion(string $version): void

public function getType(): string
public function setType(string $type): void

public function getSource(): PackageSource
public function setSource(PackageSource $source): void

public function getSourceReference(): string
public function setSourceReference(string $sourceReference): void
```

### PackageSource

Contains source repository information for a package.

**Namespace:** `DWenzel\ReporterApi\Schema\PackageSource`

#### Constructor Property Promotion

```php
public function __construct(
    protected string $url = '',
    protected string $type = '',
    protected string $reference = ''
)
```

#### Methods

```php
public function getUrl(): string
public function setUrl(string $url): void

public function getType(): string
public function setType(string $type): void

public function getReference(): string
public function setReference(string $reference): void
```

### Repository

Represents a repository containing packages.

**Namespace:** `DWenzel\ReporterApi\Schema\Repository`

#### Constructor Property Promotion

```php
public function __construct(
    protected string $type = '',
    protected string $url = '',
    protected ?Package $package = null
)
```

#### Methods

```php
public function getType(): string
public function setType(string $type): void

public function getUrl(): string
public function setUrl(string $url): void

public function getPackage(): ?Package
public function setPackage(?Package $package): void
```

### Tag

Represents a tag associated with an application.

**Namespace:** `DWenzel\ReporterApi\Schema\Tag`

#### Constructor Property Promotion

```php
public function __construct(
    protected int $id = 0,
    protected string $name = ''
)
```

#### Methods

```php
public function getId(): int
public function setId(int $id): void

public function getName(): string
public function setName(string $name): void
```

### Category

Represents a category for organizing applications.

**Namespace:** `DWenzel\ReporterApi\Schema\Category`

#### Properties

```php
protected int $id = 0;
protected string $name = '';
```

#### Methods

```php
public function getId(): int
public function setId(int $id): void

public function getName(): string
public function setName(string $name): void
```

### Null Object Classes

#### NullPackage

Null object implementation of Package that returns empty values.

**Namespace:** `DWenzel\ReporterApi\Schema\NullPackage`

#### NullPackageSource

Null object implementation of PackageSource that returns empty values.

**Namespace:** `DWenzel\ReporterApi\Schema\NullPackageSource`

---

## HTTP Classes

### JsonResponse

PSR-7 compliant JSON response implementation.

**Namespace:** `DWenzel\ReporterApi\Http\JsonResponse`

#### Constructor

```php
public function __construct(
    mixed $body = '',
    int $statusCode = 200,
    array $headers = []
)
```

**Parameters:**
- `$body` - Any JSON-encodable value
- `$statusCode` - HTTP status code (default: 200)
- `$headers` - Additional headers

**Throws:** `RuntimeException` if JSON encoding fails

### AbstractMessage

Base class for PSR-7 message implementations.

**Namespace:** `DWenzel\ReporterApi\Http\AbstractMessage`

### Response

PSR-7 HTTP response implementation.

**Namespace:** `DWenzel\ReporterApi\Http\Response`

### Stream

PSR-7 stream implementation.

**Namespace:** `DWenzel\ReporterApi\Http\Stream`

---

## Traits

### JsonSerialize

Provides JSON serialization capabilities to schema classes.

**Namespace:** `DWenzel\ReporterApi\Traits\JsonSerialize`

#### Methods

##### `jsonSerialize(): mixed`

Implements JsonSerializable interface.

```php
public function jsonSerialize(): mixed
```

### ToArray

Converts objects to arrays for serialization.

**Namespace:** `DWenzel\ReporterApi\Traits\ToArray`

#### Methods

##### `toArray(int $depth = 100, ?array $mapping = null): array`

Converts object to array representation.

```php
public function toArray(int $depth = 100, ?array $mapping = null): array
```

**Parameters:**
- `$depth` - Maximum recursion depth
- `$mapping` - Property mapping configuration

---

## Usage Examples

### Creating a Complete Report

```php
use DWenzel\ReporterApi\Schema\{Report, ApplicationStatus, Package, Repository};

// Create report
$report = new Report();
$report->setApplicationId(12345)
       ->setName('My Application')
       ->setStatus(ApplicationStatus::OK);

// Add packages
$package = new Package('vendor/package', '1.0.0', 'abc123');
$report->setPackages([$package]);

// Add repositories
$repository = new Repository('git', 'https://github.com/vendor/repo.git');
$report->setRepositories([$repository]);

// Get JSON representation
$json = json_encode($report);
```

### Using the API Middleware

```php
use DWenzel\ReporterApi\Api;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

$api = new Api();

// In your middleware stack
function middleware(ServerRequestInterface $request, RequestHandlerInterface $handler) use ($api) {
    if ($api->canHandle($request)) {
        return $api->process($request, $handler);
    }
    
    return $handler->handle($request);
}
```

### Working with Application Status

```php
use DWenzel\ReporterApi\Schema\ApplicationStatus;

// Using enum cases
$status = ApplicationStatus::OK;
$value = $status->getValue(); // 'ok'

// Using from method (built-in enum method)
$status = ApplicationStatus::from('error');

// Using default
$defaultStatus = ApplicationStatus::default(); // UNKNOWN
```

---

## Error Handling

### Exception Classes

#### InvalidClass

Thrown when an invalid endpoint class is encountered.

**Namespace:** `DWenzel\ReporterApi\Exception\InvalidClass`

### Null Object Pattern

The library uses the Null Object pattern extensively to avoid null pointer exceptions:

- `NullEndpoint` for unhandled routes
- `NullPackage` for missing package information
- `NullPackageSource` for missing source information

This ensures graceful degradation and prevents runtime errors.

---

## Serialization

All schema classes implement JSON serialization through:

1. `JsonSerializable` interface implementation
2. `ToArray` trait for array conversion
3. `SERIALIZABLE_PROPERTIES` constants defining which properties to include

### Example Serialization Configuration

```php
class Package {
    public const SERIALIZABLE_PROPERTIES = [
        'name',
        'version',
        'sourceReference',
    ];
}
```

This approach provides fine-grained control over what data is exposed in API responses.