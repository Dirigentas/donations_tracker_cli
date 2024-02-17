<?php
namespace Aras\DonationsTrackerCli\db;
 
interface DataReaderInterface
{
    function createData(array $userData): void;
 
    function updateData(int $userId, string $type, array $userData): void;
 
    function deleteData(int $userId): void;
 
    function showData(int $userId): array;
    
    function showAllData(): array;
}