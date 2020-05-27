<?php
/**
 * @author         Pierre-Henry Soria <hello@ph7cms.com>
 * @copyright      (c) 2020, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; See PH7.LICENSE.txt and PH7.COPYRIGHT.txt in the root directory.
 * @package        PH7/ App / System / Module / User / Model
 */


namespace PH7;

use PH7\Framework\Mvc\Model\Engine\Model;

class SavedSearchModel extends Model
{
    public function saveCriteria(array $aData)
    {
        $this->orm->insert(
            DbTableName::SAVED_SEARCH,
            $aData
        );
    }
}
