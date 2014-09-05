<?php

namespace Evernote\Enml\Converter;

use Evernote\Enml\HtmlCleaner\HtmlPurifier;

class HtmlToEnmlConverter implements EnmlConverterInterface
{
    protected $htmlCleaner;

    public function convertToEnml($content, $base_url = null)
    {
        //First we try to clean the HTML
        $cleanHtml = $this->cleanHtml($content);

        //Then we inline the CSS
        //$cleanHtml = $this->inlineCss($cleanHtml);

        //Transform to ENML via XSLT
        $enml_body = $this->xslTransform($cleanHtml, 'html2enml.xslt');

        $enml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE en-note SYSTEM "http://xml.evernote.com/pub/enml2.dtd">
<en-note>
$enml_body
</en-note>
EOF;

        echo $base_url = ($base_url === null)?'http://example.com':$base_url;


        //fix urls
        $enml = str_replace('href="/', 'href="' . $base_url . '/', $enml);
        $enml = str_replace('href=""', 'href="' . $base_url . '"', $enml);


        return $enml;
    }

    public function extractUrls($html)
    {
        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);
        $nodes = $xpath->query('//a/@href');

        $urls = array();
        foreach($nodes as $href) {
            $urls[] = $href->nodeValue;
        }

        return $urls;
    }

    public function isUrlValid($url)
    {
        $allowed_protocols = array('http', 'https', 'file');

        return in_array(parse_url($url, PHP_URL_SCHEME), $allowed_protocols)
            && filter_var($url, FILTER_VALIDATE_URL) !== false;

    }

    public function xslTransform($xhtml, $xsl_file)
    {
        $xml = new \DOMDocument();
        @$xml->loadXML($xhtml);

        $xsl = new \DOMDocument();
        $xsl->load($xsl_file);

        $proc = new \XSLTProcessor();
        $proc->importStyleSheet($xsl); // attach the xsl rules

        return $proc->transformToXML($xml);
    }

    public function cleanHtml($html)
    {
        $htmlCleaner = $this->getHtmlCleaner();

        $cleanHtml = $htmlCleaner->clean($html);

        return <<<EOF
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
<body>
$cleanHtml
</body>
</html>
EOF;
    }

    public function convertRelativeToAbsoluteUrls($html)
    {
        return $html;
    }

    public function validateEnml($enml, $dtd)
    {

    }

    public function getHtmlCleaner()
    {
        if (null === $this->htmlCleaner) {
            $this->htmlCleaner = new HtmlPurifier();
        }

        return $this->htmlCleaner;
    }
} 