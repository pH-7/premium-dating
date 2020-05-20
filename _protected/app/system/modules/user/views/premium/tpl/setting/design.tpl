<div class="col-md-8">
    <p>
        <a href="{path_img_background}" data-popup="image">
            <img
                src="{path_img_background}"
                alt="{lang 'Cover Photo'}"
                title="{lang 'Your current cover photo'}"
                width="160"
                height="150"
            />
        </a>
    </p>

    {* Only show "Remove" link if it's not the NONE placeholder image *}
    {if strpos($path_img_background, UserDesignCore::NONE_IMG_FILENAME) === false}
        {if $is_admin_auth AND !$is_user_auth}
            {{ LinkCoreForm::display(t('Remove cover photo?'), null, null, null, array('del'=>1)) }}
        {else}
            {{ LinkCoreForm::display(t('Remove cover photo?'), 'user', 'setting', 'design', array('del'=>1)) }}
        {/if}
    {/if}

    {{ DesignForm::display() }}
</div>
