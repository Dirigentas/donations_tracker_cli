<?php

/**
 * Class JsonReader
 * 
 * Provides methods for reading from and writing to files.
 */

 declare(strict_types=1);

 namespace Aras\DonationsTrackerCli\db;

 use Aras\DonationsTrackerCli\db\DataReaderInterface;
 
class JsonReader implements DataReaderInterface
{   
    private $fileName, $data;

    /**
     * Read data from a file.
     * 
     * @param string $fileName The name of the file
     * @return array The data read from the file
     */
    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;

        if (!file_exists(__DIR__ . "/" . $this->fileName . '.json')) {
            $this->data = [];
        } 
        else {
            $handle = fopen(__DIR__ . "/" . $this->fileName . '.json', 'r');

            $jsonData = '';
            
            while (!feof($handle)) {
                $chunk = fread($handle, 8192);
                $jsonData .= $chunk;
            }
            
            fclose($handle);
            
            $jsonArray = json_decode($jsonData, true);
            
            if ($jsonArray === null && json_last_error() !== JSON_ERROR_NONE) {
                echo "Error decoding JSON: " . json_last_error_msg() . PHP_EOL;
                exit(1);
            } else {
                $this->data = $jsonArray;
            }
        }
    }

    /**
     * Write data to a file.
     * 
     * @param string $fileName The name of the file
     * @param mixed $data The data to write to the file
     * @return void
     */
    public function __destruct()
    {
        if ($this->data !== []) {
            $jsonData = json_encode($this->data);
            file_put_contents(__DIR__ . '/' . $this->fileName . '.json', $jsonData);
        }
    }

    /**
     * Get the ID for a new record.
     * 
     * @param string $fileName The name of the file
     * @return int The ID for the new record
     */
    public function getId(): int
    {
        if (!file_exists(__DIR__ . '/' . $this->fileName.'_id')) {
            file_put_contents(__DIR__ . '/' . $this->fileName .'_id', json_encode(1));
            return 1;
        } 
        else {
            $id = json_decode(file_get_contents(__DIR__ . '/' . $this->fileName .'_id'), true);
            $id++;
            file_put_contents(__DIR__ . '/' . $this->fileName .'_id', json_encode($id));
            return $id;
        }
    }

    public function showData(int $id): array
    {
        foreach ($this->data as $key => $data) {
            if ($key == "id: " . $id) {
                return $data;
            }
        }
        return [];

        if (isset($this->data['id: ' . $id])) {
            return $this->data['id: ' . $id];
        } else {
            echo "\"$this->fileName\" data id: $id is not present." . PHP_EOL;
        }
    }

    public function showAllData(): array
    {
        uasort($this->data, fn ($a, $b) => $a['name'] <=> $b['name']);

        return $this->data;
    }

    /**
     * Create a new record.
     * 
     * @param string $fileName The name of the file
     * @param array $newRecord The new record to create
     * @return void
     */
    public function createData(array $newRecord): void
    {
        $this->data['id: ' . $this->getId()] = $newRecord;
        echo "New data in \"$this->fileName\" added successfully." . PHP_EOL;
    }

    /**
     * Update an existing record.
     * 
     * @param string $fileName The name of the file
     * @param string $id The ID of the record to update
     * @param array $newRecord The updated record
     * @return void
     */
    public function updateData(int $id, array $newRecord): void
    {
        if (isset($this->data['id: ' . $id])) {
            $this->data['id: ' . $id] = $newRecord;
            echo "$this->fileName data id: $id edited successfully." . PHP_EOL;
        } else {
            echo "$this->fileName data id: $id is not present." . PHP_EOL;
        }
    }

    /**
     * Partially update an existing record.
     * 
     * @param string $fileName The name of the file
     * @param string $id The ID of the record to update
     * @param array $newRecord The updated record
     * @param string $editableField The field to update
     * @param string $editableFieldId The ID of the field to update
     * @return void
     */
    public function partialUpdate(int $id, array $newRecord, string $editableField, string $editableFieldId): void
    {
        if (isset($this->data['id: ' . $id])) {
            $this->data['id: ' . $id][$editableField][$editableFieldId] = $newRecord;
        }
    }

    /**
     * Delete an existing record.
     * 
     * @param string $fileName The name of the file
     * @param string $id The ID of the record to delete
     * @return void
     */
    public function deleteData(int $id): void
    {
        if (isset($this->data['id: ' . $id])) {
            unset($this->data['id: ' . $id]);
            echo "\"$this->fileName\" data id: $id deleted successfully." . PHP_EOL;
        } else {
            echo "\"$this->fileName\" data id: $id is not present." . PHP_EOL;
        }
    }
}