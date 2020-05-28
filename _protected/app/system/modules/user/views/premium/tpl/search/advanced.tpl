<div class="left col-md-8">
    {{ SearchUserCoreForm::advanced() }}
    {{ SaveSearchUserCriteriaForm::display() }}

    {if !empty(saved_searches)}
        <p>{lang 'Vos recherches sauvegardées'}</p>
        <ul>
            {each $saved_search in $saved_searches}
                <li>{{ $design->url('user', 'browse', 'index', "?$saved_search") }}</li>
            {/each}
        </ul>
    {/if}
</div>

<div class="right col-md-2 col-md-offset-2 ad_160_600">
    {designModel.ad(160, 600)}
</div>
