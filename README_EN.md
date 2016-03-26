# PhpGenHTML
A little PHP framework to easily generate clean HTML code, with automatic indentation.

## English

You can look into [sample.php](https://github.com/Drulac/PhpGenHTML/blob/master/sample.php), it's an example code of framework using

### Loading
You must include [view.php](https://github.com/Drulac/PhpGenHTML/blob/master/view.php) who contains framework's code
```php
include('view.php');
```
You can use an alias to spend less time to write namespace's name
```php
use PhpGenHTML as V;
```
Create a `View` object variable, from PhpGenHTML namespace (I use the `V` alias ). We use this variable get the HTML code
```php
$view = New V\View();
```
Print the return of the `start()` function print the HTML doctype and the html tag.
```php
echo $view->start();
```

#### Summary :
```php
include('view.php');
use PhpGenHTML as V;
$view = New V\View();
echo $view->start();
```

### Tags

In HTML there are 2 types of tag :
 - Orphan's tags (example `<img>`)
 - Tags in peer (example `<div></div>`)

Orphan's tags can have some attributes, but tags in peer can have childrens, in addition to attributes

To create a tag, use `new` keyword, the namespace (here `V` alias), and the tag's name
```php
new V\Div()
```
For tags in peer, we give an array with children's tags, and an associative array with attributes
```php
new V\Div([
  new V\Div()
], ['class' => 'test'])
```
We can give a string instead the array of tags.
```php
new V\Div('Content', ['class' => 'test'])
```
Orphan's tags can't have childrens, so they take only one associative array for attributes
```php
new V\Img(['src' => 'img/img.png'])
```

To print tags we must use `view()` function of `$view` variable
```php
$view->view();
```
This function return the HTML code to print. So use `echo` function one the return
```php
echo $view->view();
```
We give to `view()` function an array with tags to print
```php
echo $view->view([
  new V\Div([
    new V\Div('Content', ['id' => 'subdiv'])
  ], ['class' => 'test']),
  new V\Img(['src' => 'img/img.png'])
]);
```
The framework manage the HTML's indentation, you won't have to worry about that :smiley:
