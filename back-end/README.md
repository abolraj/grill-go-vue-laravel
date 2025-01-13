# Grill Go 😋

Welcome to **Grill Go**! This is the back-end API for our exciting project. Grill Go aims to bring delicious grilled food to your doorstep with a seamless and efficient experience. The back-end is developed using Laravel, a powerful PHP framework.

## 🌟 Features

- **User Authentication & Authorization**: Secure and robust user management.
- **Food & Order Management**: Easily manage food items and customer orders.
- **API Documentation with Swagger**: Clear and comprehensive API docs.
- **Comprehensive Test Coverage**: Ensure reliability with thorough testing.

## 🛠️ Tech Stack

- **Framework**: Laravel
- **Database**: SQLite (You can change the database in [cofig/database](./config/database.php))
- **Authentication**: Laravel Sanctum
- **Documentation**: Swagger

## 🚀 Getting Started

To get started with the project, follow these steps:

1. **Clone the repository**:

    ```sh
    git clone https://github.com/abolraj/grill-go-vue-laravel
    ```

2. **Navigate to the project directory**:

   ```sh
   cd grill-go
   cd back-end
   ```

3. **Install dependencies**:

   ```sh
   composer install
   ```

4. **Set up the environment**:
   - Copy the `.env.example` file to `.env` and configure your environment variables.

   ```sh
   cp .env.example .env
   php artisan key:generate
   ```

5. **Run database migrations and seeders**:

   ```sh
   php artisan migrate --seed
   ```

6. **Start the development server**:

   ```sh
   php artisan serve
   ```

## 📂 Project Structure

Here's an overview of the important directories and their contents:

```plaintext
Grill Go
├── README.md
├── app
│   ├── Http
│   │   ├── Controllers
│   │   │   ├── AuthController.php
│   │   │   ├── Controller.php
│   │   │   ├── FoodController.php
│   │   │   ├── OrderController.php
│   │   │   ├── UserController.php
│   │   ├── Requests
│   │       ├── LoginRequest.php
│   │       ├── RegisterRequest.php
│   │       ├── StoreFoodRequest.php
│   │       ├── StoreOrderRequest.php
│   │       ├── UpdateFoodRequest.php
│   │       ├── UpdateOrderRequest.php
│   │       ├── UpdateUserRequest.php
│   ├── Models
│   │   ├── Food.php
│   │   ├── Order.php
│   │   ├── User.php
│   ├── Providers
│       ├── AppServiceProvider.php
├── database
│   ├── database.sqlite
│   ├── factories
│   │   ├── FoodFactory.php
│   │   ├── OrderFactory.php
│   │   ├── UserFactory.php
│   ├── migrations
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2025_01_11_162703_create_personal_access_tokens_table.php
│   │   ├── 2025_01_12_060814_create_foods_table.php
│   │   ├── 2025_01_12_071025_create_orders_table.php
│   ├── seeders
│       ├── DatabaseSeeder.php
│       ├── FoodSeeder.php
│       ├── OrderSeeder.php
├── resources
│   ├── css
│   ├── js
│   │   ├── app.js
│   ├── views
│   │   ├── welcome.blade.php
│   │   ├── l5-swagger
│   │       ├── index.blade.php
├── routes
│   ├── api.php
│   ├── console.php
│   ├── web.php
├── tests
│   ├── Feature
│   │   ├── AuthControllerTest.php
│   │   ├── FoodControllerTest.php
│   │   ├── OrderControllerTest.php
│   │   ├── UserControllerTest.php
```

## 📋 Routes Overview

Here's an organized and colorful overview of the key routes in the Grill Go API:

### AuthController

```plaintext
| Method | URI              | Action                  | Description                   |
|--------|------------------|-------------------------|-------------------------------|
| POST   | api/login        | login                   | Authenticate a user           |
| POST   | api/logout       | logout                  | Log out the authenticated user|
| POST   | api/register     | register                | Register a new user           |
```

### FoodController

```plaintext
| Method     | URI                | Action      | Description                              |
|------------|--------------------|-------------|------------------------------------------|
| GET\|HEAD  | api/foods          | index       | Retrieve a list of all food items        |
| POST       | api/foods          | store       | Create a new food item                   |
| GET\|HEAD  | api/foods/\{food\} | show        | Retrieve details of a specific food item |
| PUT\|PATCH | api/foods/\{food\} | update      | Update a specific food item              |
| DELETE     | api/foods/\{food\} | destroy     | Delete a specific food item              |
```

### OrderController

```plaintext
| Method     | URI                 | Action     | Description                          |
|------------|---------------------|------------|--------------------------------------|
| GET\|HEAD  | api/orders          | index      | Retrieve a list of all orders        |
| POST       | api/orders          | store      | Create a new order                   |
| GET\|HEAD  | api/orders/\{order\}| show       | Retrieve details of a specific order |
| PUT\|PATCH | api/orders/\{order\}| update     | Update a specific order              |
| DELETE     | api/orders/\{order\}| destroy    | Delete a specific order              |
```

### UserController

```plaintext
| Method     | URI                | Action      | Description                         |
|------------|--------------------|-------------|-------------------------------------|
| GET\|HEAD  | api/users          | index       | Retrieve a list of all users        |
| GET\|HEAD  | api/users/\{user\} | show        | Retrieve details of a specific user |
| PUT\|PATCH | api/users/\{user\} | update      | Update a specific user              |
| DELETE     | api/users/\{user\} | destroy     | Delete a specific user              |
```

### SwaggerController

```plaintext
| Method     | URI                   | Action    | Description                                 |
|------------|-----------------------|-----------|---------------------------------------------|
| GET\|HEAD  | api/documentation     | api       | API documentation provided by Swagger       |
```

## 📝 API Documentation

The API documentation is available via Swagger. You can access it at `/api/documentation` once the server is up and running.

## 📦 Deployment

To deploy the project, follow these steps:

1. **Set up a production environment**:
   - Configure your production environment variables in the `.env` file.
2. **Run the deployment commands**:

   ```sh
   php artisan serve
   ```

## 🧪 Running Tests

To run the tests, use the following command:

```sh
php artisan test
```

## 💡 Contribution Guidelines

We welcome contributions to the Grill Go project! Please follow these steps to contribute:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes and commit them (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Open a Pull Request.

## 📜 License

This project is licensed under the MIT License. See the [LICENSE](./LICENSE) file for more details.

## 📧 Contact

If you have any questions or need further assistance, feel free to contact us at `fazlabol18@gmail.com`.

Made with ❤️ by 

## ❤️ Developed with Love

Crafted with passion and dedication by [**Abolfazl (Me)**](https://github.com/abolraj). Thank you for exploring **Grill Go!** We hope it brings delight to your culinary adventures.
