<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use src\Controllers\LoanController;

$loanApplications = [
    [
        'id' => 1,
        'name' => 'John Doe',
        'ktp' => '1234560101900001',
        'loan_amount' => 5000,
        'loan_period' => 12,
        'loan_purpose' => 'vacation',
        'date_of_birth' => '1990-01-01',
        'sex' => 'male',
    ],
    [
        'id' => 2,
        'name' => 'Jane Smith',
        'ktp' => '1234564101900002',
        'loan_amount' => 8000,
        'loan_period' => 24,
        'loan_purpose' => 'wedding',
        'date_of_birth' => '1990-01-01',
        'sex' => 'female',
    ],
    [
        'id' => 3,
        'name' => 'Alex Johnson',
        'ktp' => '6543211512850003',
        'loan_amount' => 10000,
        'loan_period' => 36,
        'loan_purpose' => 'car',
        'date_of_birth' => '1985-12-15',
        'sex' => 'male',
    ],
];

$app->post('/loans', function (Request $request, Response $response) use (&$loanApplications) {
    $data = $request->getParsedBody();

    $controller = new LoanController();
    return $controller->createLoanApplication($data, $response, $loanApplications);
});

$app->get('/loans', function (Request $request, Response $response) use (&$loanApplications) {
    $controller = new LoanController();
    return $controller->getLoanApplications($response, $loanApplications);
});
