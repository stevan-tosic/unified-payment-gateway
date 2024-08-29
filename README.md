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
    docker compose -f docker/docker-compose.dev.yml up --build -d
    ```

3. Install Composer dependencies:
    ```sh
    docker compose -f docker/docker-compose.dev.yml exec php composer install
    ```

## Running the Project

1. Access the application in your browser at `http://localhost:9879`.
2. SSH into the PHP container:
    ```sh
    docker compose -f docker/docker-compose.dev.yml exec php bash
    ```

[//]: # (TODO add instructions to ssh into the php container)
## Running Tests

### Unit Tests

To run unit tests:
```sh
docker compose -f docker/docker-compose.dev.yml exec php make test-unit
```

### Integration Tests

To run integration tests:
```sh
docker compose -f docker/docker-compose.dev.yml exec php make test-integration
```

### Functional Tests

To run functional tests:
```sh
docker compose -f docker/docker-compose.dev.yml exec php make test-functional
```

### Code Coverage

To generate code coverage reports:
```sh
docker compose -f docker/docker-compose.dev.yml exec php make coverage
```

Note
It is easier to run make commands from inside the Docker container. You can SSH into the PHP container and run the commands directly:
```sh
docker compose -f docker/docker-compose.dev.yml exec php bash
# Now inside the container, you can run:
make test-unit
make test-integration
make test-functional
make coverage
```
