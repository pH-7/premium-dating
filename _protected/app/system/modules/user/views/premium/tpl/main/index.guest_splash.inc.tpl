{if $is_bg_video}
    {* If Splash Video Background is enabled in the admin panel *}
    {manual_include 'splash_video_background.inc.tpl'}
{/if}

<div class="col-md-8 login_block animated fadeInDown">
    {{ LoginSplashForm::display() }}
</div>

{if !$is_mobile}
    <div class="left col-md-8 animated fadeInLeft">
        {manual_include 'user_promo_block.inc.tpl'}
    </div>
{/if}

<div class="left col-md-4 animated fadeInRight">
    <h1 class="red3 italic underline">{headline}</h1>

    {* For small devices, the following will be activated through /templates/themes/base/css/splash.css *}
    <div class="login_button hidden center">
        <a href="{{ $design->url('user','main','login') }}" class="btn btn-primary btn-lg">
            <strong>{lang 'Login'}</strong>
        </a>
    </div>

    {{ JoinForm::step1() }}

    {if $is_mobile}
        <div class="s_tMarg"></div>
        {manual_include 'user_promo_block.inc.tpl'}
    {/if}
</div>
