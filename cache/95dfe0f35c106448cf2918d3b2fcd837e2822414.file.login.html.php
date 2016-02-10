<?php /* Smarty version Smarty-3.1.18, created on 2016-02-10 11:58:08
         compiled from "./tpl/member/login.html" */ ?>
<?php /*%%SmartyHeaderCode:141467064856baa8ddb3de25-58172148%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '95dfe0f35c106448cf2918d3b2fcd837e2822414' => 
    array (
      0 => './tpl/member/login.html',
      1 => 1455076658,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '141467064856baa8ddb3de25-58172148',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56baa8ddb46ed6_09068934',
  'variables' => 
  array (
    'mps_count' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56baa8ddb46ed6_09068934')) {function content_56baa8ddb46ed6_09068934($_smarty_tpl) {?><div class="page-header">
    <div class="v-center">
        <div class="h-center">

        </div>
    </div>
</div>
<div class="page-section">
    <div class="col visi right margin-top" id="login-frame" style="width:434px;padding:8px;">
        <div class="margin-container">
            <div class="tab-bar margin-top" id="login-tab-bar-main">
                <div class="tab selected" key="login">
                    登陆
                </div>
                <div class="tab" key="register">
                    注册
                </div>
            </div>
            <div class="view" id="view-login">
                <div class="row x1">

                </div>
                <div class="row x1">
                    <div class="textbox margin-left" id="login-account">
                        <div class="label">账号或邮箱</div>
                        <input type="text" />
                    </div>   
                </div>
                <div class="tip single-line margin-left" id="tips-login-account"></div>
                <div class="row x1">
                    <div class="textbox margin-left" id="login-password">
                        <div class="label">密码</div>
                        <input type="password" />
                    </div>  
                </div>
                <div class="tip single-line margin-left" id="tips-login-password"></div>
                <div class="row x1">
                    <div class="vericode textbox margin-left" id="login-vericode">
                        <div class="label">验证码</div>
                        <img></img>
                        <input type="text" />
                    </div>  
                </div>
                <div class="tip single-line margin-left" id="tips-login"></div>
                <div class="row x1">
                    <div class="toggle left margin-left" id="login-remember"></div>
                    <div class="label left free margin-left">记住登录状态</div>
                </div>
                <div class="row x1">
                    <div class="bc-button right margin-right with-icon" id="login-submit">
                        <span>登陆</span>
                    </div>
                </div>
            </div>
            <div class="view" id="view-register">
                <div class="row x1"></div>
                <div class="row x1">
                    <div class="textbox margin-left" id="register-account">
                        <div class="label">账号</div>
                        <input type="text" />
                    </div>
                </div>
                <div class="tip single-line margin-left" id="tips-register-account"></div>
                <div class="row x1">
                    <div class="textbox margin-left" id="register-email">
                        <div class="label">邮箱</div>
                        <input type="text" />
                    </div>
                </div>
                <div class="tip single-line margin-left" id="tips-register-email"></div>
                <div class="row x1">
                    <div class="textbox margin-left" id="register-password">
                        <div class="label">密码</div>
                        <input type="password" />
                    </div>
                </div> 
                <div class="tip single-line margin-left" id="tips-register-password"></div>
                <div class="row x1">
                    <div class="textbox margin-left" id="register-password-confirm">
                        <div class="label">密码确认</div>
                        <input type="password" />
                    </div>
                </div>
                <div class="tip single-line margin-left" id="tips-register-password-confirm"></div>
                <div class="row x1">
                    <div class="vericode textbox margin-left" id="register-vericode">
                        <div class="label">验证码</div>
                        <img></img>
                        <input type="text" />
                    </div>  
                </div>
                <div class="tip single-line margin-left" id="tips-register"></div>
                <div class="row x1">
                    <div class="button right blue margin-right with-icon" id="register-submit">
                        <i class="icon-circle-arrow-right"></i>
                        <span>下一步</span>
                    </div>
                </div>
            </div>
            <!-- <div class="row x1">
                <div class="label free right" style="color:#777;">
                    已有 <span style="color:#3b83c0;font-size:20px;"><?php echo $_smarty_tpl->tpl_vars['mps_count']->value;?>
</span> 个公众号接入到本平台
                </div>
            </div> -->
        </div>
    </div>
</div><?php }} ?>
