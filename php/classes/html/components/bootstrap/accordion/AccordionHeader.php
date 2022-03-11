<?php
    namespace SJD\php\classes\html\components\bootstrap\accordion;
    include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_file.php';
    use SJD\php\classes\html\components\div\Div;
    class AccordionHeader extends Div{
        private static string $defaultTitle = '(Titulo)';
        public static function create(array|string $params = []) : string {
            $params = $params ?? [];
            if (gettype($params) == 'string') {
                $params = ['title'=>$params];
            }
            $params['props'] = $params['props'] ?? [];
            $params['props']['class'] = trim('accordion-header ' . ($params['props']['class'] ?? ''));
            $params['sub'] = $params['sub'] ?? [];            
            $params['sub'][0] = $params['sub'][0] ?? [];
            $params['sub'][0]['tag'] = $params['sub'][0]['tag'] ?? 'div';
            $params['sub'][0]['props'] = $params['sub'][0]['props'] ?? [];
            $params['sub'][0]['props']['class'] = trim('accordion-button ' . ($params['sub'][0]['props']['class'] ?? ''));
            $params['sub'][0]['props']['data-bs-toggle'] = $params['sub'][0]['props']['data-bs-toggle'] ?? 'collapse';
            $params['sub'][0]['props']['type'] = $params['sub'][0]['props']['type'] ?? 'button';        
            $params['sub'][0]['props']['data-bs-target'] = $params['sub'][0]['props']['data-bs-target'] ?? $params['target'] ?? '';
            $params['sub'][0]['props']['aria-expanded'] = $params['sub'][0]['props']['aria-expanded'] ?? $params['expanded'] ?? 'false';
            $params['sub'][0]['props']['aria-controls'] = str_replace('#','',$params['sub'][0]['props']['aria-controls'] ?? $params['target'] ?? '');
            $params['sub'][0]['text'] = $params['sub'][0]['text'] ?? $params['title'] ?? self::$defaultTitle;
            return parent::create($params);
        }  
    }
?>