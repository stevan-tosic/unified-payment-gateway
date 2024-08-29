# Payment Processing Application
## Project Setup
### Prerequisites
- Docker
- Docker Compose
### Installation
1. Clone the repository:

   git clone https://github.com/your-repo/payment-processing-app.git
   cd payment-processing-app

2. Build and start the Docker containers:
   ```shell
   docker compose -f docker/docker-compose.dev.yml up --build -d
   ```
3. Install Composer dependencies:
   ```shell
    docker compose -f docker/docker-compose.dev.yml exec php composer install
   ```

## Running the Project
1. Access the application in your browser at http://localhost:9879.
2. SSH into the PHP container:
   ```shell
   docker compose -f docker/docker-compose.dev.yml exec php bash
   ```
   

## Running Tests
### Unit Tests
To run unit tests:
   ```shell
   docker compose -f docker/docker-compose.dev.yml exec php make test-unit
   ```

### Integration Tests
To run integration tests:
    ```shell
    docker compose -f docker/docker-compose.dev.yml exec php make test-integration
    ```
### Functional Tests
To run functional tests:
    ```shell
    docker compose -f docker/docker-compose.dev.yml exec php make test-functional
    ```
### Code Coverage
To generate code coverage reports:
    ```shell
    docker compose -f docker/docker-compose.dev.yml exec php make coverage
    ```
Note: It is easier to run make commands from inside the Docker container. You can SSH into the PHP container and run the commands directly:
docker compose -f docker/docker-compose.dev.yml exec php bash
# Now inside the container, you can run:
```shell
make test-unit
make test-integration
make test-functional
make coverage
```
# Payment Gateway API - Process Payment
## Overview
This document provides instructions on how to interact with the Payment Processing endpoint of the Payment Gateway API, both through HTTP requests and via command line.
## Endpoint Details
**URL**: http://localhost:9879/api/v1/payment/process/{shift4|aci}
**Method**: POST

## Swagger Documentation
You can view the Swagger documentation for the Payment Gateway API, which provides a detailed interactive documentation of all available endpoints, by visiting the following URL:
http://localhost:9879/api/v1/payment/doc/swaggers#/default/post_process__service_
This documentation will allow you to explore the API's functionalities, try out the endpoints directly from your browser, and view the expected request and response formats.

## Request
### Path Parameters
- **service**: This should be included in the URL. For this endpoint, the service is predefined as shift4.
### Headers
```shell
Content-Type: application/json
```
### Body Parameters
The following JSON structure shows the required fields in the request body:
```json
{
"amount": 92.00,
"currency": "EUR",
"cardNumber": "4200000000000000",
"cardExpYear": 2034,
"cardExpMonth": "05",
"cardCvv": "123"
}
```
#### Field Descriptions
- **amount** (number): The total amount to be charged.
- **currency** (string): The currency in which the amount is specified (e.g., EUR, USD).
- **cardNumber** (string): The credit card number.
- **cardExpYear** (integer): The expiration year of the credit card.
- **cardExpMonth** (string): The expiration month of the credit card.
- **cardCvv** (string): The CVV code of the credit card.
## Command Line Usage
You can also process payments using the command line interface provided by Symfony. Here's how you can invoke the payment processing command:
```shell
php bin/console payment:process shift4 --amount="92.01" --currency=EUR --cardNumber=4200000000000000 --cardExpYear=2034 --cardExpMonth=05 --cardCvv=123
php bin/console payment:process aci --amount="92.01" --currency=EUR --cardNumber=4200000000000000 --cardExpYear=2034 --cardExpMonth=05 --cardCvv=123
```
it can be run outside container as well
```shell
docker compose -f docker/docker-compose.dev.yml exec php bin/console payment:process shift4 --amount="92.01" --currency=EUR --cardNumber=4200000000000000 --cardExpYear=2034 --cardExpMonth=05 --cardCvv=123
docker compose -f docker/docker-compose.dev.yml exec php bin/console payment:process aci --amount="92.01" --currency=EUR --cardNumber=4200000000000000 --cardExpYear=2034 --cardExpMonth=05 --cardCvv=123
```
### Successful Command Line Response
```shell
Payment processed with shift4: {"transactionId":"char_KBbSDD4liS1cjERd8F5wrAbg","dateOfCreation":"2024-08-29 07:21:12","amount":92,"currency":"EUR","cardBin":"420000"}
Payment processed with aci: {"transactionId":"8ac7a4a0919c17f801919d10c60c277a","dateOfCreation":"1970-01-01 00:33:44","amount":92.01,"currency":"EUR","cardBin":"420000"}
```
This response indicates that the payment was successfully processed via the command line. It includes the transaction ID, the date the transaction was created, the amount and currency of the transaction, and the BIN number of the card used.
## HTTP Response
### Successful Response
**Code**: 200 OK
```json
{
"transactionId": "char_OdFAriy3yaIdsQDEeoyCZILq",
"dateOfCreation": "2024-08-29 07:18:45",
"amount": 92,
"currency": "EUR",
"cardBin": "420000"
}
```
This response indicates that the payment was processed successfully. It includes the transaction ID, the date the transaction was created, the amount and currency of the transaction, and the BIN number of the card used.

This response indicates that there was an error in processing the payment due to an invalid card number or other input validation issues.
## Example of HTTP Usage
Here's an example of how to use curl to make a request to this endpoint:
```shell
curl -X POST http://localhost:9879/api/v1/payment/process/shift4 \
-H "Content-Type: application/json" \
-d '{
"amount": 92.00,
"currency": "EUR",
"cardNumber": "4200000000000000",
"cardExpYear": 2034,
"cardExpMonth": "05",
"cardCvv": "123"
}'
```
This command will send a POST request to the payment processing endpoint with the necessary details to process a payment.