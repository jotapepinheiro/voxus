<?php

namespace App\Http\Responses\Locations;

use OpenApi\Annotations\Items;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;

/**
 * @Schema(title="Localizações", description="Localizações")
 *
 * @package App\Http\Responses\Locations
 */
class LocationProperty
{
    /**
     * @Property(type="integer", description="ID")
     *
     * @var int
     */
    public $id = 0;

    /**
     * @Property(type="string", description= "ip")
     *
     * @var string
     */
    public $ip;

    /**
     * @Property(type="string", description= "latitude")
     *
     * @var string
     */
    public $latitude;

    /**
     * @Property(type="string", description= "longitude")
     *
     * @var string
     */
    public $longitude;

    /**
     * @Property(type="string", description="cidade")
     *
     * @var string
     */
    public $cidade;

    /**
     * @Property(type="string", description="estado")
     *
     * @var string
     */
    public $estado;

    /**
     * @Property(type="string", description="created_at")
     *
     * @var string
     */
    public $created_at;

    /**
     * @Property(type="string", description="updated_at")
     *
     * @var string
     */
    public $updated_at;

    /**
     * @Property(type="array", @Items(ref="#/components/schemas/UserProperty"))
     *
     * @var array
     */
    public $users = [];
}
