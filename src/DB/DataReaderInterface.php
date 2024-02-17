<?php
namespace Aras\DonationsTrackerCli\db;
 
interface DataReaderInterface
{
    function createData(array $newRecord): void;
 
    function updateData(int $id, array $newRecord): void;
 
    function deleteData(int $id): void;
 
    function showData(int $id): array;
    
    function showAllData(): array;
}