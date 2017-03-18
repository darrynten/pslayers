# pslayers

![Travis Build Status](https://travis-ci.org/darrynten/pslayers.svg?branch=master)
![StyleCI Status](https://styleci.io/repos/82737297/shield?branch=master)
[![codecov](https://codecov.io/gh/darrynten/pslayers/branch/master/graph/badge.svg)](https://codecov.io/gh/darrynten/pslayers)
![Packagist Version](https://img.shields.io/packagist/v/darrynten/pslayers.svg)
![MIT License](https://img.shields.io/github/license/darrynten/pslayers.svg)

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

We're pre-releasing this as it does everything we need it to, but we're
busy with other stuff, and as you know incomplete and released is better
(and quicker) than complete and released. And we need it on packagist :)

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

It was very silly to do var/get/set all with the same name. This is on the
todo list to refactor out.

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
$layer->font('/path/to/font');
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

##### Image Layer

This *only* works with the `imageUrl` config option at this time.

You can still set the image directly or use a BlankLayer and set your
image on that canvas.

This will be fixed.

##### Gradient Layer

Currently only a start-to-finish top-to-bottom solid-to-solid gradient
layer. This will be expanded upon.

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

Like its cousin it's also not 100% implemented, but it provides the most
basic of radial gradient that Imagick has to offer.

##### Solid Layer

This is just a solid colour layer

```php
$layer = new SolidLayer($config);

$layer->colour('#FFFFFF');
```

##### Pattern Layer

A layer that tiles a standard Imagick pattern. You can add optional
scaling and scale filtering values.

This is *not* a tiling layer, this uses standard, low res, built in
patterns that come with Imagick.

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

## TODO before v1 release

* refactor out var/get/set all using same name
* z-index management
* all paramaters below
* all blend/mix modes below
* all documentation below

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

# NOT IMPLEMENTED

* Gradiant Mask
* Transparency Mask

## Filters

There is support for filters

You can combine filters on a layer in a similar way to how you combine
layers together in a collection - the z-index is the array index, and the
render is run up the index.

### Standard Filters

These are the base filters included with pslayers.

We have designed them to be easily extensible and creatable, and will
happily accept new filters into the core library should they be up to
scratch. Contributions are welcome.

##### Blur

Basic blur filter

```php
$blurFilter = new BlurFilter([
    'id' => 'blur',
    'radius' => 5,                      // required
    'sigma' => 2,                       // required
    'channel' => \Imagik::CHANNEL_ALL,  // optional
]);

$blankLayer = new BlankLayer([
    'id' => 'blank',
    'filters' => [
        $blurFilter,
        // You can combine filters
    ]
])
```

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

Gives a stained glass effect.

[Docs](http://www.fmwconcepts.com/imagemagick/stainedglass/index.php)

```php
$filter = new StainedGlassFilter([
    'id' => 1,
    'kind' => 'random',
    'size' => 50,
    'offset' => 0,
    'ncolors' => 8,
    'bright' => 100,
    'ecolor' => 'black',
    'thick' => 0,
    'rseed' => rand(),
]);

// And then add to a layer

$plasmaLayer = new PlasmaLayer([
    'id' => 'master-layer-plasma-layer',
    'width' => $width,
    'height' => $height,
    'opacity' => 0.8,
    'positionX' => 0,
    'positionY' => 0,
    'composite' => Imagick::COMPOSITE_DARKEN,
    'filters' => [
        $stainedGlassFilter,
    ],
]);
```

#### Dice

Dices up the images

[Docs](http://www.fmwconcepts.com/imagemagick/dice/index.php)

```php
$diceFilter = new DiceFilter([
    'id' => 'master-layer-dice-filter',
    'size' => 100,
    'percent' => 100,
    'center' => '10,10',
    'radii' => '0,0',
    'rounding' => '0,0',
]);
```

#### Other Freds Filters

Not all filters have been added. If you add a filter please do contribute
it back to this project via a PR.

You can extend `FredBaseFilter` and follow the style within one of the
other templates.

As an example we will run through the creation of the
[stained glass filter](http://www.fmwconcepts.com/imagemagick/stainedglass/index.php) - you can follow along in the source for this
filter.

The usage instructions show the switches

```
USAGE: stainedglass [-k kind] [-s size] [-o offset] [-n ncolors] [-b bright] [-e ecolor] [-t thick] [-r rseed] [-a] infile outfile
USAGE: stainedglass [-h or -help]

-k .... kind ....... kind of stainedglass cell shape; choices are: square 
.................... (or s), hexagon (or h), random (or r); default=random
-s .... size ....... size of cell; integer>0; default=16 
-o .... offset ..... random offset amount; integer>=0; default=6; 
.................... only applies to kind=random
-n .... ncolors .... number of desired reduced colors for the output; 
.................... integer>0; default is no color reduction
-b .... bright ..... brightness value in percent for output image; 
.................... integer>=0; default=100
-e .... ecolor ..... color for edge or border around each cell; any valid 
.................... IM color; default=black
-t .... thick ...... thickness for edge or border around each cell; 
.................... integer>=0; default=1; zero means no edge or border
-r .... rseed ...... random number seed value; integer>=0; if seed provided, 
.................... then image will reproduce; default is no seed, so that 
.................... each image will be randomly different; only applies 
.................... to kind=random
-a ................. use average color of cell rather than color at center 
.................... of cell; default is center color
```

You will use those in the creation of the class.

At the very least you need the following

```php
namespace DarrynTen\Pslayers\Filters\Filter\Fred\StainedGlass;

use DarrynTen\Pslayers\Filters\Filter\Fred\FredBaseFilter;
```

although you will see in the file that there is very strict validation
happening in all of these classes, but we will not be worrying about that
right now for the sake of this tutorial.

Next we set the extend the included base filter and set the command.

This is the command that one would run if using these filters in the
command line.

```php
class StainedGlassFilter extends FredBaseFilter
{
    protected $command = 'stainedglass';
```

We then make a mapping of all the switches

```php
    protected $switchMap = [
        'kind' => 'k',
        'size' => 's',
        'offset' => 'o',
        'ncolors' => 'n',
        'bright' => 'b',
        'ecolor' => 'e',
        'thick' => 't',
        'rseed' => 'r',
    ];
```

These will get mapped out to the command when the `render()` method that
is inside the base class is called.

You will notice that there is no support for the `-a` switch, as it
operates sort-of like a boolean, but we have not added this type of
"anonymous" switch (a switch that does not provide a value).

Please feel free to update the base filter to support this.

We then make `protected` variables for each entry in the switch map that
will be used by the base class when constructing.

```php
    protected $kind;
    protected $size;
    protected $offset;
    protected $ncolors;
    protected $bright;
    protected $ecolor;
    protected $thick;
    protected $rseed;
```

Every single one of these must be the exact name as per the switch map
you defined above. This is very important. It is also important that you
map to the short version of the switch.

Then you make a constructor

```php
    public function __construct(array $config)
    {
        // Do your validation here, before you construct the parent

        parent::__construct($config);
    }
```

And then you're done. That's the entirety of creating a mapping to one of
the filters. All the magic happens in the base fred filter :)

Remember though, we have not included any validation or doc blocks in the
above example, which *must* be included for a new filter to be accepted
into the project. It is also important to throw exceptions for any
validation errors (don't return `false`, you must `throw`).

## Acknowledgements

* [Dmitry Semenov](https://github.com/mxnr), as always.
