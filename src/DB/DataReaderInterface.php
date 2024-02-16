<?php
namespace Aras\DonationsTrackerCli\db;
 
interface DataReaderInterface
{
    function create(array $userData) : void;
 
    function update(int $userId, string $type, array $userData) : void;
 
    function delete(int $userId) : void;
 
    function show(int $userId) : array;
    
    function showAll() : array;
}