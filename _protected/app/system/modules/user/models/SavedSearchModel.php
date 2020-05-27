<?php
/**
 * @author         Pierre-Henry Soria <hello@ph7cms.com>
 * @copyright      (c) 2020, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; See PH7.LICENSE.txt and PH7.COPYRIGHT.txt in the root directory.
 * @package        PH7/ App / System / Module / User / Model
 */


namespace PH7;

use PDO;
use PH7\Framework\Mvc\Model\Engine\Db;
use PH7\Framework\Mvc\Model\Engine\Model;

class SavedSearchModel extends Model
{
    /** @var int|null */
    private $iProfileId;

    public function __construct($iProfileId = null)
    {
        $this->iProfileId = $iProfileId;
    }

    public function saveCriteria(array $aData)
    {
        $this->orm->insert(
            DbTableName::SAVED_SEARCH,
            $aData
        );
    }


    /**
     * @return array
     */
    public function retrieveSearch()
    {
        $sSql = 'SELECT searchQueries FROM' . Db::prefix(DbTableName::SAVED_SEARCH) . 'WHERE profileId = :profileId';
        $rStmt = Db::getInstance()->prepare($sSql);
        $rStmt->bindValue(':profileId', $this->iProfileId, PDO::PARAM_INT);
        $rStmt->execute();
        $aRow = $rStmt->fetchAll(PDO::FETCH_OBJ);
        Db::free($rStmt);

        return $aRow;
    }

    /**
     * @param int $iSavedSearchId
     *
     * @return bool
     */
    public function removeSearch($iSavedSearchId)
    {
        $sSql = 'DELETE FROM' . Db::prefix(DbTableName::SAVED_SEARCH) . 'WHERE savedSearchId = :savedSearchId AND profileId = :profileId LIMIT 1';
        $rStmt = Db::getInstance()->prepare($sSql);
        $rStmt->bindValue(':savedSearchId', $iSavedSearchId, PDO::PARAM_INT);
        $rStmt->bindValue(':profileId', $this->iProfileId, PDO::PARAM_INT);

        return $rStmt->execute();
    }
}
