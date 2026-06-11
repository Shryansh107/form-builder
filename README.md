# Interactive Drag-and-Drop Form Builder UI

A highly responsive, premium-grade, interactive Form Builder built directly inside a Laravel application. This tool allows users to build custom HTML forms by dragging elements onto a canvas, configuring parameters (labels, validation, placeholder, etc.) live in real-time, reordering elements, duplicating/deleting fields, and previewing the live form output rendered via custom Laravel Blade Components.

---

## 🚀 Local Installation & Setup

Follow these simple steps to run the Form Builder application locally:

1. **Clone & Enter Directory**:
   ```bash
   cd edunet_frontend_ui_dev_assigment
   ```

2. **Install Composer Dependencies**:
   ```bash
   composer install
   ```

3. **Set Up Environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run Server**:
   ```bash
   php artisan serve
   ```
   The application will be running locally at `http://127.0.0.1:8000`.

---

## 🛠️ Tech Stack & Library Choices

- **Laravel Blade (PHP/Backend)**: Used for compiling and structuring all form components. Every single form input is backed by a dedicated Blade component located at `resources/views/components/fields/*.blade.php`. This strictly adheres to the requirement that no raw HTML input fields are output outside Blade components.
- **SortableJS (D&D Library)**: Selected for drag-and-drop mechanics.
  - *Rationale*: SortableJS has zero dependencies, is incredibly fast (uses hardware-accelerated CSS transitions), handles list reordering smoothly, and supports clone dragging from a sidebar palette directly into a dynamic canvas. It behaves beautifully with virtual DOM structures and provides natural drag handle hooks.
- **Alpine.js (State Management)**: Powers the builder's reactive state, option panel synchronization, and action history logic.
  - *Rationale*: Alpine offers lightweight, declarative, reactive data bindings that sit naturally on top of compiled Laravel Blade views without requiring a heavy client-side build compilation (like React or Vue). This makes the builder codebase clean, maintainable, and easily extendable.
- **Tailwind CSS**: Custom layouts, grid widths, focus transitions, and modern visual palettes.

---

## 📐 Key Design Assumptions & Architecture

1. **Dual-Mode Blade Components**: 
   Blade components accept an `:is-builder` flag. 
   - When `true`, they output Alpine.js reactive attribute bindings (e.g. `:placeholder="field.placeholder"`, `x-text="field.label"`). This allows edits in the right options pane to reflect instantly in the builder canvas.
   - When `false`, they render standard static HTML attributes, perfect for the **Form Preview** and actual final deployment.
2. **Independent Canvas & Sidebar**:
   The canvas and sidebar scroll independently to ensure a smooth, desktop-app-like user experience. The builder is fully responsive and reflows into a single column at widths below `1024px`.
3. **No-API AJAX Preview**:
   When toggling **Preview Mode**, the client posts the JSON form schema back to the Laravel controller which compiles the actual production Blade elements server-side and sends back the HTML chunk dynamically, showing exact visual parity between editor and live states.
4. **Action History**:
   State modification events (adds, deletions, reorders, property edits) push snapshots onto an `undoStack` (up to 50 deep) to power smooth Ctrl+Z (Undo) and Ctrl+Y (Redo) flows.

---

## 📄 Sample JSON Output Schema

When the user clicks "Export Schema" or "Next" in the footer, the state is serialized into the following structured JSON format:

```json
{
    "title": "Registration Form",
    "submissionUrl": "/api/v1/register",
    "fields": [
        {
            "id": "field_init_text",
            "type": "text",
            "label": "Full Name",
            "name": "full_name",
            "placeholder": "Enter your name...",
            "required": true,
            "defaultValue": "",
            "class": "col-span-2",
            "minChars": "",
            "maxChars": ""
        },
        {
            "id": "field_init_email",
            "type": "email",
            "label": "Email Address",
            "name": "email",
            "placeholder": "name@example.com",
            "required": true,
            "defaultValue": "",
            "class": "col-span-1"
        },
        {
            "id": "field_1781192534562_a4g7m",
            "type": "dropdown",
            "label": "Membership Level",
            "name": "dropdown_8d9g",
            "placeholder": "Select membership level...",
            "required": true,
            "options": [
                "Basic Free",
                "Professional ($15/mo)",
                "Enterprise Custom"
            ],
            "class": "col-span-1"
        },
        {
            "id": "field_1781192622441_u8a2b",
            "type": "checkbox",
            "label": "Interests & Topics",
            "name": "checkbox_f3g2",
            "required": false,
            "options": [
                "Software Engineering",
                "Product Design",
                "Data Science",
                "Marketing"
            ],
            "defaultValues": [
                "Software Engineering",
                "Product Design"
            ],
            "class": "col-span-2"
        },
        {
            "id": "field_1781192700511_x9r2d",
            "type": "hidden",
            "label": "source_channel",
            "name": "utm_source",
            "defaultValue": "organic_search"
        }
    ]
}
```
