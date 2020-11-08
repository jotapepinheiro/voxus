<?php

namespace App\Repositories;

use App\Models\Location;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class LocationRepository
{
    /**
     * Retorna as localizações existentes para o mapa
     *
     * @param $ip
     * @return mixed
     */
    public function listAllLocationsMap($ip)
    {
        return Cache::remember('mapa_'.$ip, 300, function () {
            return DB::table('locations')->select('latitude', 'longitude')->get();
        });
    }

    /**
     * Retorna as localizações existentes
     *
     * @param $request
     * @return mixed
     */
    public function listAllLocations($request)
    {
        return  QueryBuilder::for(Location::class, $request)
            ->allowedFilters([
                'ip', 'latitude', 'longitude', 'cidade', 'estado', 'time_zone',
                'users.name', 'users.email'
            ])
            ->allowedIncludes([
                'users'
            ])
            ->defaultSort('-id')
            ->allowedSorts('ip', 'latitude', 'longitude', 'cidade', 'estado', 'time_zone')
            ->paginate(50)
            ->appends(request()->query());
    }

    /**
     * Retorna o localização de acordo com o ID
     *
     * @param int $id
     * @return mixed
     */
    public function getLocationById(int $id)
    {
        return Location::findOrFail($id);
    }

    /**
     * Retorna o localização de acordo com o ID de Usuário
     *
     * @param int $id
     * @return mixed
     */
    public function getLocationByUserId(int $id)
    {
        return User::with('locations')->findOrFail($id);
    }

    /**
     * Criar uma localização e vincular ao usuário
     *
     * @param $request
     * @return Collection
     */
    public function newLocation($request)
    {
        return Location::create([
            'ip' => $request->input('ip'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'cidade' => $request->input('cidade'),
            'estado' => $request->input('estado'),
            'time_zone' => $request->input('time_zone')
        ])->users()->attach($request->input('user_id'));
    }

    /**
     * Excluir uma localização
     *
     * @param $id
     */
    public function destroyLocation($id)
    {
        $location = $this->getLocationById($id);

        return $location->delete();
    }
}
