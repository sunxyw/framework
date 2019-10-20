<?php

namespace Framework\Model\Traits;

trait ModelHelpers
{
    static public function all($array = false)
    {
        $projects = (new self())->getQuery()->find();

        if ($array) {
            $data = [];
            foreach ($projects as $project) {
                $data[] = $project->toJson();
            }
            $projects = $data;
        }

        return $projects;
    }
}
