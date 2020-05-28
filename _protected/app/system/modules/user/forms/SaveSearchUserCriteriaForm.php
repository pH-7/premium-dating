<?php
/**
 * @author         Pierre-Henry Soria <hello@ph7cms.com>
 * @copyright      (c) 2020, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; See PH7.LICENSE.txt and PH7.COPYRIGHT.txt in the root directory.
 * @package        PH7 / App / System / Module / User / Form
 */

namespace PH7;

use PFBC\Element\Button;
use PFBC\Element\Hidden;
use PFBC\Element\Textbox;
use PFBC\Validation\Str;
use PH7\Framework\Mvc\Request\Http as HttpRequest;
use PH7\Framework\Url\Header;

class SaveSearchUserCriteriaForm
{
    public static function display()
    {
        if (isset($_POST['submit_save_search'])) {
            if (\PFBC\Form::isValid($_POST['submit_save_search'])) {
                new SaveSearchUserCriteriaFormProcess();
            }

            Header::redirect();
        }

        $oForm = new \PFBC\Form('form_save_search');
        $oForm->configure(['action' => '']);
        $oForm->addElement(
            new Hidden(
                'submit_save_search',
                'form_save_search'
            )
        );
        $oForm->addElement(
            new Hidden(
                'search_queries',
                (new HttpRequest)->getQueryString()
            )
        );
        $oForm->addElement(
            new Textbox(
                t('Search Name:'),
                'search_name',
                [
                    'placeholder' => t('My search 🎉'),
                    'validation' => new Str(3, 50),
                    'required' => 1
                ]
            )
        );

        $oForm->addElement(
            new Button(
                t('Save'),
                'submit',
                ['icon' => 'save']
            )
        );
        $oForm->render();
    }
}
