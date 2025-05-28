# Usage Examples

This document provides practical examples of using the Reporter API in various scenarios.

## Table of Contents

- [Basic Setup](#basic-setup)
- [Middleware Integration](#middleware-integration)
- [Creating Reports](#creating-reports)
- [Working with Packages](#working-with-packages)
- [Status Management](#status-management)
- [Custom Implementations](#custom-implementations)
- [Framework Integration](#framework-integration)

## Basic Setup

### Simple API Usage

```php
<?php

require_once 'vendor/autoload.php';

use DWenzel\ReporterApi\Api;
use DWenzel\ReporterApi\Http\JsonResponse;

// Create API instance
$api = new Api();

// Create a mock request (in real applications, this comes from your framework)
$request = /* Your PSR-7 ServerRequest */;

// Check if API can handle the request
if ($api->canHandle($request)) {
    $response = $api->process($request, $handler);
    
    // Output JSON response
    echo $response->getBody();
}
```

### Direct Endpoint Usage

```php
<?php

use DWenzel\ReporterApi\Api;

$api = new Api();
$reportEndpoint = $api->getReportEndpoint();

// Create a server request for the report endpoint
$request = /* Your PSR-7 ServerRequest for /api/reporter/v1/application/report */;

$response = $reportEndpoint->handle($request);
```

## Middleware Integration

### PSR-15 Middleware Stack

```php
<?php

use DWenzel\ReporterApi\Api;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;

class ReporterMiddleware implements MiddlewareInterface
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function process(
        ServerRequestInterface $request, 
        RequestHandlerInterface $handler
    ): ResponseInterface {
        // Check if this is a reporter API request
        if ($this->api->canHandle($request)) {
            return $this->api->process($request, $handler);
        }

        // Pass through to next middleware
        return $handler->handle($request);
    }
}
```

### Slim Framework Integration

```php
<?php

use Slim\Factory\AppFactory;
use DWenzel\ReporterApi\Api;

$app = AppFactory::create();

// Add reporter API middleware
$app->add(function ($request, $handler) {
    $api = new Api();
    
    if ($api->canHandle($request)) {
        return $api->process($request, $handler);
    }
    
    return $handler->handle($request);
});

$app->run();
```

### Laravel Integration

```php
<?php

namespace App\Http\Middleware;

use Closure;
use DWenzel\ReporterApi\Api;
use Illuminate\Http\Request;

class ReporterApiMiddleware
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function handle(Request $request, Closure $next)
    {
        // Convert Laravel request to PSR-7 (using bridge)
        $psrRequest = /* Convert to PSR-7 */;
        
        if ($this->api->canHandle($psrRequest)) {
            $response = $this->api->process($psrRequest, /* handler */);
            // Convert PSR-7 response back to Laravel response
            return /* Convert response */;
        }

        return $next($request);
    }
}
```

## Creating Reports

### Basic Report Creation

```php
<?php

use DWenzel\ReporterApi\Schema\Report;
use DWenzel\ReporterApi\Schema\ApplicationStatus;

// Create a new report
$report = new Report();

// Set basic information
$report->setApplicationId(12345)
       ->setName('My Web Application')
       ->setStatus(ApplicationStatus::OK);

// Convert to JSON
$json = json_encode($report);
echo $json;
```

### Complete Report with All Data

```php
<?php

use DWenzel\ReporterApi\Schema\{Report, ApplicationStatus, Package, Repository, Tag, Category};

// Create comprehensive report
$report = new Report();
$report->setApplicationId(12345)
       ->setName('E-commerce Platform')
       ->setStatus(ApplicationStatus::OK);

// Add packages
$packages = [
    new Package('vendor/framework', '5.2.1', 'abc123def'),
    new Package('vendor/orm', '2.8.0', 'def456ghi'),
    new Package('vendor/logger', '1.25.3', 'ghi789jkl'),
];
$report->setPackages($packages);

// Add repositories
$repositories = [
    new Repository('git', 'https://github.com/vendor/framework.git'),
    new Repository('composer', 'https://packagist.org'),
];
$report->setRepositories($repositories);

// Add tags
$tags = [
    new Tag(1, 'production'),
    new Tag(2, 'ecommerce'),
    new Tag(3, 'api'),
];
$report->setTags($tags);

// Output formatted JSON
echo json_encode($report, JSON_PRETTY_PRINT);
```

## Working with Packages

### Creating Package Objects

```php
<?php

use DWenzel\ReporterApi\Schema\Package;
use DWenzel\ReporterApi\Schema\PackageSource;

// Using constructor property promotion
$package = new Package(
    name: 'symfony/console',
    version: '6.3.4',
    sourceReference: 'abc123def456'
);

// Setting package type
$package->setType('library');

// Adding source information
$source = new PackageSource(
    url: 'https://github.com/symfony/console.git',
    type: 'git',
    reference: 'v6.3.4'
);
$package->setSource($source);

// Display package info
echo "Package: {$package->getName()} v{$package->getVersion()}\n";
echo "Source: {$package->getSource()->getUrl()}\n";
```

### Package Collection Management

```php
<?php

use DWenzel\ReporterApi\Schema\Package;

class PackageManager
{
    private array $packages = [];

    public function addPackage(Package $package): void
    {
        $this->packages[$package->getName()] = $package;
    }

    public function getPackage(string $name): ?Package
    {
        return $this->packages[$name] ?? null;
    }

    public function getAllPackages(): array
    {
        return array_values($this->packages);
    }

    public function getPackagesByType(string $type): array
    {
        return array_filter($this->packages, function(Package $package) use ($type) {
            return $package->getType() === $type;
        });
    }
}

// Usage
$manager = new PackageManager();
$manager->addPackage(new Package('vendor/package1', '1.0.0'));
$manager->addPackage(new Package('vendor/package2', '2.0.0'));

$allPackages = $manager->getAllPackages();
```

## Status Management

### Application Status Handling

```php
<?php

use DWenzel\ReporterApi\Schema\ApplicationStatus;
use DWenzel\ReporterApi\Schema\Report;

class ApplicationStatusManager
{
    public function checkApplicationHealth(): ApplicationStatus
    {
        try {
            // Perform health checks
            $databaseOk = $this->checkDatabase();
            $cacheOk = $this->checkCache();
            $externalServicesOk = $this->checkExternalServices();

            if (!$databaseOk || !$cacheOk) {
                return ApplicationStatus::ERROR;
            }

            if (!$externalServicesOk) {
                return ApplicationStatus::WARNING;
            }

            return ApplicationStatus::OK;
        } catch (Exception $e) {
            return ApplicationStatus::ERROR;
        }
    }

    public function createStatusReport(): Report
    {
        $report = new Report();
        $status = $this->checkApplicationHealth();
        
        $report->setStatus($status)
               ->setName('Health Monitor')
               ->setApplicationId(time());

        return $report;
    }

    private function checkDatabase(): bool
    {
        // Database connectivity check
        return true;
    }

    private function checkCache(): bool
    {
        // Cache service check
        return true;
    }

    private function checkExternalServices(): bool
    {
        // External API checks
        return false; // This would trigger WARNING status
    }
}

// Usage
$statusManager = new ApplicationStatusManager();
$report = $statusManager->createStatusReport();

echo "Application Status: " . $report->getStatus()->getValue() . "\n";
```

### Status-Based Actions

```php
<?php

use DWenzel\ReporterApi\Schema\ApplicationStatus;

class StatusActionHandler
{
    public function handleStatus(ApplicationStatus $status): void
    {
        match($status) {
            ApplicationStatus::OK => $this->handleHealthyStatus(),
            ApplicationStatus::WARNING => $this->handleWarningStatus(),
            ApplicationStatus::ERROR => $this->handleErrorStatus(),
            ApplicationStatus::UNKNOWN => $this->handleUnknownStatus(),
        };
    }

    private function handleHealthyStatus(): void
    {
        // Log successful health check
        error_log("Application is healthy");
    }

    private function handleWarningStatus(): void
    {
        // Send warning notifications
        error_log("Application has warnings - investigating");
    }

    private function handleErrorStatus(): void
    {
        // Alert administrators
        error_log("Critical application error detected!");
    }

    private function handleUnknownStatus(): void
    {
        // Handle unknown state
        error_log("Application status unknown - needs investigation");
    }
}
```

## Custom Implementations

### Custom Endpoint Implementation

```php
<?php

use DWenzel\ReporterApi\Endpoint\EndpointInterface;
use DWenzel\ReporterApi\Http\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CustomMetricsEndpoint implements EndpointInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Gather custom metrics
        $metrics = [
            'memory_usage' => memory_get_usage(true),
            'peak_memory' => memory_get_peak_usage(true),
            'uptime' => $this->getUptime(),
            'requests_per_minute' => $this->getRequestRate(),
        ];

        return new JsonResponse($metrics);
    }

    private function getUptime(): int
    {
        // Calculate application uptime
        return time() - $_SERVER['REQUEST_TIME'];
    }

    private function getRequestRate(): float
    {
        // Calculate requests per minute
        return 42.5; // Mock data
    }
}
```

### Custom Schema Class

```php
<?php

use DWenzel\ReporterApi\Traits\{JsonSerialize, ToArray};

class ServerMetrics
{
    use ToArray;
    use JsonSerialize;

    public const SERIALIZABLE_PROPERTIES = [
        'hostname',
        'cpuUsage',
        'memoryUsage',
        'diskUsage',
        'loadAverage',
    ];

    public function __construct(
        protected string $hostname = '',
        protected float $cpuUsage = 0.0,
        protected int $memoryUsage = 0,
        protected array $diskUsage = [],
        protected array $loadAverage = []
    ) {}

    // Getters and setters
    public function getHostname(): string
    {
        return $this->hostname;
    }

    public function setHostname(string $hostname): void
    {
        $this->hostname = $hostname;
    }

    public function getCpuUsage(): float
    {
        return $this->cpuUsage;
    }

    public function setCpuUsage(float $usage): void
    {
        $this->cpuUsage = $usage;
    }

    // ... other getters/setters
}

// Usage
$metrics = new ServerMetrics(
    hostname: 'web-server-01',
    cpuUsage: 45.2,
    memoryUsage: 1024 * 1024 * 512, // 512MB
    diskUsage: ['/' => 75.5, '/var' => 23.1],
    loadAverage: [1.2, 1.5, 1.8]
);

echo json_encode($metrics, JSON_PRETTY_PRINT);
```

## Framework Integration

### Symfony Integration

```php
<?php

// services.yaml
/*
services:
    DWenzel\ReporterApi\Api:
        public: true

    App\EventListener\ReporterApiListener:
        tags:
            - { name: kernel.event_listener, event: kernel.request }
*/

namespace App\EventListener;

use DWenzel\ReporterApi\Api;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

class ReporterApiListener
{
    public function __construct(private Api $api) {}

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        
        // Convert Symfony request to PSR-7
        $psrRequest = /* Convert using symfony/psr-http-message-bridge */;
        
        if ($this->api->canHandle($psrRequest)) {
            $psrResponse = $this->api->process($psrRequest, /* handler */);
            
            // Convert back to Symfony response
            $response = new JsonResponse(
                json_decode($psrResponse->getBody(), true),
                $psrResponse->getStatusCode()
            );
            
            $event->setResponse($response);
        }
    }
}
```

### Custom HTTP Client for API Consumption

```php
<?php

use GuzzleHttp\Client;
use DWenzel\ReporterApi\Schema\Report;

class ReporterApiClient
{
    private Client $httpClient;
    private string $baseUrl;

    public function __construct(string $baseUrl, array $options = [])
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->httpClient = new Client($options);
    }

    public function getApplicationReport(string $apiKey = null): ?Report
    {
        $headers = [];
        if ($apiKey) {
            $headers['api_key'] = $apiKey;
        }

        try {
            $response = $this->httpClient->get(
                $this->baseUrl . '/api/reporter/v1/application/report',
                ['headers' => $headers]
            );

            $data = json_decode($response->getBody(), true);
            
            // Create Report object from response data
            $report = new Report();
            $report->setApplicationId($data['applicationId'] ?? 0)
                   ->setName($data['name'] ?? '')
                   ->setStatus(ApplicationStatus::from($data['status'] ?? 'unknown'));

            return $report;
        } catch (Exception $e) {
            error_log("Failed to fetch report: " . $e->getMessage());
            return null;
        }
    }
}

// Usage
$client = new ReporterApiClient('https://api.example.com');
$report = $client->getApplicationReport('your-api-key');

if ($report) {
    echo "Application: {$report->getName()}\n";
    echo "Status: {$report->getStatus()->getValue()}\n";
}
```

## Testing Examples

### Unit Test for Report Creation

```php
<?php

use PHPUnit\Framework\TestCase;
use DWenzel\ReporterApi\Schema\{Report, ApplicationStatus, Package};

class ReportTest extends TestCase
{
    public function testReportCreation(): void
    {
        $report = new Report();
        $report->setApplicationId(123)
               ->setName('Test App')
               ->setStatus(ApplicationStatus::OK);

        $this->assertEquals(123, $report->getApplicationId());
        $this->assertEquals('Test App', $report->getName());
        $this->assertEquals(ApplicationStatus::OK, $report->getStatus());
    }

    public function testReportSerialization(): void
    {
        $report = new Report();
        $report->setApplicationId(456)
               ->setName('Serialization Test')
               ->setStatus(ApplicationStatus::WARNING);

        $package = new Package('test/package', '1.0.0');
        $report->setPackages([$package]);

        $json = json_encode($report);
        $data = json_decode($json, true);

        $this->assertEquals(456, $data['applicationId']);
        $this->assertEquals('Serialization Test', $data['name']);
        $this->assertEquals('warning', $data['status']);
        $this->assertCount(1, $data['packages']);
    }
}
```

### Integration Test for API Endpoint

```php
<?php

use PHPUnit\Framework\TestCase;
use DWenzel\ReporterApi\Api;
use Psr\Http\Message\ServerRequestInterface;

class ApiIntegrationTest extends TestCase
{
    private Api $api;

    protected function setUp(): void
    {
        $this->api = new Api();
    }

    public function testReportEndpointResponse(): void
    {
        // Create mock PSR-7 request
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getUri')
               ->willReturn($this->createConfiguredMock(UriInterface::class, [
                   'getPath' => '/api/reporter/v1/application/report'
               ]));

        $this->assertTrue($this->api->canHandle($request));

        $handler = $this->createMock(RequestHandlerInterface::class);
        $response = $this->api->process($request, $handler);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
    }
}
```

These examples demonstrate various ways to use the Reporter API in different contexts, from simple standalone usage to complex framework integrations.