<?php

namespace tests\Controllers;

use PHPUnit\Framework\TestCase;
use src\Controllers\LoanController;
use Slim\Psr7\Response;

class LoanControllerTest extends TestCase
{
    private $loanController;
    private $loanApplications;

    protected function setUp(): void
    {
        $this->loanController = new LoanController();
        $this->loanApplications = [];
    }

    public function testCreateLoanApplicationSuccessfully()
    {
        $data = [
            'name' => 'John Doe',
            'ktp' => '1234560112991234',
            'loan_amount' => 5000,
            'loan_period' => 12,
            'loan_purpose' => 'vacation',
            'date_of_birth' => '1999-12-01',
            'sex' => 'male'
        ];

        $response = new Response();

        $result = $this->loanController->createLoanApplication($data, $response, $this->loanApplications);

        $this->assertEquals(201, $result->getStatusCode());

        $expectedBody = json_encode([
            'id' => 1,
            'name' => 'John Doe',
            'ktp' => '1234560112991234',
            'loan_amount' => 5000,
            'loan_period' => 12,
            'loan_purpose' => 'vacation',
            'date_of_birth' => '1999-12-01',
            'sex' => 'male'
        ]);
        $this->assertEquals($expectedBody, (string)$result->getBody());

        $this->assertCount(1, $this->loanApplications);
    }

    public function testCreateLoanApplicationWithInvalidKTP()
    {
        $data = [
            'name' => 'Jane Doe',
            'ktp' => 'invalid_ktp',
            'loan_amount' => 5000,
            'loan_period' => '12 months',
            'loan_purpose' => 'vacation',
            'date_of_birth' => '1990-01-01',
            'sex' => 'female',
        ];

        $response = new Response();

        $result = $this->loanController->createLoanApplication($data, $response, $this->loanApplications);

        $this->assertEquals(400, $result->getStatusCode());

        $expectedBody = json_encode(['error' => 'Invalid KTP number']);
        $this->assertEquals($expectedBody, (string)$result->getBody());

        $this->assertCount(0, $this->loanApplications);
    }

    public function testCreateLoanApplicationWithValidationError()
    {
        $data = [
            'name' => 'JD',
            'ktp' => '1234567890123456',
            'loan_amount' => 500,
            'loan_period' => '12 months',
            'loan_purpose' => 'invalid_purpose',
            'date_of_birth' => '1990-01-01',
            'sex' => 'unknown',
        ];

        $response = new Response();

        $result = $this->loanController->createLoanApplication($data, $response, $this->loanApplications);

        $this->assertEquals(400, $result->getStatusCode());

        $body = json_decode((string)$result->getBody(), true);
        $this->assertArrayHasKey('error', $body);
        $this->assertEquals('Invalid KTP number', $body['error']);
    }

    public function testGetLoanApplications()
    {
        $this->testCreateLoanApplicationSuccessfully();

        $response = new Response();
        $result = $this->loanController->getLoanApplications($response, $this->loanApplications);

        $this->assertEquals(200, $result->getStatusCode());

        $expectedBody = json_encode($this->loanApplications);
        $this->assertEquals($expectedBody, (string)$result->getBody());
    }
}
