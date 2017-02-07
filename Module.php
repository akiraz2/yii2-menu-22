<?php
namespace kriptograf\menu;


use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use pceuropa\menu\models\Model;

class Module extends \yii\base\Module {
    
	public $controllerNamespace = 'kriptograf\menu\controllers';
    
	public $defaultRoute = 'creator';

    public function init()
    {
		parent::init();	  // custom initialization code goes here
	}
	
    public static function NavbarLeft($id)
    {
		return self::processNavbar($id, 'left');
	}

    public static function NavbarRight($id){
        return self::processNavbar($id, 'right');
	}

	protected static function processNavbar($id, $pos)
    {
        $m = Model::findModel($id);
        $m = Json::decode($m->menu);

        $data = self::checkIcon($m[$pos]);

        return $data;
    }

    protected static function checkIcon($array)
    {
        $result = [];
        foreach ($array as $item)
        {
            if (array_key_exists('icon', $item))
            {
                $glyph = Html::tag('i', '',
                    ['class' => sprintf("glyphicon glyphicon-%s", $item['icon'])]
                );

                $item['label'] = sprintf('%s %s', $glyph, $item['label']);
            }

            if (array_key_exists('items', $item))
            {
                $item['items'] = self::checkIcon($item['items']);
            }

            $result[] = $item;
        }

        return $result;
    }

}
