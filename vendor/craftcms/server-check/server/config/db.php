<?php

/**
 * Database Configuration
 *
 * After you've created a database, fill in this information so the [[RequirementsChecker]]
 * can connect to the database and determine if it meets the necessary requirements to run Craft.
 */

return array(
    // The database server name or IP address. Usually this is 'localhost' or '127.0.0.1'.
    'server' => 'localhost',

    // The database username to connect with.
    'user' => 'root',

    // The database password to connect with.
    'password' => 'letmein',

    // The name of the database to connect to.
    'database' => 'craft',

    // The database driver to use. Either 'mysql' for MySQL or 'pgsql' for PostgreSQL.
    'driver' => 'mysql',
);
