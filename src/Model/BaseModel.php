<?php

namespace Framework\Model;

use Exception;
use Framework\ORM;
use LeanCloud\LeanObject;
use LeanCloud\Query;

class BaseModel extends LeanObject
{
    public function __construct($objectId = null)
    {
        parent::__construct($this->getVClassName(), $objectId);
    }

    protected function getVClassName($class = null)
    {
        $class = $class ?: $this;
        if (is_object($class)) {
            $class = get_class($class);
        }
        $class = str_replace('App\Models\\', '', $class);
        $class = str_replace('\\', '', $class);

        return $class;
    }

    public function find($id)
    {
        $class = $this->getVClassName();
        return (new Orm)->find($class, $id);
    }
}
