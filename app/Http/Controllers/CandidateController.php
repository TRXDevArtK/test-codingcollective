<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use App\Http\Services\CandidateService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    private $candidateService, $authService;

    public function __construct(CandidateService $candidateService, AuthService $authService)
    {
        $this->candidateService = $candidateService;
        $this->authService = $authService;
    }

    /**
     * @OA\Get(
     *     path="/candidate",
     *     tags={"candidate"},
     *     summary="candidate get",
     *     description="this is route use to read all candidate data",
     *     operationId="candidate-get",
     *
     *     @OA\Response(
     *         response="default",
     *         description="will result in list of candidate array"
     *     )
     * )
     */
    public function get()
    {
        $permission = json_decode($this->authService->getLoginUserData()['candidate_permission'])[0];
        if($permission === 0){
            return "you don't have permission to get";
        }

        $init = $this->candidateService;

        try {
            return "<pre>".json_encode($init->get(), JSON_PRETTY_PRINT)."<pre>";
        } catch (\Throwable $th) {
            return ["something error", $th];
        }
    }

    /**
     * @OA\Post(
     *     path="/candidate",
     *     tags={"candidate"},
     *     summary="Candidate store",
     *     description="this is route use to store candidate data",
     *     operationId="candidate-store",
     *     @OA\Parameter(
     *          name="name",
     *          description="name input max 255, example : Rulaina Velania",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="email",
     *          description="email input max 255, example : vedartk@gmail.com",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *      @OA\Parameter(
     *          name="phone",
     *          description="phone input max 255, example : 085211223344",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="education",
     *          description="education input max 255, example : Bachelor Degree",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="birthday",
     *          description="birthday date inout, example : 2019-02-01",
     *          in="query",
     *          @OA\Schema(
     *              type="date"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="experience",
     *          description="experience input max 255, example : 12 year exp",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="last_position",
     *          description="last_position input max 255, example : Back-End Developer",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="applied_position",
     *          description="applied_position input max 255, example : Full-Stack Developer",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="skill",
     *          description="skill input max 255, example : PHP,HTML,JS,CSS,Laravel/NodeJS",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="resume_link",
     *          description="resume_link input file, example : {{choose your file from computer}}",
     *          in="query",
     *          @OA\Schema(
     *              type="file"
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="will show [success data created]"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $permission = json_decode($this->authService->getLoginUserData()['candidate_permission'])[1];
        if($permission === 0){
            return "you don't have permission to store/create";
        }

        $init = $this->candidateService;
        $validatedRequest = array_filter($request->validate([
            'name' => 'nullable|string',
            'email' => 'required|string',
            'phone' => 'nullable|string',
            'education' => 'nullable|string',
            'birthday' => 'nullable|string',
            'experience' => 'nullable|string',
            'last_position' => 'nullable|string',
            'applied_position' => 'nullable|string',
            'skill' => 'nullable|string',
            'resume_link' => 'nullable|file',
        ]));

        try {
            $init->create($validatedRequest);
            return "success data created";
        } catch (\Throwable $th) {
            return ["something error", $th];
        }
    }

    /**
     * @OA\Post(
     *     path="/candidate/update",
     *     tags={"candidate"},
     *     summary="Candidate update",
     *     description="this is route use to update candidate data",
     *     operationId="candidate-update",
     *     @OA\Parameter(
     *          name="name",
     *          description="name input max 255, example : Rulaina Velania",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="email",
     *          description="email input max 255, example : vedartk@gmail.com",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *      @OA\Parameter(
     *          name="phone",
     *          description="phone input max 255, example : 085211223344",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="education",
     *          description="education input max 255, example : Bachelor Degree",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="birthday",
     *          description="birthday date inout, example : 2019-02-01",
     *          in="query",
     *          @OA\Schema(
     *              type="date"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="experience",
     *          description="experience input max 255, example : 12 year exp",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="last_position",
     *          description="last_position input max 255, example : Back-End Developer",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="applied_position",
     *          description="applied_position input max 255, example : Full-Stack Developer",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="skill",
     *          description="skill input max 255, example : PHP,HTML,JS,CSS,Laravel/NodeJS",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="resume_link",
     *          description="resume_link input file, example : {{choose your file from computer}}",
     *          in="query",
     *          @OA\Schema(
     *              type="file"
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="will show [success data updated]"
     *     )
     * )
     */
    public function update(Request $request)
    {
        $permission = json_decode($this->authService->getLoginUserData()['candidate_permission'])[2];
        if($permission === 0){
            return "you don't have permission to update";
        }

        $init = $this->candidateService;
        $validatedRequest = array_filter($request->validate([
            'name' => 'nullable|string',
            'email' => 'required|string',
            'phone' => 'nullable|string',
            'education' => 'nullable|string',
            'birthday' => 'nullable|string',
            'experience' => 'nullable|string',
            'last_position' => 'nullable|string',
            'applied_position' => 'nullable|string',
            'skill' => 'nullable|string',
            'resume_link' => 'nullable|file',
        ]));

        try {
            $result = $init->update($validatedRequest);
            if($result === 0){
                throw new Exception("Something error, pls check if data is there or not");
            }
            return "success data updated";
        } catch (\Throwable $th) {
            return ["something error", $th];
        }
    }

    /**
     * @OA\Post(
     *     path="/candidate/delete",
     *     tags={"candidate"},
     *     summary="Candidate delete",
     *     description="this is route use to delete candidate data",
     *     operationId="candidate-delete",
     *     @OA\Parameter(
     *          name="email",
     *          description="email input max 255, example : vedartk@gmail.com",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="will show [success data deleted]"
     *     )
     * )
     */
    public function delete(Request $request)
    {
        $permission = json_decode($this->authService->getLoginUserData()['candidate_permission'])[3];
        if($permission === 0){
            return "you don't have permission to delete";
        }

        $init = $this->candidateService;
        $validatedRequest = array_filter($request->validate([
            'name' => 'nullable|string',
            'email' => 'required|string',
            'phone' => 'nullable|string',
            'education' => 'nullable|string',
            'birthday' => 'nullable|string',
            'experience' => 'nullable|string',
            'last_position' => 'nullable|string',
            'applied_position' => 'nullable|string',
            'skill' => 'nullable|string',
            'resume_link' => 'nullable|file',
        ]));

        try {
            $init->delete($validatedRequest);
            return "success data deleted";
        } catch (\Throwable $th) {
            return ["something error", $th];
        }
    }
}
