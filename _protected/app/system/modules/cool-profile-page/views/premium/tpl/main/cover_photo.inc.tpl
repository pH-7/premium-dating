<div class="cover-container">
    <div class="cover-content">
        <a href="{{ $design->url('user','setting','design') }}" title="{lang 'Change Cover Photo'}">
            <div class="cover-image"
                 style="background-position: center; background-image: url('{if !empty($img_background)}{url_data_sys_mod}user/background/img/{username}/{img_background}{else}http://via.placeholder.com/900x200}{/if}')">
            </div>
        </a>
    </div>
</div>
