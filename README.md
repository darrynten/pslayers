# pslayers

Powerful and fully featured PHP library that features photoshop-style
image layering, compositing, filtering, blending and masking.

Uses Imagick and PHP 7+

## Introduction

We needed to give [buzzbot.ai](https://buzzbot.ai) a way to express
herself visually, so we gave her photoshop-level image management and
manipulation capabilities.

This is the core package that our bots use during their Generation
phases. As such it has been designed from the ground up to be simple
to use, but to also allow for maximum flexibility.

The core function of this package is to provide an easy way to layer
images and then composite them together.


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

Currently only a start-to-finish top-to-bottom solid-to-solid gradient
layer. This will be expanded upon.

Like its cousin it's also not 100% implemented, but it provides the most
basic of radial gradient that Imagick has to offer.

```php
$layer = new GradientLayer($config);

$layer->startColour('#FFFFFF');
$layer->endColour('#000000');
```

There is no start or end or direction yet

#### Radial Gradient Layer

```php
$layer = new RadialGradientLayer($config);

$layer->startColour('#FFFFFF');
$layer->endColour('#000000');
```

##### Solid Layer

This is just a solid colour layer

```php
$layer = new SolidLayer($config);

$layer->colour('#FFFFFF');
```

##### Pattern Layer

A layer that tiles a standard Imagick pattern. You can add optional
scaling and scale filtering values.

```php
$layer = new PatternLayer($config);

$layer->pattern('bricks');
$layer->scale(2);
$layer->scaleFilter(Imagick::FILTER_BICUBIC);
```

##### Plasma Layer

Generates the standard Imagick `plasma:` style Psuedoimage.

```php
$layer = new PlasmaLayer($config);
```

##### Group Layer

not 100% implemented

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

## Compositing

A big part of the power of this comes from the compositing that is
available.

You can add a composite mode to any layer and during render it will be
applied.

Note that while you can apply multiple filters to layers, you can
only apply a single composite. If you want to achieve multiple composite
mixes at once you can achieve this by making a group layer with copies
of the same layer in there and composite each copy the way you want.

Supported composite modes

* Add - The image + the image below
* Atop - The result is the same shape as image, with composite image obscuring image where the image shapes overlap
* Blend - Blends the image
* Bump Map - The same as multiply, except the source is converted to grayscale first.
* Colour Burn - Darkens the destination image to reflect the source image
* Colour Dodge - Brightens the destination image to reflect the source image
* Colourise - Colorizes the target image using the composite image
* Copy - Copies the source image on the target image
* Copy Black - Copies black from the source to target
* Copy Blue - Copies blue from the source to target
* Copy Cyan - Copies cyan from the source to target
* Copy Green - Copies green from the source to target
* Copy Magenta - Copies magenta from the source to target
* Copy Opacity - Copies opacity from the source to target
* Copy Red - Copies red from the source to target
* Copy Yellow - Copies yellow from the source to target
* Darken - Darkens the target image
* Destination Atop - The part of the destination lying inside of the source is composited over the source and replaces the destination
* Destination In - The parts inside the source replace the target
* Destination Out - The parts outside the source replace the target
* Destination Over - Target replaces the source
* Difference - Subtracts the darker of the two constituent colors from the lighter
* Displace - Shifts target image pixels as defined by the source
* Dissolve - Dissolves the source in to the target
* Exclusion - Produces an effect similar to that of Difference, but appears as lower contrast
* Hard Light - Multiplies or screens the colors, dependent on the source color value
* Hue - Modifies the hue of the target as defined by source
* Composite In - Composites source into the target
* Lighten - Lightens the target as defined by source
* Luminise - Luminizes the target as defined by source
* Minus - Subtracts the source from the target
* Modulate - Modulates the target brightness, saturation and hue as defined by source
* Multiply - Multiplies the target to the source
* Composite Out - Composites outer parts of the source on the target
* Composite Over - Composites source over the target
* Overlay - Overlays the source on the target
* Plus - Adds the source to the target
* Replace - Replaces the target with the source
* Saturate - Saturates the target as defined by the source
* Screen - The source and destination are complemented and then multiplied and then replace the destination
* Soft Light - Darkens or lightens the colors, dependent on the source
* Source Atop - The part of the source lying inside of the destination is composited onto the destination
* Source In - The part of the source lying inside of the destination replaces the destination
* Source Out - The part of the source lying outside of the destination replaces the destination
* Source Over - The source replaces the destination
* Subtract - Subtract the colors in the source image from the destination image
* Threshold - The source is composited on the target as defined by source threshold
* XOR - The part of the source that lies outside of the destination is combined with the part of the destination that lies outside of the source

## TODO

* z-index management
* paramaters below
* blend/mix modes below

### Exaxt PS Layer Blend Modes for Reference

* Brightness
* Contrast
* Saturation
* Tint
* Hue

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

### Implemented Fred Filter and Usage

#### Stained Glass

Gives a stained glass effect

#### Dice

Dices up the images
