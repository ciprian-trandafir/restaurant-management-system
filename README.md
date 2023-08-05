# Restaurant Management System

A web-based application developed using PHP, MySQL, JavaScript (jQuery), HTML, CSS, and Bootstrap.

The system has four access levels: **manager**, **waiter**, **chef**, and **user**. The manager has full access to the system, while the other three users have limited access.

## Roles description and permissions:

### Manager

The manager has access to manage logs, accounts, inventory, recipes and invoices.

**Dashboard**: information about out of stock products and invoices created today.

####

<img src="readme-assets/manager-dashboard.png" width="500" alt="manager-dashboard">

####

**Logs**: grants managers access to view user actions, displaying information based on selected users, date range, and sorting options.

####

<img src="readme-assets/logs.png" width="500" alt="logs">

####

**Accounts**: allows managers to view, modify roles, and enable/disable user accounts.

####

<img src="readme-assets/accounts.png" width="500" alt="accounts">

####

**Inventory**: add, update, or remove items. The manager has also possibility to import and export the products list.

####

<img src="readme-assets/inventory.png" width="500" alt="inventory">

####

**Recipes**: add or update recipes: name, price and ingredients.

####

<img src="readme-assets/recipes.png" width="500" alt="recipes">

####

<img src="readme-assets/recipe-ingredients.png" width="500" alt="recipe-ingredients">

####

**Invoices**: view the invoices list, apply date range filters, and generate graphical insights.

####

<img src="readme-assets/invoices.png" width="500" alt="invoices">

####

### Waiter

Responsible for creating and finalizing invoices.

`Note`: When an invoice contains recipes, kitchen requests are automatically generated for each of these recipes.

**Dashboard**: shortcut to **Create invoice** page, information about pending invoices and kitchen requests.

####

<img src="readme-assets/waiter-dashboard.png" width="500" alt="waiter-dashboard">

####

**Create invoice**: add recipes and products on the invoice.

####

<img src="readme-assets/create-invoice.png" width="500" alt="create-invoice">

####

**Kitchen requests**: allows waiters to monitor the status of each recipe: **done** or **in progress**.

####

<img src="readme-assets/kitchen-requests.png" width="500" alt="kitchen-requests">

####

### Chef

Respond to waiter recipe requests: view recipes for preparation and mark them as **done**.

####

<img src="readme-assets/chef-dashboard.png" width="500" alt="chef-dashboard">

####

### User

Users have limited access and can only view the restaurant's recipes.

####

<img src="readme-assets/user-dashboard.png" width="500" alt="user-dashboard">

####

### Login and My account pages:

####

<img src="readme-assets/login.png" width="500" alt="login">

####

<img src="readme-assets/my-account.png" width="500" alt="my-account">

### Database and users login credentials

The repository contains an SQL database file with some demo data.

Below are the login credentials for each user:

1. **Admin**:

   - Email: admin@admin.com
   - Password: admin

2. **Waiter**:

   - Email: waiter@waiter.com
   - Password: waiter

3. **Chef**:

   - Email: chef@chef.com
   - Password: chef

4. **User**:

   - Email: user@user.com
   - Password: user
