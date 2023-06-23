<?php

namespace App\Http\Services;

use App\Http\Repositories\CandidateRepository;

class CandidateService
{
    private $candidateRepository, $fileService;

    public function __construct(CandidateRepository $candidateRepository, FileService $fileService)
    {
        $this->candidateRepository = $candidateRepository;
        $this->fileService = $fileService;
    }

    public function get($data = null){
        $init = $this->candidateRepository->get($data);
        return $init;
    }

    public function update($data){
        $where = $data['email'];

        //upload file if new is exist
        if(!empty($data['resume_link'])){
            $getData = $this->candidateRepository->get([
                "where" => ['email' => $data['email']]
            ])[0];

            if(!empty($getData['resume_link'])){
                $this->fileService->deleteFileLocalPath([
                    'link' => $getData['resume_link']
                ]);
            }

            $data['resume_link'] = $this->fileService->uploadResumeAndGetPath($data);
        }

        $init = $this->candidateRepository->update([
            "where" => ["email" => $where],
            "updateData" => $data
        ]);

        return $init;
    }

    public function create($data){
        if(!empty($data['resume_link'])){
            $data['resume_link'] = $this->fileService->uploadResumeAndGetPath($data);
        }
        $init = $this->candidateRepository->create(["data" => $data]);
        return $init;
    }

    public function delete($data){
        $getData = $this->candidateRepository->get([
            "where" => ['email' => $data['email']]
        ])[0];

        $this->fileService->deleteFileLocalPath([
            'link' => $getData['resume_link']
        ]);

        $init = $this->candidateRepository->delete([
            'where' => ['email' => $data['email']]
        ]);
        return $init;
    }
}
