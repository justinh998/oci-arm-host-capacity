<?php

namespace Hitrov;

use Hitrov\Interfaces\SqLiteInterface;
use Hitrov\Interfaces\SqLiteException;
use Exception;
use PDO;

class SqLite implements SqLiteInterface
{
    public $db;
    public $dsn;

    #public $databaseFile = './test.db';


    public function Connect_CreateDB(string $databaseFile)
    {
        try {
            $this->dsn = 'sqlite:' . $databaseFile;
            $this->db = new PDO($this->dsn);
            if ($this->db) {
                echo "Verbindung zur SQLite-Datenbank erfolgreich hergestellt oder erstellt.";
                // Hier kannst du Tabellen erstellen oder andere Operationen durchführen, wenn gewünscht
            } else {
                echo "Verbindung zur SQLite-Datenbank fehlgeschlagen.";
            }
        } catch (Exception $e) {
            die("Fehler beim Erstellen der SQLite-Datenbank: " . $e->getMessage());
        }
    }

    public function createTelegramCountTable(string $databaseFile)
    {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS TelegramCounter (Counter VARCHAR(255))";
            $stmt = $this->db->prepare($sql);
            $Ergebniss = $stmt->execute();
            echo ("Tabelle erfolgreich erstellt");
        } catch (Exception $e) {
            die("Fehler beim Erstellen der SQLite-Tabelle: " . $e->getMessage());
        }
    }

    public function updateTelegrammCounterinDB(int $TelegrammCounter)
    {
        try {
            $result  = $this->db->query("select count(Counter) from TelegramCounter");
            $resultfetch = $result->fetchColumn();
            if ($resultfetch == 1) {
                $sql = "Update TelegramCounter set Counter=$TelegrammCounter";
                $stmt = $this->db->prepare($sql);
                $Ergebniss = $stmt->execute();
            } elseif ($resultfetch >= 2) {
                echo ("Die Telegramm Count Tabelle enthält ");
                echo ($resultfetch);
                echo (" Spalten \n, sie darf nur 1 enthalten, ");
                die("Wer hat hier an der DB rummanipuliert?\n Die Ausführung des Codes kann fortgeführt werden");
            }
        } catch (Exception $e) {
            die("Fehler beim updaten der db: " . $e->getMessage());
        }
    }

    public function getTelegrammCounterinDB(): int

    {
        try {
            $result  = $this->db->query("select Counter from TelegramCounter");
            $resultfetch = $result->fetchColumn();

            return $resultfetch;
        } catch (Exception $e) {
            die("Fehler beim Abrufen der Daten aus der DB: " . $e->getMessage());
        }
    }
}
