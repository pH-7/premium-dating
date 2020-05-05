<?php
/**
 * File created by Pierre-Henry Soria <hi@ph7.me>
 */

namespace PFBC\Element;

use PFBC\OptionElement;

class AgeRange extends OptionElement
{
    /** @var string */
    private $sRangeInputIdName;

    public function render()
    {
        // Get unique output/input ID name to prevent problems if the "range" field is used more than once on the same page
        $this->sRangeInputIdName = $this->getRangeInputName();
        parent::render();

        echo '<div id="' . $this->sRangeInputIdName . '"></div>';
    }


    public function renderJS()
    {
        echo 'var slider = document.getElementById("' . $this->sRangeInputIdName . '");';

        echo <<<JS
noUiSlider.create(slider, {
    start: [20, 80],
    keyboardSupport: true,
    tooltips: [true, true],
    range: {
        'min': 18,
        'max': 99
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
}
