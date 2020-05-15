<div class="cover-container">
    <div class="cover-content">
        {if $is_own_profile}
            <a href="{{ $design->url('user','setting','design') }}" title="{lang 'Change Cover Photo'}">
        {/if}
        <div class="cover-image"
            style="background-position: center; background-image: url('{if !empty($img_background)}{url_data_sys_mod}user/background/img/{username}/{img_background}{else}http://via.placeholder.com/1200x250}{/if}')">
        </div>
        {if $is_own_profile}
            </a>
        {/if}
    </div>
</div>
