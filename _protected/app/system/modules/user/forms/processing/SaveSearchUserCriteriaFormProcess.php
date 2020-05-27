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
    const MIN_SEARCH_TITLE_LENGTH = 5;

    public function __construct()
    {
        $sSearchName = $this->httpRequest->get('search_name');
        if (strlen($sSearchName) >= self::MIN_SEARCH_TITLE_LENGTH) {
            $aData = [
                'profileId' => $this->session->get('member_id'),
                'searchName' => $sSearchName,
                'searchQueries' => $this->httpRequest->get('search_name')
            ];

            (new SavedSearchModel)->saveCriteria($aData);

            \PFBC\Form::setSuccess('form_save_search', t('Search has been successfully saved.'));
        } else {
            \PFBC\Form::setError('form_save_search', t('Search name must contain at least 5 characters'));
        }
    }
}
