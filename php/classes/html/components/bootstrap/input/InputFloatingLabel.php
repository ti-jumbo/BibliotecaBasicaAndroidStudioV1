<?php
namespace SJD\php\classes\html\components\bootstrap\input;
include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_file.php';
use SJD\php\classes\html\components\div\Div;    
class InputFloatingLabel extends Div{
    private static string $defaultLabel = '(Label)'; 
    private static string $defaultPlaceholder = '(Valor)'; 
    private static string $defaultType = 'text'; 
    private static string $defaultRequired = 'false';
    private static string $defaultNumberKeyUp = 'window.fnjs.verificar_tecla(this,event,{}, [\'1\',\'2\',\'3\',\'4\',\'5\',\'6\',\'7\',\'8\',\'9\',\'0\'])';    
    public static function create(array|string $params = []) : string {
        $params = $params ?? [];
        if (gettype($params) == 'string') {
            $params = ['textLabel'=>$params];
        }
        $params['props'] = $params['props'] ?? [];
        $params['props']['class'] = trim('form-floating ' . ($params['props']['class'] ?? ''));
        $params['sub'] = $params['sub'] ?? [];
        $params['sub'][0] = $params['sub'][0] ?? [];
        $params['sub'][0]['tag'] = $params['sub'][0]['tag'] ?? 'input';
        $params['sub'][0]['props'] = $params['sub'][0]['props'] ?? [];
        $params['sub'][0]['props']['name'] = $params['sub'][0]['props']['name'] ?? 'name_'.mt_rand();
        $params['sub'][0]['props']['class'] = trim('form-control ' . ($params['sub'][0]['props']['class'] ?? ''));
        $params['sub'][0]['props']['placeholder'] = $params['sub'][0]['props']['placeholder'] ?? $params['placeholder'] ?? self::$defaultPlaceholder;
        $params['sub'][0]['props']['type'] = $params['sub'][0]['props']['type'] ?? $params['type'] ?? self::$defaultType;
        $params['sub'][0]['props']['required'] = $params['sub'][0]['props']['required'] ?? $params['required'] ?? self::$defaultRequired;
        $params['sub'][0]['value'] = $params['sub'][0]['value'] ?? $params['value'] ?? '';
        if (strcasecmp($params['sub'][0]['props']['type'],'number') == 0) {
            $params['sub'][0]['props']['onkeyup'] = $params['sub'][0]['props']['onkeyup'] ?? self::$defaultNumberKeyUp;
        }
        $params['sub'][1] = $params['sub'][1] ?? [];
        $params['sub'][1]['tag'] = $params['sub'][1]['tag'] ?? 'label';
        $params['sub'][1]['props'] = $params['sub'][1]['props'] ?? [];
        $params['sub'][1]['props']['for'] = $params['sub'][1]['props']['for'] ?? $params['sub'][0]['props']['name'];
        $params['sub'][1]['text'] = $params['sub'][1]['text'] ?? $params['textLabel'] ?? $params['label'] ?? $params['text'] ?? self::$defaultLabel;
        return parent::create($params);
    }
}
?>