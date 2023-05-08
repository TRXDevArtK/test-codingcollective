<?php

namespace App\Http\Repositories;

use App\Models\User;

class UserRepository
{
    private $model;

    //NOTE : Most of it is masking, you can create own function with own specific algorithm later if needed
    //Like i want to get user but orderby + where + or update or delete if not there, etc
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function get($data){
        $init = $this->model;

        if(!empty($data['where'])){
            foreach($data['where'] as $whereKey => $whereVal){
                $init = $init->where($whereKey, $whereVal);
            }
        }

        return $init->get();
    }

    public function update($data){
        $init = $this->model;

        if(!empty($data['where'])){
            foreach($data['where'] as $whereKey => $whereVal){
                $init = $init->where($whereKey, $whereVal);
            }
        }

        if(!empty($data['updateData'])){
            $init = $init->update($data['updateData']);
        }

        return $init;
    }

    public function create($data){
        $init = $this->model;

        $init = $init->create($data['data']);

        return $init->id;
    }

    public function delete($data){
        $init = $this->model;

        if(!empty($data['where'])){
            foreach($data['where'] as $whereKey => $whereVal){
                $init = $init->where($whereKey, $whereVal);
            }
        }

        return $init->delete();
    }

    public function updateOrCreate($data){
        $init = $this->model;

        $init = $init->updateOrCreate($data['where'], $data['data']);

        return $init;
    }
}
