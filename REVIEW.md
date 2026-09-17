# Review: Why I Made These Changes

This review explains the changes from `main` to `review`, in commit `d57c865`. The main goals were to handle missing routes, support local database settings, and improve code style.

Some changes affect how the application works. Others only change how the code looks. It is important to know the difference when you review code.

## 1. Handle Missing Routes

Reference: `src/Router.php:43`

Before, the router read a handler from the routes array and called it without checking if it existed. For an unknown path, PHP could report missing array keys. Calling the missing handler then caused an error and stopped the request.

I added two checks:

```php
$callable = Router::$routes[Router::getMethod()][Router::getPath()] ?? null;
if (is_callable($callable)) {
    $callable();
}
```

- `?? null` returns `null` when the route entry is missing.
- `is_callable()` checks whether PHP can call the value.
- A registered route still runs its handler.

I put this check in the router because all routes use it. We do not need the same check in every controller.

**Limit:** This prevents the missing-handler error, but it does not send a 404 status or show an error page. An unknown route can still return an empty response. A proper 404 response is a separate next step.

**Lesson:** Check that an array entry exists before you use it, especially when a user controls the requested path.

## 2. Make the Database Port Configurable

Reference: `model/DataBase.php:25` and `.env.example:2`

I added a `port` property, read `DB_PORT` from the environment, and included it in the PDO connection string:

```php
$this->port = $_ENV['DB_PORT'];
$this->conn = new PDO("mysql:host={$this->host_name};port={$this->port};dbname={$this->db_name}", $this->username, $this->password);
```

A local database may use a different port. For example, a Docker setup may expose MySQL on port 3307. This change lets you choose that port without editing PHP code.

I also added this example setting:

```dotenv
DB_PORT=3306
```

3306 is the usual MySQL TCP port. Use the port that matches your setup. A `localhost` connection may use a Unix socket instead of TCP.

**Important:** If you already have a `.env` file, add `DB_PORT` there too. Changing `.env.example` does not update your existing file. The new PHP code has no fallback when this value is missing.

**Lesson:** Keep settings that differ between computers in configuration, not in application code.

## 3. Keep the Cache Folder Available

Reference: `.gitignore:14`, `cache/.gitkeep`, and `public/index.php:16`

The application uses `cache/` for compiled view files. Before, Git ignored the whole folder. I changed the rules to:

```gitignore
cache/*
!cache/.gitkeep
```

Git tracks files, not empty folders. The empty `.gitkeep` file lets a fresh clone include the cache folder. Generated cache files remain ignored.

The name `.gitkeep` has no special meaning to Git. It is a common name for a file used for this purpose. The application still needs permission to write to the folder.

**Lesson:** Track what the project needs for setup, but do not track files it generates while running.

### Other Ignore Rules

Reference: `.gitignore:1`

I changed `/vendor/` to `vendor/`. The new rule also ignores nested folders named `vendor`, not only the root folder.

The separate `.cache/` rule was also removed. This means `.cache/` is no longer ignored by this file. It is different from `cache/`; the new cache rules do not cover it.

## 4. Improve Formatting Without Changing Logic

The controller, model, session, migration, and view files also received formatting changes. These edits do not add new login, task, or migration behavior.

Examples:

- Put `<?php` and `namespace` on separate lines, as in `controller/HomeController.php:1`.
- Move class and method opening braces to a new line, as in `model/DataBase.php:12`.
- Remove the space before the return-type colon, as in `controller/HomeController.php:14`.
- Align the callback body in `bin/migrate.php:18`.
- Remove extra indentation in `model/DataBase.php:148`.
- Adjust template indentation and button spacing in `views/homeview.blade.php:11`.

Several PHP changes follow PSR-12 style rules. Under these rules, named functions and methods have their opening brace on a new line. Control statements such as `if` and `foreach`, and anonymous functions, keep it on the same line.

This does not mean the whole project now follows PSR-12. Some style differences remain. Template indentation should also show which blocks are inside other blocks.

**Lesson:** A shared style makes code easier to read. In future pull requests, keep formatting changes separate from bug fixes when possible. This makes the important changes easier to review.

## Main Takeaways

1. Check that a route handler exists before calling it.
2. Keep local connection settings in `.env`, and update example settings too.
3. Keep required folders available without tracking generated files.
4. Use consistent formatting, but do not confuse formatting with a bug fix.
5. State what a fix does not solve yet, such as the missing 404 response.
