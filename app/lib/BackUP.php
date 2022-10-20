<?php
/**
 * Created by PhpStorm.
 * User: FAKHRANI
 * Date: 10/27/2018
 * Time: 9:13 PM
 */

namespace App\lib;
use Morilog\Jalali\jDate;
class BackUP
{
    public static function BackUP()
    {
// Database configuration
        $host = env('DB_HOST', '127.0.0.1');
        $username = env('DB_USERNAME', 'root');
        $password = env('DB_PASSWORD', '');
        $database_name = env('DB_DATABASE', 'qjubqjoa_dbdaraq');

// Get connection object and set the charset
        $conn = mysqli_connect($host, $username, $password, $database_name);
        $conn->set_charset("utf8");


// Get All Table Names From the Database
        $tables = array();
        $sql = "SHOW TABLES";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }

        $sqlScript = "";
        foreach ($tables as $table) {

            // Prepare SQLscript for creating table structure
            $query = "SHOW CREATE TABLE $table";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_row($result);

            $sqlScript .= "\n\n" . $row[1] . ";\n\n";


            $query = "SELECT * FROM $table";
            $result = mysqli_query($conn, $query);

            $columnCount = mysqli_num_fields($result);

            // Prepare SQLscript for dumping data for each table
            for ($i = 0; $i < $columnCount; $i++) {
                while ($row = mysqli_fetch_row($result)) {
                    $sqlScript .= "INSERT INTO $table VALUES(";
                    for ($j = 0; $j < $columnCount; $j++) {
                        $row[$j] = $row[$j];

                        if (isset($row[$j])) {
                            $sqlScript .= '"' . $row[$j] . '"';
                        } else {
                            $sqlScript .= '""';
                        }
                        if ($j < ($columnCount - 1)) {
                            $sqlScript .= ',';
                        }
                    }
                    $sqlScript .= ");\n";
                }
            }

            $sqlScript .= "\n";
        }


        if (!empty($sqlScript)) {
            $date = jDate::forge()->format('date');
            // Save the SQL script to a backup file
            $backup_file_name = storage_path().'/app/'.$database_name . '_backup_'.$date. time() . '.sql';
            $fileHandler = fopen($backup_file_name, 'w+');
            $number_of_lines = fwrite($fileHandler, $sqlScript);
            fclose($fileHandler);



//            $files = glob(public_path('css/*'));

            \Zipper::make(storage_path('/app/'.$database_name.'_'.$date.'_'. time() . '.zip'))->add($backup_file_name)->close();
            unlink($backup_file_name);


        }
    }
}