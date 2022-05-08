<?php
/**
 * 当游客评论时，根据游客ip与邮箱筛选出他的历史评论，然后把历史评论里面的网站同步成最新的，当已登录用户进行评论时则会更新他的历史评论里的昵称邮箱以及网站地址。
 * @package Cuu
 * @author 泽泽社长
 * @version 1.1.0
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
        Typecho_Plugin::factory('Widget_Feedback')->finishComment = [__CLASS__, 'finishComment']; // 前台提交评论完成接口
        Typecho_Plugin::factory('Widget_Comments_Edit')->finishComment = [__CLASS__, 'finishComment']; // 后台提交评论完成接口
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
        $user=Typecho_Widget::widget('Widget_User');
        if (!$user->hasLogin()){//针对游客
        if(!empty($comment->url)){//当网址为空时不进行处理
        $db = Typecho_Db::get();//连接数据库
        $update=$db->update('table.comments')->rows(array('url'=>$comment->url))
        ->where ('ip =? and mail =? and authorId =?',$comment->ip,$comment->mail,'0');
        $updateRows= $db->query($update);//执行更新操作
        }
        }else{//针对登录用户更新历史昵称邮箱以及主页地址
        $db = Typecho_Db::get();//连接数据库
        $update=$db->update('table.comments')->rows(array('url'=>$user->url,'mail'=>$user->mail,'author'=>$user->screenName))
        ->where ('authorId =?',$user->uid);
        $updateRows= $db->query($update);//执行更新操作
        }
        return $comment;
    }


}
