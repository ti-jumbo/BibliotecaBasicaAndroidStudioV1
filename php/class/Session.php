<?php
    namespace SJD\php\class;

    /**
     * Class for management session, used for start or close session of client.
     * @author Antonio ALENCAR Velozo
     * @created 21/01/2022
     */
    final class Session {

        public static function startSession() : void{
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        }

        public static function closeSessionWrite() : void {
            if (session_status() !== PHP_SESSION_NONE) {                
                session_write_close();
            }
        }

    }

?>