<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xhtml="http://www.w3.org/1999/xhtml">

    <xsl:output method="xml" omit-xml-declaration="yes" indent="yes" />

    <xsl:template match="/">

            <xsl:apply-templates select="xhtml:html/xhtml:body"></xsl:apply-templates>

    </xsl:template>



    <xsl:template match="xhtml:html/xhtml:body">
        <xsl:apply-templates />
    </xsl:template>

    <xsl:template match="xhtml:div">
        <xsl:element name="{name()}">
            <xsl:copy-of select="@*[contains('|style|title|lang|xml:lang|dir|align|',
                    concat('|', name(), '|')
                    )]" />
            <xsl:apply-templates />
        </xsl:element>
    </xsl:template>


    <xsl:template
            match="xhtml:a|xhtml:abbr|xhtml:acronym|xhtml:address|xhtml:area|xhtml:b|xhtml:bdo|xhtml:big|xhtml:blockquote|xhtml:br|xhtml:caption|xhtml:center|xhtml:cite|xhtml:code|xhtml:col|xhtml:colgroup|xhtml:dd|xhtml:del|xhtml:dfn|xhtml:dl|xhtml:dt|xhtml:em|xhtml:en-crypt|xhtml:en-media|xhtml:en-todo|xhtml:font|xhtml:h1|xhtml:h2|xhtml:h3|xhtml:h4|xhtml:h5|xhtml:h6|xhtml:hr|xhtml:i|xhtml:img|xhtml:ins|xhtml:kbd|xhtml:li|xhtml:map|xhtml:ol|xhtml:p|xhtml:pre|xhtml:q|xhtml:s|xhtml:samp|xhtml:small|xhtml:span|xhtml:strike|xhtml:strong|xhtml:sub|xhtml:sup|xhtml:table|xhtml:tbody|xhtml:td|xhtml:tfoot|xhtml:th|xhtml:thead|xhtml:tr|xhtml:tt|xhtml:u|xhtml:ul|xhtml:var">
        <xsl:element name="{name()}">
            <xsl:copy-of select="@*[not(name() = 'class') and not(name() = 'id') and not(starts-with(name(), 'data')) and not(name() = 'onclick')]" />
            <xsl:apply-templates />
        </xsl:element>
    </xsl:template>

    <!-- Container of en-media and others -->
    <xsl:template match="embed">
        <en-media>
            <xsl:copy-of select="@type" />
        </en-media>
    </xsl:template>
    <!-- Strip unknown text -->
    <xsl:template match="*">
        <xsl:apply-templates />
    </xsl:template>

    <!-- Accept all text nodes -->
    <xsl:template match="text()">
        <xsl:copy>
            <xsl:copy-of select="@*" />
            <xsl:apply-templates />
        </xsl:copy>
    </xsl:template>

</xsl:stylesheet>