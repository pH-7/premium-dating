<?php
/**
 * File created by Pierre-Henry Soria <hi@ph7.me>
 */

namespace PFBC\Element;

use PFBC\OptionElement;
use PH7\Framework\Mvc\Model\DbConfig;

class AgeRange extends OptionElement
{
    const MIN_AGE_TYPE = 'min_age';
    const MAX_AGE_TYPE = 'max_age';

    /** @var int */
    private $iMinAge;

    /** @var int */
    private $iMaxAge;

    /** @var string */
    private $sRangeInputIdName;

    /**
     * Generate the select field for age search.
     *
     * @param string $sLabel
     * @param array|null $aProperties
     */
    public function __construct($sLabel, array $aProperties = null)
    {
        parent::__construct($sLabel, '', [], $aProperties);

        // Set unique output/input ID name to prevent problems if the "range" field is used more than once on the same page
        $this->sRangeInputIdName = $this->getRangeInputName();

        $this->iMinAge = (int)DbConfig::getSetting('minAgeRegistration');
        $this->iMaxAge = (int)DbConfig::getSetting('maxAgeRegistration');
    }

    public function render()
    {
        echo '<input type="hidden" name="age1" value="' . $this->minAgeDefaultValue() . '" id="min-age-input" />';
        echo '<input type="hidden" name="age2" value="' . $this->maxAgeDefaultValue() . '" id="max-age-input" />';
        echo '<div id="' . $this->sRangeInputIdName . '" style="width:15rem;margin-left:1.8rem;display:inline-block"></div>';
    }


    public function renderJS()
    {
        echo 'var slider = document.getElementById("' . $this->sRangeInputIdName . '");';
        echo 'var minAge = document.getElementById("min-age-input");';
        echo 'var maxAge = document.getElementById("max-age-input");';

        echo 'noUiSlider.create(slider, {
    start: [minAge.value, maxAge.value],
    keyboardSupport: true,
    tooltips: [true, true],
    range: {
    \'min\':' . $this->iMinAge . ',
        \'max\':' . $this->iMaxAge . '
    },
    format: {
    from: function(value) {
            return parseInt(value);
        },
    to: function(value) {
            return parseInt(value);
        }
    }
});

slider.noUiSlider.on(\'update\', function(values, handle) {
  minAge.value = values[0];
  maxAge.value = values[1];
});';
    }

    public function getJSFiles()
    {
        return [
            $this->form->getResourcesPath() . '/js/nouislider.js',
            'https://refreshless.com/nouislider/documentation/assets/wNumb.js'
        ];
    }

    public function getCSSFiles()
    {
        return [
            $this->form->getResourcesPath() . '/css/nouislider.css'
        ];
    }

    /**
     * @return string
     */
    private function getRangeInputName()
    {
        return 'rangeInput' . mt_rand(1, 10);
    }

    /**
     * @return int
     */
    private function minAgeDefaultValue()
    {
        return !empty($this->attributes['value'][static::MIN_AGE_TYPE]) ? $this->attributes['value'][static::MIN_AGE_TYPE] : $this->iMinAge;
    }

    /**
     * @return int
     */
    private function maxAgeDefaultValue()
    {
        return !empty($this->attributes['value'][static::MAX_AGE_TYPE]) ? $this->attributes['value'][static::MAX_AGE_TYPE] : $this->iMaxAge;
    }
}
