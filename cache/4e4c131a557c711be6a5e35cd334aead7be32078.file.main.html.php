<?php /* Smarty version Smarty-3.1.18, created on 2016-02-10 21:18:51
         compiled from "./tpl/skin/main.html" */ ?>
<?php /*%%SmartyHeaderCode:32272642656babc1608c905-78160085%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4e4c131a557c711be6a5e35cd334aead7be32078' => 
    array (
      0 => './tpl/skin/main.html',
      1 => 1455110259,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '32272642656babc1608c905-78160085',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56babc1608d535_10370987',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56babc1608d535_10370987')) {function content_56babc1608d535_10370987($_smarty_tpl) {?><div class="head-place-holder"></div>
<div class="page-section">
	<div class="col half left">
		<div class="row"></div>
	</div>
	<div class="skin-viewer" id="skin-viewer"></div>
	<div class="col list-col right">
		<div class="row"></div>
		<div class="tab-bar margin-top" id="skin-tab-main">
			<div class="tab selected" key="current">
				当前
			</div>
			<div class="tab" key="myskin">
				我的皮肤
			</div>
			<div class="tab" key="mycape">
				我的披风
			</div>
			<div class="tab" key="uploadskin">
				上传皮肤
			</div>
			<div class="tab" key="uploadcape">
				上传披风
			</div>
		</div>
		<div class="col all visi">
			<div class="view" id="view-current">
				<div class="row x1"></div>
				<div class="row x1">
					<div class="label margin-left">
						皮肤名称：
					</div>
					<div class="label free" id="current-skin-name">
						无皮肤
					</div>
				</div>
				<div class="row x1">
					<div class="label margin-left">
						皮肤来源：
					</div>
					<div class="label free" id="current-skin-origin">
						并没有
					</div>
				</div>
				<div class="hor-split-margin"></div>
				<div class="row x1">
					<div class="label margin-left">
						披风名称：
					</div>
					<div class="label free" id="current-cape-name">
						无披风
					</div>
				</div>
				<div class="row x1">
					<div class="label margin-left">
						披风来源：
					</div>
					<div class="label free" id="current-cape-origin">
						并没有
					</div>
				</div>
				<div class="hor-split-margin"></div>
				<div class="row x1">
					<div class="bc-button right margin-right" id="btn-reset-skin">
						<span>还原皮肤</span>
					</div>
					<div class="bc-button right margin-right" id="btn-reset-cape">
						<span>还原披风</span>
					</div>
				</div>
			</div>
			<div class="view" id="view-myskin">
				<div class="row x1">
					
				</div>
			</div>
			<div class="view" id="view-mycape">
				<div class="row x1">
					
				</div>
			</div>
			<div class="view" id="view-upload-skin">
				<div class="row upload-skin-list" id="upload-skin-list">
					
				</div>
				<div class="row x1">
					<div class="bc-button right margin-right" id="btn-upload-skin">
						<span>开始上传</span>
					</div>
					<div class="bc-button right margin-right" id="btn-add-skin">
						<span>添加文件</span>
					</div>
					<div class="bc-button right margin-right" id="btn-clear-skin">
						<span>清空队列</span>
					</div>
				</div>
			</div>
			<div class="view" id="view-upload-cape">
				
			</div>
		</div>
	</div>
</div>
<div class="tpl" id="tpl">
	<div class="item" data-node="dwUploadSkinListItem">
		<div class="preview front" data-node="dwFront"></div>
		<div class="preview back" data-node="dwBack"></div>
		<div class="name" data-node="dwName">皮肤名称</div>
		<div class="ctrl">
			<div class="ctrl-item ft" data-action="edit" data-flex="修改名称">
				<i class="icon-edit"></i>
			</div>
			<div class="ctrl-item ft" data-action="remove" data-flex="删除">
				<i class="icon-trash"></i>
			</div>
		</div>
		<div class="proc" data-node="dwProc">
			等待上传
		</div>
	</div>
</div><?php }} ?>
