<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('mdyToYmd')) {
	function mdyToYmd($mdy) {
		// $path = FCPATH.$path;
		if($mdy) {
			$dt = DateTime::createFromFormat('m/d/Y', $mdy);
			return $dt->format('Y-m-d');
		}
		return $mdy;
	}
}
if (!function_exists('ymdToMdy')) {
	function ymdToMdy($mdy) {
		// $path = FCPATH.$path;
		if($mdy && $mdy != '0000-00-00') {
			return date('m/d/Y',strtotime($mdy));
		}
		return '';
	}
}
if (!function_exists('dobToAge')) {
	function dobToAge($dob) {
		if($dob) {
			$from = new DateTime($dob);
		} else {
			$from = new DateTime('today');
		}
		$to   = new DateTime('today');
		return $from->diff($to)->y;
	}
}