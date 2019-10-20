<?php

namespace Framework\Model\Traits;

trait ModelHelpers
{
    static public function all($array = false)
    {
        $results = (new self())->getQuery()->find();

        if ($array) {
            $data = [];
            foreach ($results as $result) {
                $data[] = $result->toJson();
            }
            $results = $data;
        }

        return $results;
    }

    static public function find($id)
    {
        $result = (new self())->getQuery()->get($id);

        return $result;
    }
}
