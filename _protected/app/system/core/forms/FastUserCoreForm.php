<?php
/**
 * @title          Search User Core Form
 *
 * @author         Pierre-Henry Soria <hello@ph7cms.com>
 * @copyright      (c) 2012-2019, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; See PH7.LICENSE.txt and PH7.COPYRIGHT.txt in the root directory.
 * @package        PH7 / App / System / Core / Form
 */

namespace PH7;

use PFBC\Element\Button;
use PFBC\Element\Checkbox;
use PFBC\Element\Hidden;
use PFBC\Element\HTMLExternal;
use PFBC\Element\Range;
use PFBC\Element\Select;
use PFBC\Element\Textbox;
use PFBC\View\Horizontal;
use PH7\Framework\Geo\Ip\Geo;
use PH7\Framework\Mvc\Model\DbConfig;
use PH7\Framework\Mvc\Request\Http as HttpRequest;
use PH7\Framework\Mvc\Router\Uri;
use PH7\Framework\Session\Session;

class FastUserCoreForm
{
    /**
     * Default field attributes.
     */
    private static $aSexOption = ['required' => 1];
    private static $aMatchSexOption = ['required' => 1];
    private static $aCountryOption = ['id' => 'str_country'];
    private static $aCityOption = ['id' => 'str_city'];
    private static $aStateOption = ['id' => 'str_state'];
    private static $aAgeOption;
    private static $aLatestOrder = [];
    private static $aAvatarOnly = [];
    private static $aOnlineOnly = [];

    public static function display($bSetDefVals = true)
    {
        if ($bSetDefVals) {
            self::setAttrVals();
        }

        $oForm = new \PFBC\Form('form_search');
        $oForm->configure(
            [
                'view' => new Horizontal,
                'action' => Uri::get('user', 'browse', 'index') . PH7_SH,
                'method' => 'get'
            ]
        );
        $oForm->addElement(new Hidden('submit_search', 'form_search'));
        $oForm->addElement(
            new Select(
                t('I am a:'),
                SearchQueryCore::MATCH_SEX,
                [
                    GenderTypeUserCore::MALE => t('Man'),
                    GenderTypeUserCore::FEMALE => t('Woman'),
                    GenderTypeUserCore::COUPLE => t('Couple')
                ],
                self::$aSexOption
            )
        );
        $oForm->addElement(
            new Checkbox(
                t('Looking for a:'),
                SearchQueryCore::SEX,
                [
                    GenderTypeUserCore::FEMALE => t('Woman'),
                    GenderTypeUserCore::MALE => t('Man'),
                    GenderTypeUserCore::COUPLE => t('Couple')
                ],
                self::$aMatchSexOption
            )
        );
        $oForm->addElement(
            new Range(
                t('Age Range'),
                'age',
                self::$aAgeOption
            )
        );
        $oForm->addElement(new Hidden(SearchQueryCore::COUNTRY, 'fr_FR'));
        $oForm->addElement(new Textbox(t('City:'), SearchQueryCore::CITY, self::$aCityOption));
        $oForm->addElement(new Checkbox('', SearchQueryCore::ORDER, [SearchCoreModel::LATEST => '<span class="bold">' . t('Latest members') . '</span>'], self::$aLatestOrder));
        $oForm->addElement(new Checkbox('', SearchQueryCore::AVATAR, ['1' => '<span class="bold">' . t('Only with Avatar') . '</span>'], self::$aAvatarOnly));
        $oForm->addElement(new Checkbox('', SearchQueryCore::ONLINE, ['1' => '<span class="bold green2">' . t('Only Online') . '</span>'], self::$aOnlineOnly));
        $oForm->addElement(new Button(t('Search'), 'submit', ['icon' => 'search']));
        $oForm->addElement(new HTMLExternal('<script src="' . PH7_URL_STATIC . PH7_JS . 'geo/autocompleteCity.js"></script>'));
        $oForm->render();
    }

