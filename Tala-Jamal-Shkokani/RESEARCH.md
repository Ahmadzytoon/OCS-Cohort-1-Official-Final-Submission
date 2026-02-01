# Laravel Advanced CRUD Research

## 1. Eloquent Relationships
- **One to Many**: A relationship where one record (parent) can be associated with multiple records (children).
- **hasMany**: Defined in the parent model (e.g., Category). It tells Laravel that Category has many Products.
- **belongsTo**: Defined in the child model (e.g., Product). It tells Laravel that each Product belongs to a single Category.
- **Foreign Keys**: The `category_id` in the `products` table stores the ID of the related category, forming the bridge between tables.

## 2. Validation in Laravel
- **$request->validate()**: A method that intercepts the request and checks data against rules.
- **Common Rules**:
    - `required`: Field must not be empty.
    - `string`: Must be alphabetic/text.
    - `numeric`: Must be a number.
    - `exists`: Must exist in the specified database table.
    - `min/max`: Constraints on length or numerical value.

## 3. Error Handling
- **Record Not Found**: Handled by checking if a model instance is null after a query.
- **abort(404)**: Manually triggers the 404 error page, stopping execution immediately.
- **Custom Error Pages**: Blade files in `resources/views/errors/` allow for branded error UI.

## 4. Soft Delete
- **Delete**: Permanent removal of data from the database.
- **Soft Delete**: Uses a `deleted_at` column to hide records without actually deleting them.
- **Utility**: Allows for "Restore" functionality and prevents accidental data loss.

## 5. Pagination & Search
- **Pagination**: Splitting large datasets into pages to optimize page load speed and UX.
- **Search**: Providing a way to filter through large amounts of data to find specific items quickly.

## 6. Flash Messages
- **Definition**: Temporary session data that lasts for exactly one subsequent request.
- **Usage**: Typically used to show success or error notifications after a redirect.

## 7. SweetAlert
- **Importance**: Provides a "Second Chance" for destructive actions. Confirmation dialogs prevent users from deleting important data by mistake.

---

## Final Project Flow
**Form** → **Route** → **Controller** → **Model** → **Database** → **Relationship** → **View**
