# PhpGenHTML
A little PHP framework to easily generate clean HTML code, with automatic identation.
Un petit framework PHP pour générer facilement du code HTML propre, avec une indentation automatique.








#Français

Vous pouvez regarder le fichier sample.php, c'est un code exemple d'utilisation du framework.



















## Documentation
###### Loading
You must include the code file.
```php
include('view.php');
```
You can use an alias to code faster, with less chars.
```php
use PhpGenHTML as PGH;
```
Make into a variable PGH object.
```php
$view = New PGH\View();
```
Print the return of the **start()** function to print the html doctype and the html start tag.
```php
echo $view->start();
```

**_Loading Example_** :
```php
include('view.php');
use PhpGenHTML as PGH;
$view = New PGH\View();
echo $view->start();
```
