<?php
namespace app\controller;
use biny\lib\Action;
use biny\lib\Language;
use biny\lib\Response;
use App;
use Constant;
/**
 * Base action
 */
class baseAction extends Action
{
    /**
     * @param $view
     * @param array $array
     * @param array $objects 直接使用参数
     * @return Response
     */
    public function display($view, $array=array(), $objects=array())
    {
        if(!Language::getLanguage()){
            Language::setLanguage('cn', Constant::month);
        }
        $lang = $this->get('lang');
        $lang && Language::setLanguage($lang, Constant::month);

        $adminData = [];
        if(App::$model->Admin->exist()){
            $adminData = App::$model->Admin->values();
        }
        $objects = array_merge(array(
            'webRoot' => App::$base->app_config->get('webRoot'),
        ), $objects);
        $array = array_merge(array(
            'adminData' => $adminData,
        ), $array);
        return parent::display($view, $array, $objects);
    }
	
	public function displayJson($code, $content)
	{
		header('Content-Type: application/json');
		return json_encode(array(
			"result" => $code,
			"data" => $content
		));
	}
}