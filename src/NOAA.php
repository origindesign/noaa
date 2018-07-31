<?php

/*
 * This file is part of the noaa package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Origindesign\Noaa;
/**
 * main class for working with noaa forecasts and conditions
 */

use Origindesign\Noaa\Util\Fetch;
use Origindesign\Noaa\Util\Cache;


class NOAA{

		const POINT = "https://api.weather.gov/points/{point}";
		const STATION = "https://api.weather.gov/stations/{station}";


		protected $fetch;
		protected $point;
		protected $hourly;
		protected $daily;
		protected $station;
		protected $observations;


		public function __construct(Cache $cache, $apikey = "my_noaa_app"){
				$this->fetch = new Fetch($cache, $apikey);
		}


    /**
     * @param \Origindesign\Noaa\Point $point
     */
    public function setPoint(Point $point){
				$this->point = $point;
		}


    /**
     * @return mixed
     */
    public function getPoint(){
				return $this->point;
		}


    /**
     * @param \Origindesign\Noaa\Station $station
     */
    public function setStation(Station $station){
				$this->station = $station;
		}


    /**
     * @return \Origindesign\Noaa\Station
     */
    public function getStation(){
				return $this->station();
		}


    /**
     * @return \Origindesign\Noaa\Util\Cache
     */
    public function getCache(){
        return $this->fetch->getCache();
    }


    /**
     * @return mixed
     */
    protected function point(){
        if(!$this->point->isLoaded()){
                $url = str_replace("{point}", $this->point->getLat() . "," . $this->point->getLon(), self::POINT);
                $res = $this->load($url, Point::TTL);
                $this->point->setProperties($res);
        }
        return $this->point;
    }


    /**
     * @return \Origindesign\Noaa\Station
     */
    protected function station(){
        if(!isset($this->station)){
            $this->point();
            $obj = $this->load($this->point->getObservationStations(), Station::TTL);
            $stat = $this->load($obj->observationStations[0], Station::TTL);
            $this->station = new Station();
            $this->station->setProperties($stat);

        }
        if(!$this->station->isLoaded()){
            $url = str_replace("{station}", $this->station->getIdentifier(), self::STATION);
            $res = $this->load($url, Station::TTL);
            $this->station->setProperties($res);
        }
        return $this->station;
    }


    /**
     * @return array
     */
    public function getHourlyForecast(){
        if(!isset($this->hourly)||$this->hourly->isExpired()){
            $this->hourly = $this->forecast($this->point()->getForecastHourly());
        }
        return $this->hourly->getPeriods();
    }



    /**
     * @return array
     */
    public function getDailyForecast(){
        if(!isset($this->daily)||$this->daily->isExpired()){
            $this->point();
            $this->daily = $this->forecast($this->point->getForecast());
        }
        return $this->daily->getPeriods();
    }


    /**
     * @param $url
     *
     * @return \Origindesign\Noaa\Forecast
     */
    protected function forecast($url){
        $res = $this->load($url, Forecast::TTL);
        $forecast = new Forecast();
        $forecast->setProperties($res);
        return $forecast;
    }


    /**
     * @return mixed
     */
    public function getObservations(){
        if(!isset($this->observations)){
            $this->station();
            $this->observations = $this->observation($this->station->getObservations());
        }
        return $this->observations->getObservations();
    }


    /**
     * @param $url
     *
     * @return \Origindesign\Noaa\Observations
     */
    protected function observation($url){
        $res = $this->load($url, Observations::TTL);
        $observations = new Observations();
        $observations->setProperties($res);
        return $observations;

    }


    /**
     * @param $url
     * @param $ttl
     *
     * @return mixed
     */
    protected function load($url, $ttl){
        return $this->fetch->load($url, $ttl);
    }


}//class

