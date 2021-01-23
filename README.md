<p align="center"><a href="https://symfony.com" target="_blank">
    <img src="https://symfony.com/logos/symfony_black_02.svg">
</a></p>

<h3 align="center">
    Symfony UX: a new JavaScript ecosystem for Symfony
</h3>

Symfony UX is an initiative and set of libraries to seamlessly
integrate JavaScript tools into your application. For example,
want to render a chart with [Chart.js](https://www.chartjs.org/)? Use
[UX Chart.js](https://github.com/symfony/ux-chartjs)
to build the chart in PHP. The JavaScript is handled for your automatically.

**That's Symfony UX.**

[Read all the details about the Symfony UX initiative](https://symfony.com/ux)

## Components of UX

Symfony UX leverages [Stimulus](https://stimulus.hotwire.dev/) for JavaScript
and the [Stimulus Bridge](https://github.com/symfony/stimulus-bridge) for
integrating it into Webpack Encore.

## Packages

-   [UX Chart.js](https://github.com/symfony/ux-chartjs):
    [Chart.js](https://www.chartjs.org/) chart library integration for Symfony
-   [UX Cropper.js](https://github.com/symfony/ux-cropperjs):
    [Cropper.js](https://fengyuanchen.github.io/cropperjs/) image cropper library integration for Symfony
-   [UX Dropzone](https://github.com/symfony/ux-dropzone):
    File input drag-and-drop zones for Symfony Forms
-   [UX LazyImage](https://github.com/symfony/ux-lazy-image):
    Improve image loading performances through lazy-loading and data-uri thumbnails
-   [UX Swup](https://github.com/symfony/ux-swup):
    [Swup](https://swup.js.org/) page transition library integration for Symfony

## Stimulus Tools around the World

Because Stimulus is used by developers outside of Symfony, many tools
exist beyond the UX packages:

-   [stimulus-use](https://github.com/stimulus-use/stimulus-use): Add composable
    behaviors to your Stimulus controllers, like [debouncing](https://stimulus-use.github.io/stimulus-use/#/use-debounce),
    [detecting outside clicks](https://stimulus-use.github.io/stimulus-use/#/use-click-outside)
    and many other things. See: https://stimulus-use.github.io/stimulus-use/#/

-   [stimulus-components](https://stimulus-components.netlify.app/docs/components/index/): A
    large number of pre-made Stimulus controllers, like for
    [Copying to clipboard](https://stimulus-components.netlify.app/docs/components/stimulus-clipboard/),
    [Sortable](https://stimulus-components.netlify.app/docs/components/stimulus-sortable/),
    [Popover](https://stimulus-components.netlify.app/docs/components/stimulus-popover/) (similar to tooltips)
    and much more.

## Let's build an amazing ecosystem together

Symfony UX is an **initiative**: its aim is to build an ecosystem. To achieve this,
we need your help: what other packages could we create in Symfony UX? What about a
library that automatically adds an [input mask](https://imask.js.org/) to the text
fields of your Symfony forms? Or the ability to make the `EntityType` render with
[AJAX auto-completion](https://tarekraafat.github.io/autoComplete.js)? Anything you
do in JavaScript could be done streamlined as a UX package.

We have some ideas and we will release more packages in the coming days. The rest
is on you: let's create an amazing ecosystem together!
