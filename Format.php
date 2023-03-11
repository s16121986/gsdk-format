<?php

namespace Gsdk\Format;

use Illuminate\Support\Facades\Facade;

class Format extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'format';
	}
}