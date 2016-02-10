<?php /* Smarty version Smarty-3.1.18, created on 2016-02-10 12:28:32
         compiled from "tpl/public/header.html" */ ?>
<?php /*%%SmartyHeaderCode:99654808056baa8ddb2de30-70165868%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '22ff5c2bb5d89f3bf9750b7574348fc6b3e1d07c' => 
    array (
      0 => 'tpl/public/header.html',
      1 => 1455078509,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '99654808056baa8ddb2de30-70165868',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56baa8ddb3b5b4_39236969',
  'variables' => 
  array (
    'title' => 0,
    'navi' => 0,
    'i' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56baa8ddb3b5b4_39236969')) {function content_56baa8ddb3b5b4_39236969($_smarty_tpl) {?><div class="header" id="header">
    <div class="center">
        <a class="trade-mark" href="./"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</a>
        <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['navi']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value) {
$_smarty_tpl->tpl_vars['i']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['i']->key;
?>
            <a href="<?php echo $_smarty_tpl->tpl_vars['i']->value[1];?>
" class="navi"><?php echo $_smarty_tpl->tpl_vars['i']->value[0];?>
</a>
        <?php } ?>
        <div class="user" id="header-user">
            <div class="username" data-node="dwUsername"></div>
            <a class="unavi admin" data-node="dwSetting" href="./?c=admin">
                <i class="icon-cogs"></i>
                <span>管理</span>
            </a>
            <a class="unavi" data-node="dwSetting" href="./?c=member&a=setting">
                <i class="icon-cog"></i>
            </a>
            <a class="unavi" data-node="dwLogout" href="./?c=member&a=logout">
                <i class="icon-signout"></i>
            </a>
        </div>
    </div>
</div>
<div class="notify-area" id="notify-area">
    
</div><?php }} ?>
