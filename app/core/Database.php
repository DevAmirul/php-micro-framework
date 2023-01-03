<?php

namespace App\Core;

class Database {

    public \PDO$pdo;

    public function __construct( array $dbConfig ) {
        $dsn      = $dbConfig['dsn'] ?? '';
        $user     = $dbConfig['user'] ?? '';
        $password = $dbConfig['password'] ?? '';

        try {
            $this->pdo = new \PDO( $dsn, $user, $password, );
            $this->pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );

        } catch ( \PDOException$e ) {
            echo $e->getMessage();
        }

    }

    /**
     * applyMigrations function
     *
     * @return void
     */
    public function applyMigrations() {
        $newMigrationsList = [];

        $this->createMigrationsTable();
        $appliedMigration = $this->getAppliedMigrations();

        $files            = scandir( Application::$ROOT_DIR_PATH . '/migrations' );
        $toApplyMigration = array_diff( $files, $appliedMigration );

        foreach ( $toApplyMigration as $migration ) {
            if ( $migration === '.' || $migration === '..' ) {
                continue;
            }
            require_once Application::$ROOT_DIR_PATH . '/migrations/' . $migration;

            $className = pathinfo( $migration, PATHINFO_FILENAME );
            $instance  = new $className;
            echo 'Hello world!' . PHP_EOL;
            $instance->up();
            echo 'Hello world!' . PHP_EOL;

            $newMigrationsList[] = $migration;
        }

        if ( !empty( $newMigrationsList ) ) {
            $this->saveMigrations( $newMigrationsList );
        } else {
            echo 'All migration are applied';
        }

    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function createMigrationsTable() {
        $this->pdo->exec( "CREATE TABLE IF NOT EXISTS migrations(
            id INTEGER AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;" );
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getAppliedMigrations() {
        $statement = $this->pdo->prepare( "SELECT migration FROM migrations" );
        $statement->execute();

        return $statement->fetchAll( \PDO::FETCH_COLUMN );

    }

    /**
     * Undocumented function
     *
     * @param  array $newMigrationsList
     * @return void
     */
    public function saveMigrations( array $newMigrationsList ) {
        $migrationListStr = implode( "' ,'", $newMigrationsList );

        $statement = $this->pdo->prepare( "INSERT INTO migrations (migration) VALUES(
            'hello','this') " );

        $statement->execute();

    }
}
