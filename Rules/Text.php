<?php

namespace Format\Rules;

class Text implements RuleInterface {

	use Concerns\HasFormat;

	const TL = 'TL';
	const TE = '';
	const TA = '';

	protected $format = [
		'TL' => null,
		'TE' => '',
		'TA' => ''
	];

	protected function prepareValue($value): string {
		return is_string($value) ? $value : (string)$value;
	}

	public function format($value, $format = null): string {
		$string = $this->prepareValue($value);
		$format = $this->parseFormat($format ?? 'string');

		if ($format[static::TL])
			$string = mb_substr($string, 0, $format[static::TL], 'utf8');

		return $string;
	}

}