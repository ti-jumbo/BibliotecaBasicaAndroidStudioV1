<?php
namespace SJD\php\classes\html\components\div;
include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_file.php';
use SJD\php\classes\html\components\{
    IComponent,
    Component
};

class Div extends Component{
    public static function create(array|string $params = []) : string {
        $params = $params ?? [];
        $params['tag'] = 'div';
        return parent::create($params);
    }    
}
?>