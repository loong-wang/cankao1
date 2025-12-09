<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files ("Software"), to deal
 * in Software without restriction, including without limitation rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of Software, and to permit persons to whom Software is
 * furnished to do so, subject to following conditions:
 *
 * above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of Software.
 *
 * SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH SOFTWARE OR USE OR OTHER DEALINGS IN
 * SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['form_validation_required']		= '必须输入 {field}';
$lang['form_validation_isset']			= '{field} 不能为空';
$lang['form_validation_valid_email']		= '{field} 必须是邮箱格式';
$lang['form_validation_valid_emails']		= '{field} 必须是邮箱格式';
$lang['form_validation_valid_url']		= '{field} 必须是一个有效的网址';
$lang['form_validation_valid_ip']		= '{field} 必须是有效的IP';
$lang['form_validation_min_length']		= '{field} 最小长度{param}字符';
$lang['form_validation_max_length']		= '{field} 最大长度{param}字符';
$lang['form_validation_exact_length']		= '{field} 必须与 {param} 长度相等';
$lang['form_validation_alpha']			= '{field} 只能包含字母字符';
$lang['form_validation_alpha_numeric']		= '{field} 只能包含字母数字字符';
$lang['form_validation_alpha_numeric_spaces']	= '{field} 只能包含字母数字字符和空格';
$lang['form_validation_alpha_dash']		= '{field} 只能包含字母数字字符，下划线，和破折号';
$lang['form_validation_numeric']		= '{field} 必须是数字';
$lang['form_validation_is_numeric']		= '{field} 必须是数字';
$lang['form_validation_integer']		= '{field} 必须是数字';
$lang['form_validation_regex_match']		= '{field} 不是正确的格式';
$lang['form_validation_matches']		= '{field} 与 {param} 无法匹配';
$lang['form_validation_differs']		= '{field} 必须不同于 {param}';
$lang['form_validation_is_unique'] 		= '{field} 必须是一个唯一值';
$lang['form_validation_is_natural']		= '{field} 只能包含数字';
$lang['form_validation_is_natural_no_zero']	= '{field} 只能包含数字，必须大于零';
$lang['form_validation_decimal']		= '{field} 必须是一个十进制数';
$lang['form_validation_less_than']		= '{field} 必须少于 {param}';
$lang['form_validation_less_than_equal_to']	= '{field} 必须小于或等于 {param}';
$lang['form_validation_greater_than']		= '{field} 必须大于 {param}';
$lang['form_validation_greater_than_equal_to']	= '{field} 必须一个数字大于或等于 {param}';
$lang['form_validation_error_message_not_set']	= '无法获取 {field} 的错误信息。';
$lang['form_validation_in_list']		= '{field} 必须包含在 {param} ';

/********************Custom********************/
$lang['_check_captcha']      = "错误的%s";
$lang['_email_valid']      = "无效的%s";
$lang['_check_password']      = "%s错误";
$lang['_check_username'] = '%s 只能为数字/字母';
$lang['xss_clean'] = '%s 非法字符！';
$lang['_disabled_username'] = '此%s是禁止注册的';
$lang['_check_images'] = "%s不存在或%s错误";
