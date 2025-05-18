# Setup Process
> IMPORTANT! This has been tested to run with `PHP 7.4 and 8.0` version! Later version might not work.
## 1. Unzip the files
> The zip file contains all the codes that has added and modified for the project specs to run including the base files.
## 2. Setup the database
> Edit `application/config/database.php` and fill in your DB connection config.

## 3. Run the migration
Navigate to the root directory of the project via CLI and run:
```apacheconf
php index.php migrate
```
After running, you should see:
```apacheconf
Migration completed successfully.
```
## 4. Project should be ready
Visit the project via web browser and it should load up with issue.
> For specific errors, please refer to the SCSS compilation workflow and development notes below.
---

# SCSS Compilation – CodeIgniter Front-End Workflow

This project uses **Gulp 4** to compile SCSS into CSS for a legacy CodeIgniter 3.1.3 application. The build system was upgraded from Gulp 3 to Gulp 4 to ensure compatibility with modern Node.js environments.

---

## ✅ Setup Instructions

### 1. Navigate to the `assets/` directory
```apacheconf
cd assets
```

### 2. Install Dependencies
```apacheconf
npm install
```
> ⚠️ Make sure you are using Node.js v16 or newer and Gulp 4. Gulp 3 is deprecated and incompatible with modern Node.
---
# 🚀 SCSS Compilation Commands

## Development Build

Compiles SCSS to `css/` and watches for changes:

```apacheconf
npx gulp
```
## One-Time Compile Only

Compiles SCSS to `css/` once (no watch):
```apacheconf
npx gulp sass
```
## Production Build

Compiles SCSS, minifies CSS, and outputs to `dist/`:
```apacheconf
npx gulp build:production
```
---
## 📁 Project Structure
```graphql
assets/
├── css/           # Compiled SCSS output (dev)
├── dist/          # Minified CSS output (prod)
├── scss/          # Source SCSS files
├── images/        # Image assets
├── maps/          # CSS sourcemaps
├── gulpfile.js    # Gulp 4 task definitions
└── package.json   # Node.js dependency list

```
---
## 🛠️ Development Notes

# ✅ Gulp 4 Migration
Originally used Gulp 3.9.1, which caused this error with Node.js:
```apacheconf
ReferenceError: primordials is not defined
```
Fix: Upgraded to Gulp 4.0.2:
```apacheconf
npm uninstall gulp
npm install gulp@^4.0.2 --save-dev
```
> Updated `gulpfile.js` to use `exports`, `series`, and `watch`.

## ✅ Sass Compiler Setup
`gulp-sass` requires a Sass compiler. Installed Dart Sass:
```apacheconf
npm install sass --save-dev
```
Configured in `gulpfile.js` like this:
```apacheconf
const sass = require('gulp-sass')(require('sass'));
```
## ✅ imagemin Compatibility Fix
`gulp-imagemin@9.x` is ESM-only and caused an error when using `require()`:
```apacheconf
Error [ERR_REQUIRE_ASYNC_MODULE]
```
Fix: Downgraded to a compatible CommonJS version:
```apacheconf
npm uninstall gulp-imagemin
npm install gulp-imagemin@^7.1.0 --save-dev
```
---

# 🛠️ Running Migrations in CodeIgniter 3.1.3 (HMVC Setup)
This project uses CodeIgniter 3.1.3 with Modular Extensions (HMVC) via MX_Controller. To run database migrations successfully, follow the steps below.

## ✅ 1. Create Migration File
Migrations are stored in:
```apacheconf
application/migrations/
```
Example migration file:
```apacheconf
class Migration_Create_users extends CI_Migration {
    public function up() {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => true
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users');
    }

    public function down() {
        $this->dbforge->drop_table('users');
    }
}
```
> Make sure the filename starts with a version number like `001_create_users.php`.

## ✅ 2. Setup Database Configuration
Note: CodeIgniter 3 does not support `.env` natively.

Edit `application/config/database.php` and fill in your DB connection:
```apacheconf
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'your_username',
    'password' => 'your_password',
    'database' => 'your_database_name',
    'dbdriver' => 'mysqli',
    'db_debug' => TRUE,
    // ...
);
```

## ✅ 3. Add a Migration Controller
In `application/controllers/Migrate.php`:
```apacheconf
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends MY_Controller {

    public function __construct() {
        parent::__construct();

        if (!is_cli()) {
            show_error('This controller is only accessible from the command line.');
        }
    }

    public function index() {
        $this->load->library('migration');

        if ($this->migration->current() === FALSE) {
            echo $this->migration->error_string() . "\n";
        } else {
            echo "Migration completed successfully.\n";
        }
    }
}
```
## ✅ 4. Fix Routing for CLI Access
In `application/config/routes.php`, disable frontend catch-all routes for CLI:
```apacheconf
if (is_cli()) {
    return; // prevent CLI routes from being overridden
}
```
> This ensures CLI requests like `php index.php migrate` are routed correctly.

## ✅ 5. Run the Migration
From your project root:
```apacheconf
php index.php migrate
```
You should see:
```apacheconf
Migration completed successfully.
```