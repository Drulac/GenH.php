# PhpGenHTML
A little PHP framework to easily generate clean HTML code, with automatic identation.

You can use it like this to make a connection form :

```php
include('fonctions/view.php');

use PhpGenHTML as PGH;

$view = New PGH\View();
echo $view->start();

echo $view->form(array(
		new PGH\input(array('name' => 'username', 'id' => 'username', 'placeholder' => 'Pseudo')),
		new PGH\input(array('name' => 'password', 'type' => 'password', 'id' => 'password', 'placeholder' => 'Mot de passe')),
		new PGH\input(array('type' => 'submit', 'value' => 'Connexion'))
	), array(
		'method' => 'post'
	));

if(!empty($view)){
	echo $view->bodyEnd();
	echo $view->end();
}
```
  
to get in input :

```html
<!DOCTYPE html>
<html>
  <form method="post">
    <input name="username" id="username" placeholder="Pseudo" type="text">
    <input name="password" type="password" id="password" placeholder="Password">
    <input type="submit" value="Connection">
  </form>
</html>
```



## Documentation
###### Loading
You must include the code file.
```php
include('fonctions/view.php');
```
You can use an alias to code more fast, with less chars.
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
include('fonctions/view.php');
use PhpGenHTML as PGH;
$view = New PGH\View();
echo $view->start();
```
