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

Orphan's tags can have some attributes, but tags in peer can have childrens, in addition to attributes.

To create a tag, use `new` keyword, the namespace (here `V` alias), and the tag's name
```php
new V\Div()
```
For tags in peer, we give an array with children's tags, and an associative array with attributes
```php
new V\Div(array(
  new V\Div()
), array('class' => 'test'))
```
On peut également passer directement un texte à la place du tableau de composant
```php
new V\Div('Contenu', array('class' => 'test'))
```
Les balises orphelines ne pouvant pas avoir de contenu, elles ne prennent qu'un tableau associatif pour les attributs comme argument.
```php
new V\Img(array('src' => 'images/img.png'))
```

Pour afficher des balises on utilise la fonction `view()` de notre variable `$view`
```php
$view->view();
```
Cette fonction nous retourne le code HTML à afficher. Il faut donc faire un `echo`
```php
echo $view->view();
```
On donne à la fonction `view()` un tableau contenant les balises à afficher
```php
echo $view->view(array(
  new V\Div(array(
    new V\Div('Contenu', array('id' => 'subdiv'))
  ), array('class' => 'test')),
  new V\Img(array('src' => 'images/img.png'))
));
```
Le framework gérant l'indentation de l'HTML, vous n'avez pas à vous en soucier :smiley:
