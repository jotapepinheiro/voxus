<?php

namespace App\Services;

use App\Repositories\LocationRepository;
use Kielabokkie\LaravelIpdata\Facades\Ipdata;

class LocationService
{
    /**
     * @var LocationRepository
     */
    private $locationRepository;

    /**
     *  Listar todas as localizações para o mapa
     *
     * @return mixed
     */
    public function listAllLocationsMap() {

        $locationUser = Ipdata::lookup();

        $locations = $this->getLocationRepository()->listAllLocationsMap($locationUser->ip);

        return json_encode([
            'locations' => $locations,
            'locationUser' => [
                'ip' => $locationUser->ip,
                'latitude' => $locationUser->latitude,
                'longitude' => $locationUser->longitude,
                'cidade' => $locationUser->city,
                'estado' => $locationUser->region,
                'sigla_estado' => $locationUser->region_code,
                'pais' => $locationUser->country_name,
                'time_zone' => $locationUser->time_zone
            ]
        ]);
    }

    /**
     *  Listar todas as localizações existentes
     *
     * @param $request
     * @return mixed
     */
    public function listAllLocations($request) {
        return $this->getLocationRepository()->listAllLocations($request);
    }

    /**
     *  Retorna as localizações por um determinado ID de usuário
     *
     * @param $id
     * @return mixed
     */
    public function getLocationByUserId($id) {
        return $this->getLocationRepository()->getLocationByUserId($id);
    }

    /**
     * Realiza a inclusão de uma localização
     *
     * @param $request
     * @return mixed
     */
    public function newLocation($request)
    {
        try {
            $location = $this->getLocationRepository()->newLocation($request);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        return $location;
    }

    /**
     * Realiza a exclusão de uma localização
     *
     * @param $id
     * @return mixed
     */
    public function destroyLocation($id)
    {
        try {
            $location = $this->getLocationRepository()->destroyLocation($id);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        return $location;
    }

    /**
     * Retorna uma nova instância de LocationRepository.
     *
     * @return LocationRepository|mixed
     */
    private function getLocationRepository()
    {
        if (empty($this->locationRepository)) {
            $this->locationRepository = new LocationRepository();
        }

        return $this->locationRepository;
    }

}
