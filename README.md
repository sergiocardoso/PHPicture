![](http://sergiocardoso.tecnologia.ws/wp-content/uploads/2016/02/logo.svg)
# PHPicture

This class generate thumb from images with frienldy directives and settings from url on HREF attribute from IMG tag on HTML.

##### Required
* PHP > 5.4;
* PHP GD;

## Getting Started
##### Configuration:
It's necessary setup two folder on PHPicture.ini file:
* [images_folder] - folder from all your images;
* [cache_folder] - folder from a cache generation;

##### How its works:
Call all your images from HTML5 to PHPicture project.  See the example below:
If you install PHPicture project on the folder called myimg, and all your images are on the public/img folder, so change your HTML IMG SRC attribute to:

```
http://[absolute or relative path]/myimg/photo.png
```
Load the image from public/img folder.

```
http://[absolute or relative path]/myimg/photo-w:100-h:100.png
```
Resize this image to 100x100.

```
http://[absolute or relative path]/myimg/photo-w:140-h:120-b:e1e1e1.png
```
Resize this image to 140x120 and the fill the background with the hexdecimal color (b = background color parameter);

```
http://[absolute or relative path]/myimg/photo-f:jpg-q:9.png
```

Load image png in jpg format with 9 of compression. (q = quality parameter)

### Version
1.0.0

### Author
Sérgio Cardoso
<contato@sergiocardoso.org>
http://www.sergiocardoso.org