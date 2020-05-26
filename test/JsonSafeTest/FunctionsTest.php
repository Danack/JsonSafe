<?php

declare(strict_types=1);

namespace JsonSafeTest;

use JsonSafe\JsonDecodeException;
use JsonSafe\JsonEncodeException;
use function JsonSafe\json_decode_safe;
use function JsonSafe\json_encode_safe;

/**
 * @coversNothing
 */
class FunctionsTest extends BaseTestCase
{
    public function testBasicEncode()
    {
        $data = [1, 2, 3];

        $json = json_encode_safe($data);

        $outputData = json_decode_safe($json);
        $this->assertSame($data, $outputData);
    }

    public function testDecodeFailed()
    {
        $this->expectException(JsonDecodeException::class);
        json_decode_safe("This is not json{");
    }

    public function testEncodeFailed()
    {
        $this->expectException(JsonEncodeException::class);
        json_encode_safe(fopen('php://input', 'r+'));
    }
}
