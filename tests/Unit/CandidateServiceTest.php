<?php

namespace Tests\Unit;

use App\Http\Repositories\CandidateRepository;
use App\Http\Services\CandidateService;
use App\Http\Services\FileService;
use App\Models\Candidate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CandidateServiceTest extends TestCase
{
    protected $candidateService, $mockData, $testFileName;

    protected function setUp(): void
    {
        parent::setUp();

        //Mock the dependencies
        $model = new Candidate();
        $candidateRepository = new CandidateRepository($model);
        $fileService = new FileService;
        $this->candidateService = new CandidateService($candidateRepository, $fileService);

        $this->testFileName = "this-is-test-file.pdf";

        $this->mockData = [
            'name' => 'test123',
            'email' => 'test123@gmail.com',
            'phone' => '085211223344',
            'education' => 'Bachelor',
            'birthday' => '1999-01-01',
            'experience' => '5 Year',
            'last_position' => 'Back-End Developer',
            'applied_position' => 'Full-Stack Developer',
            'skill' => 'PHP,NODEJS,LARAVEL',
            'resume_link' => UploadedFile::fake()->create($this->testFileName)
        ];
    }

    public function test_get_candidate_classCandidateService()
    {
        $response = $this->candidateService->get();

        if(!empty($response)){
            return $this->assertInstanceOf(Collection::class, $response);
        } else {
            return "pls input some data in database for test first";
        }
    }

    public function test_store_candidate_classCandidateService(): void
    {
        //create
        $this->candidateService->create($this->mockData);

        //get
        $getData = $this->candidateService->get([
            "where" => ['email' => $this->mockData['email']]
        ]);

        //change file to string to match string in DB
        $this->mockData['resume_link'] = $this->testFileName;

        //check
        $this->assertEquals($getData->toArray()[0], $this->mockData);

        //remove
        $this->candidateService->delete([
            'email' => $this->mockData['email']
        ]);
    }

    public function test_update_candidate_classCandidateService(): void
    {
        // create
        $this->candidateService->create($this->mockData);

        //init mod name
        $modifiedName = 'this is new name';
        $this->mockData['name'] = $modifiedName;

        //update
        $this->candidateService->update($this->mockData);

        //get
        $getData = $this->candidateService->get([
            "where" => ['email' => $this->mockData['email']]
        ]);

        //check updated data
        $this->assertEquals($getData->toArray()[0]['name'], $modifiedName);

        //delete
        $this->candidateService->delete([
            'email' => $this->mockData['email']
        ]);
    }

    public function test_delete_candidate_classCandidateService(): void
    {
        // create
        $this->candidateService->create($this->mockData);

        //get
        $getData = $this->candidateService->get([
            "where" => ['email' => $this->mockData['email']]
        ])[0];

        //delete according to get
        $this->candidateService->delete([
            'email' => $getData['email']
        ]);

        //get again to check
        $getData = $this->candidateService->get([
            "where" => ['email' => $this->mockData['email']]
        ]);

        $this->assertEmpty($getData);
    }
}
