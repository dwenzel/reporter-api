# Migration Guide

This guide helps you migrate from earlier versions of the Reporter API to version 0.4.0, which includes significant modernizations and breaking changes.

## Version 0.4.0 - Major Modernization

### Breaking Changes

#### 1. PHP Version Requirement

**Before (0.3.x):**
- Minimum PHP 7.4

**After (0.4.0):**
- Minimum PHP 8.1+ (required)

**Migration:**
```bash
# Update your PHP version to 8.1 or higher
php -v  # Check current version

# Update composer.json
{
    "require": {
        "php": ">=8.1"
    }
}
```

#### 2. ApplicationStatus Enum

**Before (0.3.x):**
```php
use DWenzel\ReporterApi\Schema\ApplicationStatus;

// Using myclabs/php-enum
$status = new ApplicationStatus(ApplicationStatus::OK);
$value = $status->getValue();

// From string
$status = ApplicationStatus::from(ApplicationStatus::OK);
```

**After (0.4.0):**
```php
use DWenzel\ReporterApi\Schema\ApplicationStatus;

// Using native PHP 8.1 enum
$status = ApplicationStatus::OK;
$value = $status->getValue(); // Still available for compatibility

// From string (built-in enum method)
$status = ApplicationStatus::from('ok');

// Available cases
ApplicationStatus::UNKNOWN  // 'unknown'
ApplicationStatus::OK        // 'ok'
ApplicationStatus::ERROR     // 'error'
ApplicationStatus::WARNING   // 'warning'
```

**Migration Steps:**
1. Replace `new ApplicationStatus(ApplicationStatus::CONSTANT)` with `ApplicationStatus::CONSTANT`
2. Update any custom enum handling code
3. Remove `myclabs/php-enum` from your dependencies if no longer needed

#### 3. Constructor Changes

**Before (0.3.x):**
```php
use DWenzel\ReporterApi\Schema\Package;

$package = new Package();
$package->setName('vendor/package');
$package->setVersion('1.0.0');
$package->setSourceReference('abc123');
```

**After (0.4.0):**
```php
use DWenzel\ReporterApi\Schema\Package;

// Constructor property promotion available
$package = new Package(
    name: 'vendor/package',
    version: '1.0.0',
    sourceReference: 'abc123'
);

// Or continue using setters (backward compatible)
$package = new Package();
$package->setName('vendor/package');
$package->setVersion('1.0.0');
$package->setSourceReference('abc123');
```

#### 4. Package Constructor Signature

**Before (0.3.x):**
```php
$package = new Package();
$package->setSource(new NullPackageSource()); // Manual setup
```

**After (0.4.0):**
```php
// Source is automatically set to NullPackageSource in constructor
$package = new Package();
// Source is already initialized

// Or provide source in constructor
$source = new PackageSource('https://github.com/vendor/repo.git', 'git', 'v1.0.0');
$package = new Package(
    name: 'vendor/package',
    version: '1.0.0',
    sourceReference: 'abc123',
    source: $source
);
```

### New Features

#### 1. Native PHP 8.1 Enums
- `ApplicationStatus` is now a native enum with string backing
- Better IDE support and type safety
- Built-in `from()` method for string conversion

#### 2. Constructor Property Promotion
- `Package` and `PackageSource` classes use modern constructors
- More concise object creation
- Reduced boilerplate code

#### 3. Strict Types
- All classes now use `declare(strict_types=1)`
- Better type safety and error detection
- More predictable behavior

#### 4. Complete Schema Implementation
- `Repository` and `Tag` classes are now fully implemented
- Based on OpenAPI 3.0 specification
- Ready for use in applications

### Non-Breaking Improvements

#### 1. Type Declarations
All properties and methods now have proper type declarations:

```php
// Before (inferred types)
protected $applicationId = 0;
protected $name = '';

// After (explicit types)
protected int $applicationId = 0;
protected string $name = '';
```

#### 2. Method Signatures
All methods have explicit return types and parameter types:

```php
// Before
public function setApplicationId($applicationId)
public function getApplicationId()

// After
public function setApplicationId(int $applicationId): Report
public function getApplicationId(): int
```

#### 3. Removed Dependencies
- `myclabs/php-enum` no longer required
- Lighter dependency footprint
- Better performance

