<?php

namespace App\Lib\Xml;


class XmlValidator
{
    private $xml;
    private $xpathQuery;
    private $errors;

    public function __construct(\SimpleXMLElement $xml, string $query)
    {
        $this->xml = $xml;
        $this->xpathQuery = $query;
    }

    /**
     * check XML to contains required structure by query param
     * @return bool
     */
    public function isValid(): bool
    {
        try {
            $entries = $this->xml->xpath($this->xpathQuery);
            return $entries ? true : false;
        } catch (\Exception $e) {
            $this->errors = $e->getMessage();
            return false;
        }
    }

    /**
     * get last error happened
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /*
     * Set new XPath query
     * @param string $query XPath query
     */
    public function setXpathQuery(string $query): void
    {
        $this->xpathQuery = $query;
    }

    /*
     * Get XPath query
     * @return string $xpathQuery
     */
    public function getXpathQuery():string
    {
        return $this->xpathQuery;
    }
}