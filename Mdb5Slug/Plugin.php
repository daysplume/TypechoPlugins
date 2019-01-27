<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * MDB5缩略名
 * 
 * @package Mdb5Slug
 * @author Yutuo
 * @version 1.0.0
 * @link https://yutuo.net
 */
class Mdb5Slug_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Contents_Post_Edit')->write = array('Mdb5Slug_Plugin', 'pluginHandle');
    }
	
	public static function deactivate()
	{
	}
	
	public static function config(Typecho_Widget_Helper_Form $form)
	{
		$delFields = new Typecho_Widget_Helper_Form_Element_Radio('delFields', 
            array(0=>_t('保留数据'),1=>_t('删除数据'),), '0', _t('卸载设置'),_t('卸载插件后数据是否保留'));
        $form->addInput($delFields);

        $hotNums = new Typecho_Widget_Helper_Form_Element_Text('hotNums', NULL, '8', _t('热门文章数'),_t(''));
        $hotNums->input->setAttribute('class', 'mini');
        $form->addInput($hotNums);

        $sortBy = new Typecho_Widget_Helper_Form_Element_Radio('sortBy', array(0=>_t('浏览数'),1=>_t('评论数'),), '0', _t('排序依据'),_t(''));
        $form->addInput($sortBy);

        $minViews = new Typecho_Widget_Helper_Form_Element_Text('minViews', NULL, '0', _t('最低浏览/评论数'),_t('浏览/评论数低于该值时,不显示在热门文章中, 即使热门文章的数量小于热门文章数'));
        $minViews->input->setAttribute('class', 'mini');
        $form->addInput($minViews);

        $linkClass = new Typecho_Widget_Helper_Form_Element_Text('linkClass', NULL, '', _t('Link Class'),_t('输出的 a 标签的 Class'));
        $linkClass->input->setAttribute('class', 'mini');
        $form->addInput($linkClass);
	}
	
	public static function personalConfig(Typecho_Widget_Helper_Form $form){}
	
    public static function pluginHandle($content){
		if (isset($content['slug']) && !is_null($content['slug']) && strlen($content['slug']) > 0) {
            return $content;
        }

        $md5_str = md5($content['title']);
        $length = 16;
        $md5_str = substr($md5_str, intval((32 - $length) / 2), $length);
        $content['slug'] = $md5_str;
        return $content;
	}

}
