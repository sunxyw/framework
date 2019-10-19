<?php

namespace Framework;

use \LeanCloud\Client;
use \LeanCloud\LeanObject;
use LeanCloud\Query;

class ORM
{
    protected $leancloud;

    public function __construct()
    {
        Client::initialize("bYgdYlRkuK7C89TtS8CNcTUv-MdYXbMMI", "Yf4CeVBYaVWz96PtsRdhJ04o", "CzblFnk8E9NKWoHFvitnePCg");
        Client::setDebug(config('debug'));
    }

    public function insert($class, $data)
    {
        $object = new LeanObject($class);
        foreach ($data as $key => $datum) {
            $object->set($key, $datum);
        }
        try {
            $object->save();
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function find($class, $objectId)
    {
        $query = new Query($class);
        $query->equalTo('objectId', $objectId);
        $object = $query->first();

        return $object;
    }

    public function where(Query $query, $key, $val)
    {
        $query->equalTo($key, $val);

        return $query;
    }
}
