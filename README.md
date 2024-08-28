# Payment Processing Application

## Project Setup

### Prerequisites

- Docker
- Docker Compose

### Installation

1. Clone the repository:
    ```sh
    git clone https://github.com/your-repo/payment-processing-app.git
    cd payment-processing-app
    ```

2. Build and start the Docker containers:
    ```sh
    docker-compose -f docker/docker-compose.dev.yml up --build -d
    ```

## Running the Project

1. Access the application in your browser at `http://localhost:9879`.

## Running Tests

### Unit Tests

To run unit tests:
```sh
docker-compose -f docker/docker-compose.dev.yml exec php make test-unit
```

### Integration Tests

To run integration tests:
```sh
docker-compose -f docker/docker-compose.dev.yml exec php make test-integration
```

### Functional Tests

To run functional tests:
```sh
docker-compose -f docker/docker-compose.dev.yml exec php make test-functional
```

### Code Coverage

To generate code coverage reports:
```sh
docker-compose -f docker/docker-compose.dev.yml exec php make coverage
```
