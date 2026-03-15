<?php

class Directories {           
    
    public function createDirectory(string $folderName, string $fileContent): array {
        // Base directory 
        $baseDir = 'directories';

        // Validates Name
        if (empty($folderName) || !ctype_alnum($folderName)) {
            return [
                'success' => false,
                'message' => 'Please enter a valid folder name using alphanumeric characters only.',
                'path'    => ''
            ];
        }

        $newDirPath = $baseDir . '/' . $folderName;

        // Check if Exists
        if (is_dir($newDirPath)) {
            return [
                'success' => false,
                'message' => 'A directory already exists with that name.',
                'path'    => ''
            ];
        }

        // Attempts to Create
        if (!mkdir($newDirPath, 0777, true)) {
            return [
                'success' => false,
                'message' => 'Error: The directory could not be created.',
                'path'    => ''
            ];
        }

        // Creates ReadMe
        $filePath = $newDirPath . '/readme.txt';
        if (file_put_contents($filePath, $fileContent) === false) {
            return [
                'success' => false,
                'message' => 'Error: The file could not be created.',
                'path'    => ''
            ];
        }

        // Return Succes with Path
        return [
            'success' => true,
            'message' => '',
            'path'    => $filePath
        ];
    }
}

// Explain the difference between creating a directory and creating a file in PHP. What PHP functions are used for each operation, and why is it important to check if a directory already exists before attempting to create it?
// Describe the flow of data from an HTML form submission to PHP processing. How does PHP access form data, and what considerations should developers keep in mind when handling user input from forms?
// Why is it important to properly close file handles after writing to files? What problems can occur if file handles are not closed, and how does this relate to system resource management?
// Why did we use 777 permissions and what should we use and why.
// Explain the benefits of organizing file and directory operations into a class structure. How does this approach improve code organization, reusability, and maintainability compared to writing all operations in procedural code?