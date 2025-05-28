<?php

namespace DWenzel\ReporterApi\Http;

/***************************************************************
 * Copyright notice
 * This code was ported from the now abandoned package
 * bittyphp/http.
 * Copyleft (c) 2019 Luke Kingsley
 * See the original MIT licence in docs/MIT-LICENCE
 *
 * All rights reserved
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
class JsonResponse extends Response
{
    /**
     * @param mixed $body Any value that can be JSON encoded.
     * @param int $statusCode
     * @param array $headers Array of string|string[]
     */
    public function __construct(
        $body = '',
        int $statusCode = 200,
        array $headers = []
    ) {
        $json = json_encode($body);
        if ($json === false) {
            throw new \RuntimeException('Failed to encode data as JSON.');
        }

        parent::__construct($json, $statusCode, $headers);

        // forcibly override content type
        $this->headers = $this->withHeader('Content-Type', 'application/json')->getHeaders();
    }
}
