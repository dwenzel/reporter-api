<?php

namespace DWenzel\ReporterApi\Endpoint;

use Bitty\Http\JsonResponse;
use CPSIT\Auditor\BundleDescriber;
use CPSIT\Auditor\Reflection\PackageVersions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use DWenzel\ReporterApi\Schema\Report as ReportSchema;

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
class Report implements EndpointInterface
{
    /**
     * Handles a request and produces a response.
     *
     * May call other collaborating code to generate the response.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $report = new ReportSchema();
        $report->setRepositories(BundleDescriber::getProperty('repositories'))
            ->setName(BundleDescriber::getProperty('uniqueName'))
            ->setPackages(PackageVersions::getAll());

        $data = $report->jsonSerialize();
        $body = json_encode($data, JSON_FORCE_OBJECT);
        return new JsonResponse(
            $body
        );
    }
}
