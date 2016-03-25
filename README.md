# PhpGenHTML
A little PHP framework to easily generate clean HTML code, with automatic identation.
Un petit framework PHP pour générer facilement du code HTML propre, avec une indentation automatique.








##Français

Vous pouvez regarder le fichier [sample.php](https://github.com/Drulac/PhpGenHTML/blob/master/sample.php), c'est un code exemple d'utilisation du framework.

###### Chargement
Vous devez inclure le fichier [view.php](https://github.com/Drulac/PhpGenHTML/blob/master/view.php) qui contient le code du framework
```php
include('view.php');
```
Vous pouvez utiliser un alias pour gagner du temps en écrivant moins de caractères à chaques fois
```php
use PhpGenHTML as V;
```
Créez une variable contenant un objet View, du namespace PhpGenHTML (alliasé ici `V`). C'est cette variable qui va nous servir pour récuper le code HTML à afficher.
```php
$view = New V\View();
```
Affichez ensuite le retour de la fonction **start()** pour afficher le doctype HTML et le tag HTML de départ.
```php
echo $view->start();
```

**_Récapitulatif_** :
```php
include('view.php');
use PhpGenHTML as PGH;
$view = New PGH\View();
echo $view->start();
```

















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
