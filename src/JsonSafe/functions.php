<?php

declare(strict_types = 1);

namespace JsonSafe;

use JsonSafe\JsonDecodeException;
use JsonSafe\JsonEncodeException;

/**
 * Decode JSON with actual error detection
 *
 * @param string|null $json
 * @return mixed
 * @throws JsonDecodeException
 *
 * null is allowed, as a type, so that a meaningful error can be thrown.
 *
 */
function json_decode_safe(?string $json)
{
    if ($json === null) {
        throw new JsonDecodeException("Error decoding JSON: cannot decode null.");
    }

    $data = json_decode($json, true);

    if (json_last_error() === JSON_ERROR_NONE) {
        return $data;
    }

    $parser = new \Seld\JsonLint\JsonParser();
    $parsingException = $parser->lint($json);

    if ($parsingException !== null) {
        throw $parsingException;
    }

    if ($data === null) {
        throw new JsonDecodeException("Error decoding JSON: null returned.");
    }

    throw new JsonDecodeException("Error decoding JSON: " . json_last_error_msg());
}


/**
 * @param mixed $data
 * @param int $options
 * @return string
 * @throws Exception
 */
function json_encode_safe($data, $options = 0): string
{
    $result = json_encode($data, $options);

    if ($result === false) {
        throw new JsonEncodeException("Failed to encode data as json: " . json_last_error_msg());
    }

    return $result;
}
