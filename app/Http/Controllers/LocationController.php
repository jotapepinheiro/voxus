<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Location;
use Illuminate\View\View;
use OpenApi\Annotations\Get;
use OpenApi\Annotations\Post;
use Laravel\Lumen\Application;
use OpenApi\Annotations\Delete;
use OpenApi\Annotations\Schema;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Response;
use OpenApi\Annotations\MediaType;
use OpenApi\Annotations\Parameter;
use OpenApi\Annotations\RequestBody;
use App\Http\Requests\LocationIndexRequest;
use App\Http\Requests\LocationStoreRequest;

use App\Services\LocationService;

class LocationController extends Controller
{
    /**
     * @var Location
     */
    private $location;
    /**
     * @var User
     */
    private $user;

    /**
     * Create a new controller instance.
     *
     * @param Location $location
     * @param User $user
     */
    public function __construct(Location $location, User $user)
    {
        $this->location = $location;
        $this->user = $user;
    }

    /**
     * @return View|Application
     */
    public function showMapa()
    {
        $locations = (new LocationService)->listAllLocationsMap();

        return view('mapa')->with('data', json_decode($locations, FALSE));
    }

    /**
     * @Get(
     *     path="/locations",
     *     tags={"Locations"},
     *     summary="Lista de Localizações.",
     *     security={{ "apiAuth": {} }},
     *     @Parameter(
     *         name="include",
     *         in="query",
     *         description="Incluir Usuários, users",
     *         @Schema(type="string")
     *     ),
     *     @Parameter(
     *         name="filter[ip]",
     *         in="query",
     *         description="Filtrar por IP",
     *         @Schema(type="string")
     *     ),
     *     @Parameter(
     *         name="filter[latitude]",
     *         in="query",
     *         description="Filtrar por latitude",
     *         @Schema(type="string")
     *     ),
     *     @Parameter(
     *         name="filter[longitude]",
     *         in="query",
     *         description="Filtrar por longitude",
     *         @Schema(type="string")
     *     ),
     *     @Parameter(
     *         name="filter[cidade]",
     *         in="query",
     *         description="Filtrar por cidade",
     *         @Schema(type="string")
     *     ),
     *     @Parameter(
     *         name="filter[estado]",
     *         in="query",
     *         description="Filtrar por estado",
     *         @Schema(type="string")
     *     ),
     *     @Parameter(
     *         name="filter[users.name]",
     *         in="query",
     *         description="Filtrar por nome de usuário",
     *         @Schema(type="string")
     *     ),
     *     @Parameter(
     *         name="filter[users.email]",
     *         in="query",
     *         description="Filtrar por e-mail de usuário",
     *         @Schema(type="string")
     *     ),
     *     @Response(
     *         response="200",
     *         description="Resposta Operacional Normal",
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 allOf={
     *                     @Schema(ref="#/components/schemas/ApiResponse"),
     *                     @Schema(
     *                         type="object",
     *                         @Property(property="data", ref="#/components/schemas/LocationsPaginateResponse")
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(response="401",description="Não autorizado"),
     *     @Response(response="403",description="Sem permissão de acesso")
     * )
     *
     * @param LocationIndexRequest $request
     * @return JsonResponse
     */
    public function index(LocationIndexRequest $request)
    {
        $locations = (new LocationService)->listAllLocations($request);

        return response()->json(['success' => true, 'code' => 200, 'data' => $locations], 200);
    }

    /**
     * @Get(
     *     path="/locations/{id}",
     *     tags={"Locations"},
     *     summary="Listar as Localizações por ID de Usuário.",
     *     security={{ "apiAuth": {} }},
     *     @Parameter(
     *         name="id",
     *         in="path",
     *         description="Id do Usuário",
     *         required=true,
     *         @Schema(type="integer")
     *     ),
     *     @Response(
     *         response="200",
     *         description="Resposta Operacional Normal",
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 allOf={
     *                     @Schema(ref="#/components/schemas/ApiResponse"),
     *                     @Schema(
     *                         type="object",
     *                         @Property(property="data", ref="#/components/schemas/LocationProperty")
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(response="401",description="Não autorizado"),
     *     @Response(response="403",description="Sem permissão de acesso")
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $locations = (new LocationService)->getLocationByUserId($id);

        return response()->json(['success' => true, 'code' => 200, 'data' => $locations], 200);
    }

    /**
     * @Post(
     *     path="/locations",
     *     tags={"Locations"},
     *     summary="Criar nova Localização e Vincular a um Usuário.",
     *     security={{ "apiAuth": {} }},
     *     @Parameter(
     *         name="user_id",
     *         in="query",
     *         description="ID do Usuário",
     *         required=true,
     *         @Schema(type="integer")
     *     ),
     *     @RequestBody(
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 required={"ip", "latitude", "longitude"},
     *                 @Property(property="ip", type="string", description="IP"),
     *                 @Property(property="latitude", type="string", description="Latitude"),
     *                 @Property(property="longitude", type="string", description="Longitude"),
     *                 @Property(property="cidade", type="string", description="Cidade"),
     *                 @Property(property="estado", type="string", description="Estado"),
     *                 @Property(property="time_zone", type="string", description="Fuso Horário")
     *             )
     *         )
     *     ),
     *     @Response(
     *         response="200",
     *         description="Resposta Operacional Normal",
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 allOf={
     *                     @Schema(ref="#/components/schemas/ApiResponse")
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(response="401",description="Não autorizado"),
     *     @Response(response="403",description="Sem permissão de acesso")
     * )
     *
     * @param LocationStoreRequest $request
     * @return JsonResponse
     */
    public function store(LocationStoreRequest $request)
    {
        (new LocationService)->newLocation($request);

        return response()->json(['success' => true, 'code' => 200, 'data' => ['message' => 'Operação realizada com sucesso.']], 200);
    }

    /**
     * @Delete(
     *     path="/locations/{id}",
     *     tags={"Locations"},
     *     summary="Deletar Localização por ID.",
     *     security={{ "apiAuth": {} }},
     *     @Parameter(
     *         name="id",
     *         in="path",
     *         description="Id da Localização",
     *         required=true,
     *         @Schema(type="integer")
     *     ),
     *     @Response(
     *         response="200",
     *         description="Resposta Operacional Normal",
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 allOf={
     *                     @Schema(ref="#/components/schemas/ApiResponse")
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(response="401",description="Não autorizado"),
     *     @Response(response="403",description="Sem permissão de acesso")
     * )
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        (new LocationService)->destroyLocation($id);

        return response()->json(['success' => true, 'code' => 200, 'data' => ['message' => 'Operação realizada com sucesso.']], 200);
    }
}
