<?php

/*
 * This file is part of the noaa package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Origindesign\Noaa;


/**
 * class to manage a collection of Observations
 */
class Observations extends Base{
		/**
		 * refresh frequency
		 * @see http://php.net/manual/en/dateinterval.construct.php
		 */
		const TTL = "PT1H";

		/**
		 * @return array of periods
		 */
		public function getObservations(){
				$ret = array();
				foreach($this->properties->features as $observation){
						$ret[] = new Observation($observation);
				}
				return $ret;
		}
}//class
