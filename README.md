# P_001: BenHub Restaurant Appointment System

## Description

BenHub is a restaurant appointment system designed to streamline reservation bookings for customers. Users can book appointments for their preferred date and time, choose the reservation floor and table, and specify the number of guests. The system does not require user login for making reservations but includes an admin panel with login functionality for managing reservations.

**Features:**
- **Architecture:** Hybrid structure combining Modular Programming, MVC (Model-View-Controller), and RESTful APIs.
- **User Interface:** Built with HTML, CSS, and Bootstrap v5.3, utilizing JavaScript Fetch API for asynchronous interactions.
- **Backend:** Powered by PHP acting as an API server and routing traffic via a Front Controller.
- **Database Management:** PostgreSQL for robust data management and administration.
- **Reservation Workflow:** Real-time table availability, confirmation codes, guest occasions, special requests, and status-based reservation management.
- **Admin Dashboard:** Search, filters, booking metrics, reservation status updates, and delete actions.

## Table of Contents

1. [Installation](#installation)
2. [Usage](#usage)
3. [Project Structure](#project-structure)
4. [Author](#author)
5. [Acknowledgements](#acknowledgements)

## Installation

To set up the BenHub system on your local machine, follow these steps:

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/xtianvelasquez/p_001.git
   ```

2. **Navigate to the Project Directory:**
   ```bash
   cd p_001
   ```

3. **Set Up PostgreSQL:**
   - Ensure PostgreSQL is installed and running.
   - Create a database named `benhub`.
   - Import the `benhub_postgres.sql` file to set up the schema.
   - For an existing database, run `migrations/2026_06_05_top_tier_reservations.sql` to add the upgraded reservation fields and table inventory.

4. **Configure the Database Connection:**
   - Copy the `config/database.php.example` file and rename it to `config/database.php`.
   - Update the `password` field in `config/database.php` with your local PostgreSQL credentials.

5. **Run the Application:**
   - Use PHP's built-in server to serve the application, pointing the document root to the `public` directory:
   ```bash
   cd public
   php -S localhost:8000
   ```
   - Access the application at `http://localhost:8000`.



## Usage

- **Index Page:** Features a dashboard with the brand name, about us section, contact section, navigations for reservation and  terms and conditions.
- **Reservation Form:** Access the form from the reservation button in the dashboard. Fill out the form with required details, including date, time, reservation floor and table, number of guests, etc.
- **Admin Panel:** Accessible via login credentials. Admins can view and manage all reservations, including deletion.

## Project Structure

- **`/bootstrap`**: Downloaded Bootstrap v5.3 files.
- **`/extras`**: Contains navigations, header, copyright.
- **`/images`**: Includes images used in the project (e.g., restaurant logo, image).
- **`/sql`**: Contains the `.sql` file for database setup.

## Author

- [@xtianvelasquez](https://github.com/xtianvelasquez)

## Acknowledgements

- **Bootstrap v5.3**: For styling and responsive design.
- **PHP**: For backend development.
- **JavaScript**: For client-side validation and interactivity.
- **XAMPP**: For local server setup.
- **HeidiSQL**: For database management.
- **Visual Studio Code**: For development.