### Testing Updates

#### 1. PHPUnit Modernization

**Before (0.3.x):**
- Used `Nimut\TestingFramework\TestCase\UnitTestCase`
- PHPUnit 9.x compatibility

**After (0.4.0):**
- Uses `PHPUnit\Framework\TestCase`
- PHPUnit 10.5+ or 11.0+ compatibility
- Modern test syntax

**Migration:**
```php
// Before
use Nimut\TestingFramework\TestCase\UnitTestCase;

class MyTest extends UnitTestCase
{
    public function setUp()
    {
        // setup code
    }
}

// After
use PHPUnit\Framework\TestCase;

class MyTest extends TestCase
{
    protected function setUp(): void
    {
        // setup code
    }
}
```

#### 2. Test Configuration

**Before (0.3.x):**
- Legacy PHPUnit configuration
- Various deprecated options

**After (0.4.0):**
- Modern PHPUnit 11 configuration
- Cleaner XML structure
- Better performance

### Step-by-Step Migration

1. **Update PHP Version**
   ```bash
   # Ensure PHP 8.1+
   php -v
   ```

2. **Update Dependencies**
   ```bash
   composer require dwenzel/reporter-api:^0.4
   composer update
   ```

3. **Update ApplicationStatus Usage**
   ```php
   // Find and replace patterns
   // OLD: new ApplicationStatus(ApplicationStatus::OK)
   // NEW: ApplicationStatus::OK
   
   // OLD: ApplicationStatus::from(ApplicationStatus::OK)
   // NEW: ApplicationStatus::OK (direct use) or ApplicationStatus::from('ok')
   ```

4. **Update Test Base Classes**
   ```php
   // Replace in all test files
   // OLD: extends UnitTestCase
   // NEW: extends TestCase
   
   // OLD: use Nimut\TestingFramework\TestCase\UnitTestCase;
   // NEW: use PHPUnit\Framework\TestCase;
   ```

5. **Update Test Setup Methods**
   ```php
   // OLD: public function setUp()
   // NEW: protected function setUp(): void
   ```

6. **Leverage New Features (Optional)**
   ```php
   // Use constructor property promotion where beneficial
   $package = new Package(
       name: 'vendor/package',
       version: '1.0.0'
   );
   
   // Use new Repository and Tag classes
   $repository = new Repository('git', 'https://github.com/vendor/repo.git');
   $tag = new Tag(1, 'production');
   ```

### Compatibility Notes

#### Backward Compatibility
- All public APIs remain compatible
- Getter/setter methods unchanged
- JSON serialization format unchanged
- PSR-7/PSR-15 compliance maintained

#### Forward Compatibility
- Code using new features will require PHP 8.1+
- Native enum usage provides better IDE support
- Constructor property promotion offers cleaner syntax

### Common Issues and Solutions

#### Issue: "Class 'ApplicationStatus' not found"
**Solution:** Update import and usage:
```php
// Ensure correct import
use DWenzel\ReporterApi\Schema\ApplicationStatus;

// Use enum directly
$status = ApplicationStatus::OK;
```

#### Issue: "Cannot instantiate enum"
**Solution:** Don't use `new` with enums:
```php
// Wrong
$status = new ApplicationStatus('ok');

// Correct
$status = ApplicationStatus::from('ok');
// or
$status = ApplicationStatus::OK;
```

#### Issue: PHPUnit test failures
**Solution:** Update test base class and setup methods:
```php
use PHPUnit\Framework\TestCase;

class MyTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Your setup code
    }
}
```

### Performance Improvements

- Native enums are faster than class-based enums
- Reduced dependency loading time
- Better memory usage with typed properties
- Improved autoloading efficiency

### Additional Resources

- [API Documentation](API.md) - Complete API reference
- [Usage Examples](EXAMPLES.md) - Practical usage examples
- [README](../README.md) - Installation and quick start guide
- [OpenAPI Specification](../reporterApi.yaml) - Complete API specification

### Support

If you encounter issues during migration:

1. Check this migration guide for common solutions
2. Review the updated documentation
3. Check the test suite for usage examples
4. Open an issue on GitHub with specific details

The modernization brings significant improvements in type safety, performance, and developer experience while maintaining backward compatibility for most use cases.