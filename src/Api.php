<?php

declare(strict_types=1);

namespace DWenzel\ReporterApi;

use DWenzel\ReporterApi\Endpoint\EndpointInterface;
use DWenzel\ReporterApi\Endpoint\NullEndpoint;
use DWenzel\ReporterApi\Endpoint\Report;
use DWenzel\ReporterApi\Exception\InvalidClass;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2019 Dirk Wenzel <wenzel@cps-it.de>
 *  All rights reserved
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the text file GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
class Api implements MiddlewareInterface
{
    public const DEFAULT_ROUTE = '/api/reporter/v1/application/report';

    protected $endpointMap = [
        self::DEFAULT_ROUTE => Report::class,
    ];

    /**
     * @var array
     */
    private $endpointCache = [];

    public function __construct() {}

    /**
     * @return mixed
     * @throws InvalidClass
     */
    public function getReportEndpoint()
    {
        return $this->getInstance(Report::class);
    }

    /**
     * Tells whether the Api can handle the request
     *
     * @param RequestInterface $request
     * @return bool
     */
    public function canHandle(RequestInterface $request)
    {
        return !($this->determineEndpoint($request)  instanceof NullEndpoint);
    }

    /**
     * @param $className
     * @return EndpointInterface
     * @throws InvalidClass
     */
    private function getInstance($className)
    {
        if (!in_array(EndpointInterface::class, class_implements($className), true)) {
            $message = 'Invalid class %s. Class must implement ' . EndpointInterface::class . '.';
            throw new InvalidClass(
                sprintf($message, $className),
                1570790754
            );

        }
        if (!array_key_exists($className, $this->endpointCache)) {
            $this->endpointCache[$className] = new $className($this->client);
        }
        return $this->endpointCache[$className];
    }

    /**
     * @param RequestInterface $request
     * @return EndpointInterface|NullEndpoint
     */
    protected function determineEndpoint(RequestInterface $request)
    {
        $uri = $request->getUri();
        $path = $uri->getPath();
        if (array_key_exists($path, $this->endpointMap)) {
            try {
                return $this->getInstance($this->endpointMap[$path]);
            } catch (InvalidClass $e) {
                return new NullEndpoint();
            }
        }

        return new NullEndpoint();
    }

    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (($endpoint = $this->determineEndpoint($request)) instanceof NullEndpoint) {
            return $handler->handle($request);
        }

        return $endpoint->handle($request);
    }
}
