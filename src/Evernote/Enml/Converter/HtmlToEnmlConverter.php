<?php

namespace Evernote\Enml\Converter;

use Evernote\Enml\CSSInliner\CssInlinerInterface;
use Evernote\Enml\CSSInliner\CssToInlineStyles;
use Evernote\Enml\HtmlCleaner\HtmlCleanerInterface;
use Evernote\Enml\HtmlCleaner\HtmlPurifier;

class HtmlToEnmlConverter implements EnmlConverterInterface
{
    protected $htmlCleaner;

    protected $cssInliner;


    public function __construct(HtmlCleanerInterface $html_cleaner = null, CssInlinerInterface $css_inliner = null)
    {
        if (null === $html_cleaner) {
            $html_cleaner = new HtmlPurifier();
        }

        if (null === $css_inliner) {
            $css_inliner = new CssToInlineStyles();
        }

        $this->htmlCleaner = $html_cleaner;
        $this->cssInliner  = $css_inliner;
    }

    public function convertToEnml($content, $base_url = null)
    {
        $base_url = ($base_url === null)?'http://example.com':$base_url;

        //fix urls
        $content = str_replace('href="/', 'href="' . $base_url . '/', $content);
        $content = str_replace('href=""', 'href="' . $base_url . '"', $content);

//      $css = $this->extractCssFromHtml($content);
        //Then we inline the CSS
//      echo $cleanHtml = @$this->inlineCss($content, $css);

        //First we try to clean the HTML
        $content = $this->cleanHtml($content);

        //Transform to ENML via XSLT
        $enml_body = $this->xslTransform($content, 'html2enml.xslt');

        $enml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE en-note SYSTEM "http://xml.evernote.com/pub/enml2.dtd">
<en-note>
$enml_body
</en-note>
EOF;

        $enml = $enml_body;

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

    public function inlineCss($html, $css)
    {
        return $this->getCssInliner()->convert($html, $css);
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
        return $this->htmlCleaner;
    }

    public function getCssInliner()
    {
        return $this->cssInliner;
    }

    public function extractCssFromHtml($html)
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);

        $links = $dom->getElementsByTagName('link');

        $css = '';

        foreach($links as $link)
        {
            foreach ($link->attributes as $attribute) {
                if ($attribute->name === 'rel' && $attribute->value === 'stylesheet') {
                    $css .= file_get_contents($link->getAttribute('href'));
                }
            }
        }

        return $css;
    }
} 