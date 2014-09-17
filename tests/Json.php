<?php

define('DOCUMENT_ROOT', __DIR__ . '/../');
require DOCUMENT_ROOT . 'Json.php';


class Json extends \PHPUnit_Framework_TestCase {


	/**
	 * @var array
	 */
	private $array = array('<foo>',"'bar'",'"baz"','&blong&');


	public function testEncode() {
		$result = Teacup\Json::encode($this->array);
		$this->assertJsonStringEqualsJsonString($result, '["<foo>","\'bar\'","\"baz\"","&blong&"]');
	}

	public function testEncodeOptionTag() {
		$result = Teacup\Json::encode($this->array, Teacup\Json::HEX_TAG);
		$this->assertJsonStringEqualsJsonString(
				$result, '["\u003Cfoo\u003E","\'bar\'","\"baz\"","&blong&"]');
	}

	public function testEncodeOptionApos() {
		$result = Teacup\Json::encode($this->array, Teacup\Json::HEX_APOS);
		$this->assertJsonStringEqualsJsonString(
				$result, '["<foo>","\u0027bar\u0027","\"baz\"","&blong&"]');
	}

	public function testEncodeOptionQuot() {
		$result = Teacup\Json::encode($this->array, Teacup\Json::HEX_QUOT);
		$this->assertJsonStringEqualsJsonString(
				$result, '["<foo>","\'bar\'","\u0022baz\u0022","&blong&"]');
	}

	public function testEncodeOptionAmp() {
		$result = Teacup\Json::encode($this->array, Teacup\Json::HEX_AMP);
		$this->assertJsonStringEqualsJsonString(
				$result, '["<foo>","\'bar\'","\"baz\"","\u0026blong\u0026"]');
	}

	public function testEncodeOptionAll() {
		$result = Teacup\Json::encode(
				$this->array,
				Teacup\Json::HEX_TAG|Teacup\Json::HEX_APOS|Teacup\Json::HEX_QUOT|
						Teacup\Json::HEX_AMP|Teacup\Json::BIGINT_AS_STRING|
						Teacup\Json::PRETTY_PRINT|Teacup\Json::UNESCAPED_SLASHES|
						Teacup\Json::UNESCAPED_UNICODE
		);
		$this->assertJsonStringEqualsJsonString(
				$result,
				'["\u003Cfoo\u003E","\u0027bar\u0027","\u0022baz\u0022","\u0026blong\u0026"]'
		);
	}

	public function testEncodeOptionObject() {
		$result = Teacup\Json::encode($this->array, Teacup\Json::FORCE_OBJECT);
		$this->assertJsonStringEqualsJsonString(
				$result,
				'{"0":"<foo>","1":"\'bar\'","2":"\"baz\"","3":"&blong&"}'
		);
	}

	public function testEncodeOptionNumber() {
		$result = Teacup\Json::encode(array('test' => '1337'), Teacup\Json::NUMERIC_CHECK);
		$this->assertEquals($result, '{"test":1337}');
	}

	public function testEncodeOptionBigintAsString() {
		$result = Teacup\Json::encode(
				array('test' => '214748364812345'),
				Teacup\Json::BIGINT_AS_STRING);
		$this->assertEquals($result, '{"test":"214748364812345"}');
	}

	public function testEncodeOptionPrettyPrint() {
		$result = Teacup\Json::encode(array('test' => '1337'), Teacup\Json::PRETTY_PRINT);
		$this->assertEquals($result, '{
    "test": "1337"
}');
	}

	/**
	 * @expectedException RuntimeException
	 * @expectedExceptionMessage Malformed UTF-8 characters
	 */
	public function testEncodeFailingUtf8() {
		Teacup\Json::encode(array(utf8_decode('äüß')));
	}

	public function testDecode() {
		$result = Teacup\Json::decode('{"a":1,"b":2,"c":3,"d":4,"e":5}');
		$this->assertInstanceof('stdClass', $result);
	}

	public function testDecodeArray() {
		$result = Teacup\Json::decode('["<foo>","\'bar\'","\"baz\"","&blong&"]', true);
		$this->assertEquals($result, $this->array);
	}

	/**
	 * @expectedException RuntimeException
	 * @expectedExceptionMessage Maximum stack depth has been exceeded
	 */
	public function testDecodeFailingDepth() {
		Teacup\Json::decode('["<foo>","\'bar\'","\"baz\"","&blong&"]', false, 1);
	}

	/**
	 * @expectedException RuntimeException
	 * @expectedExceptionMessage Syntax error
	 */
	public function testDecodeFailingSyntax() {
		Teacup\Json::decode("{'test': 'failing away'}");
	}

}
