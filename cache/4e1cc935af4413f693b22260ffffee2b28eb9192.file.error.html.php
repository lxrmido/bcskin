<?php /* Smarty version Smarty-3.1.18, created on 2016-02-10 12:14:39
         compiled from "./tpl/public/error.html" */ ?>
<?php /*%%SmartyHeaderCode:153509468156bab92faf7a97-66387761%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4e1cc935af4413f693b22260ffffee2b28eb9192' => 
    array (
      0 => './tpl/public/error.html',
      1 => 1451457517,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '153509468156bab92faf7a97-66387761',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'error' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56bab92fafe628_46752288',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56bab92fafe628_46752288')) {function content_56bab92fafe628_46752288($_smarty_tpl) {?><div class="error-frame">
	<div class="msg-frame">
		<?php echo $_smarty_tpl->tpl_vars['error']->value['message'];?>

	</div>
	<div class="error-bottom">
		<a class="link a" href="./">首页</a>
		<a class="link" href="javascript:history.go(-1)" id="back">返回</a>
	</div>
</div>
<script>
	if(history.length <= 1){ 
		var back = document.getElementById('back');
		back.innerHTML = '关闭';
		back.href = 'javascript:window.close()';
	}
</script><?php }} ?>
