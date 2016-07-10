<?php
    namespace Composants\Framework\ORM\PGSQL\Request;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Framework\CreateLog\CreateRequestLog;

    /**
     * Class ResetAutoInc
     * @package Composants\Framework\ORM\PGSQL\Request
     */
    class ResetAutoInc{
        /**
         * ResetAutoInc constructor.
         * @param object $conn
         * @param string $table
         * @param int $number
         */
        public function __construct($conn, $table, $number){
            try{
                $request = 'ALTER SEQUENCE '.$table.'_id_seq RESTART WITH '.$number.';';

                $req = self::$conn->prepare($request);
                $req->execute();

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }
    }