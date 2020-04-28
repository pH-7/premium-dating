<div class="box-left col-md-3 col-lg-3 col-xl-2">
    <div role="search" class="design-box">
        {{ FastUserCoreForm::display() }}
    </div>
</div>

<div class="col-md-9 col-lg-9 col-xl-9 col-xl-offset-1">
    {if empty($users)}
        <p class="center bold">{lang 'Whoops! No users found.'}</p>
    {else}
        {each $user in $users}
            {{ $country_name = t($user->country) }}
            {{ $age = UserBirthDateCore::getAgeFromBirthDate($user->birthDate) }}

            <div class="col-6 col-sm-6 col-md-4 col-lg-3 thumb_photo">
                {{ $avatarDesign->get($user->username, $user->firstName, $user->sex, 100, true) }}
                <p class="cy_ico">
                    <a href="{% (new UserCore)->getProfileLink($user->username) %}" title="{lang 'Name: %0%', $user->firstName}<br> {lang 'Gender: %0% %1%', t($user->sex), $sex_ico}<br> {lang 'Seeking: %0%', t($user->matchSex)}<br> {lang 'Age: %0%', $age}<br> {lang 'From: %0%', $country_name}<br> {lang 'City: %0%', $str->upperFirst($user->city)}<br> {lang 'State: %0%', $str->upperFirst($user->state)}">
                        <strong>{% $str->extract($user->username, PH7_MAX_USERNAME_LENGTH_SHOWN) %}</strong>
                    </a> <img src="{{ $design->getSmallFlagIcon($user->country) }}" alt="{country_name}" title="{lang 'From %0%', $country_name}" />
                </p>

                {if $is_admin_auth}
                    <p class="small">
                        <a href="{{ $design->url(PH7_ADMIN_MOD,'user','loginuseras',$user->profileId) }}" title="{lang 'Login As a member'}">{lang 'Login'}</a> |
                        {if $user->ban == '0'}
                            {{ $design->popupLinkConfirm(t('Ban'), PH7_ADMIN_MOD, 'user', 'ban', $user->profileId) }}
                        {else}
                            {{ $design->popupLinkConfirm(t('UnBan'), PH7_ADMIN_MOD, 'user', 'unban', $user->profileId) }}
                        {/if}
                        | <br />{{ $design->popupLinkConfirm(t('Delete'), PH7_ADMIN_MOD, 'user', 'delete', $user->profileId.'_'.$user->username) }} |
                        {{ $design->ip($user->ip) }}
                    </p>
                {/if}
            </div>
        {/each}

        {main_include 'page_nav.inc.tpl'}
    {/if}
</div>
