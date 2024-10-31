<?php

namespace src\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;

require_once __DIR__ . '/../utils.php';

class LoanController
{
    public function createLoanApplication(array $data, Response $response, &$loanApplications)
    {
        $nameValidator = v::stringType()->length(3, null)->contains(' ');
        $amountValidator = v::intVal()->between(1000, 10000);
        $purposeValidator = v::stringType()->containsAny(['vacation', 'renovation', 'electronics', 'wedding', 'rent', 'car', 'investment']);
        $dobValidator = v::date('Y-m-d');
        $sexValidator = v::in(['male', 'female']);

        $dob = $data['date_of_birth'] ?? null;
        $sex = $data['sex'] ?? null;
        $ktp = $data['ktp'] ?? null;

        if (!isValidKTP($ktp, $dob, $sex)) {
            $response->getBody()->write(json_encode(['error' => 'Invalid KTP number']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        try {
            $nameValidator->assert($data['name']);
            $amountValidator->assert($data['loan_amount']);
            $purposeValidator->assert($data['loan_purpose']);
            $dobValidator->assert($data['date_of_birth']);
            $sexValidator->assert($data['sex']);

            $loanApplication = [
                'id' => count($loanApplications) + 1,
                'name' => $data['name'],
                'ktp' => $data['ktp'],
                'loan_amount' => $data['loan_amount'],
                'loan_period' => $data['loan_period'],
                'loan_purpose' => $data['loan_purpose'],
                'date_of_birth' => $data['date_of_birth'],
                'sex' => $data['sex'],
            ];

            $loanApplications[] = $loanApplication;

            $response->getBody()->write(json_encode($loanApplication));
            logEvent($loanApplication);
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');

        } catch (\Respect\Validation\Exceptions\ValidationException $exception) {
            $errors = $exception->getMessages();
            $response->getBody()->write(json_encode(['errors' => $errors]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    }

    public function getLoanApplications(Response $response, $loanApplications)
    {
        $response->getBody()->write(json_encode($loanApplications));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
