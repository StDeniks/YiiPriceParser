<?
class Utils extends CComponent
{

	public function init()
	{

	}

	public function formatDate($date)
	{
		if ($date) {
			return date('d.m.Y', strtotime($date));
		}else{
			return date('d.m.Y', time());
		}
	}

}