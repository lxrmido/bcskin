<?php /* Smarty version Smarty-3.1.18, created on 2016-02-10 12:14:39
         compiled from "./tpl/public/empty.html" */ ?>
<?php /*%%SmartyHeaderCode:112942364656bab92faaf8b8-48438618%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '53a3aa96394999526947419dad0a7993bde99e23' => 
    array (
      0 => './tpl/public/empty.html',
      1 => 1451458295,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '112942364656bab92faaf8b8-48438618',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'css' => 0,
    'COMPILE_LESS' => 0,
    'less' => 0,
    'ext_css' => 0,
    'js' => 0,
    'ext_js' => 0,
    '_RG_JSON' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56bab92faef026_87839846',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56bab92faef026_87839846')) {function content_56bab92faef026_87839846($_smarty_tpl) {?><!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['file'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['file']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['name'] = 'file';
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['css']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total']);
?>
    <link rel="stylesheet" type="text/css" href="static/<?php echo $_smarty_tpl->tpl_vars['css']->value[$_smarty_tpl->getVariable('smarty')->value['section']['file']['index']];?>
.css">
    <?php endfor; endif; ?>
    <?php if ($_smarty_tpl->tpl_vars['COMPILE_LESS']->value) {?>
        <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['file'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['file']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['name'] = 'file';
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['less']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total']);
?>
            <link rel="stylesheet" type="text/css" href="static/<?php echo $_smarty_tpl->tpl_vars['less']->value[$_smarty_tpl->getVariable('smarty')->value['section']['file']['index']];?>
.less.css" />
        <?php endfor; endif; ?>
    <?php } else { ?>
        <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['file'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['file']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['name'] = 'file';
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['less']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total']);
?>
            <link rel="stylesheet/less" type="text/css" href="static/<?php echo $_smarty_tpl->tpl_vars['less']->value[$_smarty_tpl->getVariable('smarty')->value['section']['file']['index']];?>
.less" />
        <?php endfor; endif; ?>
    <?php }?>
    <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['file'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['file']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['name'] = 'file';
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['ext_css']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total']);
?>
        <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['ext_css']->value[$_smarty_tpl->getVariable('smarty')->value['section']['file']['index']];?>
">
    <?php endfor; endif; ?>
    <style type="text/css"></style>
    <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['file'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['file']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['name'] = 'file';
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['js']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total']);
?>
        <script type="text/javascript" src="static/<?php echo $_smarty_tpl->tpl_vars['js']->value[$_smarty_tpl->getVariable('smarty')->value['section']['file']['index']];?>
.js"></script>
    <?php endfor; endif; ?>
    <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['file'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['file']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['name'] = 'file';
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['ext_js']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['file']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['file']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['file']['total']);
?>
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['ext_js']->value[$_smarty_tpl->getVariable('smarty')->value['section']['file']['index']];?>
"></script>
    <?php endfor; endif; ?>
</head>
<body>
<script>
    var _RG = <?php echo $_smarty_tpl->tpl_vars['_RG_JSON']->value;?>
;
</script>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_name']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</body>
</html><?php }} ?>
