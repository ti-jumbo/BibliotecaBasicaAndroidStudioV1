<?php
namespace SJD\php\classes\html\components\sjd;
include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_file.php';
use SJD\php\classes\html\components\bootstrap\accordion\AccordionHeader;    
class AccordionHeaderOpcoesPesquisa extends AccordionHeader{
    private static string $defaultTitle = 'Opções de Pesquisa';
    private static string $defaultTarget = '#painel_div_opcoes_pesquisa_corpo';
    private static string $defaultExpanded = 'true';
    public static function create(array|string $params = []) : string {
        $params = $params ?? [];
        if (gettype($params) == 'string') {
            $params = ['title'=>$params];
        }
        $params['sub'] = $params['sub'] ?? [];
        $params['sub'][0] = $params['sub'][0] ?? [];
        $params['sub'][0]['props'] = $params['sub'][0]['props'] ?? [];
        $params['sub'][0]['props']['class'] = trim('pt-2 pb-2 ' . ($params['sub'][0]['props']['class'] ?? ''));
        $params['sub'][0]['props']['data-bs-target'] = $params['sub'][0]['props']['data-bs-target'] ?? $params['target'] ?? self::$defaultTarget;
        $params['sub'][0]['props']['aria-expanded'] = $params['sub'][0]['props']['aria-expanded'] ?? $params['expanded'] ?? self::$defaultExpanded;
        $params['sub'][0]['props']['aria-controls'] = str_replace('#','',$params['sub'][0]['props']['aria-controls'] ?? $params['target'] ?? self::$defaultTarget);
        $params['sub'][0]['text'] = $params['sub'][0]['text'] ?? $params['title'] ?? self::$defaultTitle;
        return parent::create($params);
    }
}
?>