    /**
     * Set the default values for the fields in search forms.
     *
     * @return void
     */
    protected static function setAttrVals()
    {
        $oHttpRequest = new HttpRequest;
        $oSession = new Session;
        $oUserModel = new UserCoreModel;

        if ($oHttpRequest->getExists(SearchQueryCore::MATCH_SEX)) {
            self::$aSexOption += ['value' => $oHttpRequest->get(SearchQueryCore::MATCH_SEX)];
        } else {
            self::$aSexOption += ['value' => self::getGenderVals($oUserModel, $oSession)['user_sex']];
        }

        if ($oHttpRequest->getExists(SearchQueryCore::SEX)) {
            self::$aMatchSexOption += ['value' => $oHttpRequest->get(SearchQueryCore::SEX)];
        } else {
            self::$aMatchSexOption += ['value' => self::getGenderVals($oUserModel, $oSession)['match_sex']];
        }

        self::$aAgeOption = ['value' => self::getAgeVals($oUserModel, $oSession)];
        if ($oHttpRequest->getExists([SearchQueryCore::MIN_AGE, SearchQueryCore::MAX_AGE])) {
            self::$aAgeOption = [
                'value' => [
                    'min_age' => $oHttpRequest->get(SearchQueryCore::MIN_AGE),
                    'max_age' => $oHttpRequest->get(SearchQueryCore::MAX_AGE)
                ]
            ];
        }

        if ($oHttpRequest->getExists(SearchQueryCore::COUNTRY)) {
            self::$aCountryOption += ['value' => $oHttpRequest->get(SearchQueryCore::COUNTRY)];
        } else {
            self::$aCountryOption += ['value' => Geo::getCountryCode()];
        }

        if ($oHttpRequest->getExists(SearchQueryCore::CITY)) {
            $sCity = $oHttpRequest->get(SearchQueryCore::CITY);
        } else {
            $sCity = Geo::getCity();
        }
        self::$aCityOption += ['value' => $sCity, 'onfocus' => "if('" . $sCity . "' == this.value) this.value = '';", 'onblur' => "if ('' == this.value) this.value = '" . $sCity . "';"];

        self::$aStateOption += ['value' => Geo::getState(), 'onfocus' => "if('" . Geo::getState() . "' == this.value) this.value = '';", 'onblur' => "if ('' == this.value) this.value = '" . Geo::getState() . "';"];

        if ($oHttpRequest->getExists(SearchQueryCore::ORDER)) {
            self::$aLatestOrder += ['value' => SearchCoreModel::LATEST];
        }

        if ($oHttpRequest->getExists(SearchQueryCore::AVATAR)) {
            self::$aAvatarOnly += ['value' => '1'];
        }

        if ($oHttpRequest->getExists(SearchQueryCore::ONLINE)) {
            self::$aOnlineOnly += ['value' => '1'];
        }
    }

    /**
     * If a user is logged, get the relative 'user_sex' and 'match_sex' for better and more intuitive search.
     *
     * @param UserCoreModel $oUserModel
     * @param Session $oSession
     *
     * @return array The 'user_sex' and 'match_sex'
     */
    protected static function getGenderVals(UserCoreModel $oUserModel, Session $oSession)
    {
        $sUserSex = GenderTypeUserCore::MALE;
        $aMatchSex = [
            GenderTypeUserCore::MALE,
            GenderTypeUserCore::FEMALE,
            GenderTypeUserCore::COUPLE
        ];

        if (UserCore::auth()) {
            $sUserSex = $oUserModel->getSex($oSession->get('member_id'));
            $aMatchSex = Form::getVal($oUserModel->getMatchSex($oSession->get('member_id')));
        }

        return ['user_sex' => $sUserSex, 'match_sex' => $aMatchSex];
    }

    /**
     * If a user is logged, get "approximately" the relative age for better and more intuitive search.
     *
     * @param UserCoreModel $oUserModel
     * @param Session $oSession
     *
     * @return array 'min_age' and 'max_age' which is the approximately age the user is looking for.
     */
    protected static function getAgeVals(UserCoreModel $oUserModel, Session $oSession)
    {
        $iMinAge = (int)DbConfig::getSetting('minAgeRegistration');
        $iMaxAge = (int)DbConfig::getSetting('maxAgeRegistration');

        if (UserCore::auth()) {
            $sBirthDate = $oUserModel->getBirthDate($oSession->get('member_id'));
            $iAge = UserBirthDateCore::getAgeFromBirthDate($sBirthDate);

            $iMinAge = ($iAge - 5 < $iMinAge) ? $iMinAge : $iAge - 5;
            $iMaxAge = ($iAge + 5 > $iMaxAge) ? $iMaxAge : $iAge + 5;
        }

        return ['min_age' => $iMinAge, 'max_age' => $iMaxAge];
    }
}
