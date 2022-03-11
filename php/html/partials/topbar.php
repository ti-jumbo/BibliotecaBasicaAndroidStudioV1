<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_file.php';
    echo '
    <div class="row p-0 m-0">
        <div class="col p-0 m-0">
            <div id="barra_superior" class="barra_superior bg-dark text-white text-center text-uppercase fw-bolder position-relative">                              
                <text class="position-absolute top-50 start-50 translate-middle">
                    '.($_REQUEST['title'] ?? $GLOBALS['title']??'').'
                </text>
            </div>
        </div>
    </div>
    ';
?>