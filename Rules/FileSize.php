<?php

namespace Gsdk\Format\Rules;

class FileSize implements RuleInterface {

	use Concerns\HasFormat;

	const FU = 'FU';
	const FFD = 'FFD';
	const FDS = 'FDS';
	const FGS = 'FGS';
	const FZ = 'FZ';

	protected $format = [
		'FU' => 'byte,Kb,Mb,Gb,Tb,Pb,Eb,Zb,Yb',
		'FFD' => 1,
		'FDS' => ',',
		'FGS' => ' ',
		'FZ' => 'n/a'
	];

	public function fromString(string $number): float {
		return (float)str_replace([' ', ','], ['', '.'], $number);
	}

	public function prepareValue($number): ?float {
		if (null === $number)
			return null;
		else if (is_string($number))
			return $this->fromString($number);
		else if (is_numeric($number))
			return (float)$number;
		else
			return null;
	}

	public function format($value, $format = null): string {
		$format = $this->parseFormat($format ?? 'filesize');
		$size = $this->prepareValue($value);

		if (null === $size || 0.0 === $size && false !== $format[self::FZ])
			return $format[static::FZ];

		$numberFormat = 'NFD=' . $format[static::FFD]
			. ';NDS=' . $format[static::FDS]
			. ';NGS=' . $format[static::FGS]
			. ';NZ=' . $format[static::FZ];

		if (!$format[static::FU])
			return app('format')->number($size, $numberFormat);

		$units = explode(',', (string)$format[static::FU]);
		$i = floor(log($size, 1024));
		while (!isset($units[$i])) {
			$i--;
		}
		$size = $size / pow(1024, $i);

		return app('format')->number($size, $numberFormat) . ' ' . $units[$i];
	}

}
