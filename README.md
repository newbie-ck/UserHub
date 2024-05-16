# UserHub

UserHub is a simple application for managing user registration and login using REST API. It allows users to register, login, update their details, and deactivate their accounts. Additionally, administrators can generate dummy user records concurrently using queue jobs.

## Key Features

1. **User Registration:** Users can register by providing their name, email, username, password, and phone number. Registration is validated against specified rules.
2. **User Login:** Registered users can securely log in using their username and password. Authentication is performed via REST API endpoints.
3. **User Dashboard:** After logging in, users are presented with a dashboard where they can view their profile information and update their details if necessary.
4. **Admin Dashboard:** Administrators have access to a separate dashboard to manage user accounts. They can view user details, deactivate user accounts, and generate dummy user records concurrently.
5. **Data Storage:** User data is securely stored in a database, ensuring data integrity and confidentiality.
6. **REST API:** The application exposes REST API endpoints for user registration, authentication, and data management, enabling seamless integration with other systems.
7. **Concurrency:** UserHub supports concurrent operations, allowing administrators to generate dummy user records efficiently.
8. **Validation and Error Handling:** Form submissions and API requests are validated, and appropriate error messages are displayed to users to ensure data accuracy and user experience.

## Installation

1. **Composer Install:**
    ```bash
    composer install

2. **NPM Install:**
    ```bash
    npm install

3. **Create MySQL Database:**
    ```bash
    Create a MySQL database. You can adjust the database settings in the .env file.

4. **Run the migration:**
    ```bash
    Run the migration

5. **Generate new encryption key:**
    ```bash
    php artisan key:generate

## Take Note

**Run Queue Job:**
```bash
    Run the queue job to use concurrent operations, allowing administrators to generate dummy user records.