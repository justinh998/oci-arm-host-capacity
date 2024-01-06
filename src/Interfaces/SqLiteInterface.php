<?php


namespace Hitrov\Interfaces;


interface SqLiteInterface
{
    public function createTelegramCountTable(string $databaseFile);
    public function updateTelegrammCounterinDB(int $TelegrammCounter);
    public function getTelegrammCounterinDB(): int;
    public function Connect_CreateDB(string $databaseFile);
}
