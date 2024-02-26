<?php
namespace Engine\DB;

use mysqli;

interface DBConnectionInterface{


    public function getConnection():mysqli|null;
}