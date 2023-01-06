<?php

namespace Format\Rules;

interface RuleInterface {

	public function format($value, $format = null): string;

}