<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE users MODIFY role ENUM('superadmin', 'admin', 'guru', 'student') NOT NULL DEFAULT 'student'");
        } elseif ($driver === 'sqlite') {
            $this->rebuildSqliteUsersTable("role in ('superadmin', 'admin', 'guru', 'student')");
        }

        DB::table('users')
            ->where('role', 'admin')
            ->update(['role' => 'guru']);

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE users MODIFY role ENUM('superadmin', 'guru', 'student') NOT NULL DEFAULT 'student'");
        } elseif ($driver === 'sqlite') {
            $this->rebuildSqliteUsersTable("role in ('superadmin', 'guru', 'student')");
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE users MODIFY role ENUM('superadmin', 'admin', 'guru', 'student') NOT NULL DEFAULT 'student'");
        } elseif ($driver === 'sqlite') {
            $this->rebuildSqliteUsersTable("role in ('superadmin', 'admin', 'guru', 'student')");
        }

        DB::table('users')
            ->where('role', 'guru')
            ->update(['role' => 'admin']);

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE users MODIFY role ENUM('superadmin', 'admin', 'student') NOT NULL DEFAULT 'student'");
        } elseif ($driver === 'sqlite') {
            $this->rebuildSqliteUsersTable("role in ('superadmin', 'admin', 'student')");
        }
    }

    private function rebuildSqliteUsersTable(string $roleCheck): void
    {
        DB::statement('PRAGMA foreign_keys=OFF');

        DB::statement(<<<SQL
            CREATE TABLE users_new (
                id integer primary key autoincrement not null,
                name varchar not null,
                email varchar not null,
                email_verified_at datetime,
                password varchar not null,
                role varchar check ({$roleCheck}) not null default 'student',
                nisn varchar,
                phone varchar,
                address text,
                is_active tinyint(1) not null default '0',
                remember_token varchar,
                created_at datetime,
                updated_at datetime,
                grade_level varchar,
                birth_date date,
                mother_name varchar,
                school_origin varchar,
                gender varchar check (gender in ('L', 'P'))
            )
        SQL);

        DB::statement(<<<SQL
            INSERT INTO users_new (
                id, name, email, email_verified_at, password, role, nisn, phone, address,
                is_active, remember_token, created_at, updated_at, grade_level, birth_date,
                mother_name, school_origin, gender
            )
            SELECT
                id, name, email, email_verified_at, password, role, nisn, phone, address,
                is_active, remember_token, created_at, updated_at, grade_level, birth_date,
                mother_name, school_origin, gender
            FROM users
        SQL);

        DB::statement('DROP TABLE users');
        DB::statement('ALTER TABLE users_new RENAME TO users');
        DB::statement('CREATE UNIQUE INDEX users_email_unique ON users (email)');
        DB::statement('CREATE UNIQUE INDEX users_nisn_unique ON users (nisn)');
        DB::statement('PRAGMA foreign_keys=ON');
    }
};
