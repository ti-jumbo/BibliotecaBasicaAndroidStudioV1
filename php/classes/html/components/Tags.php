<?php
namespace SJD\php\classes\html\components;
include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_file.php';
class Tags {
    public const tags = [
        'div'=>[
            'open'=>'<div',
            'closeOpen'=>'>',
            'close'=>'</div>'
        ],
        'input'=>[
            'open'=>'<input',
            'closeOpen'=>'',
            'close'=>'/>'
        ],
        'label'=>[
            'open'=>'<label',
            'closeOpen'=>'>',
            'close'=>'</label>'
        ]
    ];
}
?>