<?php namespace Arcanesoft\Blog\ViewComposers\Admin\Forms;

use Arcanesoft\Blog\ViewComposers\AbstractComposer;
use Illuminate\Contracts\View\View;
use Arcanedev\Localization\Entities\Locale;

/**
 * Class     LocalesSelectComposer
 *
 * @package  Arcanesoft\Blog\ViewComposers\Admin\Forms
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class LocalesSelectComposer extends AbstractComposer
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const VIEW = 'blog::admin.posts._includes.locale-select';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Compose the view.
     *
     * @param  \Illuminate\Contracts\View\View  $view
     */
    public function compose(View $view)
    {
        $locales = localization()->getSupportedLocales()->transform(function (Locale $locale) {
            return $locale->native();
        });

        $view->with('supportedLocales', $locales);
    }
}
