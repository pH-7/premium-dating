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

        $this->iMinAge = (int)DbConfig::getSetting('minAgeRegistration');
        $this->iMaxAge = (int)DbConfig::getSetting('maxAgeRegistration');
    }

    public function render()
    {
        // Get unique output/input ID name to prevent problems if the "range" field is used more than once on the same page
        $this->sRangeInputIdName = $this->getRangeInputName();
        parent::render();

        echo '<input type="hidden" name="age1" value="' . $this->minAgeDefaultValue() . '" id="min-age-input" />';
        echo '<input type="hidden" name="age2" value="' . $this->maxAgeDefaultValue() . '" id="max-age-input" />';
        echo '<div id="' . $this->sRangeInputIdName . '"></div>';
    }


    public function renderJS()
    {
        echo 'let slider = document.getElementById("' . $this->sRangeInputIdName . '");';
        echo 'let minAge = document.getElementById("min-age-input");';
        echo 'let maxAge = document.getElementById("max-age-input");';

        echo <<<JS
noUiSlider.create(slider, {
    start: [20, 60],
    keyboardSupport: true,
    tooltips: [true, true],
    range: {
        'min': 18,
        'max': 90
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

slider.noUiSlider.on('update', function(values, handle) {
  minAge.value = values[0];
  maxAge.value = values[1];
});
JS;
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
