<?php

namespace PhpTek\Mataara\Report;

use SilverStripe\View\ArrayData;

/**
 * Base definition, format and functionality of a report, regardless of version.
 * 
 * @author Russell Michell <russ@theruss.com>
 * @package phptek/silverstripe-mataara
 */
class AbstractReport
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * 
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->data, true);
    }

    /**
     * 
     * @return ArrayData
     */
    public function toArrayData(): ArrayData
    {
        return ArrayData::create($this->data);
    }
}