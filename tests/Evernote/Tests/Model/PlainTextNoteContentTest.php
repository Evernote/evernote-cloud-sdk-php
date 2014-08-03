<?php
namespace Evernote\Tests\Model;

use Evernote\Model\PlainTextNoteContent;

class PlainTextNoteContentTest extends \PHPUnit_Framework_TestCase
{
    public function test_getEnmlConverter_notSet_shouldInstantiateTheConverter()
    {
        $note_content = new PlainTextNoteContent('foo');

        $this->assertInstanceOf('\Evernote\Helper\EnmlConverterInterface', $note_content->getEnmlConverter());
    }

    public function test_getEnmlConverter_isSet_shouldReturnTheConverter()
    {
        $converterStub = $this->getMock('\Evernote\Helper\EnmlConverterInterface');
        $note_content = new PlainTextNoteContent('foo', $converterStub);

        $this->assertEquals($converterStub, $note_content->getEnmlConverter());
    }

    public function test_toEnml_shouldCallTheConvertToEnmlMethodOnce()
    {
        $content = 'foo';
        $converter = $this->getMockBuilder('\Evernote\Helper\EnmlConverterInterface')
            ->getMock();

        $converter->expects($this->once())
            ->method('convertToEnml')
            ->with($this->equalTo($content));

        $note_content = $note_content = new PlainTextNoteContent('foo', $converter);
        $note_content->toEnml();
    }
} 