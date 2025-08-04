# Logistics Dashboard

A web-based logistics dashboard built with PHP and Blade templating. This application provides real-time insights, analytics, and management tools for logistics operations.

## Table of Contents

-   [Installation](#installation)
-   [API Usage](#api-usage)
-   [Deployment Details](#deployment-details)
-   [Integration (Frontend to Backend)](#integration-frontend-to-backend)
-   [Customization](#customization)

## Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/MikhailAquino/logistics-dashboard.git
    cd logistics-dashboard
    ```

2. **Install PHP dependencies:**

    ```bash
    composer install
    ```

3. **Set up environment:**

    - Copy `.env.example` to `.env` and configure your database and application settings.
    - Generate application key:
        ```bash
        php artisan key:generate
        ```

4. **Run database migrations (if applicable):**

    ```bash
    php artisan migrate
    ```

5. **Start the development server:**

    ```bash
    php artisan serve
    ```

    The dashboard will be available at `http://localhost:8000/`.

## API Usage

The application exposes a RESTful API for warehouse proximity calculations.

**Base Endpoint:** `/api/v1/warehouses/proximity`

### Example Request

```http
POST https://warehouse-proximity.onrender.com
Content-Type: application/json

{
  "warehouse": [14.5995, 120.9842],
  "delivery": [14.6000, 120.9850],
  "radius": 250
}
```

### Example Response

```json
{
    "distance": 102.42,
    "within_range": true
}
```

## Deployment Details

-   **Requirements**:

    -   PHP >= 8.0
    -   Composer
    -   MySQL or PostgreSQL recommended

-   **Production Deployment**:

    -   Deploy on shared hosting, a VPS, or cloud services (e.g., AWS, DigitalOcean).
    -   Set up a web server (Apache/Nginx) pointing to the `public/` directory.

-   **Environment Variables**:

    -   Set `APP_ENV`, `APP_KEY`, `DB_*` variables, and any API keys.

## Integration (Frontend to Backend)

-   **Blade Templates**:  
    Use Blade for dynamic server-side rendering.
-   **AJAX/JS Integration**:  
    For dynamic data updates, use AJAX calls to `/api/*` endpoints.
-   **API Structure**:  
    Extend API endpoints in `routes/api.php` for frontend consumption.

## Customization

-   **UI Styling**:  
    Modify Blade templates in `resources/views/` and update CSS/JS in `public/`.
-   **Add Widgets/Modules**:  
    Add new features by creating Blade components and updating controllers.
