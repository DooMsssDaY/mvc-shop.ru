<?php
/**
 * Абстрактный класс. Cодержит общую логику для контроллеров, которые 
 * используются в панели администратора
 */
Abstract class AdminBase
{
	public function __construct()
	{
		if(User::isAdmin())
			return true;

        die('Access denied');
	}
}