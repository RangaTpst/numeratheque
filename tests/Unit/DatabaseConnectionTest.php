<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DatabaseConnectionTest extends TestCase
{
    #[Test]
    public function database_connection_success()
    {
        try {
            DB::connection()->getPdo();
            $this->assertTrue(true, 'Connexion réussie à la base de données.');
        } catch (\Exception $e) {
            $this->fail('Impossible de se connecter à la base de données : ' . $e->getMessage());
        }
    }

    #[Test]
    public function database_connection_failure()
    {
        config(['database.connections.mysql.database' => 'wrong_database']);

        try {
            DB::connection()->getPdo();
            $this->fail('La connexion aurait dû échouer, mais elle a réussi.');
        } catch (\Exception $e) {
            $this->assertTrue(true, 'La connexion a bien échoué comme prévu.');
        }
    }
}
