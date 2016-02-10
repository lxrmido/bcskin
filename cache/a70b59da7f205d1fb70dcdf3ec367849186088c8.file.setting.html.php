<?php /* Smarty version Smarty-3.1.18, created on 2016-02-10 15:37:05
         compiled from "./tpl/member/setting.html" */ ?>
<?php /*%%SmartyHeaderCode:126851307356babc72a89670-05113671%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a70b59da7f205d1fb70dcdf3ec367849186088c8' => 
    array (
      0 => './tpl/member/setting.html',
      1 => 1455089823,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '126851307356babc72a89670-05113671',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56babc72ab9b06_66553038',
  'variables' => 
  array (
    'user_info' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56babc72ab9b06_66553038')) {function content_56babc72ab9b06_66553038($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/Users/lxrmido/Html/bcskin/module/public/class/smarty/plugins/modifier.date_format.php';
?><div class="col x7 center">
	<div class="row x2"></div>
	<div class="row">
		<div class="col all visi" id="setting-frame">
			<div class="row x1"></div>
			<div class="tab-bar" id="setting-tab">
				<div class="tab selected" key="base">
					基本信息
				</div>
				<div class="tab" key="safe">
					安全设置
				</div>
			</div>

			<div class="view" id="view-base">
				<div class="col center">
					<div class="row x1"></div>					
					<div class="row x1">
						<div class="label margin-left">
							UID
						</div>
						<div class="label free">
							<?php echo $_smarty_tpl->tpl_vars['user_info']->value['id'];?>

						</div>
					</div>
					<div class="row x1">
						<div class="label margin-left">
							用户名
						</div>
						<div class="label free">
							<?php echo $_smarty_tpl->tpl_vars['user_info']->value['username'];?>

						</div>
					</div>
					<div class="row x1">
						<div class="textbox margin-left" id="email">
							<div class="label">
								邮箱
							</div>
							<input type="text" value="<?php echo $_smarty_tpl->tpl_vars['user_info']->value['email'];?>
">
						</div>
						<div class="bc-button margin-left" id="save-email">
							<span>保存修改</span>
						</div>
					</div>
					<div class="tip single-line margin-left" id="tip-email">
						
					</div>
					<div class="row x1">
						<div class="label margin-left">
							用户组
						</div>
						<div class="label free">
							<?php echo $_smarty_tpl->tpl_vars['user_info']->value['group_name'];?>

						</div>
					</div>
					<div class="row x1">
						<div class="label margin-left">
							注册时间
						</div>
						<div class="label free">
							<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['user_info']->value['regdate'],"%Y-%m-%d %H:%I:%S");?>

						</div>
					</div>
					<div class="row x1">
						<div class="label margin-left">
							登录时间
						</div>
						<div class="label free">
							<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['user_info']->value['lastlogin'],"%Y-%m-%d %H:%I:%S");?>

						</div>
					</div>
	                <div class="hor-split margin-top"></div>
					<div class="row x1"></div>
				</div>
			</div>

			<div class="view" id="view-safe">
				<div class="col center">
					<div class="row x1"></div>
					<div class="row x1">
	                    <div class="textbox margin-left" id="password">
	                        <div class="label">新密码</div>
	                        <input type="password" />
	                    </div>
	                </div> 
	                <div class="tip single-line margin-left" id="tip-password"></div>
	                <div class="row x1">
	                    <div class="textbox margin-left" id="password-confirm">
	                        <div class="label">密码确认</div>
	                        <input type="password" />
	                    </div>
	                </div>
	                <div class="tip single-line margin-left" id="tip-password-confirm"></div>
	                <div class="row x1">
	                    <div class="vericode textbox margin-left" id="password-vericode">
	                        <div class="label">验证码</div>
	                        <img></img>
	                        <input type="text" />
	                    </div>  
	                </div>
	                <div class="row x1">
	                    <div class="textbox margin-left" id="old-password">
	                        <div class="label">原密码</div>
	                        <input type="password" />
	                    </div>
	                    <div class="bc-button right margin-right" id="save-password">
	                    	<span>保存修改</span>
	                    </div>
	                </div>
	                <div class="tip single-line margin-left" id="tip-password-save"></div>
	                <div class="hor-split margin-top"></div>
	                <div class="row x1"></div>
				</div>
			</div>
		</div>
	</div>
</div><?php }} ?>
