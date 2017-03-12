# pslayers

Image layering with compositing

Uses Imagick and PHP 7+

##

Holds and manages layers of imagick canvases for easy manipulation and
blending.

### Basic Usage

```php
$init = [
  'id' => 12,
  'width' => 100,
  'height' => 100,
];

$pslayers = new Pslayers($init);
```

#### Single Layer

```php
// Bare minimum for a blank layer
$layerConfig = [
  'id' => 14,
  'width' => 100,
  'height' => 100,
];

$layer = new BlankLayer($layerConfig);

// getting
$width = $layer->width(); // $width = 100

// setting
$layer->width(200); // $width = 200
```

##### Standard base getters and setters

```
$layer->width();
$layer->height();
$layer->positionX();
$layer->positionY();
$layer->opacity(); // number between 0 and 1
$layer->composite(); // see notes below
```

##### Getting details of the layer

All layer classes implement an interface which forces the method
`getLayerDetailsArray()` which returns an array representation of the
layer, which differs from layer to layer.

There is a helper method that fetches the JSON representation of this
which is called `getLayerDetailsJson()` and all types of layers have
this method available on them.

##### Setting the Composite

Composite is the Composite Operator Constants, which is Imagick integer
constants.

You pass then in with `Imagick::COMPOSITE_DEFAULT` or whichever composite
operator you want to apply on your layer.

Currently only 1 composite, it is not possible to combine composites yet.

```php
$layer->composite(Imagick::COMPOSITE_LIGHTEN);
```

This composite will be applied when the stack is rendered.

#### Collections of Layers

```php
// Make a layer
$layer = new BlankLayer($config);

// Add to your Pslayers object
$pslayer->layers->addLayerToCollection($layer);

// Add with foced z-index (destructive, see notes below)
$pslayer->layers->addLayerToCollection($layer, 2);
```

##### Programmatic Collections

You can make and manipulate your own collections if you like

```php
// Make a collection
$collection = new LayerCollection();

// Add a layer to a collection
$collection->addLayerToCollection($layer);

// Add a layer with a forced z index (destructive, see notes below)
$collection->addLayerToCollection($layer, 1);
```

#### Rendering

Not yet implemented

You can call the render method on your collection which will render
up from index 0

```
$pslayers->addLayerToCollection($layer1);
$pslayers->addLayerToCollection($layer2);
$pslayers->addLayerToCollection($layer3);

$pslayers->render();
```

#### Layer Types

More info on the standard layer types

##### Blank Layer

Detailed above, this is the most basic but most powerful of layers. It has
unlimited potential.

You can interact with its `canvas` attribute, which is a fully functional
Imagick class.

Go crazy!

##### Text Layer

Allows addition and manipulation of text

Adds some additional text-specific properties

```php
$layer = new TextLayer($config);

$layer->text('text');
$layer->font('Ubuntu');
$layer->fontFamily('Times');
$layer->fontSize(16);
$layer->fontWeight(400);
$layer->fontStretch(\Imagick::STRETCH_ANY);
$layer->fontSize(\Imagick::STYLE_NORMAL);
$layer->underColour('#FFF');
$layer->fillColour('rgba(255, 128, 0, 0.5)');
$layer->fillOpacity(0.1);
$layer->strokeColour('hsl(200, 20, 50)');
$layer->strokeWidth(2);
$layer->strokeOpacity(1.0);
```

##### Gradient Layer

Not fully implemented

```php
$layer = new GradientLayer($config);

$layer->startColour('#FFFFFF');
$layer->endColour('#000000');
```

There is no start or end or direction yet

##### Solid Layer

This is just a solid colour layer

```php
$layer = new SolidLayer($config);

$layer->colour('#FFFFFF');
```

##### Group Layer

This is basically a layer that contains another collection of layers
that can each have their own compositing trees, so you can have greater
control over your layer composition and manipulation.

```php
$layer = new GroupLayer($config);

$newTextLayer = new Text($config);
$newGradientLayer = new Text($config);

$layer->group->addLayerToCollection($newGradientLayer, 1);
$layer->group->addLayerToCollection($newTextLayer, 2);
```

This needs to get its render triggered when appropriate

## TODO

* z-index management
* paramaters below
* blend/mix modes below

### Layer Parameters

* Brightness
* Contrast
* Opacity
* Saturation
* Tint
* Hue

### Layer Blend Modes

* Normal
* Dissolve

#### Darken

* Darken
* Multiply
* Colour Burn
* Linear Burn
* Darker Colour

#### Lighten

* Lighten
* Screen
* Colour Dodge
* Linear Dodge (Add)
* Lighter Colour

#### Contrast

* Overlay
* Soft Light
* Hard Light
* Vivid Light
* Linear Light
* Pin Light
* Hard Mix

#### Inversion

* Difference
* Exclusion


#### Cancelleation

* Subtract
* Divide

#### Component

* Hue
* Saturation
* Colour
* Luminosity

## Mask

* Gradiant Mask
* Transparency Mask

## Filters

There is support for filters

### Standard Filters

These are the base filters included with pslayers.

We have designed them to be easily extensible and creatable, and will
happily accept new filters into the core library should they be up to
scratch. Contributions are welcome.

### Fred's Filters Filter Pack

> We've included this by default, but you need to ask Fred if you're
wanting to use them for anything other than personal use.

These are wrapped up versions of the infamous Fred's Imagick scripts that
have been implemented as safely and securely as we possibly could.

In order to keep things consistent we do not support any default values
with any of these filters.

We have not implemented all the filters, but there is a solid base there
that should make it easy for anyone to quickly add one of his filters.

This also means that you can wrap up any bash script you like, but please,
use this wisely. We will only accept any contributions along these lines
after careful vetting.

#### Implemented Fred Filter and Usage
