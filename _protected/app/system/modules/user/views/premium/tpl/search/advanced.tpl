<div class="left col-md-8">
    {{ SearchUserCoreForm::advanced() }}
    {{ SaveSearchUserCriteriaForm::display() }}

    {each $saved_search in $saved_searches}

    {/each}
</div>

<div class="right col-md-2 col-md-offset-2 ad_160_600">
    {designModel.ad(160, 600)}
</div>
