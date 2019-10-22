<?php
declare(strict_types=1);

namespace DWenzel\ReporterApi;

use DWenzel\ReporterApi\Endpoint\EndpointInterface;
use DWenzel\ReporterApi\Endpoint\Report;
use DWenzel\ReporterApi\Exception\InvalidClass;
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
class Api
{

    /**
     * @var string
     */
    protected $apiKey = '';
    /**
     * @var string
     */
    protected $secret = '';
    /**
     * @var string
     */
    protected $site = '';

    /**
     * @var string
     */
    protected $lang = 'en';

    /**
     * @var array
     */
    private $endpointCache = [];

    public function __construct(
        string $apiKey,
        string $secret,
        RequestHandlerInterface $handler,
        string $site = null,
        string $lang = 'en',
        array $config = []
    )
    {
    }

    /**
     * @return mixed
     * @throws InvalidClass
     */
    public function getReportEndpoint()
    {
        return $this->getInstance(Report::class);
    }

    /**
     * @param $className
     * @return EndpointInterface
     * @throws InvalidClass
     */
    private function getInstance($className)
    {
        if (!in_array(EndpointInterface::class, class_implements($className), true))
        {
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
}
