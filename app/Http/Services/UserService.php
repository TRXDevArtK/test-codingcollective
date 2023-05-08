<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function get($data = null){
        $init = $this->userRepository->get($data);
        return $init;
    }

    public function update($data){
        $init = $this->userRepository->update($data);
        return $init;
    }

    public function create($data){
        $init = $this->userRepository->create($data);
        return $init;
    }

    public function updateOrCreate($data){
        $init = $this->userRepository->updateOrCreate($data);
        return $init;
    }

    public function delete($data){
        $init = $this->userRepository->delete($data);
        return $init;
    }
}
