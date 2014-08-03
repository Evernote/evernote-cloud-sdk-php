<?php
namespace Evernote\Tests\Helper;

use Evernote\Helper\PlainTextToEnmlConverter;

class PlainTextToEnmlConverterTest extends \PHPUnit_Framework_TestCase
{
    public function test_convertToEnml_shouldReturnAString()
    {
        $converter = new PlainTextToEnmlConverter();
        $this->assertInternalType('string', $converter->convertToEnml('foo'));
    }
} 