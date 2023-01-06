<?php

namespace Format\Rules;

class Custom implements RuleInterface {

	protected $handler;

	public function __construct(callable $handler) {
		$this->handler = $handler;
	}

	public function format($value, $format = null): string {
		return call_user_func($this->handler, $value, $format);
	}

}