
# TMDB Fetcher Project

## Project Setup

1. **Configuration**:
    - copy .env from env.example
    - Add your TMDB API key to `.env`:
      ```
      TMDB_API_KEY=your_api_key
      ```

2. **Start Docker**:
    ```bash
    docker compose -f compose.dev.yaml up --build -d
    ```

3. **Install Dependencies**:
    ```bash
    docker compose -f compose.dev.yaml exec workspace composer install
    npm install && npm run dev
    ```

4. **Run Database Migrations**:
    ```bash
    docker compose -f compose.dev.yaml exec workspace php artisan migrate
    ```

5. **Fetch Data from TMDB**:
    - Run the command to dispatch the job:
      ```bash
      docker compose -f compose.dev.yaml exec workspace php artisan tmdb:fetch
      ```
    - Remember to run the queue worker to process the job:
      ```bash
      docker compose -f compose.dev.yaml exec workspace php artisan queue:work --once
      ```

---

## API Endpoints

All endpoints support pagination and the `Accept-Language` header (pl, en, de). The default language is `en`.

### 1. Movies

**GET** `/api/movies`
- Returns a list of movies (paginated, 50 per page).
- **Example Usage**:
  ```bash
  curl -H "Accept-Language: pl" "http://localhost/api/movies?page=1"
  ```

**GET** `/api/movies/{id}`
- Returns details of a specific movie.
- `{id}` is the database record ID (not TMDB ID).
- **Example Usage**:
  ```bash
  curl -H "Accept-Language: en" http://localhost/api/movies/1
  ```

### 2. Series

**GET** `/api/series`
- Returns a list of series (paginated, 10 per page).
- **Example Usage**:
  ```bash
  curl -H "Accept-Language: de" "http://localhost/api/series?page=2"
  ```

**GET** `/api/series/{id}`
- Returns details of a specific series.
- **Example Usage**:
  ```bash
  curl http://localhost/api/series/1
  ```

### 3. Genres

**GET** `/api/genres`
- Returns a list of genres (paginated, 50 per page).
- **Example Usage**:
  ```bash
  curl -H "Accept-Language: pl" http://localhost/api/genres
  ```

**GET** `/api/genres/{id}`
- Returns details of a specific genre.
- **Example Usage**:
  ```bash
  curl http://localhost/api/genres/5
  ```
### 4. Scramble
to access API docs use: http://localhost/api/docs

## Frontend (Livewire)

The project includes a Livewire component to browse movies.

**URL**: `http://localhost/movies`

## Tests 

This project uses PHPUnit for testing.

```bash
php artisan test
```
