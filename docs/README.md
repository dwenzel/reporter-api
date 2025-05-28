# Documentation Index

Welcome to the Reporter API documentation. This directory contains comprehensive documentation for the Reporter API library.

## 📚 Documentation Overview

### Getting Started
- **[Main README](../README.md)** - Installation, quick start, and overview
- **[Migration Guide](MIGRATION.md)** - Upgrading from previous versions

### Technical Documentation
- **[API Reference](API.md)** - Complete class and method documentation
- **[Usage Examples](EXAMPLES.md)** - Practical code examples and integrations
- **[OpenAPI Specification](../reporterApi.yaml)** - REST API specification

### Project Information
- **[ChangeLog](../ChangeLog)** - Version history and changes
- **[License](MIT-LICENSE)** - GPL-2.0+ license information
- **[CLAUDE.md](../CLAUDE.md)** - Developer workflow and Claude Code instructions

## 🚀 Quick Navigation

### For New Users
1. Start with the [Main README](../README.md) for installation and basic usage
2. Check out [Usage Examples](EXAMPLES.md) for practical implementations
3. Refer to [API Reference](API.md) for detailed class documentation

### For Upgrading Users
1. Read the [Migration Guide](MIGRATION.md) for breaking changes
2. Review the [ChangeLog](../ChangeLog) for detailed version changes
3. Update your code following the migration examples

### For Developers
1. Review [CLAUDE.md](../CLAUDE.md) for development workflow
2. Check [API Reference](API.md) for implementation details
3. Use [Usage Examples](EXAMPLES.md) for integration patterns

## 📖 Document Descriptions

### [Main README](../README.md)
The primary documentation file containing:
- Installation instructions
- Feature overview
- Quick start guide
- Basic usage examples
- Requirements and dependencies
- Project structure overview

### [API Reference](API.md)
Comprehensive technical documentation including:
- All class definitions and methods
- Parameter types and return values
- Usage patterns and examples
- Error handling information
- Serialization details

### [Usage Examples](EXAMPLES.md)
Practical implementation examples covering:
- Basic API usage
- Framework integration (Slim, Laravel, Symfony)
- Custom implementations
- Testing strategies
- Status management
- Package handling

### [Migration Guide](MIGRATION.md)
Version upgrade information including:
- Breaking changes between versions
- Step-by-step migration instructions
- Code examples for common changes
- Compatibility notes
- Troubleshooting common issues

### [OpenAPI Specification](../reporterApi.yaml)
REST API specification containing:
- Complete endpoint documentation
- Request/response schemas
- Authentication requirements
- Example requests and responses
- Error codes and descriptions

## 🏗️ Architecture Overview

The Reporter API is built with modern PHP 8.1+ features and follows these design principles:

### Core Components
- **PSR-7/PSR-15 Middleware** for HTTP handling
- **Native PHP 8.1 Enums** for type safety
- **Constructor Property Promotion** for clean code
- **Strict Type Declarations** throughout
- **Null Object Pattern** for robust error handling

### Key Features
- Application status reporting
- Package information collection
- Repository metadata
- JSON serialization
- JWT authentication support
- Modern PHP conventions

## 🛠️ Development

### Testing
All examples in the documentation are validated against the test suite:
```bash
# Run tests
composer test

# With DDEV
ddev exec "cd /var/www/html/app/vendor/dwenzel/reporter-api && .build/bin/phpunit -c tests/Build/UnitTests.xml"
```

### Requirements
- **PHP 8.1+** (required for native enum support)
- **Composer** for dependency management
- **PHPUnit 10.5+/11.0+** for testing

### Code Standards
- PSR-4 autoloading
- PSR-7/PSR-15 compliance
- Strict type declarations
- Modern PHP conventions
- 100% test coverage

## 🔗 External Resources

### PHP Documentation
- [PHP 8.1 Enums](https://www.php.net/manual/en/language.enumerations.php)
- [Constructor Property Promotion](https://www.php.net/manual/en/language.oop5.decon.php#language.oop5.decon.constructor.promotion)
- [Strict Types](https://www.php.net/manual/en/language.types.declarations.php#language.types.declarations.strict)

### PSR Standards
- [PSR-7: HTTP Message Interface](https://www.php-fig.org/psr/psr-7/)
- [PSR-15: HTTP Server Request Handlers](https://www.php-fig.org/psr/psr-15/)
- [PSR-4: Autoloader](https://www.php-fig.org/psr/psr-4/)

### OpenAPI
- [OpenAPI 3.0 Specification](https://swagger.io/specification/)
- [Swagger UI](https://swagger.io/tools/swagger-ui/) for interactive documentation

## 📝 Contributing to Documentation

When contributing to the documentation:

1. **Accuracy**: Ensure all code examples are tested and working
2. **Completeness**: Cover all major use cases and scenarios
3. **Clarity**: Use clear, concise language with good examples
4. **Consistency**: Follow the established documentation style
5. **Testing**: Validate examples against the actual codebase

### Documentation Standards
- Use GitHub Flavored Markdown
- Include practical code examples
- Provide context for complex topics
- Link to related documentation
- Keep examples up-to-date with current API

## 🆘 Getting Help

If you need assistance:

1. **Check the documentation** - Most questions are answered here
2. **Review examples** - Look for similar use cases in the examples
3. **Check the test suite** - Tests demonstrate proper usage
4. **Open an issue** - For bugs or missing documentation
5. **Consult the OpenAPI spec** - For detailed API information

---

**Last Updated:** January 2025  
**Version:** 0.4.0  
**PHP Version:** 8.1+