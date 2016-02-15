<?
class Utils extends CComponent
{

	public function init()
	{

	}

	public function formatDate($date)
	{
		return date('d.m.Y', strtotime($date));
	}

}