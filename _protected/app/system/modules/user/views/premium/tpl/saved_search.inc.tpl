{{ SaveSearchUserCriteriaForm::display() }}

{if !empty($saved_searches) && count($saved_searches) > 0}
    <p class="bold">{lang 'Vos recherches sauvegardées'}</p>
    <ol>
        {each $saved_search in $saved_searches}
            <li>
                <a href="{url_root}{% $saved_search->searchQueries %}">
                    {% $saved_search->searchName %}
                </a>
            </li>
        {/each}
    </ol>
{/if}
