# Grocery Service Project

## Project Setup

1. **Clone the repository**:
    ```bash
    git clone git@github.com:esraanfq/task.git
    cd task
    ```

2. **Build and start the Docker containers**:
    ```bash
    docker-compose up --build
    docker exec -it symfony_app /bin/bash
    ```

3. **Install dependencies**:
    ```bash
    composer install
    ```

4. **Set up the database**:
    ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:schema:update --force
    ```

## Running Tests
first you need to create a test database
```bash
  php bin/console --env=test doctrine:database:create
  php bin/console --env=test doctrine:schema:create
  php bin/console --env=test doctrine:fixtures:load
```
To run the unit and integration tests, use the following command:
```bash
  bin/phpunit
 ```
## Usage
1**Access the application**:
    Open your browser and navigate to `http://localhost:8080`.

## API Endpoints

### Get Groceries

- **URL**: `/api/grocery`
- **Method**: `GET`
- **Description**: Retrieve a list of groceries.
- **Query Parameters**:
  - `page` (optional): Page number for pagination.
  - `limit` (optional): Number of items per page.
  - Additional filters can be applied as query parameters.

**Example Request**:
```bash
curl -X GET 'http://localhost:8080/api/grocery?page=1&limit=10'
```
### Create Grocery

- **URL**: `/api/grocery`
- **Method**: `POST`
- **Description**: Create a new grocery item.
- **Request Body**:
  - `name` (string): Name of the grocery item.
  - `type` (string): Type of the grocery item (e.g., `fruit`, `vegetable`).
  - `quantity` (integer): Quantity of the grocery item.
  - `unit` (string): Unit of the grocery item (e.g., `g`, `kg`).

**Example Request**:
```bash
curl -X POST 'http://localhost:8080/api/grocery' \
-H 'Content-Type: application/json' \
-d '{
  "name": "Apple",
  "type": "fruit",
  "quantity": 1000,
  "unit": "g"
}'
``` 
### Process File

- **URL**: `/api/process`
- **Method**: `POST`
- **Description**: Process a file to add groceries.

**Example Request**:
```bash
curl -X POST 'http://localhost:8080/api/process'
```
