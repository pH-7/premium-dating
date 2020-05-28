{if User::auth()}
    {{ SaveSearchUserCriteriaForm::display() }}

    <p>{lang 'Vos recherches sauvegardées'}</p>
    <ul>
        {each $saved_search in $saved_searches}
            <li>{{ $design->url('user', 'browse', 'index', "?{$saved_search->searchQueries}") }}</li>
        {/each}
    </ul>
{/if}
