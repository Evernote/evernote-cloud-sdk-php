<?php

namespace Evernote\Enml\Converter;

class EnmlToHtmlConverter implements HtmlConverterInterface
{
    public function convertToHtml($content)
    {
        return $this->xslTransform($content, __DIR__ . '/enml2html.xslt');
    }

    public function xslTransform($enml, $xsl_file)
    {
        $xml = new \DOMDocument();
        @$xml->loadXML($enml);

        $xsl = new \DOMDocument();
        $xsl->load($xsl_file);

        $proc = new \XSLTProcessor();
        $proc->importStyleSheet($xsl); // attach the xsl rules

        return $proc->transformToXML($xml);
    }
} 