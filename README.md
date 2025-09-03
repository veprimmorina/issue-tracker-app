# 📝 Issue Tracker

A simple Issue Tracking application built with **Laravel 12**, **TailwindCSS**, and **Blade templates**.  
This app allows teams to manage **Projects, Issues, Tags, and Users** with a clean and intuitive UI.

---

## ✨ Features

- **Authentication** (Laravel Breeze/Jetstream scaffolding ready).
- **Projects Management**  
  - Create, update, delete projects.  
  - Associate projects with the logged-in user.  
- **Issues Management**  
  - Track issues per project.  
  - Set status (`Open`, `In Progress`, `Closed`).  
  - Set priority (`Low`, `Medium`, `High`).  
  - Assign due dates.  
  - Associate tags and users.  
- **Tags Management**  
  - Create tags with custom colors.  
  - Use tags for filtering and categorizing issues.  
- **User Assignment**  
  - Attach/detach users to issues.  
- **Dashboard**  
  - Quick links to Projects, Issues, and Tags.  
- **Validation**  
  - Inline form validation errors (no alert boxes).  

---

## 🛠️ Tech Stack

- **Backend:** [Laravel 12](https://laravel.com) (PHP 8.2+)
- **Frontend:** [Blade](https://laravel.com/docs/blade), [TailwindCSS](https://tailwindcss.com)
- **Database:** MySQL (or any supported by Laravel)
- **Authentication:** Laravel Breeze/Jetstream compatible
- **Pagination & Search:** Laravel built-in + AJAX search for issues

---

📂 Project Structure
app/
 ├── Http/
 │    ├── Controllers/    # Controllers
 │    ├── Requests/       # Form validation requests
 │    └── Services/       # Business logic layer
 ├── Models/              # Eloquent models
resources/
 ├── views/
 │    ├── layouts/        # app.blade.php
 │    ├── projects/       # Project views (index, create, edit, show)
 │    ├── issues/         # Issue views (index, create, edit, partials)
 │    └── tags/           # Tag views (index, create, edit)
routes/
 ├── web.php              # Web routes

 ---

 🎨 UI

TailwindCSS used for styling.
Consistent card-based design for Projects, Issues, and Tags.
Colored buttons for actions (View, Edit, Delete).
Clean form validation feedback inline with inputs.
