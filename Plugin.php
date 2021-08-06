<?php

/**
 * Cuu全名Comment Url Update 当游客评论时，根据游客ip与邮箱筛选出他的历史评论，然后把历史评论里面的网站同步成最新的
 * @package Cuu
 * @author 泽泽社长
 * @version 1.0.1
 * @link http://zezeshe.com
 */


class Cuu_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     *
     * @access public
     * @return string
     */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Feedback')->finishComment_15 = array('Cuu_Plugin', 'finishComment'); // 前台提交评论完成接口
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     *
     * @static
     * @access public
     * @return void
     */
    public static function deactivate()
    {
    }

    /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
    }

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {
    }

    /**
     * 插件实现方法
     *
     * @access public
     * @return void
     */
    public static function render()
    {
    }

    public static function finishComment($comment)
    {   
        if(!empty($comment->url)){//当网址为空时不进行处理
        
        $db = Typecho_Db::get();//连接数据库
        
        $update=$db->update('table.comments')->rows(array('url'=>$comment->url))
        ->where ('ip =? and mail =?',$comment->ip,$comment->mail);
        $updateRows= $db->query($update);//执行更新操作
        }


    }


}
