<?php

namespace App\Customs\Repository;

use App\Distributor;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class DistributorRepository extends Eloquent
{
	/**
	 * Generate and update a new password
	 * 
	 * @return array
	 */
	public static function renewPasswd()
	{
		$collection = Distributor::all();

		return collect($collection)->map(function ($row) {
			return [
				'_id' => $row->_id,
				'login' => $row->login,
				'email' => $row->email,
				'password' => self::generateRandomPasswd()
			];
		});
	}

	/**
	 * Generate Ramdon Password 
	 * genera string between 1 to 8 character
	 * 
	 * @return string
	 */
	protected static function generateRandomPasswd()
	{
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}
}