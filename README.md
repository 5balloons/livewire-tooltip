# Livewire Tooltip

A dynamic, easy-to-use tooltip component for Laravel Livewire, enabling developers to add interactive tooltips to their Laravel applications with minimal effort.

## Features

- Dynamic content loading via Livewire
- Customizable tooltip positioning with Popper.js
- Easy integration with any Laravel project
- Support for HTML content and asynchronous data fetching

## Installation

To install the package, run the following command in your terminal:

```bash
composer require 5balloons/livewire-tooltip
```

## Usage

To use the `LivewireTooltip` component in your Livewire views, you need to follow below steps

### Install PooperJs

You can either install PopperJS via npm , or simply include the below CDN file in your layout file head element. 

```
    <script src="https://unpkg.com/@popperjs/core@2"></script>    
```

### Include Tooltip component in your view / layout

Include the tooltip component in your view file where you want to have the dynamic tooltip implemented, or you can include it in your layout file if you intend to have tooltips across your application

```
    <livewire:livewire-tooltip />
```

### Tooltip Elements

Example of a link that triggers the tooltip:

```
<a class="tooltip-link" tooltip-method="\App\Http\Controllers\YourController::tooltip">Hover me</a>
```


To implement the dynamic tooltip functionality, you need to define a method named `tooltip` in your controller. This method should return either a string or a view file that contains the content to be displayed in the tooltip.

Here's an example of how you can define the `tooltip` method in your controller:

```php
public function tooltip()
{
    // Your code here to generate the tooltip content
    return 'This is the tooltip content';
}
```

Make sure to replace `'This is the tooltip content'` with the actual content you want to display in the tooltip.

Once you have defined the `tooltip` method, you can use it in your view by adding the `tooltip-method` attribute to the tooltip link element, like this:

```html
<a class="tooltip-link" tooltip-method="\App\Http\Controllers\YourController::tooltip">Hover me</a>
```

Remember to replace `\App\Http\Controllers\YourController` with the actual namespace and class name of your controller.

That's it! Now when the user hovers over the tooltip link, the `tooltip` method will be invoked and the returned content will be displayed in the tooltip.


The tooltip method can either return a String or a View file. Tooltip component should be able to parse the dynamic variables and render the content inside tooltip

## Advanced Usage

For dynamic content loading and custom positioning:

```
<a class="tooltip-link" tooltip-method="\App\Http\Controllers\YourController::tooltip" data-param1="value" data-placement="bottom">Hover for dynamic content</a>
```

You can pass parameters to the method and specify the tooltip position as given in the above example

## License

This package is open-sourced software licensed under the MIT license.








