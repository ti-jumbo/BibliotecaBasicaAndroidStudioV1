<?php
namespace SJD\php\classes\html\components;
include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_file.php';
abstract class Component implements IComponent{
    private static string $defaultTag = 'div';

    private static function mountProps(array $params) : string {
        $return = ' ';
        if (isset($params['props'])) {
            $arr_props = [];
            foreach($params['props'] as $prop=>$val) {
                $arr_props[] = $prop . '="'.$val.'"';
            }
            if (count($arr_props) > 0) {
                $return = ' ' . implode(' ',$arr_props) . ' ';
            }
        }
        return $return;
    }

    private static function mountSubs(array $params) : string {
        $return = '';
        if (isset($params['sub'])) {
            $arr_subs = [];
            foreach($params['sub'] as $subKey=>$sub) {
                $arr_subs[] = self::create($sub);
            }
            if (count($arr_subs) > 0) {
                $return = implode('',$arr_subs);
            }
        }
        return $return;
    }

    private static function mount(array $params) : string {
        $return = '';
        if (in_array($params['tag'],array_keys(Tags::tags))) {
            $return = Tags::tags[$params['tag']]['open'];
            $return .= self::mountProps($params);
            $return .= Tags::tags[$params['tag']]['closeOpen'] ?? '';
            $return .= $params['text'] ?? '';
            $return .= self::mountSubs($params);
            $return .= Tags::tags[$params['tag']]['close'];
        } else {            
            print_r($params);
            throw new \Exception(Messages::messages[Messages::$lang]['tagNotFound']);
        }
        return $return;
    }

    public static function create(array|string $params = []) : string {
        $params = $params ?? [];
        $params['tag'] = $params['tag'] ?? self::$defaultTag;                        
        return self::mount($params);
    }
}
?>