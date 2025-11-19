# Full-Stack Bar Management ERP (MVP)

### Context
This project represents a functional **MVP (Minimum Viable Product)** built entirely from scratch to solve a real-world problem for a local hospitality business. The goal was to create a system capable of managing orders, inventory, and complex financial reports without relying on expensive, pre-made software.

### Development Approach
As a **self-taught developer**, I deliberately chose to build this system using **raw PHP and SQL** instead of relying on high-level frameworks. My objective was to deeply understand the fundamentals of web development, including:
* How data flows between the client and the server.
* How to structure relational databases for real-world commerce.
* How to implement business logic directly in the back-end.

### Key Features & Business Logic Implemented
This isn't just a CRUD app; it handles specific business rules for the client:

* **Financial Reporting:** The system generates daily closing reports filtered by specific dates, aggregating total revenue based on closed orders.
* **Real-Time Order Management:** A digital command system (comandas) that tracks consumption per table/client in real-time.
* **Conditional Service Fee Logic:** Implemented specific toggles for "Service Fee (10%)". The system dynamically recalculates the order total and daily revenue based on whether the customer opted to pay the tip or not.
* **Role-Based Access:** Separate views and permissions for Administrators (who can edit products and see financials) vs. Staff (who can only manage orders).

### Technologies Used
* **Back-End:** PHP (Structural)
* **Database:** MySQL (Relational Design)
* **Front-End:** HTML5, JavaScript (AJAX for async operations)
* **Styling:** PicoCSS (for a lightweight, responsive UI)

### Project Status
This is a legacy project that demonstrates my ability to **architect and deliver a working software solution** from a blank page. While it utilizes structural patterns common in legacy systems, the logic accurately reflects the complex needs of a real business operation.

## Screenshots

**1. Real-Time Dashboard**
*Overview of open tabs and active orders.*

<img width="1893" height="780" alt="image" src="https://github.com/user-attachments/assets/c4a4c547-dd68-4514-ba95-3891ec386595" />


**2. Order Management**
*Adding items to a tab with automatic total calculation.*

<img width="1890" height="834" alt="image" src="https://github.com/user-attachments/assets/2b0896b5-90f3-4b09-b093-cd694d26189f" />


**3. Checkout & Financial Logic**
*Payment flow with partial payments and conditional service fee application.*

<img width="1905" height="797" alt="image" src="https://github.com/user-attachments/assets/86364af3-8828-4bd3-a01e-8b7cbbee38b1" />


**4. Financial Reporting**
*Daily closing reports filtered by specific dates.*

<img width="1906" height="816" alt="image" src="https://github.com/user-attachments/assets/9d9bc7d6-900f-4957-8b2b-d9b712814fab" />
