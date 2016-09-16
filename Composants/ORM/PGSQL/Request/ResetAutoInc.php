<?php
    namespace Composants\ORM\PGSQL\Request;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Framework\CreateLog\CreateRequestLog;

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
         * @param bool $ajax
         */
        public function __construct(\PDO $conn, $table, $number, $ajax = false){
            try{
                $request = 'ALTER SEQUENCE '.$table.'_id_seq RESTART WITH '.$number.';';

                $req = $conn->prepare($request);
                $req->execute();

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request, $ajax);
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage(), $ajax);
                die('Il y a eu une erreur.');
            }
        }
    }