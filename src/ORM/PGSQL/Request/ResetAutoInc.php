<?php
namespace Frash\ORM\PGSQL\Request;
use Frash\Framework\Log\CreateLog;

/**
 * Class ResetAutoInc
 * @package Composants\ORM\PGSQL\Request
 */
class ResetAutoInc{
    /**
     * ResetAutoInc constructor.
     * @param \PDO $conn
     * @param string $table
     * @param int $number
     */
    public function __construct(\PDO $conn, string $table, int $number){
        try{
            $request = 'ALTER SEQUENCE '.$table.'_id_seq RESTART WITH '.$number.';';

            $req = $conn->prepare($request);
            $req->execute();

            CreateLog::request(date('d/m/Y à H:i:s').' - Requête : '.$request);
        }
        catch(\Exception $e){
            CreateLog::error($e->getMessage());
            die('Il y a eu une erreur.');
        }
    }
}