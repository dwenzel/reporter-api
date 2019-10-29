<?php

namespace DWenzel\ReporterApi\Traits;

use JsonSerializable;

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
trait JsonSerialize
{

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>
     */
    public function jsonSerialize()
    {
        $data = [];
        foreach (static::SERIALIZABLE_PROPERTIES as $name) {
            $value = '';
            if (is_string($this->{$name})) {
                $value = $this->{$name};
            }
            if (is_int($this->{$name})) {
                $value = (string)$this->{$name};
            }
            if ($this->{$name} instanceof JsonSerializable) {
                $value = $this->{$name}->jsonSerialize();
            }
            if (is_array($this->{$name})) {
                $value = $this->{$name};
            }
            $data[$name] = $value;
        }

        return $data;
    }

}
