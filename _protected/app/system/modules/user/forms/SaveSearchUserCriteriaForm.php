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

        // Generate the Quick Search form
        $oForm = new \PFBC\Form('form_save_search');
        $oForm->configure(['action' => '']);
        $oForm->addElement(
            new Hidden(
                'submit_save_search',
                'form_save_search'
            )
        );
        $oForm->addElement(
            new Textbox(
                t('Save Search:'),
                'search_name'
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
