<div class="col-xs-12 col-sm-11 col-md-11 col-md-offset-1 col-lg-10 col-lg-offset-1">
    <div role="search" class="search-block">
        {{ FastSearchUserCoreForm::display() }}
    </div>

    {if empty($users)}
        <p class="center bold">{lang 'Whoops! No users found.'}</p>
    {else}
        {each $user in $users}
            {{ $country_name = t($user->country) }}
            {{ $age = UserBirthDateCore::getAgeFromBirthDate($user->birthDate) }}

            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 thumb_photo">
                <figure>
                    {{ $avatarDesign->get($user->username, $user->firstName, $user->sex, 100) }}
                    <figcaption class="cy_ico">
                        <a href="{% (new UserCore)->getProfileLink($user->username) %}">
                            <strong>{% $str->extract($user->username, PH7_MAX_USERNAME_LENGTH_SHOWN) %}</strong>
                        </a> <img src="{{ $design->getSmallFlagIcon($user->country) }}" alt="{country_name}" title="{lang 'From %0%', $country_name}" />
                    </figcaption>
                </figure>

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

    <div class="row">
        <div class="col-xs-12">
            <p class="center">
                <a class="italic" href="{{ $design->url('user', 'search', 'advanced') }}">
                    {lang 'Advanced Search'}
                </a>
            </p>
        </div>
    </div>
</div>
