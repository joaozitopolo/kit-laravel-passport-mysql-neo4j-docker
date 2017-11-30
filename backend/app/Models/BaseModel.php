<?php

namespace App;

use Vinelab\NeoEloquent\Eloquent\Model;

class NeoBaseModel extends Model

{

    protected $connection = 'neo4j';
    
}
