## About Laravel

The Image Optimizer only optimize PNG to PNG and JPG/JPEG to JPG/JPEG. Also it converts the PNG and JPG to WEBP extension.  


## Steps To Install
### Step 1
``` git clone https://github.com/Curves-n-Colors/Image-Optimizer.git ```

```composer install```

### Step 2
Check for Imagick and ImageMagick extesnion is installed using phpinfo().
If not installed install Imagick and ImageMagick using the given [link](https://phpandmysql.com/extras/install-imagemagick-and-imagick-xampp/).



## Way to use 
``` $image = new ImageHelper($image_path); ```
Give the Image path for compression or convertion in the ImageHelper Class.

``` $image->compress() ```
Use the compress() function to compress image. 

``` $image->convert_to_webp() ```
Use the convert_to_webp() function to convert to webp extension. 

