# AI Agent Guide: Hybrid Architecture (Modular, MVC, RESTful API)

This guide outlines the target architecture for this project. As an AI agent working on this codebase, you are expected to follow these architectural principles, migrating the existing procedural PHP code towards a hybrid structure combining Modular Programming, Model-View-Controller (MVC) patterns, and RESTful APIs.

## 1. Architectural Overview
The system utilizes a hybrid approach:
- **Modular Programming**: Code is separated into independent, interchangeable modules based on business domains (e.g., Auth, Admin, Reservation, Tickets).
- **MVC (Model-View-Controller)**: Each module implements MVC to separate data handling (Model), presentation/UI (View), and business logic/routing (Controller).
- **RESTful API**: Communication between the frontend (Views/JS) and backend (Controllers/Models) happens via RESTful JSON APIs, enabling a stateless, decoupled design.

## 2. Directory Structure
```text
/
├── modules/
│   ├── Auth/
│   │   ├── Controllers/
│   │   ├── Models/
│   │   ├── Views/
│   │   └── Routes/
│   ├── Admin/
│   └── Reservation/
├── public/              # Entry point (index.php), CSS, JS, images
│   ├── index.php
│   └── assets/
├── core/                # Core system files (Router, Database interface, Base Controller/Model)
└── config/              # Configuration files (Database, App settings)
```

## 3. Modular Programming Principles
- **Separation of Concerns**: Keep related functionality grouped within a specific module folder.
- **Independence**: A module should ideally be functional even if other modules are removed (or gracefully handle their absence).
- **Namespacing**: Use namespaces to avoid naming collisions (e.g., `namespace App\Modules\Auth\Controllers;`).

## 4. MVC Implementation
- **Model**: Handles database interactions (CRUD). Extends a base Model class. Returns data to the Controller. Never contains HTML or `echo` statements.
- **View**: Contains HTML/UI code. Receives data from the Controller. Minimal logic (only iteration/conditional display). For REST API clients, Views might be purely static HTML/JS frontend files fetching data via AJAX.
- **Controller**: Processes incoming HTTP requests, invokes Models to process data, and returns a response (either an HTML View or a JSON REST API response).

## 5. RESTful API & CRUD Operations
When building APIs, follow RESTful conventions. Controllers should return JSON responses and use appropriate HTTP status codes.

### CRUD Example: `Reservation` Module
| Operation | HTTP Method | Endpoint (Route) | Controller Method | Description |
|---|---|---|---|---|
| **Create** | `POST` | `/api/reservations` | `create()` | Inserts a new reservation. |
| **Read (List)** | `GET` | `/api/reservations` | `index()` | Retrieves a list of reservations. |
| **Read (Single)** | `GET` | `/api/reservations/{id}`| `show($id)` | Retrieves a specific reservation. |
| **Update** | `PUT/PATCH` | `/api/reservations/{id}`| `update($id)` | Updates an existing reservation. |
| **Delete** | `DELETE` | `/api/reservations/{id}`| `delete($id)` | Deletes a reservation. |

### Sample Controller Implementation (PHP)
```php
<?php
namespace App\Modules\Reservation\Controllers;

use App\Core\Controller;
use App\Modules\Reservation\Models\ReservationModel;

class ReservationAPIController extends Controller {
    private $model;

    public function __construct() {
        $this->model = new ReservationModel();
    }

    // CREATE (POST /api/reservations)
    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $this->model->insert($data);
        
        http_response_code(201);
        echo json_encode(["status" => "success", "message" => "Reservation created", "id" => $id]);
    }

    // READ (GET /api/reservations/{id})
    public function show($id) {
        $reservation = $this->model->findById($id);
        if ($reservation) {
            http_response_code(200);
            echo json_encode(["status" => "success", "data" => $reservation]);
        } else {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "Not found"]);
        }
    }

    // UPDATE (PUT /api/reservations/{id})
    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $updated = $this->model->update($id, $data);
        
        http_response_code(200);
        echo json_encode(["status" => "success", "message" => "Reservation updated"]);
    }

    // DELETE (DELETE /api/reservations/{id})
    public function delete($id) {
        $deleted = $this->model->delete($id);
        
        http_response_code(200);
        echo json_encode(["status" => "success", "message" => "Reservation deleted"]);
    }
}
?>
```

## 6. Migration Strategy for AI Agents
When refactoring legacy files (like `db_reservation.php` or `admin_login.php`):
1. **Identify the Domain**: Determine which module the script belongs to (e.g., Reservation, Auth).
2. **Extract Database Logic**: Move SQL queries into the respective Module's Model class. Use PDO prepared statements to prevent SQL injection.
3. **Extract Business Logic**: Move validation and processing into the Module's Controller.
4. **Transform Output**: If it's an API endpoint, return JSON. If it's a UI, create a View file and route the frontend via the main entry point to load it.
5. **Update Routes**: Map the old endpoint behavior to the new routing system in the `core/Router` or specific module's route file.
