# Compare Club Application

Welcome to the **Compare Club** application! This is a web application built using **Laravel 11** and designed to manage and apply various discount rules to clothing items. The project is designed with scalability in mind, allowing for the addition of more rules and features as needed.

This README will guide you through the setup process and provide an overview of how the application works.

---

## Table of Contents

1. [Installation](#installation)
2. [Configuration](#configuration)
3. [Application Flow](#application-flow)
4. [Discount Service](#discount-service)
5. [Unit Tests](#unit-tests)
6. [Future Scalability](#future-scalability)
7. [Notes](#notes)

---

## Installation

To get started with the Compare Club application, follow these steps:

### 1. Extract the application

Download and extract the zip file.

### 2. Install Dependencies

Run the following commands to install PHP and npm dependencies.

-   **Install PHP dependencies:**

```bash
composer install
```

-   **Install JavaScript dependencies:**

```bash
npm install
```

### 3. Build Assets

After installing dependencies, build the frontend assets:

```bash
npm run build
```

### 4. Configure the Database

Create a database called `compare_club` in your MySQL/PostgreSQL server (depending on your setup). Although the database isn't actively used in all parts of the application, it is required for the sake of proper setup.

### 5. Environment Setup

Ensure your `.env` file is properly set up for database and other services. You can copy the example `.env` file provided:

```bash
cp .env.example .env
```

Make sure to update the database credentials as needed.

### 6. Run Migrations

Run the migrations to set up the database tables:

```bash
php artisan migrate
```

### 7. Import Collection

For ease, I have included the Postman collection `Compare Club Clothing.postman_collection.json` file in apps root directory which includes the APIs requests. Make sure to set a env variable in the postman with `endpoint`. eg. http://compare-club.test/api

---

## Application Flow

### 1. **Discount Calculation Flow**

The Compare Club application is designed to apply multiple discount rules on a list of clothing items. These rules are configurable, and the system applies the following checks:

-   **Total Cost Discount:** If the total cost of the clothing items exceeds a certain threshold, a discount is applied to the entire cart.
-   **Item Count Discount:** If the number of clothing items exceeds a specified count, a discount is applied.
-   **Size-based Discount:** If a clothing item belongs to a certain size category (e.g., "LARGE"), a discount is applied to that specific item.

### 2. **Clothing Data**

The clothing items are provided as a collection, where each item has attributes such as:

-   `id`: Unique identifier for the item
-   `name`: Name of the item (e.g., Shirt, Pants, Jacket)
-   `size`: Size of the item (using the `ClothingSizeEnums` class)
-   `price`: Price of the item

### 3. **Discount Service**

The discount logic is handled by the `DiscountService`, which applies the rules defined in `config/discounts.php`. Each rule is represented by a specific class:

-   **TotalCostDiscountRule**
-   **ItemCountDiscountRule**
-   **LargeSizeDiscountRule**

Each of these rules checks specific conditions and applies the discount accordingly.

### 4. **Scalability**

The application is designed with scalability in mind, so adding more discount rules or adjusting the existing ones is easy. All rules are defined in the `DiscountServiceProvider`, and you can modify them or add new rules as the application grows.

---

## Discount Service

### Configuration

The discount rules are configured in the `config/discounts.php` file. Here you can modify the conditions for each discount rule, such as:

-   `TotalCostDiscountRule`: Discount percentage and the total price threshold
-   `ItemCountDiscountRule`: Discount percentage and the minimum number of items
-   `LargeSizeDiscountRule`: Discount percentage and the size criteria (e.g., "LARGE")

### DiscountServiceProvider

The `DiscountServiceProvider` is responsible for registering all discount rules in the application. This makes it easy to add or update rules without changing the core logic.

---

## Unit Tests

The application includes unit tests for both the **Discount** and **Clothing** services.

### 1. **Discount Test**

Tests are written for various scenarios, including:

-   Discount calculation for total cost, item count, and size-based rules
-   Edge cases such as when no discounts are applied
-   Ensuring correct discount percentage calculations

Test cases cover scenarios like:

-   Applying discounts when the total price or item count exceeds thresholds
-   Verifying that the correct discount percentage is applied based on the conditions
-   Calculating the final discounted price correctly

### 2. **Clothing Test**

-   Tests are written to validate the clothing data, ensuring that attributes like `id`, `name`, `size`, and `price` are properly handled.
-   Tests for Validation, success response and correct JSON structure are all implemented.

---

## Notes

-   If additional scenarios or features were added, such as more complex conditions for the discount rules, further unit tests would be written for those.
-   The `ClothingSizeEnums` class is used to define clothing sizes and is essential for certain discount rules, like the **LargeSizeDiscountRule**.
-   The `compare_club` database is not actively used in the core functionality but is kept for database integrity and future expansion.

The above approach is designed for ease of expansion, so new discount rules, features, and functionalities can be integrated with minimal effort.

---

## Conclusion

This application demonstrates a clean and scalable implementation of a clothing discount service using Laravel 11. I’ve designed it to allow for future scalability, both in terms of discount rules and overall application features. The existing tests provide coverage for the key functionalities, and new tests can be added as needed.
