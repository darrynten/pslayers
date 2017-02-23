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

##### Blank Layer

Detailed above

##### Text Layer

Allows addition and manipulation of text

Adds some basic properties

```php
$layer = new TextLayer($config);

$layer->text('text');
$layer->font('Ubuntu');
$layer->size(16);
```

##### Gradient Layer

Not yet implemented

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





