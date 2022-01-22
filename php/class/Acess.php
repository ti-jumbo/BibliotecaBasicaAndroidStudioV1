<?php 
    namespace SJD\php\class;
  
    /**
     * Class to manage access, usually used for check if client is logged or not.
     * @author Antonio ALENCAR Velozo
     * @created 21/01/2021
     */
    final class Acess {

        /**
         * Check if client is logged or not, return bool
         * @return {bool} if client is logged or not
         */
        public static function logged() : bool {
            try {
                Session::startSession();
                if ($_SESSION["logged"] ?? false) {
                    Session::closeSessionWrite();
                    return true;
                } else {
                    Session::closeSessionWrite();
                    return false;
                }
            } catch(\Exception | \Trowable $e) {
                print_r($e);
                return false;
            }
        }    

    }

?>