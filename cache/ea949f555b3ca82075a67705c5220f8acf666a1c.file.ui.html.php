<?php /* Smarty version Smarty-3.1.18, created on 2016-02-10 11:05:01
         compiled from "tpl/public/ui.html" */ ?>
<?php /*%%SmartyHeaderCode:150756462456baa8ddb4c5a7-41198502%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ea949f555b3ca82075a67705c5220f8acf666a1c' => 
    array (
      0 => 'tpl/public/ui.html',
      1 => 1449543185,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '150756462456baa8ddb4c5a7-41198502',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_56baa8ddb502a2_88482954',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56baa8ddb502a2_88482954')) {function content_56baa8ddb502a2_88482954($_smarty_tpl) {?><div class="tpl" id="ui-tpl">
	<div class="flex-tips" data-node="dwFlexTips">
		<div class="text" data-node="dwText"></div>
	</div>
	<div class="input-tips" data-node="dwInputTips">
		
	</div>
	<div class="item" data-node="dwInputTipsItem">
		
	</div>
	<div class="row x1" data-node="dwSimplePage">
		<div class="button right margin-right slim" data-node="dwJump">跳转</div>
		<input class="input right margin-right center slim" data-node="dwInput" />
		<div class="button right margin-right with-icon slim" data-node="dwNext">
			<i class="icon-caret-right"></i>
		</div>
		<div class="label free right margin-right slim" data-node="dwLabel">
			1 / 12
		</div>
		<div class="button right margin-right with-icon slim" data-node="dwPrev">
			<i class="icon-caret-left"></i>
		</div>
	</div>
	<div class="window-frame" data-node="dwAlert">
		<div class="close" data-node="dwClose">
			<i class="icon-remove"></i>
		</div>
		<div class="title" data-node="dwTitle">
			提示：
		</div>
		<div class="content" data-node="dwContent">
			<div class="text" data-node="dwText"></div>
		</div>
		<div class="ctrl" data-node="dwCtrl">
			<span class="button-frame" data-node="dwBtnFrame">
				<div class="button blue" data-node="dwBtnOk">
					确定
				</div>
			</span>
		</div>
	</div>
	<div class="window-frame" data-node="dwConfirm">
		<div class="close" data-node="dwClose">
			<i class="icon-remove"></i>
		</div>
		<div class="title" data-node="dwTitle">
			提示：
		</div>
		<div class="content" data-node="dwContent">
			<div class="text" data-node="dwText"></div>
		</div>
		<div class="ctrl" data-node="dwCtrl">
			<span class="button-frame" data-node="dwBtnFrame">
				<div class="button blue margin-right with-icon" data-node="dwBtnOk">
					<i class="icon-ok"></i>
					<span>确定</span>
				</div>
				<div class="button margin-left with-icon" data-node="dwBtnCancel">
					<span>取消</span>
					<i class="icon-remove"></i>
				</div>
			</span>
		</div>
	</div>
	<div class="window-frame" data-node="dwPrompt">
		<div class="close" data-node="dwClose">
			<i class="icon-remove"></i>
		</div>
		<div class="title" data-node="dwTitle">
			请输入：
		</div>
		<div class="content" data-node="dwContent">
			<div class="text" data-node="dwText"></div>
			<input type="text" data-node="dwInput">
			<div class="tip" data-node="dwTip"></div>
		</div>
		<div class="ctrl" data-node="dwCtrl">
			<span class="button-frame" data-node="dwBtnFrame">
				<div class="button blue margin-right with-icon" data-node="dwBtnOk">
					<i class="icon-ok"></i>
					<span>确定</span>
				</div>
				<div class="button margin-left with-icon" data-node="dwBtnCancel">
					<span>取消</span>
					<i class="icon-remove"></i>
				</div>
			</span>
		</div>
	</div>
	<div class="window-frame" data-node="dwSelect">
		<div class="close" data-node="dwClose">
			<i class="icon-remove"></i>
		</div>
		<div class="title" data-node="dwTitle">
			请选择：
		</div>
		<div class="content" data-node="dwContent">
			<div class="text" data-node="dwText"></div>
			<div class="select" data-node="dwSelect">
				<div class="option">请选择</div>
			</div>
		</div>
		<div class="ctrl" data-node="dwCtrl">
			<span class="button-frame" data-node="dwBtnFrame">
				<div class="button blue margin-right with-icon" data-node="dwBtnOk">
					<i class="icon-ok"></i>
					<span>确定</span>
				</div>
				<div class="button margin-left with-icon" data-node="dwBtnCancel">
					<span>取消</span>
					<i class="icon-remove"></i>
				</div>
			</span>
		</div>
	</div>
	<div class="day" data-node="dwDateDay"></div>
	<div class="window-frame" data-node="dwDate">
		<div class="close" data-node="dwClose">
			<i class="icon-remove"></i>
		</div>
		<div class="title" data-node="dwTitle">
			请选择时间：
		</div>
		<div class="content" data-node="dwContent">
			<div class="row" data-node="dwRowMain">
				<div class="col half left" data-node="dwColLeft">
					<div class="calendar" data-node="dwCalendar">
						<div class="hd" data-node="dwHd">
							<div class="hor-adj left" data-node="dwLeft">
								<i class="entypo-icon-left-open"></i>
							</div>
							<div class="year" data-node="dwYear">2015</div>
							<div class="ver-adj" data-node="dwVer">
								<div class="adj" data-node="dwUp">
									<i class="entypo-icon-up-open-mini"></i>
								</div>
								<div class="adj" data-node="dwDown">
									<i class="entypo-icon-down-open-mini"></i>
								</div>
							</div>
							<div class="hor-adj right" data-node="dwRight">
								<i class="entypo-icon-right-open"></i>
							</div>
							<div class="month" data-node="dwMonth">8</div>
						</div>
						<div class="week-hd">
							<div class="day">日</div>
							<div class="day">一</div>
							<div class="day">二</div>
							<div class="day">三</div>
							<div class="day">四</div>
							<div class="day">五</div>
							<div class="day">六</div>
						</div>
						<div class="day-table" data-node="dwTable">
							
						</div>
					</div>
				</div>
				<div class="col half right" data-node="dwColRight">
					<div class="row x1" data-node="dwRow1">
						<div class="label free with-icon">
							<i class="icon-calendar"></i>
						</div>
						<div class="button right right green slim" data-node="dwNow">
							<span>转到现在</span>
						</div>
					</div>
					<div class="hor-split"></div>
					<div class="row x1" data-node="dwRow2">
						<div class="label free right">
							日
						</div>
						<input class="input slim x2d right" data-node="dwDay">
						<div class="label free right">
							月
						</div>
						<input class="input slim x2d right" data-node="dwMon">
						<div class="label free right">
							年
						</div>
						<input class="input slim x2d right" data-node="dwYear">
					</div>
					<div class="row x1" data-node="dwRow3">
						<div class="label free right">
							秒
						</div>
						<input class="input slim x2d right" data-node="dwSec">
						<div class="label free right">
							分
						</div>
						<input class="input slim x2d right" data-node="dwMin">
						<div class="label free right">
							时
						</div>
						<input class="input slim x2d right" data-node="dwHour">
					</div>
				</div>
			</div>
		</div>
		<div class="ctrl" data-node="dwCtrl">
			<span class="button-frame" data-node="dwBtnFrame">
				<div class="button blue margin-right with-icon" data-node="dwBtnOk">
					<i class="icon-ok"></i>
					<span>确定</span>
				</div>
				<div class="button margin-left with-icon" data-node="dwBtnCancel">
					<span>取消</span>
					<i class="icon-remove"></i>
				</div>
			</span>
		</div>
	</div>
</div><?php }} ?>
