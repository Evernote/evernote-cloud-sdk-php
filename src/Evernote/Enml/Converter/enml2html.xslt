<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <!-- https://gist.github.com/masatomo/273067 -->

    <xsl:output method="html"/>

    <xsl:template match="en-note">
        <xsl:apply-templates/>
    </xsl:template>

    <xsl:template match="en-todo">
        <input type="checkbox" value="1" checked="{@checked}"/>
    </xsl:template>

    <xsl:template match="en-crypt">
        <span title="{@hint}" data="{text()}">
            ENCRYPTED (Hint: <xsl:value-of select="@hint"/>)
        </span>
    </xsl:template>

    <xsl:template match="en-media">
        <xsl:choose>
            <xsl:when test="contains(@type, 'image/png')">
                <img>
                    <xsl:attribute name="class">attach_img</xsl:attribute>
                    <xsl:attribute name="src">
                        <xsl:value-of select="concat('/images/', @hash, '.png')"/>
                    </xsl:attribute>
                </img>
            </xsl:when>
            <xsl:when test="contains(@type, 'image/jpeg')">
                <img>
                    <xsl:attribute name="class">attach_img</xsl:attribute>
                    <xsl:attribute name="src">
                        <xsl:value-of select="concat('/images/', @hash, '.jpg')"/>
                    </xsl:attribute>
                </img>
            </xsl:when>
            <xsl:otherwise>
                Unknown media:
                <xsl:value-of select="@type"/>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <!-- All the rest -->
    <xsl:template match="* | @* | text()">
        <xsl:copy>
            <xsl:apply-templates select="* | @* | text()"/>
        </xsl:copy>
    </xsl:template>

</xsl:stylesheet>