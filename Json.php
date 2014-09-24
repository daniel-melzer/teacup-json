<?php

namespace Teacup;


class Json {


	/**
	 * @var array
	 */
	static protected $errors = array(
			JSON_ERROR_CTRL_CHAR => 'Control character error',
			JSON_ERROR_DEPTH => 'Maximum stack depth has been exceeded',
			JSON_ERROR_NONE => 'No error has occured',
			JSON_ERROR_STATE_MISMATCH => 'Malformed or invalid JSON',
			JSON_ERROR_SYNTAX => 'Syntax error',
			JSON_ERROR_UTF8 => 'Malformed UTF-8 characters'
	);


	const HEX_TAG = JSON_HEX_TAG;
	const HEX_AMP = JSON_HEX_AMP;
	const HEX_APOS = JSON_HEX_APOS;
	const HEX_QUOT = JSON_HEX_QUOT;
	const FORCE_OBJECT = JSON_FORCE_OBJECT;
	const NUMERIC_CHECK = JSON_NUMERIC_CHECK;
	const BIGINT_AS_STRING = JSON_BIGINT_AS_STRING;
	const PRETTY_PRINT = JSON_PRETTY_PRINT;
	const UNESCAPED_SLASHES = JSON_UNESCAPED_SLASHES;
	const UNESCAPED_UNICODE = JSON_UNESCAPED_UNICODE;


	/**
	 * Encodes a value to a JSON string and checks for errors.
	 *
	 * @static
	 * @param mixed $value
	 * @param int $options
	 * @return string
	 * @throws \RuntimeException
	 */
	static public function encode($value, $options = 0) {
		$return = @json_encode($value, $options);
		$lastError = json_last_error();

		if(JSON_ERROR_NONE !== $lastError) {
			throw new \RuntimeException(static::$errors[$lastError]);
		}

		return $return;
	}

	/**
	 * Decodes a json string and checks for errors.
	 *
	 * @static
	 * @param string $json
	 * @param bool $assoc
	 * @param int $depth
	 * @return mixed
	 * @throws \RuntimeException
	 */
	static public function decode($json, $assoc = false, $depth = 512) {
		$return = @json_decode($json, $assoc, $depth);
		$lastError = json_last_error();

		if(JSON_ERROR_NONE !== $lastError) {
			throw new \RuntimeException(static::$errors[$lastError]);
		}

		return $return;
	}

}
