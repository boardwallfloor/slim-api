# Running the Server and Testing the Loan Application API

## Prerequisites

Before running the server and tests, ensure you have the following installed:

- PHP (version >= 8.1.2)
- Composer
- PHPUnit (installed globally or via Composer)

## Setting Up the Project

1. **Getting Project File**
   Either clone the project from git link
   ```
   https://github.com/boardwallfloor/slim-api
   ```
   or from attached email file
2. **Install Dependencies**

   Install the required PHP packages via Composer:

   ```bash
   composer install
   ```

## Running the Server

You can use PHP's built-in server for development purposes:

1. **Navigate to the Project Directory**

   Change to the directory containing your `index.php` or the entry point of your application:

   ```bash
   cd <your-project-directory>
   ```

2. **Start the PHP Built-in Server**

   Run the following command to start the server:

   ```bash
   php -S localhost:8000 ./index.php
   ```

   - The server will be accessible at `http://localhost:8000`.

3. **Hitting Endpoint**

   Open your API client and hit:

   ```curl
   http://localhost:8000/loans
   ```

   Avalaible method are GET and POST

   Sample payload for POST

   ```json
   {
     "name": "John Doe",
     "ktp": "1234560112991234",
     "loan_amount": 5000,
     "loan_period": 12,
     "loan_purpose": "vacation",
     "date_of_birth": "1999-12-01",
     "sex": "male"
   }
   ```

   To monitor created log file run

   ```bash
   tail -f event_log.txt
   ```

## Running PHPUnit Tests

To ensure your application works correctly, run the PHPUnit tests:

1. **Navigate to the Test Directory**

   Ensure you are in the root directory of your project or the directory where your test files are located.

2. **Run PHPUnit**

   Execute the following command to run the tests:

   ```bash
   vendor/bin/phpunit test/test.php
   ```

   - If PHPUnit is installed globally, you can simply run:
     ```bash
     phpunit test/test.php
     ```

3. **View the Test Results**

   PHPUnit will output the results of the tests in the terminal. Review the results to ensure all tests pass.
