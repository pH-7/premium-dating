<?php
/**
 * @author         Pierre-Henry Soria <hello@ph7cms.com>
 * @copyright      (c) 2020, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; See PH7.LICENSE.txt and PH7.COPYRIGHT.txt in the root directory.
 * @package        PH7 / App / System / Module / User / Form
 */

namespace PH7;

class SaveSearchUserCriteriaFormProcess extends Form
{
    public function __construct()
    {
        $sSearchName = $this->httpRequest->get('search_name');
        $aData = [
            'profileId' => $this->session->get('member_id'),
            'searchName' => $sSearchName,
            'searchQueries' => $this->httpRequest->getQueryString()
        ];
        (new SavedSearchModel)->saveCriteria($aData);

        \PFBC\Form::setSuccess('form_save_search', t('Search has been successfully saved.'));
    }
}
